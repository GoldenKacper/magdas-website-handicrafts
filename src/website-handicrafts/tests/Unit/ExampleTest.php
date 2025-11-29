<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\App;
use PHPUnit\Framework\TestCase;
use App\Models\Category;
use App\Models\Product;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     * @return void
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Test basic math operations.
     * Addition of two numbers.
     * @return void
     */
    public function test_basic_math(): void
    {
        $this->assertEquals(4, 2 + 2);
    }
}
