<?php

declare(strict_types=1);

namespace App\DTO\Author;

use App\Contracts\DTO\DataTransferObjectInterface;

final class AuthorDTO implements DataTransferObjectInterface
{
    /**
     * @param int $countryId
     * @param string $name
     * @param string $surname
     * @param string $gender
     * @param string|null $birthDate
    */
    public function __construct(
        public readonly int $countryId,
        public readonly string $name,
        public readonly string $surname,
        public readonly string $gender,
        public readonly ?string $birthDate
    ) {}

    /**
     * @param array $data
     * @return self
    */
    public static function fromArray(array $data): self
    {
        return new self(
            countryId: (int) $data['country_id'],
            name: $data['name'],
            surname: $data['surname'],
            gender: $data['gender'],
            birthDate: $data['birth_date'] ?? null
        );
    }

    /**
     * @return array
    */
    public function toArray(): array
    {
        return [
            'country_id' => (int) $this->countryId,
            'name'       => $this->name,
            'surname'    => $this->surname,
            'gender'     => $this->gender,
            'birthDate'  => $this->birthDate
        ];
    }
}
