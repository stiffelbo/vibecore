# VibeCore /Routing

## Intent
Route incoming requests to a handler deterministically, with typed params and metadata.
Routing is a pure matcher + route definition store, not a DI system.

## Responsibilities
- Route definitions: method, path pattern, name, handler, metadata
- Route matching: METHOD + PATH -> RouteMatch
- Param extraction and normalization (basic)
- Middleware attachment points (global/domain/route) via metadata, not via hidden magic

## Non-goals
- No controller discovery, no auto-wiring, no reflection scanning
- No HTTP parsing (belongs to Http)
- No auth/access decisions (belongs to Security + app policy)

## Public contracts (examples)
- RouterInterface
- Route
- RouteMatch
- RouteMetadata (typed VO preferred)

## Dependencies
- May depend on Support
- Should not depend on Persistence/Model/Schema directly
