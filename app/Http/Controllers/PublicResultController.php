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
            $result = StudentResult::query()
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->whereHas('student', fn ($query) => $query->where('roll_number', $rollNumber))
                ->latest('published_at')
                ->first();

            if ($result) {
                return redirect()->route('results.show', $result->verification_token);
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

        return view('results.sheet', ['result' => $result, 'cumulativeGpa' => $grading->cumulativeGpa($result->student), 'qrCode' => $qrCode->dataUri($result), 'adminPreview' => false]);
    }
}
