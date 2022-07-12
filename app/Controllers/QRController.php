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

        $label = input('label') ? input('label') : '';
        $data = input('data') ? input('data') : '';
        $image = input('image') ? '../public/assets/img/logo/AGC_CIRCLE.png' :  '../public/assets/img/logo/blank.png';

        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($data)
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
        echo $result->getString();

        // Save it to a file
        // $result->saveToFile(__DIR__ . '/qrcode.png');

        // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        $dataUri = $result->getDataUri();
    }
}
