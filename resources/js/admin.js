const body = document.body;
const sidebar = document.querySelector('[data-sidebar]');
const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
const sidebarScrim = document.querySelector('[data-sidebar-scrim]');

const setSidebar = (open) => {
    sidebar?.classList.toggle('open', open);
    sidebarScrim?.classList.toggle('open', open);
    body.classList.toggle('sidebar-open', open);
};

sidebarToggle?.addEventListener('click', () => setSidebar(!sidebar?.classList.contains('open')));
sidebarScrim?.addEventListener('click', () => setSidebar(false));

const profileMenu = document.querySelector('[data-profile-menu]');
const profileToggle = document.querySelector('[data-profile-toggle]');

profileToggle?.addEventListener('click', () => {
    const open = !profileMenu?.classList.contains('open');
    profileMenu?.classList.toggle('open', open);
    profileToggle.setAttribute('aria-expanded', String(open));
});

document.addEventListener('click', (event) => {
    if (profileMenu && !profileMenu.contains(event.target)) {
        profileMenu.classList.remove('open');
        profileToggle?.setAttribute('aria-expanded', 'false');
    }
});

document.querySelectorAll('[data-dismiss]').forEach((button) => {
    button.addEventListener('click', () => button.closest('.flash')?.remove());
});

document.querySelector('[data-password-toggle]')?.addEventListener('click', (event) => {
    const input = document.querySelector('[data-password]');
    const visible = input?.type === 'text';
    if (input) input.type = visible ? 'password' : 'text';
    event.currentTarget.textContent = visible ? 'Show' : 'Hide';
});

const tabs = document.querySelectorAll('[data-language-tab]');
const panels = document.querySelectorAll('[data-language-panel]');

tabs.forEach((tab) => {
    tab.addEventListener('click', () => {
        const locale = tab.dataset.languageTab;
        tabs.forEach((item) => item.classList.toggle('active', item === tab));
        panels.forEach((panel) => {
            const active = panel.dataset.languagePanel === locale;
            panel.classList.toggle('active', active);
            panel.hidden = !active;
        });
    });
});

document.querySelectorAll('[data-counted]').forEach((field) => {
    const counter = field.parentElement?.querySelector('[data-counter]');
    const recommended = field.tagName === 'TEXTAREA' ? 160 : 60;
    const update = () => {
        if (!counter) return;
        counter.textContent = `${field.value.length} / ${recommended} recommended`;
        counter.classList.toggle('over', field.value.length > recommended);
    };
    field.addEventListener('input', update);
    update();
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    setSidebar(false);
    profileMenu?.classList.remove('open');
});
