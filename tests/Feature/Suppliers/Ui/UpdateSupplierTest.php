<?php

namespace Tests\Feature\Suppliers\Ui;

use App\Models\Supplier;
use App\Models\User;
use Tests\TestCase;

class UpdateSupplierTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('suppliers.edit', Supplier::factory()->create()->id))
            ->assertOk();
    }

    public function testUserCanEditSuppliers()
    {
        $supplier = Supplier::factory()->create(['name' => 'Test Supplier']);
        $this->assertDatabaseHas('suppliers', [
            'name' => 'Test Supplier'
        ]);

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->put(route('suppliers.update', ['supplier' => $supplier]), [
                'name' => 'Test Supplier Edited',
                'notes' => 'Test Note Edited',
                'url' => 'http://example.com',
                'latitude' => '38.7532',
                'longitude' => '-77.1969',
                'wikidata' => 'Q12345'
            ])
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('suppliers.index'));

        $this->followRedirects($response)->assertSee('Success');
        $this->assertDatabaseHas('suppliers', [
            'name' => 'Test Supplier Edited',
            'notes' => 'Test Note Edited',
            'url' => 'http://example.com',
            'latitude' => '38.7532',
            'longitude' => '-77.1969',
            'wikidata' => 'Q12345'
        ]);
    }
}
