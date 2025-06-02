<?php

declare(strict_types=1);

namespace App\Enums;

enum BookOrderBy: string
{
    case ID = 'id';
    case TITLE = 'title';
    case TYPE = 'type';
    case BORROWED = 'borrowed';
}
