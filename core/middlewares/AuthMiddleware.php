<?php

namespace App\Core\Middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Exception;

class AuthMiddleware
{
  public function handle(ServerRequestInterface $request, $next) {
    $accessToken = $request->getHeader("Authorization");

    if ($accessToken) {
      return $next($request);
    }

    return new JsonResponse([
      'error' => "Yêu cầu đăng nhập để sử dụng chức năng này!"
    ], 401);
  }
}