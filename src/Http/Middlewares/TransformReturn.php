<?php

namespace NodeAdmin\Http\Middlewares;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use NodeAdmin\Lib\NodeContent\NodeResponse;

class TransformReturn
{
    public function handle(Request $request,\Closure $next){
        /** @var Response $response */
        $response = $next($request);
        if ($response->exception){
            return $response;
        }

        if ($request->expectsJson()) {
            if ($response instanceof NodeResponse) {
                return $response;
            } elseif ($response instanceof JsonResponse) {
                $res = new NodeResponse(json_decode($response->getContent()));
                return $res;
            }
            $res = new NodeResponse($response->original);
            return $res;
        }else{
            return $response;
        }
    }
}
