const header = document.querySelector('[data-header]');
const progress = document.querySelector('[data-scroll-progress]');
const menuButton = document.querySelector('[data-menu-button]');
const mobileNav = document.querySelector('[data-mobile-nav]');
const languageSwitcher = document.querySelector('[data-language-switcher]');
const languageButton = document.querySelector('[data-language-button]');
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

let scrollFrame = 0;

const updateScrollUI = () => {
    scrollFrame = 0;
    header?.classList.toggle('scrolled', window.scrollY > 18);

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

menuButton?.addEventListener('click', () => {
    const open = menuButton.getAttribute('aria-expanded') !== 'true';
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
    languageSwitcher?.classList.toggle('open', open);
    languageButton.setAttribute('aria-expanded', String(open));
});

document.addEventListener('click', (event) => {
    if (languageSwitcher && !languageSwitcher.contains(event.target)) {
        languageSwitcher.classList.remove('open');
        languageButton?.setAttribute('aria-expanded', 'false');
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;

    languageSwitcher?.classList.remove('open');
    languageButton?.setAttribute('aria-expanded', 'false');
    mobileNav?.classList.remove('open');
    menuButton?.setAttribute('aria-expanded', 'false');
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

const canTilt = !reduceMotion && window.matchMedia('(hover: hover) and (pointer: fine)').matches;

if (canTilt) {
    const coreStage = document.querySelector('[data-core-stage]');
    const coreScene = document.querySelector('[data-core-scene]');
    let coreFrame = 0;

    coreStage?.addEventListener('pointermove', (event) => {
        if (coreFrame) return;

        coreFrame = window.requestAnimationFrame(() => {
            const bounds = coreStage.getBoundingClientRect();
            const x = (event.clientX - bounds.left) / bounds.width - 0.5;
            const y = (event.clientY - bounds.top) / bounds.height - 0.5;
            coreScene?.style.setProperty('--ry', `${8 + x * 12}deg`);
            coreScene?.style.setProperty('--rx', `${-6 - y * 9}deg`);
            coreScene?.style.setProperty('--mx', `${x * 9}px`);
            coreScene?.style.setProperty('--my', `${y * 7}px`);
            coreFrame = 0;
        });
    });

    coreStage?.addEventListener('pointerleave', () => {
        coreScene?.style.setProperty('--ry', '8deg');
        coreScene?.style.setProperty('--rx', '-6deg');
        coreScene?.style.setProperty('--mx', '0px');
        coreScene?.style.setProperty('--my', '0px');
    });

    document.querySelectorAll('[data-tilt]').forEach((card) => {
        let frame = 0;

        card.addEventListener('pointermove', (event) => {
            if (frame) return;

            frame = window.requestAnimationFrame(() => {
                const bounds = card.getBoundingClientRect();
                const x = (event.clientX - bounds.left) / bounds.width - 0.5;
                const y = (event.clientY - bounds.top) / bounds.height - 0.5;
                card.style.setProperty('--tilt-y', `${x * 3.5}deg`);
                card.style.setProperty('--tilt-x', `${-y * 3.5}deg`);
                frame = 0;
            });
        });

        card.addEventListener('pointerleave', () => {
            card.style.setProperty('--tilt-y', '0deg');
            card.style.setProperty('--tilt-x', '0deg');
        });
    });
}

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
