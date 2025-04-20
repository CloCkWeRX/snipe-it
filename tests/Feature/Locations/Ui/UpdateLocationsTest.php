<?php

namespace Tests\Feature\Locations\Ui;

use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

class UpdateLocationsTest extends TestCase
{
    public function testPermissionRequiredToStoreLocation()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('locations.store'), [
                'name' => 'Test Location',
            ])
            ->assertStatus(403)
            ->assertForbidden();
    }

    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('locations.edit', Location::factory()->create()))
            ->assertOk();
    }

    public function testUserCanEditLocations()
    {
        $location = Location::factory()->create(['name' => 'Test Location']);
        $this->assertDatabaseHas('locations', [
            'name' => 'Test Location'
        ]);

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->put(route('locations.update', ['location' => $location]), [
                'name' => 'Test Location Edited',
                'notes' => 'Test Note Edited',
                'latitude' => '38.7532',
                'longitude' => '-77.1969'
            ])
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('locations.index'));

        $this->followRedirects($response)->assertSee('Success');
        $this->assertDatabaseHas('locations', [
            'name' => 'Test Location Edited',
            'notes' => 'Test Note Edited',
            'latitude' => 38.7532,
            'longitude' => -77.1969
        ]);
    }

    public function testUserCannotEditLocationsToMakeThemTheirOwnParent()
    {
        $location = Location::factory()->create();

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->from(route('locations.edit', $location))
            ->put(route('locations.update', $location), [
                'name' => 'Test Location',
                'parent_id' => $location->id,
            ])
            ->assertRedirect(route('locations.edit', ['location' => $location]));

        $this->followRedirects($response)->assertSee(trans('general.error'));
        $this->assertDatabaseMissing('locations', [
            'name' => 'Test Location'
        ]);
    }

    public function testUserCannotEditLocationsWithInvalidParent()
    {
        $location = Location::factory()->create();
        $response = $this->actingAs(User::factory()->superuser()->create())
            ->from(route('locations.edit', $location))
            ->put(route('locations.update', ['location' => $location]), [
                'name' => 'Test Location',
                'parent_id' => '100000000'
            ])
            ->assertRedirect(route('locations.edit', ['location' => $location->id]));

        $this->followRedirects($response)->assertSee(trans('general.error'));
        $this->assertDatabaseMissing('locations', [
            'name' => 'Test Location'
        ]);
    }
}
