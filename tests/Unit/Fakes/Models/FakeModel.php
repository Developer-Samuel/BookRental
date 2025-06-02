<?php

declare(strict_types=1);

namespace Tests\Unit\Fakes\Models;

use Illuminate\Database\Eloquent\Model;

class FakeModel extends Model
{
    public function create(array $attributes)
    {
        return $this;
    }
}
