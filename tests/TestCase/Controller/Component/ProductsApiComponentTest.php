<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\ProductsApiComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\ProductsApiComponent Test Case
 */
class ProductsApiComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\ProductsApiComponent
     */
    protected $ProductsApi;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->ProductsApi = new ProductsApiComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ProductsApi);

        parent::tearDown();
    }
}
