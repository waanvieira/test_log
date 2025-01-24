<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\UserExternalService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserExternalController extends Controller
{
    public function __construct(
        protected UserExternalService $userExternalService
    ) {}

    public function index(Request $request)
    {
        $response = $this->userExternalService->getAllPaginateWithCache('', '', intval($request->page));
        return response()->json([$response], Response::HTTP_OK);
    }
}
