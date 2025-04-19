<?php

namespace Tests\Feature\Companies\Ui;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class UpdateCompanyTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('companies.edit', Company::factory()->create()))
            ->assertOk();
    }

    public function testUserCanEditCompanies()
    {
        $company = Company::factory()->create(['name' => 'Test Company']);
        $this->assertTrue(Company::where('name', 'Test Company')->exists());
        $response = $this->actingAs(User::factory()->superuser()->create())
            ->put(route('companies.update', $company), [
                'name' => 'Test Company Edited',
                'notes' => 'Test Note Edited',
                'url' => 'http://example.com',
                'wikidata' => 'Q12345'
            ])
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('companies.index'));
        $this->followRedirects($response)->assertSee('Success');
        $this->assertTrue(Company::where('name', 'Test Company Edited')->where('notes', 'Test Note Edited')->where('url', 'http://example.com')->where('wikidata', 'Q12345')->exists());
    }
}
