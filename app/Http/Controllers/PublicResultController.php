<?php

namespace App\Http\Controllers;

use App\Models\StudentResult;
use App\Services\ResultGradingService;
use App\Services\ResultQrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            $results = StudentResult::query()
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->whereHas('student', fn ($query) => $query->where('roll_number', $rollNumber))
                ->with('semesterDefinition')
                ->latest('published_at')
                ->get();

            if ($results->isNotEmpty()) {
                return redirect()->route('results.show', $results->first()->verification_token);
            }
        }

        return view('results.index', ['searched' => $rollNumber !== '', 'rollNumber' => $rollNumber]);
    }

    public function show(string $verificationToken, ResultQrCodeService $qrCode, ResultGradingService $grading): View
    {
        $result = StudentResult::query()
            ->where('verification_token', $verificationToken)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->with(['student.course', 'subjects'])
            ->firstOrFail();

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

        $qrCodes = $allResults->mapWithKeys(fn (StudentResult $semesterResult): array => [
            $semesterResult->id => $qrCode->dataUri($semesterResult),
        ]);

        return view('results.sheet', ['result' => $result, 'allResults' => $allResults, 'qrCodes' => $qrCodes, 'semesterResults' => $semesterResults, 'cumulativeGpa' => $grading->cumulativeGpa($result->student), 'qrCode' => $qrCode->dataUri($result), 'adminPreview' => false]);
    }
}
