<?php

namespace App\Models;

//Tips for impelementing codes

use App\Core\Model;
use App\Core\Database;

class Api extends Model
{
    public function getApi($array_data)
    {
        $query = "SELECT * FROM api_keys WHERE 1 AND status = 1 AND api_key = ?";
        $paramType = "s";
        $response = Database::connect()->runQuery($query, $paramType, $array_data);
        return count($response) > 0 ? $response[0] : $response;
    }

    public function getApiAccessUri($array_data)
    {
        $query = "SELECT * FROM api_key_access_uris WHERE 1 AND status = 1 AND api_key_id = ? AND uri = ?";
        $paramType = "is";
        $response = Database::connect()->runQuery($query, $paramType, $array_data);
        return count($response) > 0 ? $response[0] : $response;
    }

    public function createApiLog($array_data)
    {
        $query = "INSERT INTO `api_logs` VALUES (null,?,?,?,?,NOW())";
        $paramType = "isss";
        $response = Database::connect()->insert($query, $paramType, $array_data);
        return $response;
    }
}
