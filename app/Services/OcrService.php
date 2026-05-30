<?php

namespace App\Services;

class OcrService
{
    public function extractText(string $filePath): string
{
if (strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === 'pdf') {
    $pdfPrefix = storage_path('app/pdf_page_' . uniqid());

    $cmd = 'pdftoppm -png '
        . escapeshellarg($filePath) . ' '
        . escapeshellarg($pdfPrefix) . ' 2>&1';

    exec($cmd, $out, $code);

    $images = glob($pdfPrefix . '-*.png');

    if (!$images) {
        file_put_contents(storage_path('app/ocr_debug.txt'), implode("\n", $out));
        return '';
    }

    sort($images);

    $allText = [];

    foreach ($images as $imageFile) {
        $pageText = $this->extractText($imageFile);

        if (trim($pageText) !== '') {
            $allText[] = $pageText;
        }
    }

    return trim(implode("\n\n", $allText));
}


    
        $outputBase = storage_path('app/ocr_output_' . uniqid());
        $processedImage = storage_path('app/ocr_prepared_' . uniqid() . '.png');
        $debugFile = storage_path('app/ocr_debug.txt');

        $prepareCommand = 'convert '
            . escapeshellarg($filePath)
            . ' -colorspace Gray -contrast -contrast -sharpen 0x1 '
            . escapeshellarg($processedImage)
            . ' 2>&1';

        exec($prepareCommand, $prepareOutput, $prepareCode);

        file_put_contents(
            $debugFile,
            "PREPARE CODE: {$prepareCode}\n" .
            "PREPARE OUTPUT:\n" . implode("\n", $prepareOutput) . "\n\n" .
            "PROCESSED IMAGE: {$processedImage}\n\n"
        );

        $command = 'tesseract '
            . escapeshellarg($processedImage) . ' '
            . escapeshellarg($outputBase)
            . ' -l rus+eng --oem 3 --psm 6 2>&1';

        exec($command, $output, $code);

        file_put_contents(
            $debugFile,
            "TESSERACT CODE: {$code}\n" .
            "TESSERACT OUTPUT:\n" . implode("\n", $output) . "\n\n",
            FILE_APPEND
        );

        $textFile = $outputBase . '.txt';

        if ($code !== 0 || !file_exists($textFile)) {
            return '';
        }

        $text = file_get_contents($textFile);

        file_put_contents(
            $debugFile,
            "OCR TEXT:\n" . $text . "\n",
            FILE_APPEND
        );

        return trim($text);
    }
}