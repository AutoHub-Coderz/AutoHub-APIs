<?php

namespace App\Controllers;

use App\Core\Controller;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class QRController extends Controller
{
    public static function generate()
    {

        // AGC_TRANSPARENT.png
        // AGC.png
        // Label
        // image = true false

        // Params:
        // logo
        // label
        if (empty(input('data'))) {
            response()->json(array("status" => 0, "message" => "data parameter is required."));
        }
        $label = input('label') ? input('label') : '';
        $image = input('logo') ? config('qr')->logo : config('qr')->no_logo;

        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data(input('data'))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->logoPath($image)
            ->labelText($label)
            ->labelFont(new NotoSans(20))
            ->labelAlignment(new LabelAlignmentCenter())
            ->build();

        // Directly output the QR code
        header('Content-Type: ' . $result->getMimeType());
        if (!empty(input('filename'))) {
            header("Content-Disposition: inline;filename=" . input('filename') . ".png");
        }
        echo $result->getString();

        // Save it to a file
        // $result->saveToFile(__DIR__ . '/qrcode.png');

        // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        $dataUri = $result->getDataUri();
    }
}
