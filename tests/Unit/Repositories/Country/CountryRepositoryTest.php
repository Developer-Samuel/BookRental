<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\Country;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\Core\Traits\MockeryTearDown;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Builder;

use App\Repositories\Country\CountryRepository;
use App\Contracts\Repositories\Country\CountryRepositoryContract;

use App\Models\Country\Country;

class CountryRepositoryTest extends TestCase
{
    use MockeryTearDown;

    #[Test]
    public function canFetchAllSortedByNameReturnsCollection(): void
    {
        $builder = \Mockery::mock(Builder::class);
        $builder->shouldReceive('orderBy')
            ->with('name', 'asc')
            ->andReturnSelf();
        $builder->shouldReceive('get')
            ->once()
            ->andReturn(new EloquentCollection());

        $mock = \Mockery::mock(Country::class);
        $mock->shouldReceive('orderBy')
            ->with('name', 'asc')
            ->andReturn($builder);

        $repository = new class($mock) extends CountryRepository implements CountryRepositoryContract {
            public function __construct($model)
            {
                $this->model = $model;
            }
        };

        $result = $repository->fetchAllSortedByName();
        $this->assertInstanceOf(EloquentCollection::class, $result);
    }
}
