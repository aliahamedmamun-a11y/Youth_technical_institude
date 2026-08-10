<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentResult;
use App\Services\QrCodeService;
use App\Services\ResultGradingService;
use App\Services\ResultQrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class StudentDocumentController extends Controller
{
    private const ADMIT_CARD_EXAMINEE_TYPE = 'Regular';

    private const DOCUMENT_INSTITUTE_CODE = 'BR-5667655';

    private const DOCUMENT_INSTITUTE_NAME = 'Titas Technical Training Center';

    /** @var array<string, string> */
    private const DOCUMENTS = [
        'admit-card' => 'Admit Card',
        'registration-card' => 'Registration Card',
        'student-id' => 'Student ID Card',
        'certificate' => 'Certificate',
        'testimonial' => 'Testimonial',
        'transcript' => 'Transcript',
        'forwarding-letter' => 'Forwarding Letter',
        'results' => 'Results',
    ];

    public function show(
        Student $student,
        string $document,
        ResultGradingService $grading,
        ResultQrCodeService $resultQrCode,
        QrCodeService $qrCode,
    ): View|RedirectResponse {
        Gate::authorize('view', $student);

        abort_unless(array_key_exists($document, self::DOCUMENTS), 404);

        if ($document === 'results') {
            $result = $student->results()->latest('published_at')->first();

            if ($result) {
                return redirect()->route('super-admin.results.show', $result);
            }
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
            'certificateSerial' => $latestResult ? sprintf('CERT-%06d', $latestResult->id) : null,
        ];

        if ($document === 'admit-card') {
            $documentData = [...$documentData, ...$this->admitCardData($student, $qrCode)];
        }

        if ($document === 'registration-card') {
            $documentData = [...$documentData, ...$this->registrationCardData($student, $qrCode)];
        }

        if ($document === 'transcript') {
            $documentData = [
                ...$documentData,
                ...$this->transcriptData($student, $resultQrCode),
                'transcriptLetterGrade' => $grading->letterGradeForGpa($cumulativeGpa),
            ];
        }

        return view('super-admin.students.document', $documentData);
    }

    /**
     * @return array{
     *     admitCardSerial: string,
     *     admitCardInstituteCode: string,
     *     admitCardInstituteName: string,
     *     admitCardExamineeType: string,
     *     admitCardQrCode: string,
     *     admitCardQrUrl: string,
     *     admitCardPrintedAt: Carbon
     * }
     */
    private function admitCardData(Student $student, QrCodeService $qrCode): array
    {
        $admitCardQrUrl = route('home');

        return [
            'admitCardSerial' => sprintf('STU-%06d', $student->id),
            'admitCardInstituteCode' => self::DOCUMENT_INSTITUTE_CODE,
            'admitCardInstituteName' => self::DOCUMENT_INSTITUTE_NAME,
            'admitCardExamineeType' => self::ADMIT_CARD_EXAMINEE_TYPE,
            'admitCardQrCode' => $qrCode->dataUri($admitCardQrUrl),
            'admitCardQrUrl' => $admitCardQrUrl,
            'admitCardPrintedAt' => now(),
        ];
    }

    /**
     * @return array{
     *     registrationCardSerial: string,
     *     registrationCardInstituteCode: string,
     *     registrationCardInstituteName: string,
     *     registrationCardQrCode: string,
     *     registrationCardQrUrl: string
     * }
     */
    private function registrationCardData(Student $student, QrCodeService $qrCode): array
    {
        $registrationCardQrUrl = route('home');

        return [
            'registrationCardSerial' => sprintf('STU-%06d', $student->id),
            'registrationCardInstituteCode' => self::DOCUMENT_INSTITUTE_CODE,
            'registrationCardInstituteName' => self::DOCUMENT_INSTITUTE_NAME,
            'registrationCardQrCode' => $qrCode->dataUri($registrationCardQrUrl),
            'registrationCardQrUrl' => $registrationCardQrUrl,
        ];
    }

    /**
     * @return array{
     *     transcriptPages: Collection<int, array{
     *         result: StudentResult|null,
     *         subjects: Collection<int, mixed>,
     *         isContinuation: bool,
     *         isSemesterFinal: bool,
     *         serial: string|null,
     *         outcome: string|null,
     *         verificationQrCode: string|null,
     *         verificationUrl: string|null,
     *         verificationReference: string|null
     *     }>,
     *     transcriptInstituteName: string
     * }
     */
    private function transcriptData(Student $student, ResultQrCodeService $qrCode): array
    {
        $publishedResults = $student->results()
            ->where('status', 'published')
            ->whereNotNull('published_at')
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

        $transcriptPages = $publishedResults->flatMap(function (StudentResult $result) use ($qrCode): Collection {
            $subjectChunks = $result->subjects->chunk(7);
            $verificationUrl = $result->verification_token
                ? route('results.show', $result->verification_token)
                : null;
            $verificationQrCode = $verificationUrl ? $qrCode->dataUri($result) : null;

            if ($subjectChunks->isEmpty()) {
                $subjectChunks = collect([collect()]);
            }

            return $subjectChunks->values()->map(fn (Collection $subjects, int $chunkIndex): array => [
                'result' => $result,
                'subjects' => $subjects,
                'isContinuation' => $chunkIndex > 0,
                'isSemesterFinal' => $chunkIndex === $subjectChunks->count() - 1,
                'serial' => sprintf('TRANS-%06d', $result->id),
                'outcome' => $result->overall_grade === null
                    ? null
                    : ($result->overall_grade === 'F' ? 'Failed' : 'Passed'),
                'verificationQrCode' => $verificationQrCode,
                'verificationUrl' => $verificationUrl,
                'verificationReference' => $result->verification_token,
            ]);
        })->values();

        if ($transcriptPages->isEmpty()) {
            $transcriptPages->push([
                'result' => null,
                'subjects' => collect(),
                'isContinuation' => false,
                'isSemesterFinal' => true,
                'serial' => null,
                'outcome' => null,
                'verificationQrCode' => null,
                'verificationUrl' => null,
                'verificationReference' => null,
            ]);
        }

        return [
            'transcriptPages' => $transcriptPages,
            'transcriptInstituteName' => self::DOCUMENT_INSTITUTE_NAME,
        ];
    }
}
