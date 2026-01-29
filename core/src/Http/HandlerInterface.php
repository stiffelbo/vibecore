<?php declare(strict_types=1);

namespace VibeCore\Http;

interface HandlerInterface
{
    public function handle(Request $request, RequestContext $ctx): Response;
}
