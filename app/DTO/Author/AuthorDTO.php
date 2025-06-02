<?php

declare(strict_types=1);

namespace App\DTO\Author;

use App\Contracts\DTO\DataTransferObjectInterface;

final class AuthorDTO implements DataTransferObjectInterface
{
    /**
     * @param int $country_id
     * @param string $name
     * @param string $surname
     * @param string $gender
     * @param string|null $birth_date
    */
    public function __construct(
        public readonly int $country_id,
        public readonly string $name,
        public readonly string $surname,
        public readonly string $gender,
        public readonly ?string $birth_date
    ) {}

    /**
     * @param array $data
     * @return self
    */
    public static function fromArray(array $data): self
    {
        return new self(
            country_id: (int) $data['country_id'],
            name: $data['name'],
            surname: $data['surname'],
            gender: $data['gender'],
            birth_date: $data['birth_date'] ?? null
        );
    }

    /**
     * @return array
    */
    public function toArray(): array
    {
        return [
            'country_id'  => (int) $this->country_id,
            'name'        => $this->name,
            'surname'     => $this->surname,
            'gender'      => $this->gender,
            'birth_date'  => $this->birth_date
        ];
    }
}
