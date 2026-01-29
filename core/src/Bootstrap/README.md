# VibeCore /Http

## Intent

Provide the lowest-level application bootstrap and runtime composition layer.
Bootstrap is responsible for assembling infrastructure components into runnable kernels, without imposing framework conventions or application structure.

Bootstrap defines how things are wired, not what they do.

## Responsibilities

Application bootstrap entry composition (HTTP / CLI)

Deterministic runtime assembly (kernel + pipeline + emitters)

Environment initialization hooks (timezone, env/config loading boundaries)

Centralized infrastructure composition (Http, Routing, Security integration)

Stable extension points for application-level wiring (VibeApp)

Bootstrap acts as an explicit composition root, not a service locator.

## Non-goals

No routing logic

No HTTP request parsing

No business logic or domain initialization

No dependency injection container

No global state beyond explicit bootstrap setup

Bootstrap must not become a “mini framework”.

## Public contracts (examples)

Bootstrap (builder / DSL for runtime assembly)

AppRuntime (immutable, runnable runtime container)

KernelInterface (e.g. HttpKernelInterface)

RuntimeEntrypoint helpers (optional)

Typical responsibilities split

VibeCore

Provides bootstrap primitives and contracts

Defines kernel boundaries (HTTP / CLI)

Exposes assembly DSL without app policy

VibeApp

Chooses concrete middleware, router, policies

Registers routes and handlers

Defines environment configuration

Decides which kernels are enabled

Typical HTTP bootstrap flow

Entrypoint (public/index.php)

Composer autoload initialization

Bootstrap composition (via builder / DSL)

Request creation via Http adapter

Kernel execution (middleware pipeline + dispatch)

Response emission

Bootstrap itself does not execute request logic; it only prepares the runtime.