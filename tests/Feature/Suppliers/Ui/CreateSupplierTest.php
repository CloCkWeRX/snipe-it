<?php

namespace Tests\Feature\Suppliers\Ui;

use App\Models\User;
use Tests\TestCase;

class CreateSupplierTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('suppliers.create'))
            ->assertOk();
    }

    public function testUserCanCreateManufacturer()
    {
        $this->assertFalse(Supplier::where('name', 'Test Supplier')->exists());

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('suppliers.store'), [
                'name' => 'Test Supplier',
                'notes' => 'Test Note',
                'wikidata' => 'Q12345'
            ])
            ->assertRedirect(route('suppliers.index'));

        $this->assertTrue(Supplier::where('name', 'Test Supplier')->where('notes', 'Test Note')->exists());
    }
}
