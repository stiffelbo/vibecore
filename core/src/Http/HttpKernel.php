<?php declare(strict_types=1);

namespace VibeCore\Http;

final class HttpKernel implements HttpKernelInterface
{
    /** @var MiddlewareInterface[] */
    private array $middlewares;

    public function __construct(
        array $middlewares,
        private readonly HandlerInterface $handler,
        private readonly ?RequestContext $baseContext = null,
    ) {
        foreach ($middlewares as $mw) {
            if (!$mw instanceof MiddlewareInterface) {
                throw new \InvalidArgumentException('HttpKernel: all middlewares must implement MiddlewareInterface.');
            }
        }
        $this->middlewares = array_values($middlewares);
    }

    public function handle(Request $request): Response
    {
        $ctx = $this->baseContext ?? RequestContext::empty();

        /** @var callable(Request, RequestContext): Response $next */
        
        $next = function (Request $req, RequestContext $ctx) : Response {
            return $this->handler->handle($req, $ctx);
        };

        // last middleware wraps handler, then previous wraps that, etc.
        for ($i = count($this->middlewares) - 1; $i >= 0; $i--) {
            $mw = $this->middlewares[$i];
            $prevNext = $next;

            $next = function (Request $req, RequestContext $ctx) use ($mw, $prevNext): Response {
                return $mw->handle($req, $ctx, $prevNext);
            };
        }

        return $next($request, $ctx);
    }
}
