<?php

namespace Tests\Feature;

use App\Mail\NewRfqNotificationMail;
use App\Mail\RfqAcknowledgementMail;
use App\Models\Rfq;
use App\Models\User;
use Database\Seeders\GovernmentTechnologySolutionsSeeder;
use Database\Seeders\RfqPageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RfqWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        config()->set('website.indexable', true);
        config()->set('website.rfq_email', 'info@fida.af');

        $this->seed([
            GovernmentTechnologySolutionsSeeder::class,
            RfqPageSeeder::class,
        ]);
    }

    public function test_enterprise_infrastructure_and_procurement_pages_are_indexable_and_structured(): void
    {
        $this->get('/data-center-it-infrastructure-afghanistan')
            ->assertOk()
            ->assertSee('Data Center &amp; IT Infrastructure in Afghanistan', false)
            ->assertSee('Data center and server-room design')
            ->assertSee('government, NGOs and enterprise operations')
            ->assertSee('"@type":"Service"', false)
            ->assertSee('"@type":"FAQPage"', false);

        $this->get('/government-ngo-technology-procurement-afghanistan')
            ->assertOk()
            ->assertSee('Government &amp; NGO Technology Procurement in Afghanistan', false)
            ->assertSee('One accountable technology partner for institutional procurement')
            ->assertSee('RFQ, RFP and tender response')
            ->assertSee('Submit an RFQ');

        $this->get('/fa/data-center-it-infrastructure-afghanistan')
            ->assertOk()
            ->assertSee('دیتاسنتر و زیربنای IT در افغانستان');

        $this->get('/ps/network-engineering-operations-afghanistan')
            ->assertOk()
            ->assertSee('په افغانستان کې د شبکې انجینري او عملیات');
    }

    public function test_public_rfq_page_is_transactional_multilingual_and_has_contact_schema(): void
    {
        $this->get('/request-for-quotation')
            ->assertOk()
            ->assertSee('<h1>Request for Quotation (RFQ)</h1>', false)
            ->assertSee('RFQ / RFP / TOR / BoQ', false)
            ->assertSee('info@fida.af')
            ->assertSee('name="documents[]"', false)
            ->assertSee('"@type":"ContactPage"', false)
            ->assertSee('"@type":"FAQPage"', false);

        $this->get('/fa/request-for-quotation')
            ->assertOk()
            ->assertSee('درخواست قیمت (RFQ)')
            ->assertSee('ارسال RFQ');

        $this->get('/ps/request-for-quotation')
            ->assertOk()
            ->assertSee('د نرخ غوښتنه (RFQ)')
            ->assertSee('RFQ واستوئ');
    }

    public function test_rfq_submission_is_stored_privately_notified_and_acknowledged(): void
    {
        Mail::fake();
        Storage::fake('local');

        $response = $this->post(route('rfqs.store'), [
            'organization' => 'Example Development Organization',
            'organization_type' => 'ngo',
            'contact_name' => 'Procurement Officer',
            'job_title' => 'Procurement Manager',
            'email' => 'procurement@example.org',
            'phone' => '+93700000000',
            'procurement_type' => 'data-center',
            'project_title' => 'Primary Data Center Infrastructure',
            'submission_deadline' => now()->addDays(10)->toDateString(),
            'location' => 'Kabul, Afghanistan',
            'budget' => 'USD 50,000',
            'requirements' => 'Supply, install and configure server, storage, rack, UPS, network and backup infrastructure with training and documentation.',
            'documents' => [
                UploadedFile::fake()->create('RFQ-data-center.pdf', 800, 'application/pdf'),
            ],
            'locale' => 'en',
            'source_url' => url('/request-for-quotation'),
        ]);

        $rfq = Rfq::query()->firstOrFail();

        $response
            ->assertRedirect()
            ->assertSessionHas('rfq_success', $rfq->reference);

        $this->assertMatchesRegularExpression('/^RFQ-\d{4}-\d{6}$/', (string) $rfq->reference);
        $this->assertSame('new', $rfq->status);
        $this->assertSame('Example Development Organization', $rfq->organization);
        $this->assertCount(1, $rfq->attachments ?? []);

        Storage::disk('local')->assertExists($rfq->attachments[0]['path']);

        Mail::assertSent(NewRfqNotificationMail::class, function (NewRfqNotificationMail $mail) use ($rfq): bool {
            return $mail->hasTo('info@fida.af')
                && $mail->rfq->is($rfq);
        });

        Mail::assertSent(RfqAcknowledgementMail::class, function (RfqAcknowledgementMail $mail) use ($rfq): bool {
            return $mail->hasTo('procurement@example.org')
                && $mail->rfq->is($rfq);
        });

        $this->assertDatabaseHas('website_analytics_events', [
            'event_name' => 'rfq_submitted',
            'event_label' => 'data-center',
            'page_slug' => 'request-for-quotation',
        ]);
    }

    public function test_rfq_documents_are_only_available_through_authorized_admin_route(): void
    {
        Storage::fake('local');

        $path = UploadedFile::fake()
            ->create('TOR.pdf', 300, 'application/pdf')
            ->store('rfqs/1', 'local');

        $rfq = Rfq::query()->create([
            'reference' => 'RFQ-'.now()->format('Y').'-000001',
            'organization' => 'Government Agency',
            'organization_type' => 'government',
            'contact_name' => 'Procurement Contact',
            'email' => 'procurement@example.gov',
            'procurement_type' => 'network',
            'project_title' => 'Network Infrastructure',
            'requirements' => 'Design and deploy a secure network with routing, switching, wireless, cabling and documentation.',
            'attachments' => [[
                'name' => 'TOR.pdf',
                'path' => $path,
                'mime' => 'application/pdf',
                'size' => 300 * 1024,
            ]],
            'locale' => 'en',
            'status' => 'new',
        ]);

        $this->get(route('admin.rfqs.attachments.show', [$rfq, 0]))
            ->assertRedirect(route('admin.login'));

        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.rfqs.show', $rfq))
            ->assertOk()
            ->assertSee($rfq->reference)
            ->assertSee('TOR.pdf');

        $this->actingAs($admin)
            ->get(route('admin.rfqs.attachments.show', [$rfq, 0]))
            ->assertOk();
    }
}
