<?php

namespace App\Http\Middleware;

use App\Core\Util;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TransformApiRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log::info('TransformApiRequest', [
        //     'path' => $request->path(),
        //     'method' => $request->method(),
        //     'content_type' => $request->header('Content-Type'),
        //     'raw_content' => $request->getContent(),
        //     'isJson' => $request->isJson(),
        // ]);

        $request->query->replace(Util::convertKeysToSnakeCase($request->query()));

        // Handle JSON body (common for APIs)
        if ($request->isJson()) {
            $json = $request->json()->all();
            if (is_array($json) && $json) {
                $request->merge(Util::convertKeysToSnakeCase($json));
            }
        } elseif ($request->post()) {
            $request->replace(Util::convertKeysToSnakeCase($request->post()));
        }

        return $next($request);
    }
}
