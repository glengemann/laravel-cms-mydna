<?php

namespace Tests\Unit\Models;

use App\Http\Requests\ValueObjects\Filter;
use App\Models\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class FilterTraitTest extends TestCase
{
    public function testApplyFilter(): void
    {
        $filters = [
            new Filter('name', 'partial', 'John'),
            new Filter('name', 'start', 'John'),
            new Filter('name', 'end', 'John'),
        ];

        $builder = DummyModel::query()
            ->applyFilter($filters);

        $expected = "select * from `dummy_models` where `name` LIKE '%John%' and `name` LIKE 'John%' and `name` LIKE '%John'";
        $actual = $builder->toRawSql();

        $this->assertEquals($expected, $actual);
    }
}

class DummyModel extends Model
{
    use FilterTrait;
}
