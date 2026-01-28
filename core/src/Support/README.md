# VibeCore /Support

## Intent
Shared low-level utilities used across core modules.
Support exists to prevent duplication, not to become a junk drawer.

## Responsibilities
- Value Objects primitives (Id, EntityName, FieldName, NonEmptyString, etc.)
- Collections helpers (typed collections, iterators)
- Error types (DomainException vs InfrastructureException distinctions)
- Small functional helpers (result types, optionals) if needed
- Time utilities (Clock interface) for testability

## Non-goals
- No business logic
- No heavy abstractions that belong to specific modules
- No uncontrolled growth ("utils dump")

## Dependencies
- Must be dependency-light
- Must not depend on higher-level modules
