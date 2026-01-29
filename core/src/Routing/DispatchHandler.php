<?php declare(strict_types=1);

namespace VibeCore\Routing;

use VibeCore\Http\{HandlerInterface, Request, RequestContext, Response};

final class DispatchHandler implements HandlerInterface
{
    public function __construct(
        private readonly RouterInterface $router,
        private readonly HandlerInterface $notFound,
    ) {}

    public function handle(Request $request, RequestContext $ctx): Response
    {
        $match = $this->router->match($request->method(), $request->path());

        if ($match === null) {
            return $this->notFound->handle($request, $ctx);
        }

        $req = $request;
        foreach ($match->params as $k => $v) {
            $req = $req->withAttribute($k, $v);
        }

        return $match->route->handler->handle($req, $ctx);
    }
}
