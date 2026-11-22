<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLeadDeletionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_super_administrator_can_delete_a_lead_from_the_index(): void
    {
        $admin = User::factory()->admin()->create();
        $lead = $this->createLead();

        $this->actingAs($admin)
            ->get(route('admin.leads.index'))
            ->assertOk()
            ->assertSee('aria-label="Delete lead"', false)
            ->assertSee(route('admin.leads.destroy', $lead), false);

        $this->actingAs($admin)
            ->delete(route('admin.leads.destroy', $lead))
            ->assertRedirect(route('admin.leads.index'))
            ->assertSessionHas('success', 'Lead permanently deleted.');

        $this->assertDatabaseMissing('leads', ['id' => $lead->id]);
    }

    public function test_sales_manager_cannot_delete_leads(): void
    {
        $sales = User::factory()->admin('sales')->create();
        $lead = $this->createLead();

        $this->actingAs($sales)
            ->get(route('admin.leads.index'))
            ->assertOk()
            ->assertDontSee('aria-label="Delete lead"', false);

        $this->actingAs($sales)
            ->delete(route('admin.leads.destroy', $lead))
            ->assertForbidden();

        $this->assertDatabaseHas('leads', ['id' => $lead->id]);
    }

    private function createLead(): Lead
    {
        return Lead::query()->create([
            'name' => 'Spam Contact',
            'email' => 'spam@example.com',
            'project_type' => 'website',
            'message' => 'Unwanted advertising submitted through the contact form.',
            'locale' => 'en',
            'status' => 'spam',
        ]);
    }
}
