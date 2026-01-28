# VibeCore /Model

## Intent
A "Model" is a schema-aware CRUD operator and a domain extension point.
It is NOT Active Record and does not represent a row/object with state.

## Responsibilities
- Define base Model API: create/update/read/delete using schema + context
- Apply validation + normalization (via Schema transformers)
- Apply access overlay (intersection of schema capabilities + runtime access context)
- Provide hook points for domain extensions (before/after, custom commands)
- Delegate execution to Persistence (CRUD engine + gateway)

## Non-goals
- No domain aggregates or entity state objects by default
- No persistence details (SQL, joins) in Model (belongs to Persistence)
- No HTTP concerns (belongs to Http)

## Public contracts (examples)
- Model (base abstract)
- ModelContext (wraps Request/Auth/Access context)
- ModelRegistry (optional)
- Hook interfaces (optional)

## Dependencies
- Depends on Schema
- Depends on Persistence contracts
- Should not depend on Http directly (use ModelContext boundary instead)
