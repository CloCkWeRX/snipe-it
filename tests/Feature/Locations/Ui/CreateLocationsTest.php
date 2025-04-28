<?php

namespace Tests\Feature\Locations\Ui;

use App\Models\Location;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class CreateLocationsTest extends TestCase
{
    public function testPermissionRequiredToCreateLocation()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('locations.store'), [
                'name' => 'Test Location',
                'company_id' => Company::factory()->create()->id
            ])
            ->assertForbidden();
    }

    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('locations.create'))
            ->assertOk();
    }

    public function testUserCanCreateLocations()
    {
        $this->assertDatabaseMissing('locations', [
            'name' => 'Test Location'
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.store'), [
                'name' => 'Test Location',
                'notes' => 'Test Note',
            ])
            ->assertRedirect(route('locations.index'));

        $this->assertDatabaseMissing('locations', [
            'name' => 'Test Invalid License',
            'notes' => 'Test Note'
        ]);
    }

    public function testUserCannotCreateLocationsWithInvalidParent()
    {
        $this->assertDatabaseMissing('locations', [
            'name' => 'Test Location'
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->from(route('locations.create'))
            ->post(route('locations.store'), [
                'name' => 'Test Location',
                'parent_id' => '100000000'
            ])
            ->assertRedirect(route('locations.create'));

        $this->assertDatabaseMissing('locations', [
            'name' => 'Test Location'
        ]);
    }
}
