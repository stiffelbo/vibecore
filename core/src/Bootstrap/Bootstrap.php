<?php declare(strict_types=1);

namespace VibeCore\Bootstrap;

use VibeCore\Http\HttpKernelInterface;
use VibeCore\Http\RequestFactory;
use VibeCore\Http\ResponseEmitter;

final class Bootstrap
{
    private ?string $timezone = null;

    private ?HttpKernelInterface $httpKernel = null;
    private ?RequestFactory $requestFactory = null;
    private ?ResponseEmitter $emitter = null;

    private function __construct() {}

    public static function create(): self
    {
        return new self();
    }

    public function timezone(string $timezone): self
    {
        $this->timezone = $timezone;
        return $this;
    }

    public function http(
        HttpKernelInterface $kernel,
        ?RequestFactory $requestFactory = null,
        ?ResponseEmitter $emitter = null,
    ): self {
        $this->httpKernel = $kernel;
        $this->requestFactory = $requestFactory;
        $this->emitter = $emitter;
        return $this;
    }

    public function build(): AppRuntime
    {
        if ($this->timezone !== null) {
            date_default_timezone_set($this->timezone);
        }

        if ($this->httpKernel === null) {
            throw new \LogicException('Bootstrap: HTTP kernel is not configured.');
        }

        $requestFactory = $this->requestFactory ?? RequestFactory::default();
        $emitter = $this->emitter ?? new ResponseEmitter();

        return new AppRuntime(
            new HttpRuntime(
                kernel: $this->httpKernel,
                requestFactory: $requestFactory,
                emitter: $emitter,
            )
        );
    }
}
