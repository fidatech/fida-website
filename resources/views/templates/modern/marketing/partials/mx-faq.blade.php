{{-- FAQ list. Keeps id="frequently-asked-questions" and per-answer lang/dir from the shared data. --}}
@if(($faqs ?? []) !== [])
<section class="mx-section mx-section-soft" id="frequently-asked-questions">
    <div class="mx-wrap mx-faq-layout">
        <header class="mx-faq-intro">
            <h2>{{ $title ?? __('website.page.faq_title') }}</h2>
            @if(filled($description ?? __('website.page.faq_description')))
                <p>{{ $description ?? __('website.page.faq_description') }}</p>
            @endif
        </header>
        <div class="mx-faq">
            @foreach($faqs as $faq)
                @php $faqLocale = $faq['locale'] ?? app()->getLocale(); @endphp
                <details lang="{{ $faqLocale }}" dir="{{ config("website.locales.{$faqLocale}.direction", 'ltr') }}" @if($loop->first) open @endif>
                    <summary>{{ $faq['question'] }}</summary>
                    <p>{{ $faq['answer'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
@endif
