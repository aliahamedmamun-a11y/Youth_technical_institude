<?php

namespace App\Services;

use App\Models\StudentResult;

class ResultQrCodeService
{
    public function __construct(private QrCodeService $qrCode) {}

    public function dataUri(StudentResult $result): string
    {
        return $this->qrCode->dataUri(route('results.show', $result->verification_token));
    }
}
