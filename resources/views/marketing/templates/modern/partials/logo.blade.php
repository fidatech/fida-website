{{-- Fida FR monogram, traced from the original logo (see public/favicon.svg). $light renders the navy strokes in white for dark surfaces. --}}
@php
    $uid = $uid ?? 'logo';
    $height = $height ?? 32;
    $navyFill = ($light ?? false) ? '#ffffff' : "url(#fx-n-{$uid})";
@endphp
<svg viewBox="28 32 772 476" width="{{ round($height * 1.62) }}" height="{{ $height }}" aria-hidden="true" focusable="false">
    <defs>
        <linearGradient id="fx-n-{{ $uid }}" x1="33" y1="36" x2="520" y2="520" gradientUnits="userSpaceOnUse"><stop stop-color="#173244"/><stop offset="1" stop-color="#071823"/></linearGradient>
        <linearGradient id="fx-o-{{ $uid }}" x1="440" y1="37" x2="755" y2="508" gradientUnits="userSpaceOnUse"><stop stop-color="#ff961e"/><stop offset=".6" stop-color="#ff7312"/><stop offset="1" stop-color="#fb4008"/></linearGradient>
    </defs>
    <path fill="{{ $navyFill }}" d="M432 181L161 181L133 189L99 211L53 256L41 277L36 293L33 349L34 503L45 496L114 432L134 409L142 382L142 311L148 295L160 282L179 274L316 274L340 269L359 257L432 184Z"/>
    <path fill="{{ $navyFill }}" d="M36 234L40 235L125 146L149 132L179 125L460 125L476 118L553 38L173 37L137 45L92 70L72 89L54 114L38 158Z"/>
    <path fill="url(#fx-o-{{ $uid }})" d="M578 39L495 123L633 125L646 129L665 145L675 167L674 195L662 221L631 249L601 260L401 262L398 268L571 447L620 494L645 503L794 503L793 499L628 337L675 331L710 316L746 285L761 264L774 236L782 194L781 163L768 119L756 98L737 76L712 57L692 47L652 37Z"/>
</svg>
