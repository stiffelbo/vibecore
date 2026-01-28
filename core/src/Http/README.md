# VibeCore /Http

## Intent
Provide minimal HTTP primitives and a deterministic request pipeline.
This is not a web framework; it is the smallest stable boundary for handling requests and producing responses.

## Responsibilities
- RequestContext (normalized input: method, path, headers, query, cookies, body, files)
- Response primitives (status, headers, body, cookies)
- Optional HTTP kernel/pipeline contracts (middleware chaining)
- Input limits and normalization hooks (size limits, content-type sanity, parsing)

## Non-goals
- No controller conventions, annotations, or framework-style routing
- No global state; no reliance on superglobals outside adapters
- No business logic; no access decisions (belongs to Security/Access in app)

## Public contracts (examples)
- RequestContext
- Response
- MiddlewareInterface (if used)
- HttpKernelInterface (if used)

## Dependencies
- May depend on Support
- Must NOT depend on Schema/Model/Persistence (keep it infrastructure-first)
