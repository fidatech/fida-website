const header = document.querySelector('[data-header]');
const menuButton = document.querySelector('[data-menu-button]');
const mobileNav = document.querySelector('[data-mobile-nav]');
const languageSwitcher = document.querySelector('[data-language-switcher]');
const languageButton = document.querySelector('[data-language-button]');

const updateHeader = () => header?.classList.toggle('scrolled', window.scrollY > 18);

updateHeader();
window.addEventListener('scroll', updateHeader, { passive: true });

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

const revealItems = document.querySelectorAll('.reveal');

if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -30px' });

    revealItems.forEach((item) => observer.observe(item));
} else {
    revealItems.forEach((item) => item.classList.add('visible'));
}
