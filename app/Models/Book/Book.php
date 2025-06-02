<?php

declare(strict_types=1);

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Enums\BookType;

use App\Models\Author\Author;

/**
 * @property int $author_id
 * @property string $title
 * @property BookType $type
 * @property bool $is_borrowed
 * @property Author|null $author
*/
class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
    */
    protected $fillable = [
        'author_id',
        'title',
        'type',
        'is_borrowed',
    ];

    protected $casts = [
        'type'        => BookType::class,
        'is_borrowed' => 'boolean',
    ];

    /**
     * Define the relationship between Book and Author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
