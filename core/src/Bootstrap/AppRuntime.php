<?php declare(strict_types=1);

namespace VibeCore\Bootstrap;

final class AppRuntime
{
    public function __construct(
        private readonly HttpRuntime $http,
    ) {}

    public function http(): HttpRuntime
    {
        return $this->http;
    }
}
