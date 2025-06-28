<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ProductCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_product()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/products', [
            'name' => 'Test Product',
            'price' => 500,
        ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }
   
    // public function test_example(): void
    // {
    //     $response = $this->get('/');
    //     $response->assertStatus(200);
    // }
    
}
