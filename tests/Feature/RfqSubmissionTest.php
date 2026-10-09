<?php

namespace Tests\Feature;

use App\Mail\NewRfqNotificationMail;
use App\Models\Rfq;
use Database\Seeders\GovernmentNgoCapabilitySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RfqSubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        config()->set('website.indexable', true);
    }

    public function test_rfq_page_exposes_government_ngo_procurement_content(): void
    {
        $this->seed(GovernmentNgoCapabilitySeeder::class);

        $this->get('/request-for-quotation')
            ->assertOk()
            ->assertSee('FORMAL RFQ CHANNEL')
            ->assertSee('info@fida.af')
            ->assertSee('Custom ERP &amp; Enterprise Software', false)
            ->assertSee('Data Center &amp; IT Infrastructure', false)
            ->assertSee('Enterprise Hardware &amp; Technology Supply', false)
            ->assertSee('"@type":"FAQPage"', false);
    }

    public function test_valid_rfq_is_stored_with_document_and_notified_to_info_email(): void
    {
        Storage::fake('local');
        Mail::fake();
        $this->seed(GovernmentNgoCapabilitySeeder::class);

        $response = $this->post('/request-for-quotation', [
            'organization_name' => 'Example Development Organization',
            'organization_type' => 'ngo',
            'contact_name' => 'Procurement Officer',
            'job_title' => 'Procurement Manager',
            'email' => 'procurement@example.org',
            'phone' => '+93700000000',
            'country' => 'Afghanistan',
            'city' => 'Kabul',
            'procurement_reference' => 'RFQ-2026-104',
            'procurement_method' => 'rfq',
            'submission_deadline' => now()->addDays(10)->toDateString(),
            'capabilities' => ['datacenter', 'network', 'hardware', 'integration'],
            'budget_currency' => 'USD',
            'budget_min' => '25000',
            'budget_max' => '50000',
            'delivery_location' => 'Kabul',
            'project_summary' => 'Supply and implement a secure server room and network environment for the organization.',
            'scope_requirements' => 'Provide servers, switching, racks, UPS, structured cabling, installation, configuration, testing, training and documentation.',
            'compliance_requirements' => 'Include warranty assumptions, implementation plan and handover documentation.',
            'timeline' => '60 days',
            'document' => UploadedFile::fake()->create('rfq-scope.pdf', 120, 'application/pdf'),
            'locale' => 'en',
            'source_url' => url('/request-for-quotation'),
            'privacy_accepted' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('rfqs', 1);

        $rfq = Rfq::query()->firstOrFail();

        $this->assertStringStartsWith('RFQ-', $rfq->reference);
        $this->assertSame(['datacenter', 'network', 'hardware', 'integration'], $rfq->capabilities);
        $this->assertSame('rfq-scope.pdf', $rfq->attachment_name);
        Storage::disk('local')->assertExists($rfq->attachment_path);

        Mail::assertSent(NewRfqNotificationMail::class, function (NewRfqNotificationMail $mail) use ($rfq): bool {
            return $mail->hasTo('info@fida.af') && $mail->rfq->is($rfq);
        });
    }

    public function test_solution_capability_pages_are_seeded_for_search_and_ai_discovery(): void
    {
        $this->seed(GovernmentNgoCapabilitySeeder::class);

        foreach ([
            'web-digital-platforms-afghanistan',
            'ai-automation-solutions-afghanistan',
            'iot-smart-infrastructure-afghanistan',
            'data-center-it-infrastructure-afghanistan',
            'network-infrastructure-operations-afghanistan',
            'cloud-server-infrastructure-afghanistan',
            'cybersecurity-solutions-afghanistan',
            'enterprise-hardware-technology-supply-afghanistan',
            'systems-integration-deployment-afghanistan',
            'managed-it-services-afghanistan',
        ] as $slug) {
            $this->get('/'.$slug)
                ->assertOk()
                ->assertSee('"@type":"Service"', false)
                ->assertSee('"@type":"FAQPage"', false);
        }

        $this->get('/llms.txt')
            ->assertOk()
            ->assertSee('Data centers, servers, storage and backup')
            ->assertSee('Formal RFQ / RFP / tender submission');
    }
}
