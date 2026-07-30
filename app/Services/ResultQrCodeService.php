<?php

namespace App\Services;

use App\Models\StudentResult;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class ResultQrCodeService
{
    public function dataUri(StudentResult $result): string
    {
        return (new Builder(
            writer: new PngWriter,
            data: route('results.show', $result->verification_token),
            size: 280,
            margin: 10,
        ))->build()->getDataUri();
    }
}
