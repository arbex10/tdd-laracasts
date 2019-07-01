<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    protected function createOrderWithProducts()
    {
        // Set the products
        $product = new Product('Fallout 4', 59);
        $product2 = new Product('Borderlands 2', 29);
        // Create a new object of Order
        $order = new Order();
        // Add products to Order
        $order->add($product);
        $order->add($product2);
        // Return Order
        return $order;
    }

    /** @test */
    function an_order_consists_of_products()
    {
        // Initiate method Order with products
        $order = $this->createOrderWithProducts();
        // Get the array of products
        $this->assertCount(2, $order->products());
    }

    /** @test */
    function an_order_can_determine_the_total_cost_of_all_its_products()
    {
        // Initiate method Order with products
        $order = $this->createOrderWithProducts();
        // Get the total cost of order
        $this->assertEquals(88, $order->total());
    }
}
