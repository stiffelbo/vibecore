# VibeCore /Persistence

## Intent
Provide persistence execution primitives for relational storage (and potentially other backends).
This is the infrastructure layer for CRUD execution, queries, mapping, and transactions.

## Responsibilities
- CRUD engine: execute create/update/read/delete plans
- Gateway boundary: abstract DB driver (PDO/DBAL/etc.)
- Query abstraction (minimal): filters, sorting, pagination, projections
- Mapping: db rows <-> normalized records/value objects
- Transaction runner boundary

## Non-goals
- No schema definitions (belongs to Schema)
- No domain logic or access policy decisions (belongs to Model + app)
- No HTTP/Request parsing (belongs to Http)

## Public contracts (examples)
- CrudEngine
- GatewayInterface
- QuerySpec / QueryParams (VO)
- TransactionRunnerInterface
- RecordMapper (if used)

## Dependencies
- May depend on Support
- Should not depend on Http
- Can depend on Schema only for mapping intent (prefer transformer outputs over direct coupling)
