# VibeCore /src

## Intent
VibeCore is an infrastructure kernel for schema-driven business apps.
It provides stable contracts, conventions, and a typed DSL for building CRUD + validation + UI schema + access overlays.

## Responsibilities (high level)
- HTTP request processing primitives (context, response, pipeline hooks)
- Routing contracts (route matching, params, metadata)
- Security primitives (request protection, rate limiting, auth boundary hooks)
- Schema DSL and schema metadata model
- Schema-aware Model operators (domain extension points, not Active Record)
- Persistence abstractions (CRUD engine, gateway boundary, query abstraction)
- Low-level shared utilities (support layer)

## Non-goals
- Not a full-stack framework (no templating, no DI container mandate)
- Not a domain model framework (no aggregates/entities as runtime objects by default)
- Not application-specific logic or policies (belongs to VibeApp)

## Architectural rule of thumb
Core defines "what is possible" (schemas, capabilities) and "how it executes" (engines).
VibeApp defines "what it means" (domain rules, services, access policies).
