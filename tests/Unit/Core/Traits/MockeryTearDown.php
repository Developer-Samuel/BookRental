<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Traits;

trait MockeryTearDown
{
    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
