# VibeCore/Normalization

## Intent

Provide schema-aware normalization primitives to transform raw input into canonical data before validation/execution.
Normalization is deterministic and pure: it does not perform side effects.

##  Responsibilities

Normalization contracts and result objects

Schema-aware normalizers:

trim strings

empty string → null (when nullable)

cast primitives (int/bool)

apply simple defaults (when safe and explicit)

Composition utilities (normalizer chain)

Structured reporting (what changed) — optional

## Non-goals

No persistence (no database type conversions requiring DB)

No domain-specific transformations (belongs to VibeApp)

No HTTP parsing (input acquisition is Http responsibility)

No implicit guessing that could corrupt data (prefer explicit rules)

## Public contracts (examples)

NormalizerInterface (normalize(data, schema, context): NormalizationResult)

NormalizationResult (VO: data + changes)

SchemaNormalizer (default implementation)

NormalizerChain (compose normalizers)

NormalizationContext (optional VO)

## Dependencies

Depends on Schema (FieldSchema, DbMeta, WriteMeta)

May depend on Support

Must not depend on Http

Must not depend on Persistence implementations