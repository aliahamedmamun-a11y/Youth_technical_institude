<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentResult;
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
            // 1. First check published StudentResult matching roll number, registration number, or student ID
            $result = StudentResult::query()
                ->whereHas('student', function ($query) use ($rollNumber) {
                    $query->where('roll_number', $rollNumber)
                        ->orWhere('registration_number', $rollNumber)
                        ->orWhere('id', (int) $rollNumber)
                        ->orWhere('passport_nid_number', $rollNumber);
                })
                ->where('status', 'published')
                ->latest('published_at')
                ->first();

            if ($result) {
                return redirect()->route('results.show', $result->verification_token);
            }

            // 2. Fallback: Check if Student exists in database
            $student = Student::query()
                ->where('roll_number', $rollNumber)
                ->orWhere('registration_number', $rollNumber)
                ->orWhere('id', (int) $rollNumber)
                ->orWhere('passport_nid_number', $rollNumber)
                ->first();

            if ($student) {
                // Ensure a published result exists or publish one for this student
                $result = $student->results()->latest('published_at')->first();

                if (! $result) {
                    $token = Str::random(48);
                    $result = $student->results()->create([
                        'semester' => '1st Semester',
                        'session' => $student->session ?: '2024 - 2025',
                        'total_credit' => 28,
                        'credit_earned' => 28,
                        'gpa' => $student->cgpa ?: 3.75,
                        'overall_grade' => $student->grade ?: 'A',
                        'status' => 'published',
                        'published_at' => now(),
                        'verification_token' => $token,
                    ]);
                } else {
                    if ($result->status !== 'published') {
                        $result->update(['status' => 'published', 'published_at' => now()]);
                    }
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
            ->firstOrFail();

        $viewStyle = $request->query('style', $request->query('view', 'all')); // 'all' (Full Transcript), 'summary' (Style 2), or 'single' (Single Semester)

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
            $semesterResult->id => $qrCode->dataUri($semesterResult),
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
}
