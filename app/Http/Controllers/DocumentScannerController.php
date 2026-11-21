<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class DocumentScannerController extends Controller
{
    public function scan(Request $request): JsonResponse
    {
        try {
            $file = $request->file('document');
            if (! $file) {
                return response()->json(['success' => false, 'message' => 'No file uploaded'], 200);
            }

            $mimeType = $file->getClientMimeType() ?: 'application/pdf';
            if (strtolower($file->getClientOriginalExtension()) === 'pdf') {
                $mimeType = 'application/pdf';
            }

            $base64Data = base64_encode(file_get_contents($file->getRealPath()));
            $docType = strtolower($request->input('doc_type', 'passport'));

            if (str_contains($docType, 'nid')) {
                $docType = 'nid';
            } elseif (str_contains($docType, 'birth')) {
                $docType = 'birth_reg';
            } else {
                $docType = 'passport';
            }

            $prompt = "You are an expert Bangladeshi document OCR & data extraction system.
Analyze this {$docType} document (Image or PDF) and extract the exact student details into JSON.

Rules:
1. Translate or transliterate Bangla names into English Title Case (e.g., 'Md. Tanvir Ahmed', 'Sagar Roy').
2. Format 'dob' strictly as YYYY-MM-DD (e.g., 1985-12-31).
3. For 'gender', return 'Male' or 'Female'.
4. For 'id_number', extract Passport Number (e.g., A16954295), NID Number (10, 13, or 17 digits), or Birth Reg Number.
5. For 'phone', extract mobile number (01XXXXXXXXX).
6. For 'address', extract full address in English Title Case.

Return ONLY a valid JSON object with exact keys:
{
    \"student_name\": \"\",
    \"father_name\": \"\",
    \"mother_name\": \"\",
    \"dob\": \"\",
    \"gender\": \"\",
    \"id_number\": \"\",
    \"phone\": \"\",
    \"address\": \"\"
}";

            $apiKey = env('GEMINI_API_KEY') ?: config('services.gemini.key');

            if ($apiKey && ! str_starts_with($apiKey, 'your_')) {
                $models = ['gemini-2.5-flash', 'gemini-1.5-flash', 'gemini-2.0-flash-exp'];
                foreach ($models as $model) {
                    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
                    $res = Http::timeout(30)->post($url, [
                        'contents' => [[
                            'parts' => [
                                ['text' => $prompt],
                                ['inline_data' => ['mime_type' => $mimeType, 'data' => $base64Data]],
                            ],
                        ]],
                        'generationConfig' => [
                            'responseMimeType' => 'application/json',
                            'temperature' => 0.1,
                        ],
                    ]);

                    if ($res->successful()) {
                        $result = $res->json();
                        $jsonText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
                        $extractedData = json_decode($jsonText, true);

                        if (is_array($extractedData) && ! empty($extractedData)) {
                            $titleFields = ['student_name', 'father_name', 'mother_name', 'address'];
                            foreach ($titleFields as $field) {
                                if (! empty($extractedData[$field])) {
                                    $extractedData[$field] = ucwords(strtolower(trim($extractedData[$field])));
                                }
                            }

                            return response()->json([
                                'success' => true,
                                'data' => $extractedData,
                            ], 200);
                        }
                    }
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Local scanner fallback enabled',
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 200);
        }
    }
}
