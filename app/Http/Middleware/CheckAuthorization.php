<?php

namespace App\Http\Middleware;

use App\Services\AuthorizationService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $module_code): Response
    {
      if (auth()->check()) {
        $authorization_service = new AuthorizationService;

        if ($authorization_service->check_authorization($module_code)) {
          return $next($request);
        }

        if ($request->hasHeader("Accept") && $request->header("Accept") == "application/json") {
          return response()->json([
            "status" => FALSE,
            "message" => "Unauthorized",
            "status_code" => 403,
          ], 403);
        }

        return redirect()->to("/forbidden");
      }

      return redirect()->to("/login");
    }
}
