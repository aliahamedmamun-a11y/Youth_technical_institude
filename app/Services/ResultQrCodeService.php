<?php

namespace App\Services;

use App\Models\StudentResult;

class ResultQrCodeService
{
    public function __construct(private QrCodeService $qrCode) {}

    public function dataUri(StudentResult $result): string
    {
        if (! $result->verification_token) {
            $token = bin2hex(random_bytes(16));
            $result->forceFill(['verification_token' => $token])->saveQuietly();
        }

        return $this->qrCode->dataUri(route('results.show', $result->verification_token));
    }
}
