<?php

declare(strict_types=1);

namespace App\Enums;

enum AuthorOrderBy: string
{
    case ID = 'id';
    case NAME = 'name';
    case NATIONALITY = 'nationality';
    case BIRTH_DATE = 'birth date';
}
