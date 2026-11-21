<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentResult;
use App\Services\QrCodeService;
use App\Services\ResultGradingService;
use App\Services\ResultQrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PublicResultController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'roll_number' => ['sometimes', 'required', 'string', 'max:50'],
        ]);
        $rollNumber = trim((string) ($validated['roll_number'] ?? ''));

        if ($rollNumber !== '') {
            $searchType = $request->query('type', $request->input('type'));

            $student = Student::query()
                ->where('roll_number', $rollNumber)
                ->orWhere('registration_number', $rollNumber)
                ->orWhere('id', (int) $rollNumber)
                ->orWhere('passport_nid_number', $rollNumber)
                ->first();

            if (! $student) {
                $result = StudentResult::query()
                    ->whereHas('student', function ($query) use ($rollNumber) {
                        $query->where('roll_number', $rollNumber)
                            ->orWhere('registration_number', $rollNumber)
                            ->orWhere('id', (int) $rollNumber)
                            ->orWhere('passport_nid_number', $rollNumber);
                    })
                    ->latest('published_at')
                    ->first();

                if ($result) {
                    $student = $result->student;
                }
            }

            if ($student) {
                $result = $student->results()->where('status', 'published')->latest('published_at')->first();

                if (! $result) {
                    $result = $student->results()->create([
                        'semester' => '1st Semester',
                        'session' => $student->session ?: '2025-2026',
                        'gpa' => $student->cgpa,
                        'overall_grade' => $student->grade,
                        'status' => 'published',
                        'verification_token' => Str::random(48),
                        'published_at' => now(),
                    ]);
                }

                if (! $result->verification_token) {
                    $result->forceFill(['verification_token' => Str::random(48)])->saveQuietly();
                }

                if ($searchType === 'certificate') {
                    return redirect()->route('public.certificate', $result->verification_token);
                }

                return redirect()->route('results.show', $result->verification_token);
            }
        }

        return view('results.index', ['searched' => $rollNumber !== '', 'rollNumber' => $rollNumber]);
    }

    public function show(string $verificationToken, ResultQrCodeService $qrCode, ResultGradingService $grading, Request $request): View
    {
        $result = StudentResult::query()
            ->where('verification_token', $verificationToken)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->with(['student.course', 'subjects'])
            ->first();

        if (! $result) {
            $student = Student::query()
                ->where('registration_number', $verificationToken)
                ->orWhere('roll_number', $verificationToken)
                ->orWhere('id', (int) $verificationToken)
                ->firstOrFail();

            $result = $student->results()
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->first();

            if (! $result) {
                $result = new StudentResult([
                    'student_id' => $student->id,
                    'semester' => '1st Semester',
                    'session' => $student->session,
                    'gpa' => $student->cgpa,
                    'overall_grade' => $student->grade,
                    'status' => 'published',
                    'published_at' => $student->created_at,
                ]);
                $result->setRelation('student', $student);
                $result->setRelation('subjects', collect());
            }
        }

        $viewStyle = $request->query('style', $request->query('view', 'all'));

        $semesterResults = StudentResult::query()
            ->whereBelongsTo($result->student)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->orderBy('semester')
            ->get(['semester', 'verification_token']);

        $allResults = StudentResult::query()
            ->whereBelongsTo($result->student)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->with('subjects')
            ->orderBy('semester')
            ->get();

        if ($allResults->isEmpty()) {
            $allResults = collect([$result]);
        }

        $qrCodes = $allResults->mapWithKeys(fn (StudentResult $semesterResult): array => [
            $semesterResult->id ?? 0 => $qrCode->dataUri($semesterResult),
        ]);

        return view('results.sheet', [
            'result' => $result,
            'allResults' => $allResults,
            'qrCodes' => $qrCodes,
            'semesterResults' => $semesterResults,
            'cumulativeGpa' => $grading->cumulativeGpa($result->student) ?: $result->student->cgpa ?: $result->gpa,
            'qrCode' => $qrCode->dataUri($result),
            'adminPreview' => false,
            'viewStyle' => $viewStyle,
        ]);
    }

    private function resolveStudent(string $verificationToken): Student
    {
        $result = StudentResult::query()
            ->where('verification_token', $verificationToken)
            ->first();

        if ($result && $result->student) {
            return $result->student;
        }

        return Student::query()
            ->where('registration_number', $verificationToken)
            ->orWhere('roll_number', $verificationToken)
            ->orWhere('id', (int) $verificationToken)
            ->firstOrFail();
    }

    public function verifyCertificate(
        string $verificationToken,
        SuperAdmin\StudentDocumentController $documentController,
        ResultGradingService $grading,
        ResultQrCodeService $resultQrCode,
        QrCodeService $qrCode
    ): View|RedirectResponse {
        $result = StudentResult::query()->where('verification_token', $verificationToken)->first();

        if ($result && $result->verification_token) {
            return redirect()->route('results.show', $result->verification_token);
        }

        $student = $this->resolveStudent($verificationToken);
        $latestResult = $student->results()->where('status', 'published')->latest('published_at')->first();

        if ($latestResult?->verification_token) {
            return redirect()->route('results.show', $latestResult->verification_token);
        }

        return redirect()->route('results.index', ['roll_number' => $student->roll_number]);
    }

    public function verifyAdmitCard(
        string $verificationToken,
        SuperAdmin\StudentDocumentController $documentController,
        ResultGradingService $grading,
        ResultQrCodeService $resultQrCode,
        QrCodeService $qrCode
    ): View|RedirectResponse {
        $student = $this->resolveStudent($verificationToken);

        return $documentController->show($student, 'admit-card', $grading, $resultQrCode, $qrCode, true);
    }

    public function verifyRegistrationCard(
        string $verificationToken,
        SuperAdmin\StudentDocumentController $documentController,
        ResultGradingService $grading,
        ResultQrCodeService $resultQrCode,
        QrCodeService $qrCode
    ): View|RedirectResponse {
        $student = $this->resolveStudent($verificationToken);

        return $documentController->show($student, 'registration-card', $grading, $resultQrCode, $qrCode, true);
    }

    public function verifyStudentId(
        string $verificationToken,
        SuperAdmin\StudentDocumentController $documentController,
        ResultGradingService $grading,
        ResultQrCodeService $resultQrCode,
        QrCodeService $qrCode
    ): View|RedirectResponse {
        $student = $this->resolveStudent($verificationToken);

        return $documentController->show($student, 'student-id', $grading, $resultQrCode, $qrCode, true);
    }

    public function verifyTestimonial(
        string $verificationToken,
        SuperAdmin\StudentDocumentController $documentController,
        ResultGradingService $grading,
        ResultQrCodeService $resultQrCode,
        QrCodeService $qrCode
    ): View|RedirectResponse {
        $student = $this->resolveStudent($verificationToken);

        return $documentController->show($student, 'testimonial', $grading, $resultQrCode, $qrCode, true);
    }

    public function verifyTranscript(
        string $verificationToken,
        SuperAdmin\StudentDocumentController $documentController,
        ResultGradingService $grading,
        ResultQrCodeService $resultQrCode,
        QrCodeService $qrCode
    ): View|RedirectResponse {
        $student = $this->resolveStudent($verificationToken);

        return $documentController->show($student, 'transcript', $grading, $resultQrCode, $qrCode, true);
    }
}
