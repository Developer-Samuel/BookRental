<?php

declare(strict_types=1);

namespace App\Enums;

enum BookType: string
{
    case FICTION = 'fiction';
    case NON_FICTION = 'non-fiction';
    case BIOGRAPHY = 'biography';
    case SCIENCE = 'science';
    case HISTORY = 'history';
    case ROMANCE = 'romance';
    case MYSTERY = 'mystery';
    case FANTASY = 'fantasy';
    case THRILLER = 'thriller';
    case POETRY = 'poetry';
    case ADVENTURE = 'adventure';
    case HUMOR = 'humor';
    case SELF_HELP = 'self-help';
    case COOKBOOK = 'cookbook';
    case GUIDE = 'guide';
    case TEXTBOOK = 'textbook';
    case ART = 'art';
    case TRAVEL = 'travel';
    case RELIGION = 'religion';
    case PSYCHOLOGY = 'psychology';

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }
        return $values;
    }

    public static function options(): array
    {
        return self::getSortedOptions();
    }

    private static function getSortedOptions(): array
    {
        $options = array_map(
            fn(self $case) => [
                'value' => $case->value,
                'name'  => ucfirst(str_replace('-', ' ', $case->value)),
            ],
            self::cases()
        );

        usort($options, fn($optA, $optB) => strcmp($optA['name'], $optB['name']));

        return $options;
    }
}
