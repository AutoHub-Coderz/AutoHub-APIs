<?php

namespace App\Controllers;

use App\Core\Controller;
use JsonMachine\JsonDecoder\ExtJsonDecoder;
use JsonMachine\Items;
use App\Core\View;
use App\Core\Resource;

class PlaceController extends Controller
{


    public static function place()
    {

        // ini_set('max_execution_time', '0');
        // set_time_limit(0);
        // //same code above
        // ini_set('memory_limit', '-1');

        // $generated_json = array();
        // $countries_old = Items::fromFile('../resources/json/place/countries1.json', ['decoder' => new ExtJsonDecoder(true)]);
        // $countries_new = Items::fromFile('../resources/json/place/countries+states+cities.json', ['decoder' => new ExtJsonDecoder(true)]);
        // foreach ($countries_new as $row) {
        //     $nationality = "";
        //     $flag = "";
        //     foreach ($countries_old as $row1) {
        //         if ($row['iso2'] == $row1['iso2']) {
        //             $nationality = $row1['nationality'];
        //             $flag = $row1['flag'];
        //         }
        //     }
        //     $row['flag'] = $flag;
        //     $row['nationality'] = $nationality;
        //     $generated_json = array_merge($generated_json, array($row));
        // }
        // $myfile = fopen("newfile.json", "w") or die("Unable to open file!");
        // fwrite($myfile, json_encode($generated_json));

        // fclose($myfile);
        // response()->json($generated_json);

        // $countries = Items::fromFile('../resources/json/place/countries+states+cities.json', ['pointer' => '/-/states']);
        // foreach ($countries as $name => $data) {
        //     print_r($data);
        // }
        // exit;


        $countries = Items::fromFile('../resources/json/place/countries+states+cities.json', ['decoder' => new ExtJsonDecoder(true)]);
        if (!empty(input('country')) && !empty(input('state')) && !empty(input('city'))) {
            // $countries = Items::fromFile('../resources/json/place/countries+states+cities.json', ['decoder' => new ExtJsonDecoder(true)]);
            $result = array();
            foreach ($countries as $name => $data) {
                $country_key = null;
                if (is_numeric(input('country'))) {
                    $country_key = 'id';
                } else {
                    $country_key = 'iso2';
                }

                if ($data[$country_key] == input('country')) {
                    foreach ($data['states'] as $stateK => $stateV) {
                        $state_key = null;
                        if (is_numeric(input('state'))) {
                            $state_key = 'id';
                        } else {
                            $state_key = 'state_code';
                        }
                        if ($stateV[$state_key] == input('state')) {
                            // response()->json($stateV['cities']);
                            $result = $stateV['cities'];
                            break;
                        }
                    }
                }
            }
            if (count($result)) {
                $result['status'] = 1;
                response()->json($result);
            } else {
                response()->json(array("status" => 0, "message" => "Country or state not found."));
            }
        } else if (!empty(input('country')) && !empty(input('state'))) {
            // $countries = Items::fromFile('../resources/json/place/countries+states+cities.json', ['decoder' => new ExtJsonDecoder(true)]);
            $result = array();
            foreach ($countries as $name => $data) {
                $country_key = null;
                if (is_numeric(input('country'))) {
                    $country_key = 'id';
                } else {
                    $country_key = 'iso2';
                }

                if ($data[$country_key] == input('country')) {
                    foreach ($data['states'] as $stateK => $stateV) {
                        unset($data['states'][$stateK]['cities']);
                    }
                    $result = $data;
                    break;
                    // response()->json($data['states']);
                }
            }
            if (count($result)) {
                $result['status'] = 1;
                response()->json($result);
            } else {
                response()->json(array("status" => 0, "message" => "Country not found."));
            }
        } else if (!empty(input('country'))) {
            // $countries = Items::fromFile('../resources/json/place/countries+states+cities.json', ['decoder' => new ExtJsonDecoder(true)]);
            $result = array();
            foreach ($countries as $name => $data) {
                $country_key = null;
                if (is_numeric(input('country'))) {
                    $country_key = 'id';
                } else {
                    $country_key = 'iso2';
                }
                if ($data[$country_key] == input('country')) {
                    // $data = array_diff_key($data, array_flip(["states"]));
                    unset($data['states']);
                    $result = $data;
                    break;
                }
            }
            if (count($result)) {
                $result['status'] = 1;
                response()->json($result);
            } else {
                response()->json(array("status" => 0, "message" => "Country not found."));
            }
        } else {
            // $countries = Items::fromFile('../resources/json/place/countries+states+cities.json', ['decoder' => new ExtJsonDecoder(true)]);
            $country_arr = array();
            foreach ($countries as $key => $value) {
                unset($value['states']);
                $country_arr = array_merge($country_arr, array($value));
            }
            response()->json($country_arr);
        }
    }
}
