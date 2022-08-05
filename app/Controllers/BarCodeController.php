<?php

namespace App\Controllers;

use App\Core\Controller;



class BarCodeController extends Controller
{
    public static function generate()
    {

        if (empty(input('data'))) {
            response()->json(array("status" => 0, "message" => "data parameter is required."));
        }

        $color = [0, 0, 0];
        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

        // file_put_contents('barcode.jpg', $generator->getBarcode(input('data'), $generator::TYPE_CODE_128, 3, 50, $color));

        header('Content-Type: image/png');
        if (!empty(input('filename'))) {
            header("Content-Disposition: inline;filename=" . input('filename') . ".png");
        }
        echo $generator->getBarcode(input('data'), $generator::TYPE_CODE_128, 3, 50, $color);

        // echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode(input('data'), $generator::TYPE_CODE_128)) . '">';

    }
}
