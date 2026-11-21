<script>
(function () {
    if (window.pdfjsLib) {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
    }

    let activeDocType = null;
    let cameraStream = null;
    let facingMode = 'environment';

    const blockedNamePatterns = [
        /\bnational\s*id\b/i,
        /\bemergency\s*contact\b/i,
        /\bnid\s*data\b/i,
        /\bsurname\b/i,
        /\bgiven\s*name\b/i,
        /\bpassport\s*no\b/i,
        /\bdate\s*of\s*birth\b/i,
        /\bnationality\b/i,
        /\bauthority\b/i,
        /\bdocument\s*no\b/i,
        /naidataandemergencycontact/i
    ];

    function setScanStatus(msg, isError = false) {
        const box = document.getElementById('scan-status-alert');
        const txt = document.getElementById('scan-status-msg');
        if (!box || !txt) return;
        box.classList.remove('hidden', 'border-rose-500/30', 'bg-rose-500/10', 'text-rose-300', 'border-indigo-500/30', 'bg-indigo-500/10', 'text-indigo-300');
        if (isError) {
            box.classList.add('border-rose-500/30', 'bg-rose-500/10', 'text-rose-300');
        } else {
            box.classList.add('border-indigo-500/30', 'bg-indigo-500/10', 'text-indigo-300');
        }
        txt.textContent = msg;
    }

    function updatePreviewBox(docType, dataUrl) {
        const map = {
            'Passport': 'box-preview-passport',
            'NID Card': 'box-preview-nid',
            'Birth Registration': 'box-preview-birth'
        };
        const el = document.getElementById(map[docType]);
        if (!el || !dataUrl) return;
        el.innerHTML = `<img src="${dataUrl}" alt="${docType}" class="size-full object-contain rounded-lg">`;
    }

    function cleanAddressText(rawAddr) {
        if (!rawAddr) return '';
        let cleaned = rawAddr
            .replace(/\s+/g, ' ')
            .replace(/,\s*,+/g, ', ')
            .replace(/\b([A-Za-z])\s+([A-Za-z])\s*$/g, '')
            .replace(/\s+[-–]\s*$/, '')
            .trim();
        cleaned = cleaned.replace(/\b([A-Za-z]+),\s*\1\b/gi, '$1');
        return cleaned;
    }

    function isValidPersonName(candidate) {
        if (!candidate) return false;
        const s = candidate.trim();
        if (s.length < 3 || s.length > 70) return false;
        if (/\d/.test(s)) return false;
        if (blockedNamePatterns.some((rx) => rx.test(s))) return false;
        const words = s.split(/\s+/).filter(Boolean);
        return words.length >= 1 && words.length <= 6;
    }

    function parsePassportMRZ(text) {
        const lines = text
            .split(/\r?\n/)
            .map((l) => l.replace(/\s+/g, '').toUpperCase())
            .filter((l) => l.includes('<') && l.length >= 25);

        let name = '';
        let passportNo = '';
        let dob = '';

        const mrz1 = lines.find((l) => l.startsWith('P<') || l.includes('<<'));
        if (mrz1) {
            const afterCountry = mrz1.replace(/^P<[A-Z<]{3}/, '');
            const parts = afterCountry.split('<<');
            const surname = (parts[0] || '').replace(/<+/g, ' ').trim();
            const givenNames = (parts[1] || '').replace(/<+/g, ' ').trim();
            const full = `${givenNames} ${surname}`.trim();
            if (isValidPersonName(full)) {
                name = full.replace(/\b\w+/g, (w) => w.charAt(0) + w.slice(1).toLowerCase());
            }
        }

        const mrz2 = lines.find((l) => l !== mrz1 && /[A-Z0-9<]{20,}/.test(l));
        if (mrz2) {
            const passMatch = mrz2.match(/^([A-Z0-9<]{7,9})</);
            if (passMatch) {
                passportNo = passMatch[1].replace(/<+$/, '');
            }
            const dobMatch = mrz2.match(/^[A-Z0-9<]{9,13}[MF<](\d{6})[0-9<][MF<]/);
            if (dobMatch) {
                const yymmdd = dobMatch[1];
                const yy = parseInt(yymmdd.slice(0, 2), 10);
                const mm = yymmdd.slice(2, 4);
                const dd = yymmdd.slice(4, 6);
                const currentYY = 26;
                const yyyy = yy <= currentYY ? `20${yymmdd.slice(0, 2)}` : `19${yymmdd.slice(0, 2)}`;
                dob = `${yyyy}-${mm}-${dd}`;
            }
        }

        return { name, passportNo, dob };
    }

    function parseDocumentText(rawText, docType) {
        const lines = rawText
            .split(/\r?\n/)
            .map((l) => l.trim())
            .filter(Boolean);

        const result = {
            name: '',
            father_name: '',
            mother_name: '',
            date_of_birth: '',
            passport_nid_number: '',
            phone: '',
            address: '',
            district: '',
            upazila: ''
        };

        const phoneMatch = rawText.match(/(?:\+?88)?01[3-9]\d{8}/);
        if (phoneMatch) {
            result.phone = phoneMatch[0].replace(/^\+?88/, '');
        }

        const dobMatch = rawText.match(/\b(\d{2})[\/\-](\d{2})[\/\-](\d{4})\b/) || rawText.match(/\b(\d{4})[\/\-](\d{2})[\/\-](\d{2})\b/);
        if (dobMatch) {
            if (dobMatch[1].length === 4) {
                result.date_of_birth = `${dobMatch[1]}-${dobMatch[2]}-${dobMatch[3]}`;
            } else {
                const day = parseInt(dobMatch[1], 10);
                const month = parseInt(dobMatch[2], 10);
                const year = dobMatch[3];
                if (month >= 1 && month <= 12 && day >= 1 && day <= 31) {
                    result.date_of_birth = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                }
            }
        }

        for (let i = 0; i < lines.length; i++) {
            const line = lines[i];
            const nextLine = lines[i + 1] || '';

            if (/^(?:name|full\s*name|student\s*name)\s*[:\-]?\s*(.*)$/i.test(line)) {
                const m = line.match(/^(?:name|full\s*name|student\s*name)\s*[:\-]?\s*(.*)$/i);
                const val = (m && m[1]) ? m[1].trim() : nextLine;
                if (isValidPersonName(val)) result.name = val;
            }

            if (/^(?:father(?:'s)?\s*name)\s*[:\-]?\s*(.*)$/i.test(line)) {
                const m = line.match(/^(?:father(?:'s)?\s*name)\s*[:\-]?\s*(.*)$/i);
                const val = (m && m[1]) ? m[1].trim() : nextLine;
                if (isValidPersonName(val)) result.father_name = val;
            }

            if (/^(?:mother(?:'s)?\s*name)\s*[:\-]?\s*(.*)$/i.test(line)) {
                const m = line.match(/^(?:mother(?:'s)?\s*name)\s*[:\-]?\s*(.*)$/i);
                const val = (m && m[1]) ? m[1].trim() : nextLine;
                if (isValidPersonName(val)) result.mother_name = val;
            }

            if (/(?:address|location|vill|village|post|upazila|zila|district)/i.test(line) && line.length > 10) {
                const addrVal = line.replace(/^(?:address|location)\s*[:\-]?\s*/i, '');
                if (!result.address || addrVal.length > result.address.length) {
                    result.address = cleanAddressText(addrVal);
                }
            }
        }

        if (docType === 'Passport') {
            const mrz = parsePassportMRZ(rawText);
            if (mrz.name) result.name = mrz.name;
            if (mrz.passportNo) result.passport_nid_number = mrz.passportNo;
            if (mrz.dob) result.date_of_birth = mrz.dob;
        }

        if (!result.passport_nid_number) {
            const passNo = rawText.match(/\b[A-Z]{1,2}\d{7,8}\b/);
            const nidNo = rawText.match(/\b(?:\d{10}|\d{13}|\d{17})\b/);
            if (docType === 'Passport' && passNo) {
                result.passport_nid_number = passNo[0];
            } else if (nidNo) {
                result.passport_nid_number = nidNo[0];
            } else if (passNo) {
                result.passport_nid_number = passNo[0];
            }
        }

        const distSelect = document.getElementById('form-district-select');
        if (distSelect) {
            const options = Array.from(distSelect.options).map((o) => o.value).filter(Boolean);
            const matchedDist = options.find((d) => new RegExp(`\\b${d}\\b`, 'i').test(rawText));
            if (matchedDist) {
                result.district = matchedDist;
            }
        }

        return result;
    }

    function applyParsedDataToForm(data, docType) {
        if (data.name && isValidPersonName(data.name)) {
            const el = document.getElementById('field-name');
            if (el) el.value = data.name;
        }
        if (data.father_name && isValidPersonName(data.father_name)) {
            const el = document.getElementById('field-father-name');
            if (el) el.value = data.father_name;
        }
        if (data.mother_name && isValidPersonName(data.mother_name)) {
            const el = document.getElementById('field-mother-name');
            if (el) el.value = data.mother_name;
        }
        if (data.date_of_birth) {
            const el = document.getElementById('field-dob');
            if (el) el.value = data.date_of_birth;
        }
        if (data.passport_nid_number) {
            const el = document.getElementById('field-passport');
            if (el) el.value = data.passport_nid_number;
        }
        if (data.phone) {
            const el = document.getElementById('field-phone');
            if (el) el.value = data.phone;
        }
        if (data.address) {
            const el = document.getElementById('field-address');
            if (el) el.value = cleanAddressText(data.address);
        }
        if (data.district) {
            const distEl = document.getElementById('form-district-select');
            if (distEl) {
                distEl.value = data.district;
                distEl.dispatchEvent(new Event('change'));
            }
        }

        if (docType === 'Passport' && (!data.father_name || !data.mother_name)) {
            setScanStatus('Passport scanned. Note: Father/Mother names are usually not printed on Passport bio pages—scan NID or Birth Certificate if needed.');
        } else {
            setScanStatus(`${docType} scanned and form fields updated.`);
        }
    }

    function loadScriptOnce(src) {
        return new Promise((resolve, reject) => {
            const existing = document.querySelector(`script[src="${src}"]`);
            if (existing) {
                if (existing.dataset.loaded === 'true') return resolve();
                existing.addEventListener('load', () => resolve(), { once: true });
                existing.addEventListener('error', reject, { once: true });
                return;
            }
            const s = document.createElement('script');
            s.src = src;
            s.async = true;
            s.onload = () => {
                s.dataset.loaded = 'true';
                resolve();
            };
            s.onerror = reject;
            document.head.appendChild(s);
        });
    }

    async function ensureOcrLibs() {
        if (!window.pdfjsLib) {
            await loadScriptOnce('https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js');
        }
        if (window.pdfjsLib && !pdfjsLib.GlobalWorkerOptions.workerSrc) {
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
        }
        if (!window.Tesseract) {
            await loadScriptOnce('https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js');
        }
    }

    async function pdfFileToDataUrl(file) {
        await ensureOcrLibs();
        const arrayBuffer = await file.arrayBuffer();
        const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
        const page = await pdf.getPage(1);
        const viewport = page.getViewport({ scale: 2.0 });
        const canvas = document.createElement('canvas');
        canvas.width = viewport.width;
        canvas.height = viewport.height;
        const ctx = canvas.getContext('2d');
        await page.render({ canvasContext: ctx, viewport }).promise;
        return canvas.toDataURL('image/png');
    }

    async function runOcrOnImageDataUrl(dataUrl, docType) {
        setScanStatus(`Loading OCR & scanning ${docType}...`);
        await ensureOcrLibs();
        const { data } = await Tesseract.recognize(dataUrl, 'eng');
        const parsed = parseDocumentText(data.text || '', docType);
        applyParsedDataToForm(parsed, docType);
    }

    window.handleDocumentFileChange = async function (input, docType) {
        const file = input.files && input.files[0];
        if (!file) return;

        try {
            let dataUrl = '';
            if (file.type === 'application/pdf' || /\.pdf$/i.test(file.name)) {
                setScanStatus(`Rendering PDF page for ${docType}...`);
                dataUrl = await pdfFileToDataUrl(file);
            } else {
                dataUrl = await new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = reject;
                    reader.readAsDataURL(file);
                });
            }

            updatePreviewBox(docType, dataUrl);
            await runOcrOnImageDataUrl(dataUrl, docType);
        } catch (err) {
            console.error(err);
            setScanStatus(`Failed to process ${docType} file: ${err.message || err}`, true);
        } finally {
            input.value = '';
        }
    };

    window.openDocumentScanner = async function (docType) {
        activeDocType = docType;
        const modal = document.getElementById('doc-camera-modal');
        const title = document.getElementById('camera-modal-title');
        const loading = document.getElementById('camera-loading-text');
        const video = document.getElementById('camera-feed');

        if (title) title.textContent = `${docType} Live Scanner`;
        if (loading) {
            loading.textContent = 'Initializing Camera...';
            loading.classList.remove('hidden');
        }
        if (modal) modal.classList.remove('hidden');

        try {
            if (cameraStream) {
                cameraStream.getTracks().forEach((t) => t.stop());
            }
            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode },
                audio: false
            });
            if (video) {
                video.srcObject = cameraStream;
                video.onloadedmetadata = () => {
                    if (loading) loading.classList.add('hidden');
                };
            }
        } catch (err) {
            console.error(err);
            if (loading) loading.textContent = 'Camera unavailable. Use Upload button.';
        }
    };

    window.closeDocCameraModal = function () {
        const modal = document.getElementById('doc-camera-modal');
        if (modal) modal.classList.add('hidden');
        if (cameraStream) {
            cameraStream.getTracks().forEach((t) => t.stop());
            cameraStream = null;
        }
    };

    window.switchCameraFacing = async function () {
        facingMode = facingMode === 'environment' ? 'user' : 'environment';
        if (activeDocType) {
            await window.openDocumentScanner(activeDocType);
        }
    };

    window.captureCameraPhoto = async function () {
        const video = document.getElementById('camera-feed');
        const canvas = document.getElementById('camera-canvas');
        if (!video || !canvas || !activeDocType) return;

        canvas.width = video.videoWidth || 1280;
        canvas.height = video.videoHeight || 720;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataUrl = canvas.toDataURL('image/png');
        const docType = activeDocType;
        window.closeDocCameraModal();
        updatePreviewBox(docType, dataUrl);
        await runOcrOnImageDataUrl(dataUrl, docType);
    };

    window.triggerFileFallbackFromModal = function () {
        const docType = activeDocType;
        window.closeDocCameraModal();
        const inputMap = {
            'Passport': 'file-input-passport',
            'NID Card': 'file-input-nid',
            'Birth Registration': 'file-input-birth'
        };
        const input = document.getElementById(inputMap[docType]);
        if (input) input.click();
    };

    window.previewStudentPhoto = function (input) {
        const file = input.files && input.files[0];
        const img = document.getElementById('student-photo-preview-img');
        const icon = document.getElementById('student-photo-preview-icon');
        if (!file || !img) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            img.src = e.target.result;
            img.classList.remove('hidden');
            if (icon) icon.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    };
})();
</script>
