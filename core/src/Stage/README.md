# VibeCore /Stage

## Intent
A "Stage" is a schema-aware CRUD operator and a domain extension point.
It is NOT Active Record and does not represent a row/object with state.

## Responsibilities
- Define base Stage API: create/update/read/delete using schema + context
- Apply validation + normalization (via Schema transformers)
- Apply access overlay (intersection of schema capabilities + runtime access context)
- Provide hook points for domain extensions (before/after, custom commands)
- Delegate execution to Persistence (CRUD engine + gateway)

## Non-goals
- No domain aggregates or entity state objects by default
- No persistence details (SQL, joins) in Stage (belongs to Persistence)
- No HTTP concerns (belongs to Http)

## Public contracts (examples)
- Stage (base abstract)
- StageContext (wraps Request/Auth/Access context)
- StageRegistry (optional)
- Hook interfaces (optional)

## Dependencies
- Depends on Schema
- Depends on Persistence contracts
- Should not depend on Http directly (use StageContext boundary instead)
