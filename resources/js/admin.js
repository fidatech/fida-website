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

const brandNameInput = document.querySelector('[data-brand-name]');
const brandTaglineInput = document.querySelector('[data-brand-tagline]');
const brandNamePreview = document.querySelector('[data-brand-name-preview]');
const brandTaglinePreview = document.querySelector('[data-brand-tagline-preview]');
const brandMarkPreview = document.querySelector('[data-brand-mark-preview]');

const updateBrandPreview = () => {
    if (brandNamePreview && brandNameInput) brandNamePreview.textContent = brandNameInput.value || 'Brand';
    if (brandTaglinePreview && brandTaglineInput) brandTaglinePreview.textContent = brandTaglineInput.value || 'Tagline';
    if (brandMarkPreview && brandNameInput) brandMarkPreview.textContent = (brandNameInput.value.trim()[0] || 'F').toUpperCase();
};

brandNameInput?.addEventListener('input', updateBrandPreview);
brandTaglineInput?.addEventListener('input', updateBrandPreview);

const logoInput = document.querySelector('[data-logo-input]');
const logoPreview = document.querySelector('[data-logo-preview]');
let logoObjectUrl;

logoInput?.addEventListener('change', () => {
    const file = logoInput.files?.[0];
    if (!file || !logoPreview) return;
    if (logoObjectUrl) URL.revokeObjectURL(logoObjectUrl);
    logoObjectUrl = URL.createObjectURL(file);
    logoPreview.replaceChildren(Object.assign(document.createElement('img'), {
        src: logoObjectUrl,
        alt: 'Selected logo preview',
    }));
});

const colorInputs = Object.fromEntries(
    [...document.querySelectorAll('[data-color-input]')].map((input) => [input.dataset.colorInput, input]),
);

const updateColorCode = (name) => {
    const code = document.querySelector(`[data-color-code="${name}"]`);
    if (code && colorInputs[name]) code.textContent = colorInputs[name].value.toLowerCase();
};

document.querySelectorAll('[data-palette-card]').forEach((card) => {
    card.addEventListener('click', () => {
        const radio = card.querySelector('input[type="radio"]');
        if (radio?.value === 'custom') return;

        ['primary', 'secondary', 'highlight'].forEach((name) => {
            if (!colorInputs[name] || !card.dataset[name]) return;
            colorInputs[name].value = card.dataset[name];
            updateColorCode(name);
        });
    });
});

Object.entries(colorInputs).forEach(([name, input]) => {
    input.addEventListener('input', () => {
        const customPalette = document.querySelector('input[name="palette"][value="custom"]');
        if (customPalette) customPalette.checked = true;
        updateColorCode(name);
    });
    updateColorCode(name);
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    setSidebar(false);
    profileMenu?.classList.remove('open');
});


/* Collapsible admin navigation */
document.querySelectorAll('[data-nav-group]').forEach((group) => {
    const toggle = group.querySelector('[data-nav-group-toggle]');
    const menu = group.querySelector('[data-nav-group-menu]');
    if (!toggle || !menu) return;

    const setOpen = (open) => {
        group.classList.toggle('open', open);
        toggle.setAttribute('aria-expanded', String(open));
    };

    toggle.addEventListener('click', () => setOpen(!group.classList.contains('open')));
});

