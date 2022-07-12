<?php

namespace App\Controllers;

use App\Core\Controller;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
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


        $writer = new PngWriter();

        // Create QR code
        $qrCode = QrCode::create('Data')
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        // Create generic logo 
        $logo = Logo::create('../public/assets/img/logo/AGC_CIRCLE.png')
            ->setResizeToWidth(80);
            

        // Create generic label
        $label = Label::create('Arnel')
            ->setTextColor(new Color(255, 0, 0));

        // $result = $writer->write($qrCode, $logo, $label);
        $result = $writer->write($qrCode, input('logo') ? $logo : null, $label);

        // Directly output the QR code
        header('Content-Type: ' . $result->getMimeType());
        echo $result->getString();

        // Save it to a file
        // $result->saveToFile(__DIR__ . '/qrcode.png');

        // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        // $dataUri = $result->getDataUri();
    }
}
