<?php

namespace Tests\Unit\App\Helper;

use Tests\TestCase;
use App\Helper\CustomPaginator;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomPaginatorTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function paginate(): void
    {
        $array = range(1, 100);
        $perPage = 10;

        $paginator = CustomPaginator::paginate($array, $perPage);

        // dd($paginator->lastItem());

        $this->assertEquals($perPage, $paginator->perPage());
        $this->assertEquals(1, $paginator->currentPage());
        $this->assertEquals(100, $paginator->total());
        $this->assertEquals(10, $paginator->count());
        $this->assertEquals(10, $paginator->lastPage());
        $this->assertEquals(1, $paginator->firstItem());
        $this->assertEquals(10, $paginator->lastItem());
    }
}
