<?php

namespace App\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeService
{
    public function dataUri(string $data): string
    {
        return (new Builder(
            writer: new PngWriter,
            data: $data,
            size: 280,
            margin: 0,
            backgroundColor: new Color(255, 255, 255, 127),
        ))->build()->getDataUri();
    }
}
