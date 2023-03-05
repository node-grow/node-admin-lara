<?php

namespace NodeAdmin\Http\Middlewares;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use NodeAdmin\Exceptions\NodeException;

class TransformException
{
    public function handle(Request $request, \Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);
        if ($response->exception) {
            $e = $response->exception;
            $ne = new NodeException($e->getMessage(), $e->getCode() ?? 0, $e);
            if ($e instanceof ValidationException){
                $message=$e->validator->errors()
                    ?$e->validator->errors()->first()
                    :$e->getMessage();
                $ne->setMessage($message);
                $ne->errors=$e->errors();
            }
            $ne->http_code = $response->getStatusCode() ?? 400;
            throw $ne;
        }
        return $response;
    }


}
