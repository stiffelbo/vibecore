<?php declare(strict_types=1);

namespace VibeCore\Http;

interface HttpKernelInterface
{
    public function handle(Request $request): Response;
}
