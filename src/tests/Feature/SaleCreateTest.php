<?php

namespace Tests\Feature;

use Cart;
use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use Livewire\Livewire;
use App\Models\Product;
use App\Models\Category;
use App\Livewire\Sale\SaleCreate;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleCreateTest extends TestCase
{
        use RefreshDatabase;

   /** @test */
    public function puede_crear_una_venta_completa_y_no_duplica_el_cliente_existente()
    {
        // 1) Crear usuario manualmente
        $user = User::create([
            'name'     => 'Admin Test',
            'email'    => 'admin@prueba.test',
            'password' => Hash::make('secret'),
            'admin'    => true,
        ]);
        $this->actingAs($user);
        $user = User::factory()->create(['admin' => true]);
        $this->actingAs($user);

      
        $category = Category::factory()->create();
        $product  = Product::factory()->create([
            'category_id'   => $category->id,
            'precio_compra' => 10,
            'precio_venta'  => 100,
        ]);

        // 3) Creo el cliente EXISTENTE de forma manual
        $client = Client::create([
            'name'           => 'Cliente Existente',
            'identificacion' => 'DUPL123445',
            'telefono'       => '987654321',
            'email'          => 'existente@cliente.test',
            'empresa'        => 'Empresa Test SAC',
            'nit'            => 'NIT123',
        ]);

        // Verifico que ahora mismo solo hay UN cliente en la tabla
        $this->assertDatabaseCount('clients', 1);

        // 4) Lleno el carrito con el producto
        Cart::session($user->id)->add([
            'id'              => $product->id,
            'name'            => $product->name,
            'price'           => $product->precio_venta,
            'quantity'        => 2,
            'associatedModel' => $product,
        ]);

        // 5) Llamo a createSale() pasando el ID de ese cliente existente
        Livewire::actingAs($user)
            ->test(SaleCreate::class)
            ->set('pago', 200)
            ->set('client', $client->id)
            ->call('createSale')
            ->assertDispatched('msg')
            ->assertSet('pago', 0);

        // 6a) Sigo teniendo SOLO ESE cliente (no se duplicó)
        $this->assertDatabaseCount('clients', 1);

        // 6b) Y se creó la venta correctamente
        $this->assertDatabaseCount('sales', 1);
        $this->assertDatabaseHas('sales', [
            'client_id' => $client->id,
            'user_id'   => $user->id,
            'total'     => 200,
        ]);
    }
}
