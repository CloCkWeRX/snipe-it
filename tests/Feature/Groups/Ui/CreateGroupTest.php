<?php

namespace Tests\Feature\Groups\Ui;

use App\Models\Group;
use App\Models\User;
use Tests\TestCase;

class CreateGroupTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('groups.create'))
            ->assertOk();
    }

    public function testUserCanCreateGroup()
    {
        $this->assertDatabaseMissing('groups', [
            'name' => 'Test Group'
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('groups.store'), [
                'name' => 'Test Group',
                'notes' => 'Test Note',
            ])
            ->assertRedirect(route('groups.index'));

        $this->assertDatabaseHas('groups', [
            'name' => 'Test Group',
            'notes' => 'Test Note'
        ]);
    }
}
