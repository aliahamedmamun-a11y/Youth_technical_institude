@props([
    'student',
    'qrCode' => null,
    'isPublic' => false,
])

@php
    $studentPhotoUrl = null;
    if ($student->image_path) {
        if (str_starts_with($student->image_path, 'http://') || str_starts_with($student->image_path, 'https://')) {
            $studentPhotoUrl = $student->image_path;
        } elseif (str_starts_with($student->image_path, 'images/')) {
            $studentPhotoUrl = asset($student->image_path);
        } else {
            $studentPhotoUrl = asset('storage/' . ltrim($student->image_path, '/'));
        }
    }
@endphp

@vite(['resources/css/app.css', 'resources/css/student-id.css', 'resources/js/app.js'])

<main class="student-id-screen">
    <div class="student-id-frame">
        <article class="student-id-card">
            <img src="{{ asset('images/' . rawurlencode('Logo Or ID card-02.png')) }}" alt="Student ID Card Template" class="student-id__template">

            <div class="student-id__content">
                {{-- FRONT SIDE OVERLAYS --}}
                <div class="id-front-photo">
                    @if ($studentPhotoUrl)
                        <img src="{{ $studentPhotoUrl }}" alt="{{ $student->name }}" onerror="this.onerror=null; this.src='https://i.ibb.co/qMgPTvMQ/1000072415.jpg';">
                    @else
                        <div class="flex size-full items-center justify-center bg-slate-100 text-slate-400">
                            <svg class="size-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    @endif
                </div>

                <div class="id-front-info">
                    <h3 class="id-student-name">
                        {{ $student->name }}
                    </h3>
                    <p class="id-student-roll">
                        ROLL NO: {{ $student->roll_number ?: sprintf('%06d', $student->id) }}
                    </p>
                </div>

                {{-- BACK SIDE OVERLAYS --}}
                <div class="id-back-details">
                    <dl>
                        <dt>NAME</dt><dd>: {{ $student->name }}</dd>
                        <dt>ROLL NO</dt><dd>: {{ $student->roll_number ?? '—' }}</dd>
                        <dt>REG NO</dt><dd>: {{ $student->registration_number ?? '—' }}</dd>
                        <dt>SESSION</dt><dd>: {{ $student->session ?? '—' }}</dd>
                        <dt>COURSE</dt><dd>: {{ $student->course?->name ?? '—' }}</dd>
                        <dt>FATHER</dt><dd>: {{ $student->father_name ?? '—' }}</dd>
                        <dt>MOTHER</dt><dd>: {{ $student->mother_name ?? '—' }}</dd>
                        <dt>PHONE</dt><dd>: {{ $student->phone ?? '—' }}</dd>
                    </dl>
                </div>

                <div class="id-back-qr">
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
            📥 Download PDF (পিডিএফ ডাউনলোড)
        </button>

        <button type="button" data-download-image class="rounded-xl bg-blue-600 hover:bg-blue-700 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-blue-500">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
            🖼️ Download Image (ছবি)
        </button>

        <button type="button" onclick="window.print()" class="rounded-xl bg-slate-900 hover:bg-slate-800 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-slate-700">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m11.318-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 001.913-.247m10.5 0a48.536 48.036 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.656" />
            </svg>
            🖨️ Print / Save (প্রিন্ট করুন)
        </button>

        @if (! $isPublic)
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-6 py-3 text-xs font-black uppercase tracking-wider text-slate-700 transition">
            Back
        </a>
        @endif
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const doc = document.querySelector('.student-id-card');

                const finish = () => {
                    btnElement.innerHTML = originalHTML;
                    btnElement.disabled = false;
                };

                if (typeof html2canvas !== 'undefined') {
                    html2canvas(doc, {
                        scale: 4,
                        useCORS: true,
                        allowTaint: false,
                        logging: false,
                        imageTimeout: 15000,
                        dpi: 300
                    }).then(canvas => {
                        const imgData = canvas.toDataURL('image/jpeg', 1.0);
                        const jsPDF = window.jspdf ? window.jspdf.jsPDF : (window.jsPDF ? window.jsPDF : null);
                        if (jsPDF) {
                            const pdf = new jsPDF('landscape', 'mm', 'a4', true);
                            pdf.addImage(imgData, 'JPEG', 0, 0, 297, 210, undefined, 'FAST');
                            pdf.save(filename);
                        } else {
                            window.print();
                        }
                        finish();
                    }).catch(err => {
                        console.error('PDF error:', err);
                        window.print();
                        finish();
                    });
                } else {
                    window.print();
                    finish();
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
                    <span>ছবি তৈরি হচ্ছে...</span>
                `;
                btnElement.disabled = true;

                const studentName = "{{ addslashes($student->name) }}";
                const cleanName = studentName.replace(/[^a-zA-Z0-9]/g, '_');
                const filename = `StudentID_${cleanName}.pdf`;

                const finish = () => {
                    btnElement.innerHTML = originalHTML;
                    btnElement.disabled = false;
                };

                if (typeof html2canvas !== 'undefined') {
                    html2canvas(doc, {
                        scale: 4,
                        useCORS: true,
                        allowTaint: false,
                        logging: false,
                        imageTimeout: 15000,
                        backgroundColor: '#ffffff',
                        dpi: 300
                    }).then(canvas => {
                        const imageUri = canvas.toDataURL('image/jpeg', 1.0);
                        const link = document.createElement('a');
                        link.download = filename;
                        link.href = imageUri;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        finish();
                    }).catch(err => {
                        console.error('Image error:', err);
                        finish();
                    });
                } else {
                    finish();
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
