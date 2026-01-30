<?php declare(strict_types=1);

namespace VibeCore\Normalization;

use VibeCore\Schema\EntitySchema;

final class NormalizerChain implements NormalizerInterface
{
    /** @var NormalizerInterface[] */
    private array $normalizers;

    /**
     * @param NormalizerInterface[] $normalizers
     */
    public function __construct(array $normalizers)
    {
        foreach ($normalizers as $n) {
            if (!$n instanceof NormalizerInterface) {
                throw new \InvalidArgumentException('NormalizerChain: all items must implement NormalizerInterface.');
            }
        }
        $this->normalizers = array_values($normalizers);
    }

    public function normalize(array $input, EntitySchema $schema, NormalizationContext $ctx): NormalizationResult
    {
        $data = $input;
        $changes = [];

        foreach ($this->normalizers as $n) {
            $res = $n->normalize($data, $schema, $ctx);
            $data = $res->data;
            if ($res->changes) {
                $changes = array_merge($changes, $res->changes);
            }
        }

        return new NormalizationResult($data, $changes);
    }
}
