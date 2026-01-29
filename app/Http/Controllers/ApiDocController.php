<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Cellphones API",
 *     version="1.0.0",
 *     description="API documentation for the Cellphones system"
 * )
 * 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Main API server"
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Nhập token JWT vào ô Authorization",
 *     name="Authorization",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth"
 * )
 *
 */
class ApiDocController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ping",
     *     tags={"Health Check"},
     *     summary="Health check endpoint",
     *     description="Returns a simple pong message to verify that the API is running.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="pong")
     *         )
     *     )
     * )
     */
    public function ping()
    {
        return response()->json(['message' => 'pong']);
    }
}
