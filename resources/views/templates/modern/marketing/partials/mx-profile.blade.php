{{-- Key facts panel for product, solution, service and industry pages. $title, $facts (list of [label, value]), $chips (list), optional $code. --}}
@php $facts = array_values(array_filter($facts, fn ($fact) => filled($fact[1] ?? null))); @endphp
@if($facts !== [] || ($chips ?? []) !== [])
<section class="mx-profile-section">
    <div class="mx-wrap">
        <div class="mx-profile">
            <div class="mx-profile-head">
                @if(filled($code ?? null))
                    <span class="mx-profile-code" aria-hidden="true">{{ mb_strtoupper(mb_substr($code, 0, 1)) }}</span>
                @endif
                <h2>{{ $title }}</h2>
            </div>
            @if($facts !== [])
                <dl class="mx-profile-facts">
                    @foreach($facts as [$label, $value])
                        <div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>
                    @endforeach
                </dl>
            @endif
            @if(($chips ?? []) !== [])
                <ul class="mx-chips mx-profile-chips">
                    @foreach($chips as $chip)<li>{{ $chip }}</li>@endforeach
                </ul>
            @endif
        </div>
    </div>
</section>
@endif
