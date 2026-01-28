# VibeCore /Security

## Intent
Provide base request security mechanisms and boundaries for auth/access integration.
Security in core is about infrastructure-level protection, not domain authorization logic.

## Responsibilities
- Rate limiting / brute-force protection primitives (policy + limiter interface + storage boundary)
- Request security checks (optional): body size, header sanity, method allowlist
- Auth boundary contracts (e.g., AuthContext interface, identity resolution hook)
- Access boundary contracts (e.g., AccessContext interface) — only as contracts, not app policy
- Security event emission hooks (audit-friendly)

## Non-goals
- No application-specific roles/permissions (belongs to VibeApp)
- No UI challenges (CAPTCHA/2FA flows belong to app)
- No hard dependency on any auth provider

## Public contracts (examples)
- RateLimiterInterface
- RateLimitPolicy
- AuthContext (contract)
- AccessContext (contract)
- SecurityEventSink (optional)

## Dependencies
- May depend on Support and Http (middleware)
- Must avoid depending on Schema/Model/Persistence where possible