/* Lightweight sortable, searchable, paginated analytics tables */
document.querySelectorAll('[data-datatable]').forEach((table, tableIndex) => {
    const body = table.tBodies[0];
    if (!body) return;

    const originalRows = Array.from(body.rows);
    if (!originalRows.length || originalRows.every((row) => row.cells.length === 1 && row.cells[0].colSpan > 1)) return;

    let rows = [...originalRows];
    let filteredRows = [...rows];
    let page = 1;
    let pageSize = Number(table.dataset.pageSize || 10);
    let sortIndex = -1;
    let sortDirection = 1;

    const wrap = table.closest('.analytics-table-wrap');
    if (!wrap) return;

    const toolbar = document.createElement('div');
    toolbar.className = 'analytics-table-toolbar';
    toolbar.innerHTML = `
        <div class="analytics-table-search">
            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6"></circle><path d="m16 16 4 4"></path></svg>
            <input type="search" placeholder="Search table..." aria-label="Search table">
        </div>
        <label class="analytics-page-size">
            <span>Rows</span>
            <select aria-label="Rows per page">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </label>
    `;

    const footer = document.createElement('div');
    footer.className = 'analytics-table-footer';
    footer.innerHTML = `
        <span class="analytics-table-info"></span>
        <div class="analytics-pager">
            <button type="button" data-page-prev aria-label="Previous page">‹</button>
            <span data-page-label></span>
            <button type="button" data-page-next aria-label="Next page">›</button>
        </div>
    `;

    wrap.parentNode.insertBefore(toolbar, wrap);
    wrap.parentNode.insertBefore(footer, wrap.nextSibling);

    const search = toolbar.querySelector('input');
    const sizeSelect = toolbar.querySelector('select');
    const info = footer.querySelector('.analytics-table-info');
    const pageLabel = footer.querySelector('[data-page-label]');
    const prev = footer.querySelector('[data-page-prev]');
    const next = footer.querySelector('[data-page-next]');
    sizeSelect.value = String(pageSize);

    const valueOf = (row, index) => {
        const cell = row.cells[index];
        if (!cell) return '';
        const explicit = cell.dataset.value;
        const raw = explicit ?? cell.textContent.trim();
        const numeric = Number(String(raw).replace(/[,%]/g, ''));
        return raw !== '' && Number.isFinite(numeric) ? numeric : String(raw).toLocaleLowerCase();
    };

    const render = () => {
        const total = filteredRows.length;
        const pages = Math.max(1, Math.ceil(total / pageSize));
        page = Math.min(page, pages);
        const start = (page - 1) * pageSize;
        const end = Math.min(start + pageSize, total);

        body.innerHTML = '';
        filteredRows.slice(start, end).forEach((row) => body.appendChild(row));

        info.textContent = total ? `Showing ${start + 1}–${end} of ${total}` : 'No matching rows';
        pageLabel.textContent = `Page ${page} of ${pages}`;
        prev.disabled = page <= 1;
        next.disabled = page >= pages;
    };

    const applyFilter = () => {
        const term = search.value.trim().toLocaleLowerCase();
        filteredRows = term
            ? rows.filter((row) => row.textContent.toLocaleLowerCase().includes(term))
            : [...rows];
        page = 1;
        render();
    };

    search.addEventListener('input', applyFilter);
    sizeSelect.addEventListener('change', () => {
        pageSize = Number(sizeSelect.value);
        page = 1;
        render();
    });
    prev.addEventListener('click', () => { if (page > 1) { page -= 1; render(); } });
    next.addEventListener('click', () => {
        const pages = Math.max(1, Math.ceil(filteredRows.length / pageSize));
        if (page < pages) { page += 1; render(); }
    });

    table.querySelectorAll('th[data-sort]').forEach((header, index) => {
        header.setAttribute('tabindex', '0');
        header.setAttribute('role', 'button');

        const sort = () => {
            if (sortIndex === index) sortDirection *= -1;
            else {
                sortIndex = index;
                sortDirection = 1;
            }

            table.querySelectorAll('th[data-sort]').forEach((item) => item.classList.remove('sort-asc', 'sort-desc'));
            header.classList.add(sortDirection === 1 ? 'sort-asc' : 'sort-desc');

            rows.sort((a, b) => {
                const av = valueOf(a, index);
                const bv = valueOf(b, index);
                if (typeof av === 'number' && typeof bv === 'number') return (av - bv) * sortDirection;
                return String(av).localeCompare(String(bv), undefined, { numeric: true, sensitivity: 'base' }) * sortDirection;
            });
            applyFilter();
        };

        header.addEventListener('click', sort);
        header.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                sort();
            }
        });
    });

    render();
});


/* Multilingual rich text editor (Quill) */
const bootRichEditors = () => {
    if (!window.Quill) return false;

    document.querySelectorAll('textarea[data-rich-editor]').forEach((source) => {
        if (source.dataset.richReady === '1') return;
        source.dataset.richReady = '1';

        const editor = document.createElement('div');
        editor.className = 'admin-rich-editor';
        editor.setAttribute('dir', source.getAttribute('dir') || 'ltr');
        source.insertAdjacentElement('afterend', editor);
        source.hidden = true;

        const quill = new window.Quill(editor, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ header: [2, 3, false] }],
                    ['bold', 'italic'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link', 'blockquote'],
                    ['clean'],
                ],
            },
        });

        quill.root.innerHTML = source.value || '';
        quill.on('text-change', () => {
            source.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
        });

        source.form?.addEventListener('submit', () => {
            source.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
        });
    });

    return true;
};

if (!bootRichEditors()) {
    window.addEventListener('DOMContentLoaded', () => {
        if (bootRichEditors()) return;
        let attempts = 0;
        const timer = window.setInterval(() => {
            attempts += 1;
            if (bootRichEditors() || attempts > 20) window.clearInterval(timer);
        }, 150);
    }, { once: true });
}


