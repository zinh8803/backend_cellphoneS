<?php

namespace App\Http\Middleware;

use App\Core\Util;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TransformApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Normalize ALL JSON responses (success + error) to a consistent shape
        if ($response instanceof JsonResponse) {
            $status = $response->getStatusCode();
            $payload = $response->getData(true) ?? [];

            if (is_array($payload) && $payload) {
                $payload = Util::convertKeysToCamelCase($payload);
            }

            // Avoid double-wrapping if controller already returns our envelope
            $alreadyWrapped = is_array($payload)
                && array_key_exists('status', $payload)
                && array_key_exists('message', $payload)
                && (array_key_exists('data', $payload) || array_key_exists('errors', $payload));

            if ($alreadyWrapped) {
                $payload['status'] = $payload['status'] ?? $status;
                $response->setStatusCode($status);
                $response->setData($payload);
                return $response;
            }

            $message =
                (is_array($payload) && isset($payload['message']) && is_string($payload['message']))
                ? $payload['message']
                : (Response::$statusTexts[$status] ?? ($response->isSuccessful() ? 'OK' : 'Error'));

            // Laravel validation errors: { message, errors: {...} }
            $errors = null;
            if (!$response->isSuccessful() && is_array($payload)) {
                $errors = $payload['errors'] ?? ($payload['error'] ?? null);
            }

            // For success: keep original payload as data unless it already has "data"
            $data = null;
            if ($response->isSuccessful()) {
                $data = (is_array($payload) && array_key_exists('data', $payload)) ? $payload['data'] : $payload;
            }

            $response->setData([
                'status' => $status,
                'message' => $message,
                'data' => $data,
                'errors' => $errors,
            ]);
            $response->setStatusCode($status);
            return $response;
        }

        return $response;
    }
}
