<?php

namespace Tests\Feature\Manufacturers\Ui;

use App\Models\User;
use App\Models\Manufacturer;
use Tests\TestCase;

class CreateManufacturerTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('manufacturers.create'))
            ->assertOk();
    }

    public function testUserCanCreateManufacturer()
    {
        $this->assertDatabaseMissing('manufacturers', [
            'name' => 'Test Manufacturer'
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('manufacturers.store'), [
                'name' => 'Test Manufacturer',
                'notes' => 'Test Note',
                'wikidata' => 'Q12345'
            ])
            ->assertRedirect(route('manufacturers.index'));

        $this->assertDatabaseHas('manufacturers', [
            'name' => 'Test Manufacturer',
            'notes' => 'Test Note',
            'wikidata' => 'Q12345'
        ]);
    }
}