/* Human-readable ISO country labels for analytics without a server-side intl dependency. */
(() => {
    let displayNames = null;
    try {
        if (typeof Intl !== 'undefined' && Intl.DisplayNames) {
            displayNames = new Intl.DisplayNames(['en'], { type: 'region' });
        }
    } catch {}

    document.querySelectorAll('[data-country-name]').forEach((node) => {
        const code = (node.dataset.countryName || '').toUpperCase();
        if (!/^[A-Z]{2}$/.test(code)) return;
        try {
            node.textContent = displayNames?.of(code) || code;
        } catch {
            node.textContent = code;
        }
    });

    document.querySelectorAll('[data-country-flag]').forEach((node) => {
        const code = (node.dataset.countryFlag || '').toUpperCase();
        if (!/^[A-Z]{2}$/.test(code)) return;
        node.textContent = String.fromCodePoint(...Array.from(code).map((char) => 127397 + char.charCodeAt(0)));
    });
})();


/* Growth advisor provider defaults */
(() => {
    const provider = document.querySelector('[data-ai-provider]');
    const model = document.querySelector('[data-ai-model]');
    const help = document.querySelector('[data-ai-model-help]');
    if (!provider || !model) return;

    const defaults = {
        gemini: ['gemini-3.8-flash', 'Leave blank to use Gemini 3.8 Flash.'],
        openrouter: ['openrouter/free', 'Leave blank to use OpenRouter free routing.'],
        openai: ['gpt-5.6-luna', 'Leave blank to use GPT-5.6 Luna, OpenAI’s cost-sensitive model, with reasoning disabled for this advisor task.'],
    };

    const sync = () => {
        const current = defaults[provider.value] || defaults.gemini;
        model.placeholder = 'Auto: ' + current[0];
        if (help) help.textContent = current[1];
    };

    provider.addEventListener('change', sync);
    sync();
})();

/* Instant admin appearance picker */
(() => {
    const menu = document.querySelector('[data-admin-theme-menu]');
    if (!menu) return;

    const toggle = menu.querySelector('[data-admin-theme-toggle]');
    const themeButtons = [...menu.querySelectorAll('[data-admin-theme-choice]')];
    const paletteButtons = [...menu.querySelectorAll('[data-admin-palette-choice]')];
    const status = menu.querySelector('[data-admin-theme-status]');
    const root = document.documentElement;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    let theme = themeButtons.find((button) => button.classList.contains('active'))?.dataset.adminThemeChoice || 'midnight';
    let palette = paletteButtons.find((button) => button.classList.contains('active'))?.dataset.adminPaletteChoice || 'fida';
    let saveTimer;

    const hexToRgb = (hex) => {
        const clean = hex.replace('#', '');
        return [0, 2, 4].map((offset) => parseInt(clean.slice(offset, offset + 2), 16)).join(',');
    };

    const applyTheme = (button) => {
        root.style.setProperty('--admin-bg', button.dataset.bg);
        root.style.setProperty('--admin-panel-soft', button.dataset.soft);
        root.style.setProperty('--admin-panel', button.dataset.surface);
    };

    const applyPalette = (button) => {
        root.style.setProperty('--admin-lime', button.dataset.primary);
        root.style.setProperty('--admin-violet', button.dataset.secondary);
        root.style.setProperty('--admin-cyan', button.dataset.highlight);
        root.style.setProperty('--admin-accent-rgb', hexToRgb(button.dataset.primary));
        root.style.setProperty('--admin-secondary-rgb', hexToRgb(button.dataset.secondary));
        root.style.setProperty('--admin-highlight-rgb', hexToRgb(button.dataset.highlight));
    };

    const persist = () => {
        window.clearTimeout(saveTimer);
        saveTimer = window.setTimeout(async () => {
            if (status) status.textContent = 'Saving…';
            try {
                const response = await fetch(menu.dataset.themeUrl, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf || '',
                    },
                    body: JSON.stringify({ theme, palette }),
                });
                if (!response.ok) throw new Error('Save failed');
                if (status) status.textContent = 'Saved automatically';
            } catch {
                if (status) status.textContent = 'Could not save — try again';
            }
        }, 120);
    };

    toggle?.addEventListener('click', (event) => {
        event.stopPropagation();
        const open = !menu.classList.contains('open');
        menu.classList.toggle('open', open);
        toggle.setAttribute('aria-expanded', String(open));
    });

    themeButtons.forEach((button) => button.addEventListener('click', () => {
        theme = button.dataset.adminThemeChoice;
        themeButtons.forEach((item) => item.classList.toggle('active', item === button));
        applyTheme(button);
        persist();
    }));

    paletteButtons.forEach((button) => button.addEventListener('click', () => {
        palette = button.dataset.adminPaletteChoice;
        paletteButtons.forEach((item) => item.classList.toggle('active', item === button));
        applyPalette(button);
        persist();
    }));

    document.addEventListener('click', (event) => {
        if (!menu.contains(event.target)) {
            menu.classList.remove('open');
            toggle?.setAttribute('aria-expanded', 'false');
        }
    });
})();
