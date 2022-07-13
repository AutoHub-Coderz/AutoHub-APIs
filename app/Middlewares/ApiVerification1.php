<?php

namespace App\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class ApiVerification1 implements IMiddleware
{
	public function handle(Request $request): void
	{
		$request->authenticated = true;
	}
}
