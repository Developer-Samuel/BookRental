<?php

declare(strict_types=1);

namespace Tests\Unit\Core\DTO;

use App\Contracts\DTO\DataTransferObjectInterface;

final class TestDTO implements DataTransferObjectInterface
{
    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
