<?php

namespace App\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class ApiVerification implements IMiddleware
{
	public function handle(Request $request): void
	{
		/**
		 * Clarence Andaya API Logic 07-13-2022
		 * 0. check if key is present
		 * 1. check if api key valid
		 * 2. check if has access to current uri
		 * 3. log the access
		 */

		// echo url(null, null, array());
		// exit;

		if (empty(input('key'))) {
			response()->json(array('status' => 0, "message" => "Parameter (key) is required."));
		}
		$api = new \App\Models\Api();
		$api_data = $api->getApi(array(input('key')));
		if (empty($api_data)) {
			response()->json(array('status' => 0, "message" => "Invalid key."));
		}
		$api_access_uri_data = $api->getApiAccessUri(array($api_data['id'], url(null, null, array())));
		if (empty($api_access_uri_data)) {
			response()->json(array('status' => 0, "message" => "Key has no access to this API."));
		}

		$api_log_arr = array(
			$api_access_uri_data['id'],
			\App\Utilities\Utility::clientIP(),
			\App\Utilities\Utility::clientUserAgent(),
			null,
		);
		$api->createApiLog($api_log_arr);
	}
}
