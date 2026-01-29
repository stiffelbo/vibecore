<?php declare(strict_types=1);

namespace VibeCore\Http;

interface MiddlewareInterface
{
    public function handle(Request $request, RequestContext $ctx, callable $next): Response;
}
