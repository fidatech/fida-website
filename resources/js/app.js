const header = document.querySelector('[data-header]');
const progress = document.querySelector('[data-scroll-progress]');
const backToTop = document.querySelector('[data-back-to-top]');
const menuButton = document.querySelector('[data-menu-button]');
const mobileNav = document.querySelector('[data-mobile-nav]');
const languageSwitcher = document.querySelector('[data-language-switcher]');
const languageButton = document.querySelector('[data-language-button]');
const colorModeButton = document.querySelector('[data-color-mode-toggle]');
const navClusters = Array.from(document.querySelectorAll('[data-nav-cluster]'));
const mobileNavGroups = Array.from(document.querySelectorAll('.mobile-nav-group'));
const colorModeQuery = window.matchMedia('(prefers-color-scheme: light)');
const colorModeStorageKey = 'fida_color_mode';
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const readColorMode = () => {
    try {
        return window.localStorage.getItem(colorModeStorageKey);
    } catch {
        return null;
    }
};

const applyColorMode = (mode, remember = false) => {
    const nextMode = mode === 'light' ? 'light' : 'dark';
    document.documentElement.dataset.colorMode = nextMode;

    if (remember) {
        try {
            window.localStorage.setItem(colorModeStorageKey, nextMode);
        } catch {
            // The visual preference still works when storage is blocked.
        }
    }

    if (colorModeButton) {
        const nextLabel = nextMode === 'dark' ? colorModeButton.dataset.lightLabel : colorModeButton.dataset.darkLabel;
        colorModeButton.setAttribute('aria-label', nextLabel);
        colorModeButton.setAttribute('title', nextLabel);
        colorModeButton.setAttribute('aria-pressed', String(nextMode === 'light'));
    }

    const themeColor = document.querySelector('[data-theme-color]');
    themeColor?.setAttribute('content', nextMode === 'light' ? '#f4f7fa' : themeColor.dataset.darkColor);
};

applyColorMode(document.documentElement.dataset.colorMode || (colorModeQuery.matches ? 'light' : 'dark'));

colorModeButton?.addEventListener('click', () => {
    applyColorMode(document.documentElement.dataset.colorMode === 'light' ? 'dark' : 'light', true);
});

colorModeQuery.addEventListener?.('change', (event) => {
    if (readColorMode() === null) applyColorMode(event.matches ? 'light' : 'dark');
});

let scrollFrame = 0;

const updateScrollUI = () => {
    scrollFrame = 0;
    header?.classList.toggle('scrolled', window.scrollY > 18);

    if (backToTop) {
        const visible = window.scrollY > 520;
        backToTop.classList.toggle('is-visible', visible);
        backToTop.setAttribute('aria-hidden', String(!visible));
        backToTop.tabIndex = visible ? 0 : -1;
    }

    if (progress) {
        const scrollable = document.documentElement.scrollHeight - window.innerHeight;
        const percentage = scrollable > 0 ? Math.min(100, (window.scrollY / scrollable) * 100) : 0;
        progress.style.width = `${percentage}%`;
    }
};

const requestScrollUpdate = () => {
    if (!scrollFrame) scrollFrame = window.requestAnimationFrame(updateScrollUI);
};

updateScrollUI();
window.addEventListener('scroll', requestScrollUpdate, { passive: true });

backToTop?.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: reduceMotion ? 'auto' : 'smooth',
    });
});

menuButton?.addEventListener('click', () => {
    const open = menuButton.getAttribute('aria-expanded') !== 'true';
    closeNavClusters();
    menuButton.setAttribute('aria-expanded', String(open));
    mobileNav?.classList.toggle('open', open);
});

mobileNav?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
        menuButton?.setAttribute('aria-expanded', 'false');
        mobileNav.classList.remove('open');
    });
});

languageButton?.addEventListener('click', () => {
    const open = !languageSwitcher?.classList.contains('open');
    closeNavClusters();
    languageSwitcher?.classList.toggle('open', open);
    languageButton.setAttribute('aria-expanded', String(open));
});

function setNavClusterOpen(cluster, open) {
    cluster?.classList.toggle('open', open);
    cluster?.querySelector('[data-nav-cluster-button]')?.setAttribute('aria-expanded', String(open));
}

function closeNavClusters(except = null) {
    navClusters.forEach((cluster) => {
        if (cluster !== except) setNavClusterOpen(cluster, false);
    });
}

navClusters.forEach((cluster) => {
    const button = cluster.querySelector('[data-nav-cluster-button]');

    if (!button) return;

    button.addEventListener('click', () => {
        const open = !cluster.classList.contains('open');

        closeNavClusters(cluster);
        setNavClusterOpen(cluster, open);
    });
});

document.querySelector('.desktop-nav')?.addEventListener('focusin', (event) => {
    const focusedCluster = event.target instanceof Element
        ? event.target.closest('[data-nav-cluster]')
        : null;

    closeNavClusters(focusedCluster);
});

mobileNavGroups.forEach((group) => {
    group.addEventListener('toggle', () => {
        if (!group.open) return;

        mobileNavGroups.forEach((item) => {
            if (item !== group) item.removeAttribute('open');
        });
    });
});

