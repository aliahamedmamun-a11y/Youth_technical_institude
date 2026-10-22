@props([
    'student',
    'qrCode' => null,
])

@vite(['resources/css/app.css', 'resources/css/student-id.css', 'resources/js/app.js'])

<main class="student-id-screen">
    <div class="student-id-container">

        {{-- FRONT SIDE --}}
        <article class="id-card id-card--front">
            <img src="{{ asset('images/Logo Or ID card-02.png') }}" alt="ID Card Front Template" class="id-card__template id-card__template--front">

            <div class="id-card__content">
                <!-- Student Photo Frame -->
                <div class="id-card__photo-box">
                    @if ($student->image_path)
                        <img src="{{ str_starts_with($student->image_path, 'http') ? $student->image_path : asset('storage/'.$student->image_path) }}" alt="{{ $student->name }}" onerror="this.onerror=null; this.src='https://i.ibb.co/qMgPTvMQ/1000072415.jpg';">
                    @else
                        <div class="flex size-full items-center justify-center bg-slate-100 text-slate-400">
                            <svg class="size-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    @endif
                </div>

                <!-- Student Front Info -->
                <div class="id-card__front-info text-center">
                    <h3 class="text-sm font-black text-[#03224c] uppercase tracking-wide truncate px-2">
                        {{ $student->name }}
                    </h3>
                    <p class="text-[9.5px] font-bold text-slate-700 truncate px-2 mt-0.5">
                        {{ $student->course?->name ?? 'Technical Training Course' }}
                    </p>
                    <p class="text-[9px] font-black text-[#03224c] uppercase tracking-wider mt-1">
                        ROLL NO: {{ $student->roll_number ?: sprintf('%06d', $student->id) }}
                    </p>
                </div>
            </div>
        </article>

        {{-- BACK SIDE --}}
        <article class="id-card id-card--back">
            <img src="{{ asset('images/Logo Or ID card-02.png') }}" alt="ID Card Back Template" class="id-card__template id-card__template--back">

            <div class="id-card__content">
                <!-- Details List -->
                <div class="id-card__details">
                    <dl>
                        <dt>NAME</dt><dd>: {{ $student->name }}</dd>
                        <dt>ROLL NO</dt><dd>: {{ $student->roll_number ?? '—' }}</dd>
                        <dt>REG NO</dt><dd>: {{ $student->registration_number ?? '—' }}</dd>
                        <dt>SESSION</dt><dd>: {{ $student->session ?? '2024-2025' }}</dd>
                        <dt>COURSE</dt><dd>: {{ $student->course?->name ?? '—' }}</dd>
                        <dt>BLOOD GROUP</dt><dd>: {{ $student->blood_group ?? 'O+' }}</dd>
                        <dt>FATHER'S NAME</dt><dd>: {{ $student->father_name ?? '—' }}</dd>
                        <dt>MOTHER'S NAME</dt><dd>: {{ $student->mother_name ?? '—' }}</dd>
                        <dt>PHONE</dt><dd>: {{ $student->phone ?? '—' }}</dd>
                    </dl>
                </div>

                <!-- QR Code Box -->
                <div class="id-card__qr-box">
                    @if($qrCode)
                        <img src="{{ $qrCode }}" alt="QR Verification">
                    @else
                        <div class="size-full bg-slate-50 flex items-center justify-center text-[7px] text-slate-400 font-bold">QR CODE</div>
                    @endif
                </div>
            </div>
        </article>

    </div>

    <!-- ACTIONS -->
    <nav class="id-card-actions print:hidden mt-6 flex flex-wrap items-center justify-center gap-3">
        <button type="button" data-download-pdf class="rounded-xl bg-emerald-600 hover:bg-emerald-700 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-emerald-500">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            📥 Download PDF (সরাসরি পিডিএফ ডাউনলোড)
        </button>

        <button type="button" data-download-image class="rounded-xl bg-blue-600 hover:bg-blue-700 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-blue-500">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
            🖼️ Download Image (ছবি)
        </button>

        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-6 py-3 text-xs font-black uppercase tracking-wider text-slate-700 transition">
            Back
        </a>
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const doc = document.querySelector('.student-id-container');

            function fallbackJsPDF(element, filename, finish) {
                if (typeof html2canvas !== 'undefined') {
                    html2canvas(element, {
                        scale: 3,
                        useCORS: true,
                        allowTaint: true,
                        logging: false
                    }).then(canvas => {
                        const imgData = canvas.toDataURL('image/jpeg', 0.92);
                        const jsPDF = window.jspdf ? window.jspdf.jsPDF : null;
                        if (jsPDF) {
                            const pdf = new jsPDF('portrait', 'mm', 'a4', true);
                            pdf.addImage(imgData, 'JPEG', 0, 0, 210, 297, undefined, 'FAST');
                            pdf.save(filename);
                        }
                        finish();
                    }).catch(err => {
                        console.error('jsPDF fallback error:', err);
                        finish();
                    });
                } else {
                    finish();
                }
            }

            function downloadPDF(btnElement) {
                if (!doc) return;

                const originalHTML = btnElement.innerHTML;
                btnElement.innerHTML = `
                    <svg class="size-4 animate-spin inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span>HD PDF তৈরি হচ্ছে...</span>
                `;
                btnElement.disabled = true;

                const studentName = "{{ addslashes($student->name) }}";
                const cleanName = studentName.replace(/[^a-zA-Z0-9]/g, '_');
                const filename = `StudentID_${cleanName}.pdf`;

                const finish = () => {
                    btnElement.innerHTML = originalHTML;
                    btnElement.disabled = false;
                };

                const opt = {
                    margin: 0,
                    filename: filename,
                    image: { type: 'jpeg', quality: 0.92 },
                    html2canvas: { scale: 3, useCORS: true, allowTaint: true, logging: false },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait', compress: true }
                };

                if (typeof html2pdf !== 'undefined') {
                    html2pdf().set(opt).from(doc).save().then(finish).catch(err => {
                        console.error('html2pdf error:', err);
                        fallbackJsPDF(doc, filename, finish);
                    });
                } else {
                    fallbackJsPDF(doc, filename, finish);
                }
            }

            function downloadImage(btnElement) {
                if (!doc) return;

                const originalHTML = btnElement.innerHTML;
                btnElement.innerHTML = `
                    <svg class="size-4 animate-spin inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span>HD ছবি তৈরি হচ্ছে...</span>
                `;
                btnElement.disabled = true;

                const studentName = "{{ addslashes($student->name) }}";
                const cleanName = studentName.replace(/[^a-zA-Z0-9]/g, '_');
                const filename = `StudentID_${cleanName}.jpg`;

                if (typeof html2canvas !== 'undefined') {
                    html2canvas(doc, { scale: 3, useCORS: true, allowTaint: true, logging: false, backgroundColor: '#ffffff' }).then(canvas => {
                        const imageUri = canvas.toDataURL('image/jpeg', 0.92);
                        const link = document.createElement('a');
                        link.download = filename;
                        link.href = imageUri;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        btnElement.innerHTML = originalHTML;
                        btnElement.disabled = false;
                    }).catch(err => {
                        console.error('Image error:', err);
                        btnElement.innerHTML = originalHTML;
                        btnElement.disabled = false;
                    });
                } else {
                    btnElement.innerHTML = originalHTML;
                    btnElement.disabled = false;
                }
            }

            document.querySelectorAll('[data-download-pdf]').forEach(btn => {
                btn.addEventListener('click', function () { downloadPDF(this); });
            });

            document.querySelectorAll('[data-download-image]').forEach(btn => {
                btn.addEventListener('click', function () { downloadImage(this); });
            });
        });
    </script>
</main>
