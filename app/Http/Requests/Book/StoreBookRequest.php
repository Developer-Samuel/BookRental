<?php

declare(strict_types=1);

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Core\AuthorIdRule;
use App\Rules\Book\TitleRule;
use App\Rules\Book\TypeRule;
use App\Rules\Book\IsBorrowedRule;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
    */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules(): array
    {
        return [
            'author_id'   => ['required', 'integer', new AuthorIdRule()],
            'title'       => ['required', new TitleRule()],
            'type'        => ['required', new TypeRule()],
            'is_borrowed' => ['required', new IsBorrowedRule()],
        ];
    }
}
