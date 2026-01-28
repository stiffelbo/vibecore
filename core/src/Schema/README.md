# VibeCore /Schema

## Intent
Schema is the single source of truth for entity structure, validation intent, UI metadata, and max capabilities.
Schema is declarative and transformable.

## Responsibilities
- Typed DSL for describing fields and entities
- Immutable schema objects (EntitySchema, FieldSchema, collections)
- Metadata model: UI, DB, validation, access capabilities (max possible)
- Transformers interfaces: schema -> validation rules / UI schema / DB mapping intent

## Non-goals
- No persistence execution (belongs to Persistence)
- No request handling (belongs to Http)
- No application authorization rules (schema declares max capability; access can only restrict)

## Public contracts (examples)
- EntitySchema
- FieldSchema
- Field DSL (builders)
- SchemaTransformer interfaces (UiSchemaTransformer, ValidationTransformer, DbMappingTransformer)

## Dependencies
- May depend on Support
- Must remain independent from Persistence gateways and Http request specifics
