<?php

declare(strict_types=1);

namespace Database\Macros;

use Illuminate\Database\Schema\Blueprint;

use Database\Validators\EnumValidator;
use Database\Validators\SpecialValidator;

final class EnumMacro
{
    /**
     * Register the macro for adding a enum column with a default value.
     *
     * @return \Illuminate\Database\Schema\Blueprint
    */
    public static function register(): void
    {
        Blueprint::macro('addEnum', function (
            string $name,
            array $values,
            ?string $default = null,
            bool $unique = false
        ) {
            if (!EnumValidator::validateEnum($values, $default)) {
                throw new \InvalidArgumentException('Invalid default value for enum column ' . $name);
            }

            if (!SpecialValidator::validateUnique($unique)) {
                throw new \InvalidArgumentException('Invalid unique key reference to table ' . $unique);
            }

            $column = Blueprint::enum($name, $values);

            if ($default !== null) {
                $column->default($default);
            }

            if ($unique) {
                $column->unique();
            }

            return $column;
        });
    }
}
