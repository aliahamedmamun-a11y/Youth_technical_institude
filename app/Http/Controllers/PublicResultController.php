<?php

namespace App\Http\Controllers;

use App\Models\StudentResult;
use App\Services\ResultQrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicResultController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $registrationNumber = $request->string('registration_number')->trim()->toString();
        $rollNumber = $request->string('roll_number')->trim()->toString();

        if ($registrationNumber !== '' && $rollNumber !== '') {
            $result = StudentResult::query()
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->whereHas('student', fn ($query) => $query->where('registration_number', $registrationNumber)->where('roll_number', $rollNumber))
                ->latest('published_at')
                ->first();

            if ($result) {
                return redirect()->route('results.show', $result->verification_token);
            }
        }

        return view('results.index', ['searched' => $registrationNumber !== '' || $rollNumber !== '']);
    }

    public function show(string $verificationToken, ResultQrCodeService $qrCode): View
    {
        $result = StudentResult::query()
            ->where('verification_token', $verificationToken)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->with(['student.course', 'subjects'])
            ->firstOrFail();

        return view('results.sheet', ['result' => $result, 'qrCode' => $qrCode->dataUri($result), 'adminPreview' => false]);
    }
}
