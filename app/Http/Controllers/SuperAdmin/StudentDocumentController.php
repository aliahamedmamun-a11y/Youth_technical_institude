<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentResult;
use App\Services\QrCodeService;
use App\Services\ResultGradingService;
use App\Services\ResultQrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class StudentDocumentController extends Controller
{
    private const ADMIT_CARD_EXAMINEE_TYPE = 'Regular';

    private const DOCUMENT_INSTITUTE_CODE = 'BR-5667655';

    private const DOCUMENT_INSTITUTE_NAME = 'South Asia Engineering & Technical Institute';

    /** @var array<string, string> */
    private const DOCUMENTS = [
        'admit-card' => 'Admit Card',
        'registration-card' => 'Registration Card',
        'student-id' => 'Student ID Card',
        'certificate' => 'Certificate 2 (Gold Border)',
        'certificate-one' => 'Certificate 1 (Classic)',
        'certificate-two' => 'Certificate 2 (Gold Border)',
        'certificate-three' => 'Certificate 3 (Modern)',
        'certificate-four' => 'Certificate 4 (Elegant)',
        'certificate-five' => 'Certificate 5 (Premium)',
        'certificate-six' => 'Certificate 6 (Honor)',
        'certificate-seven' => 'Certificate 7 (Excellence)',
        'testimonial' => 'Testimonial',
        'transcript' => 'Transcript',
        'transcript-one' => 'Transcript One',
        'transcript-two' => 'Transcript Two',
        'forwarding-letter' => 'Forwarding Letter',
        'results' => 'Results',
        'results-2' => 'Result 2',
    ];

    public function show(
        Student $student,
        string $document,
        ResultGradingService $grading,
        ResultQrCodeService $resultQrCode,
        QrCodeService $qrCode,
        bool $isPublic = false,
    ): View|RedirectResponse {
        if (! $isPublic) {
            Gate::authorize('view', $student);
        }

        abort_unless(array_key_exists($document, self::DOCUMENTS), 404);

        if ($document === 'results' || $document === 'results-2') {
            $result = $student->results()->latest('published_at')->latest('id')->first();

            if (! $result) {
                $result = $student->results()->create([
                    'semester' => '1st Semester',
                    'session' => $student->session ?: '2025-2026',
                    'gpa' => $student->cgpa,
                    'overall_grade' => $student->grade,
                    'status' => 'published',
                    'verification_token' => \Illuminate\Support\Str::random(48),
                    'published_at' => now(),
                ]);
            }

            $style = $document === 'results-2' ? 'summary' : 'all';

            return redirect()->route('super-admin.results.show', [$result, 'style' => $style]);
        }

        $student->load('course');
        $latestResult = $student->results()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->latest('id')
            ->first();

        $cumulativeGpa = $grading->cumulativeGpa($student);
        $documentData = [
            'student' => $student,
            'document' => $document,
            'documentTitle' => self::DOCUMENTS[$document],
            'latestResult' => $latestResult,
            'cumulativeGpa' => $cumulativeGpa,
            'certificateSerial' => $student->certificate_serial ?: ($latestResult ? sprintf('%06d', $latestResult->id) : null),
            'isPublic' => $isPublic,
        ];

        if ($document === 'admit-card') {
            $documentData = [...$documentData, ...$this->admitCardData($student, $qrCode)];
        }

        if ($document === 'student-id') {
            $documentData = [...$documentData, ...$this->studentIdData($student, $qrCode)];
        }

        if (in_array($document, ['registration-card', 'certificate', 'certificate-one', 'certificate-two', 'certificate-three', 'certificate-four', 'certificate-five', 'certificate-six', 'certificate-seven'])) {
            $documentData = [...$documentData, ...$this->registrationCardData($student, $qrCode)];
        }

        if (in_array($document, ['certificate', 'certificate-one', 'certificate-two', 'certificate-three', 'certificate-four', 'certificate-five', 'certificate-six', 'certificate-seven'])) {
            $verifiedResult = $this->ensureStudentResult($student);
            $documentData['qrCode'] = $verifiedResult?->verification_token
                ? $qrCode->dataUri(route('results.show', $verifiedResult->verification_token))
                : null;
            $documentData['template'] = str_replace('certificate-', '', $document);
            if ($documentData['template'] === 'certificate' || ! in_array($documentData['template'], ['1', '2', '3', '4', '5', '6', '7'])) {
                $documentData['template'] = '2';
            }
        }

        if ($document === 'testimonial') {
            $verifiedResult = $this->ensureStudentResult($student);
            $documentData['qrCode'] = $verifiedResult?->verification_token
                ? $qrCode->dataUri(route('public.testimonial', $verifiedResult->verification_token))
                : null;
        }

        if ($document === 'transcript' || $document === 'transcript-one' || $document === 'transcript-two') {
            $documentData = [
                ...$documentData,
                ...$this->transcriptData($student, $qrCode),
                'transcriptGradingScale' => $grading->gradingScale(),
                'transcriptLetterGrade' => $cumulativeGpa ? $grading->letterGradeForGpa($cumulativeGpa) : null,
            ];
        }

        return view('super-admin.students.document', $documentData);
    }

    private function ensureStudentResult(Student $student): ?StudentResult
    {
        $result = $student->results()->latest('published_at')->latest('id')->first();

        if ($result && ! $result->verification_token) {
            $result->forceFill(['verification_token' => \Illuminate\Support\Str::random(48)])->saveQuietly();
        }

        return $result;
    }

    private function admitCardData(Student $student, QrCodeService $qrCode): array
    {
        $result = $this->ensureStudentResult($student);
        $token = $result?->verification_token;
        $admitCardQrUrl = $token ? route('public.admit-card', $token) : route('results.index', ['roll_number' => $student->roll_number]);

        return [
            'admitCardSerial' => $student->certificate_serial ?: sprintf('%06d', $student->id),
            'admitCardInstituteCode' => self::DOCUMENT_INSTITUTE_CODE,
            'admitCardInstituteName' => self::DOCUMENT_INSTITUTE_NAME,
            'admitCardExamineeType' => self::ADMIT_CARD_EXAMINEE_TYPE,
            'admitCardQrCode' => $qrCode->dataUri($admitCardQrUrl),
            'admitCardQrUrl' => $admitCardQrUrl,
            'admitCardPrintedAt' => now(),
        ];
    }

    private function studentIdData(Student $student, QrCodeService $qrCode): array
    {
        $result = $this->ensureStudentResult($student);
        $token = $result?->verification_token;
        $studentIdQrUrl = $token ? route('public.student-id', $token) : route('results.index', ['roll_number' => $student->roll_number]);

        return [
            'studentIdSerial' => $student->certificate_serial ?: sprintf('ID-%06d', $student->id),
            'studentIdQrCode' => $qrCode->dataUri($studentIdQrUrl),
            'studentIdQrUrl' => $studentIdQrUrl,
        ];
    }

    private function registrationCardData(Student $student, QrCodeService $qrCode): array
    {
        $result = $this->ensureStudentResult($student);
        $token = $result?->verification_token;
        $registrationCardQrUrl = $token ? route('public.registration-card', $token) : route('results.index', ['roll_number' => $student->roll_number]);

        return [
            'registrationCardSerial' => $student->certificate_serial ?: sprintf('036%03d', $student->id),
            'registrationCardInstituteCode' => self::DOCUMENT_INSTITUTE_CODE,
            'registrationCardInstituteName' => self::DOCUMENT_INSTITUTE_NAME,
            'registrationCardQrCode' => $qrCode->dataUri($registrationCardQrUrl),
            'registrationCardQrUrl' => $registrationCardQrUrl,
        ];
    }

    private function transcriptData(Student $student, QrCodeService $qrCode): array
    {
        $allResults = $student->results()
            ->with(['subjects', 'semesterDefinition'])
            ->get()
            ->sort(fn (StudentResult $first, StudentResult $second): int => [
                $first->semesterDefinition?->sort_order ?? PHP_INT_MAX,
                $first->semester,
                $first->id,
            ] <=> [
                $second->semesterDefinition?->sort_order ?? PHP_INT_MAX,
                $second->semester,
                $second->id,
            ])
            ->values();

        if ($allResults->isNotEmpty()) {
            $transcriptPages = $allResults->flatMap(function (StudentResult $result) use ($student, $qrCode): Collection {
                $subjects = $result->subjects;

                if ($subjects->isEmpty()) {
                    $matchedSemester = $student->course?->semesters()
                        ->where('name', $result->semester)
                        ->with('subjects')
                        ->first();

                    if ($matchedSemester && $matchedSemester->subjects->isNotEmpty()) {
                        $subjects = $matchedSemester->subjects->map(function ($s) use ($result) {
                            return (object) [
                                'code' => $s->code,
                                'title' => $s->title,
                                'credit' => $s->credit,
                                'grade' => $result->overall_grade,
                                'grade_point' => $result->gpa,
                            ];
                        });
                    } else {
                        $subjects = collect();
                    }
                }

                $subjectChunks = $subjects->chunk(7);
                $verificationUrl = $result->verification_token
                    ? route('public.transcript', $result->verification_token)
                    : null;
                $verificationQrCode = $verificationUrl ? $qrCode->dataUri($verificationUrl) : null;

                if ($subjectChunks->isEmpty()) {
                    $subjectChunks = collect([collect()]);
                }

                return $subjectChunks->values()->map(fn (Collection $subjects, int $chunkIndex): array => [
                    'result' => $result,
                    'semesterName' => $result->semester,
                    'subjects' => $subjects->values(),
                    'isContinuation' => $chunkIndex > 0,
                    'isSemesterFinal' => $chunkIndex === $subjectChunks->count() - 1,
                    'serial' => $student->certificate_serial ?: sprintf('TRANS-%06d', $result->id),
                    'outcome' => $result->overall_grade === null
                        ? null
                        : ($result->overall_grade === 'F' ? 'Failed' : 'Passed'),
                    'verificationQrCode' => $verificationQrCode,
                    'verificationUrl' => $verificationUrl,
                    'verificationReference' => $result->verification_token,
                ]);
            })->values();
        } else {
            $courseSemesters = $student->course?->semesters()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();

            if ($courseSemesters && $courseSemesters->isNotEmpty()) {
                $transcriptPages = $courseSemesters->map(function ($semester, int $index) use ($student): array {
                    return [
                        'result' => null,
                        'semesterName' => $semester->name,
                        'subjects' => $semester->subjects ?? collect(),
                        'isContinuation' => false,
                        'isSemesterFinal' => true,
                        'serial' => $student->certificate_serial ?: sprintf('TRANS-%06d', $student->id),
                        'outcome' => null,
                        'verificationQrCode' => null,
                        'verificationUrl' => null,
                        'verificationReference' => null,
                    ];
                })->values();
            } else {
                $transcriptPages = collect([
                    [
                        'result' => null,
                        'semesterName' => '1st Semester',
                        'subjects' => collect(),
                        'isContinuation' => false,
                        'isSemesterFinal' => true,
                        'serial' => $student->certificate_serial ?: sprintf('TRANS-%06d', $student->id),
                        'outcome' => null,
                        'verificationQrCode' => null,
                        'verificationUrl' => null,
                        'verificationReference' => null,
                    ],
                ]);
            }
        }

        return [
            'transcriptPages' => $transcriptPages,
            'transcriptInstituteName' => self::DOCUMENT_INSTITUTE_NAME,
        ];
    }
}
