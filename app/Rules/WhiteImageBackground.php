<?php

namespace App\Rules;

use Closure;
use GdImage;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Translation\PotentiallyTranslatedString;

class WhiteImageBackground implements ValidationRule
{
    /** @var list<array{0: float, 1: float}> */
    private const array SAMPLE_POINTS = [
        [0.02, 0.02], [0.10, 0.02], [0.20, 0.02], [0.80, 0.02], [0.90, 0.02], [0.98, 0.02],
        [0.02, 0.15], [0.08, 0.15], [0.92, 0.15], [0.98, 0.15],
        [0.02, 0.40], [0.06, 0.40], [0.94, 0.40], [0.98, 0.40],
        [0.02, 0.65], [0.06, 0.65], [0.94, 0.65], [0.98, 0.65],
    ];

    private const int MINIMUM_WHITE_CHANNEL = 225;

    private const float REQUIRED_WHITE_RATIO = 0.8;

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile || ! $value->isValid()) {
            return;
        }

        if (! function_exists('imagecreatefromstring')) {
            $fail('Teacher photo background validation is temporarily unavailable.');

            return;
        }

        $contents = file_get_contents($value->getRealPath());
        $image = $contents === false ? false : @imagecreatefromstring($contents);

        if (! $image instanceof GdImage) {
            $fail('The teacher photo could not be inspected.');

            return;
        }

        try {
            $whiteSamples = 0;

            foreach (self::SAMPLE_POINTS as [$horizontalPosition, $verticalPosition]) {
                $x = (int) round((imagesx($image) - 1) * $horizontalPosition);
                $y = (int) round((imagesy($image) - 1) * $verticalPosition);
                $color = imagecolorsforindex($image, imagecolorat($image, $x, $y));

                if ($color['alpha'] >= 96 || min($color['red'], $color['green'], $color['blue']) >= self::MINIMUM_WHITE_CHANNEL) {
                    $whiteSamples++;
                }
            }
        } finally {
            imagedestroy($image);
        }

        if (($whiteSamples / count(self::SAMPLE_POINTS)) < self::REQUIRED_WHITE_RATIO) {
            $fail('The teacher photo must have a plain white background.');
        }
    }
}
