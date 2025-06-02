<?php

declare(strict_types=1);

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Core\CountryIdRule;
use App\Rules\Author\NameRule;
use App\Rules\Author\GenderRule;
use App\Rules\Author\BirthDateRule;

class UpdateAuthorRequest extends FormRequest
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
            'id'         => 'required|integer|exists:authors,id',
            'country_id' => ['required', 'integer', new CountryIdRule()],
            'name'       => ['required', 'string', new NameRule()],
            'surname'    => ['required', 'string', new NameRule()],
            'gender'     => ['required', 'string', new GenderRule()],
            'birth_date' => ['date', 'nullable', new BirthDateRule()],
        ];
    }
}
