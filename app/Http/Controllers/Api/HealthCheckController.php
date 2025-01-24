<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class HealthCheckController extends Controller
{
    public function health()
    {
        return response()->json([
            'app' => env('APP_NAME'),
            'external_link' => true,
            'version'   => date("d/m/Y H:m:i")
        ], Response::HTTP_OK);
    }
}
