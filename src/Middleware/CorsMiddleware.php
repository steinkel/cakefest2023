<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Cake\Http\CorsBuilder;

/**
 * Cors middleware
 */
class CorsMiddleware implements MiddlewareInterface
{
    /**
     * Process method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // enable CORS headers, for example, only for Users controller
        $params = $request->getAttribute('params');
        $controller = $params['controller'] ?? null;
        if ($controller !== 'Users') {
            return $handler->handle($request);
        }
        $response = $handler->handle($request);
        $serverParams = $request->getServerParams();
        $https = $serverParams['HTTPS'] ?? false;
        $corsBuilder = new CorsBuilder($response, $request->getHeaderLine('Origin'), $https);

        return $corsBuilder
            ->allowOrigin(['blog.example.com:8767'])
            ->allowMethods(['GET'])
            //->allowHeaders(['X-CSRF-Token'])
            ->allowCredentials()
            //->exposeHeaders(['Link'])
            ->maxAge(300)
            ->build();
    }
}
