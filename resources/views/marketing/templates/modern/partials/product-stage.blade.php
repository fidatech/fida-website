{{-- Hero product scene: an illustration of Prime Sarafi and Ograyi with sample data, plus a live-infrastructure card. Product UI stays left-to-right in every language. --}}
<figure class="fx-stage">
    <div class="fx-stage-scene" aria-hidden="true" lang="en" dir="ltr">
        <div class="fx-app">
            <div class="fx-app-top"><i></i><i></i><i></i><span>app.fida.af / prime-sarafi</span></div>
            <div class="fx-app-body">
                <div class="fx-app-side">
                    <div class="fx-app-brand">@include('marketing.templates.modern.partials.logo', ['uid' => 'app', 'height' => 16, 'light' => true]) Prime Sarafi</div>
                    <b class="on">Dashboard</b><b>Exchange</b><b>Hawala</b><b>Customers</b><b>Cash &amp; bank</b><b>Reports</b><b>Settings</b>
                </div>
                <div class="fx-app-main">
                    <div class="fx-app-head"><div><strong>Daily position</strong><small>Kabul main branch · today</small></div><span class="fx-live">Live</span></div>
                    <div class="fx-kpis">
                        <div><small>USD balance</small><strong>$248,300</strong><em>▲ 4.2%</em></div>
                        <div><small>AFN balance</small><strong>؋ 9.42M</strong><em>▲ 1.1%</em></div>
                        <div><small>Open hawalas</small><strong>37</strong><em class="wait">12 due</em></div>
                    </div>
                    <div class="fx-chart">
                        <svg viewBox="0 0 400 110" preserveAspectRatio="none">
                            <defs><linearGradient id="fx-area" x1="0" y1="0" x2="0" y2="1"><stop stop-color="#ff7312" stop-opacity=".35"/><stop offset="1" stop-color="#ff7312" stop-opacity="0"/></linearGradient></defs>
                            <path d="M0,90 C40,80 60,40 100,52 C140,64 160,20 200,30 C240,40 260,70 300,48 C340,26 360,12 400,22 L400,110 L0,110 Z" fill="url(#fx-area)"/>
                            <path d="M0,90 C40,80 60,40 100,52 C140,64 160,20 200,30 C240,40 260,70 300,48 C340,26 360,12 400,22" fill="none" stroke="#ff7312" stroke-width="2.5"/>
                            <path d="M0,100 C60,95 120,70 200,74 C280,78 330,60 400,56" fill="none" stroke="#173244" stroke-width="2" stroke-dasharray="4 4" opacity=".5"/>
                        </svg>
                    </div>
                    <div class="fx-table">
                        <div><span>Transaction</span><span>Branch</span><span>Amount</span><span>Status</span></div>
                        <div><span>Hawala #4821</span><span>Herat</span><b>$3,500</b><span class="fx-st ok">Paid</span></div>
                        <div><span>USD → AFN</span><span>Kabul</span><b>$12,000</b><span class="fx-st ok">Settled</span></div>
                        <div><span>Hawala #4822</span><span>Dubai</span><b>$8,250</b><span class="fx-st wait">Pending</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fx-phone">
            <div class="fx-phone-screen">
                <div class="fx-phone-top"><small>Ograyi · Total receivable</small><strong>؋ 1,284,500</strong><div><span>+ Credit</span><span>− Debit</span></div></div>
                <ul>
                    <li><i>AK</i><span>Ahmad Khan<small>Today, 10:24</small></span><b class="in">+؋ 45,000</b></li>
                    <li><i>NS</i><span>Noor Store<small>Yesterday</small></span><b class="out">−؋ 12,300</b></li>
                    <li><i>RT</i><span>Rahim Traders<small>Mon</small></span><b class="in">+؋ 80,000</b></li>
                    <li><i>ZM</i><span>Zarghona Med<small>Sun</small></span><b class="in">+؋ 9,750</b></li>
                </ul>
            </div>
        </div>

        <div class="fx-status">
            <b>Infrastructure · live</b>
            <ul>
                <li><i></i>Kabul HQ network<em>Online</em></li>
                <li><i></i>ERP server VM-02<em>99.97%</em></li>
                <li><i></i>Herat backup<em>Synced</em></li>
            </ul>
        </div>
    </div>
    <figcaption>{{ __('modern.hero.illustration') }}</figcaption>
</figure>
