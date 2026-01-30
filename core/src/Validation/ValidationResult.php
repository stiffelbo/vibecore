<?php declare(strict_types=1);

namespace VibeCore\Validation;

final class ValidationResult
{
    /** @var Violation[] */
    public readonly array $violations;

    /**
     * @param Violation[] $violations
     */
    public function __construct(array $violations = [])
    {
        foreach ($violations as $v) {
            if (!$v instanceof Violation) {
                throw new \InvalidArgumentException('ValidationResult: violations must be Violation[]');
            }
        }
        $this->violations = array_values($violations);
    }

    public function ok(): bool
    {
        return $this->violations === [];
    }

    /**
     * @return array<int, array{path: string, code: string, message: string, meta: array}>
     */
    public function toArray(): array
    {
        return array_map(
            fn(Violation $v) => ['path' => $v->path, 'code' => $v->code, 'message' => $v->message, 'meta' => $v->meta],
            $this->violations
        );
    }
}
