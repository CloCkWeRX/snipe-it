<?php

namespace Tests\Feature\Categories\Ui;

use App\Models\AssetModel;
use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class CreateCategoriesTest extends TestCase
{
    public function testPermissionRequiredToCreateCategories()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('categories.store'), [
                'name' => 'Test Category',
                'category_type' => 'asset',
            ])
            ->assertForbidden();
    }

    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('categories.create'))
            ->assertOk();
    }

    public function testUserCanCreateCategories()
    {
        $this->assertDatabaseMissing('categories', [
            'name' => 'Test Category'
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('categories.store'), [
                'name' => 'Test Category',
                'category_type' => 'asset',
                'notes' => 'Test Note',
            ])
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category',
            'notes' => 'Test Note'
        ]);
    }

    public function testUserCannotCreateCategoriesWithInvalidType()
    {
        $this->assertDatabaseMissing('categories', [
            'name' => 'Test Category'
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->from(route('categories.create'))
            ->post(route('categories.store'), [
                'name' => 'Test Category',
                'category_type' => 'invalid',
            ])
            ->assertRedirect(route('categories.create'));

        $this->assertDatabaseMissing('categories', [
            'name' => 'Test Category'
        ]);
    }
}
