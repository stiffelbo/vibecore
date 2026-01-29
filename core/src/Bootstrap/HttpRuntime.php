<?php declare(strict_types=1);

namespace VibeCore\Bootstrap;

use VibeCore\Http\Request;
use VibeCore\Http\Response;
use VibeCore\Http\RequestFactory;
use VibeCore\Http\ResponseEmitter;
use VibeCore\Http\HttpKernelInterface;

final class HttpRuntime
{
    public function __construct(
        private readonly HttpKernelInterface $kernel,
        private readonly RequestFactory $requestFactory,
        private readonly ResponseEmitter $emitter,
    ) {}

    public function handle(Request $request): Response
    {
        return $this->kernel->handle($request);
    }

    public function handleGlobals(): Response
    {
        return $this->handle($this->requestFactory->fromGlobals());
    }

    public function emit(Response $response): void
    {
        $this->emitter->emit($response);
    }
}
