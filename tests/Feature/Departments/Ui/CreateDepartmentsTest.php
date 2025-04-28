<?php

namespace Tests\Feature\Departments\Ui;

use App\Models\Component;
use App\Models\Department;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class CreateDepartmentsTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('departments.create'))
            ->assertOk();
    }

    public function testPermissionRequiredToCreateDepartment()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('departments.store'), [
                'name' => 'Test Department',
                'company_id' => Company::factory()->create()->id
            ])
            ->assertForbidden();
    }

    public function testUserCanCreateDepartments()
    {
        $this->assertDatabaseMissing('departments', [
            'name' => 'Test Department'
        ]);
        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('departments.store'), [
                'name' => 'Test Department',
                'company_id' => Company::factory()->create()->id,
                'notes' => 'Test Note',
                'wikidata' => 'Q12345'
            ])
            ->assertRedirect(route('departments.index'));
        $this->assertDatabaseHas('departments', [
            'name' => 'Test Department',
            'notes' => 'Test Note',
            'wikidata' => 'Q12345'
        ]);
    }
}
