# VibeCore/Access

## Intent

Provide infrastructure-level access boundaries and field-level restriction primitives.
Access in core is about expressing and applying constraints (view/edit ceilings + runtime overlays), not defining application policy.

## Responsibilities

Access result/value objects (allowed/denied, restricted fields, flags)

Access context contracts (who acts, which scope) — as boundaries only

Field-level overlay primitives:

compute effective viewable / editable fields

apply restricted field lists to schemas and/or row data

Helper utilities for safe field filtering (deny-by-default optional patterns)

## Non-goals

No application authorization policy (roles/pages/subscriptions belong to VibeApp)

No persistence logic (no SQL, no repositories)

No HTTP/session/cookie handling

No UI enforcement (UI can read schemas but is not security)

## Public contracts (examples)

AccessResult (VO)

AccessContextInterface (contract)

AccessDecision / AccessFlags (optional VO)

FieldAccessOverlay (pure helper: filterViewable/filterEditable)

## Dependencies

May depend on Support

May depend on Schema (for field-level overlay)

Must not depend on Http

Must not depend on Persistence implementations