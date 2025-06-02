<?php

declare(strict_types=1);

namespace App\DTO\Book;

use App\Contracts\DTO\DataTransferObjectInterface;

use App\Enums\BookType;

final class BookDTO implements DataTransferObjectInterface
{
    /**
     * @param int $authorId
     * @param string $title
     * @param BookType $type
     * @param bool $is_borrowed
    */
    public function __construct(
        public readonly int $authorId,
        public readonly string $title,
        public readonly BookType $type,
        public readonly bool $is_borrowed
    ) {}

    /**
     * @param array $data
     * @return self
    */
    public static function fromArray(array $data): self
    {
        return new self(
            authorId: (int) $data['author_id'],
            title: $data['title'],
            type: BookType::from($data['type']),
            is_borrowed: (bool) $data['is_borrowed']
        );
    }

    /**
     * @return array
    */
    public function toArray(): array
    {
        return [
            'author_id'   => (int) $this->authorId,
            'title'       => $this->title,
            'type'        => $this->type,
            'is_borrowed' => (bool) $this->is_borrowed
        ];
    }
}
