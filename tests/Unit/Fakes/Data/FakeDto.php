<?php

declare(strict_types=1);

namespace Tests\Unit\Fakes\Data;

use App\Contracts\DTO\DataTransferObjectInterface;

final class FakeDto implements DataTransferObjectInterface
{
    public function __construct(private array $payload) {}

    public function toArray(): array
    {
        return $this->payload;
    }
}
