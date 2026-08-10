<?php

namespace App\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeService
{
    public function dataUri(string $data): string
    {
        return (new Builder(
            writer: new PngWriter,
            data: $data,
            size: 280,
            margin: 10,
        ))->build()->getDataUri();
    }
}