document.addEventListener('click', (event) => {
    if (languageSwitcher && !languageSwitcher.contains(event.target)) {
        languageSwitcher.classList.remove('open');
        languageButton?.setAttribute('aria-expanded', 'false');
    }

    const clickedCluster = event.target instanceof Element
        ? event.target.closest('[data-nav-cluster]')
        : null;

    if (!clickedCluster) closeNavClusters();
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;

    languageSwitcher?.classList.remove('open');
    languageButton?.setAttribute('aria-expanded', 'false');
    mobileNav?.classList.remove('open');
    menuButton?.setAttribute('aria-expanded', 'false');
    closeNavClusters();
});

const revealItems = document.querySelectorAll('.reveal');

if ('IntersectionObserver' in window && !reduceMotion) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -35px' });

    revealItems.forEach((item, index) => {
        item.style.transitionDelay = `${Math.min((index % 4) * 55, 165)}ms`;
        observer.observe(item);
    });
} else {
    revealItems.forEach((item) => item.classList.add('visible'));
}

// Intentionally keep the marketing site lightweight. Interactive 3D tilt was removed
// because continuous pointer-driven transforms add paint/compositing work without
// improving the information architecture or conversion path.

const analyticsEndpoint = '/analytics/event';
const analyticsCsrf = document.querySelector('meta[name="csrf-token"]')?.content;

const recordFirstPartyEvent = (eventName, eventLabel = '') => {
    if (!analyticsCsrf) return;

    fetch(analyticsEndpoint, {
        method: 'POST',
        keepalive: true,
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': analyticsCsrf,
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            event_name: eventName,
            event_label: eventLabel,
            path: window.location.pathname,
        }),
    }).catch(() => {});
};

document.querySelectorAll('[data-track-event]').forEach((element) => {
    element.addEventListener('click', () => {
        recordFirstPartyEvent(element.dataset.trackEvent, element.dataset.trackLabel || '');
    });
});

document.querySelectorAll('a[href^="tel:"]').forEach((element) => {
    element.addEventListener('click', () => recordFirstPartyEvent('phone_click', element.getAttribute('href')));
});

document.querySelectorAll('a[href^="mailto:"]').forEach((element) => {
    element.addEventListener('click', () => recordFirstPartyEvent('email_click', element.getAttribute('href')));
});

document.querySelectorAll('a[href*="wa.me"], a[href*="whatsapp.com"]').forEach((element) => {
    element.addEventListener('click', () => recordFirstPartyEvent('whatsapp_click', element.getAttribute('href')));
});

const analyticsConfig = window.fidaAnalytics;

if (analyticsConfig?.measurementId) {
    const consentBanner = document.querySelector('[data-analytics-consent]');
    const acceptButton = document.querySelector('[data-analytics-accept]');
    const declineButton = document.querySelector('[data-analytics-decline]');
    const pendingEvents = [];
    const storageKey = 'fida_analytics_consent';
    let analyticsLoaded = false;

    const readConsent = () => {
        try {
            return window.localStorage.getItem(storageKey);
        } catch {
            return null;
        }
    };

    const writeConsent = (value) => {
        try {
            window.localStorage.setItem(storageKey, value);
        } catch {
            // A blocked storage API should not block the visitor from using the site.
        }
    };

    const track = (name, parameters = {}) => {
        if (!analyticsLoaded || typeof window.gtag !== 'function') {
            pendingEvents.push([name, parameters]);
            return;
        }

        window.gtag('event', name, parameters);
    };

    const loadAnalytics = () => {
        if (analyticsLoaded) return;

        analyticsLoaded = true;
        window.dataLayer = window.dataLayer || [];
        window.gtag = function gtag() {
            window.dataLayer.push(arguments);
        };

        const script = document.createElement('script');
        script.async = true;
        script.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(analyticsConfig.measurementId)}`;
        document.head.append(script);

        window.gtag('js', new Date());
        window.gtag('config', analyticsConfig.measurementId);

        pendingEvents.splice(0).forEach(([name, parameters]) => {
            window.gtag('event', name, parameters);
        });
    };

    document.querySelectorAll('[data-track-event]').forEach((element) => {
        element.addEventListener('click', () => {
            track(element.dataset.trackEvent, {
                event_label: element.dataset.trackLabel || '',
                page_path: window.location.pathname,
                language: document.documentElement.lang,
            });
        });
    });

    if (document.querySelector('[data-conversion="generate_lead"]')) {
        track('generate_lead', {
            method: 'website_form',
            page_path: window.location.pathname,
            language: document.documentElement.lang,
        });
    }

    const consent = readConsent();

    if (consent === 'granted' || !analyticsConfig.requireConsent) {
        loadAnalytics();
    } else if (consent !== 'denied' && consentBanner) {
        consentBanner.hidden = false;
    }

    acceptButton?.addEventListener('click', () => {
        writeConsent('granted');
        consentBanner.hidden = true;
        loadAnalytics();
    });

    declineButton?.addEventListener('click', () => {
        writeConsent('denied');
        pendingEvents.length = 0;
        consentBanner.hidden = true;
    });
}
