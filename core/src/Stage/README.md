# VibeCore/Stage

## Intent

A Stage is a schema-aware decision and preparation layer that turns input and context into a declarative CRUD operation.

It does not execute persistence and does not represent entity state.
Stage is the primary infrastructure component that eliminates repetitive glue code between HTTP, access policy, validation, and persistence.

## Responsibilities

Accept Schema + Input DTO + StageContext

Determine operation intent (create / update / delete / read)

Apply access overlay
(intersection of schema capabilities and runtime access result)

Apply normalization (schema-driven, deterministic)

Apply validation (schema-driven)

Apply write rules and behaviours (timestamps, soft delete, actor, etc.)

Produce a canonical Operation DTO ready for execution

Expose hook points for domain-level extensions (before/after, custom commands)

Stage prepares decisions — it does not execute them.

## Non-goals

No persistence execution (SQL, joins, transactions)

No domain aggregates or entity state objects

No HTTP concerns (request parsing, responses)

No application-specific authorization policy

No dependency on concrete storage engines

## Public contracts (examples)

StageInterface / EntityStage

StageContext (actor, access result, source, time)

StageResult (allowed, violations, operation)

CrudInput (Create / Update / Delete / Query)

Operation / OperationDto

Hook interfaces (optional)

## Dependencies

Depends on Schema

Depends on Access (AccessResult / overlay primitives)

Depends on Validation contracts

Depends on Normalization contracts

Must not depend on Http

Must not depend on Persistence implementations
(may depend on persistence contracts only, if absolutely needed)