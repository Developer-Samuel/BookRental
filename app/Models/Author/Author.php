<?php

declare(strict_types=1);

namespace App\Models\Author;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Country\Country;
use App\Models\Book\Book;

/**
 * @property int $country_id
 * @property string $name
 * @property string $surname
 * @property string|null $birthDate
 * @property string $gender
 * @property Country|null $country
 * @property Book[]|null $books
*/
class Author extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
    */
    protected $fillable = [
        'country_id',
        'name',
        'surname',
        'gender',
        'birth_date'
    ];

    /**
     * Define the relationship between Author and Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Define the relationship between Author and Books.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
