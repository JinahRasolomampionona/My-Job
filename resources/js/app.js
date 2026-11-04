import './bootstrap';
import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

import 'bootstrap/dist/css/bootstrap.min.css';
// Bootstrap est importé une seule fois ici et exposé globalement
// (le CDN chargé en double dans le layout provoquait des conflits sur les modales et menus)
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import AOS from 'aos';
import 'aos/dist/aos.css';

import Quill from 'quill';
import 'quill/dist/quill.snow.css';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

const axios = window.axios;
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
}
axios.defaults.headers.common['Accept'] = 'application/json';

/* ------------------------------------------------------------------ */
/*  Outils                                                            */
/* ------------------------------------------------------------------ */

const escapeHtml = (text) => String(text ?? '').replace(/[&<>"']/g, (c) => ({
    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
}[c]));

/** Affiche un toast Bootstrap animé en haut à droite */
export function showToast(message, type = 'success') {
    let container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        document.body.appendChild(container);
    }
    const icon = type === 'success' ? 'fa-circle-check' : (type === 'info' ? 'fa-bell' : 'fa-circle-exclamation');
    const el = document.createElement('div');
    el.className = `toast app-toast align-items-center text-bg-${type} border-0`;
    el.setAttribute('role', 'alert');
    el.innerHTML = `<div class="d-flex"><div class="toast-body"><i class="fas ${icon} me-2"></i>${escapeHtml(message)}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
    container.appendChild(el);
    el.addEventListener('hidden.bs.toast', () => el.remove());
    new bootstrap.Toast(el, { delay: 5000 }).show();
}
window.showToast = showToast;

/** Ouvre une modale (en fermant proprement celle déjà ouverte) */
function openModal(selector) {
    const target = document.querySelector(selector);
    if (!target) return false;

    const current = document.querySelector('.modal.show');
    const show = () => bootstrap.Modal.getOrCreateInstance(target).show();

    if (current && current !== target) {
        current.addEventListener('hidden.bs.modal', show, { once: true });
        bootstrap.Modal.getInstance(current)?.hide();
    } else {
        show();
    }
    return true;
}

/* ------------------------------------------------------------------ */
/*  Animations générales                                              */
/* ------------------------------------------------------------------ */

function initAnimations() {
    AOS.init({ once: true, duration: 700, easing: 'ease-out-cubic', offset: 40 });
    requestAnimationFrame(() => document.body.classList.add('page-loaded'));

    // Barre de progression en haut de page lors d'un changement de page
    const progress = document.getElementById('pageProgress');
    if (progress) {
        window.addEventListener('beforeunload', () => progress.classList.add('running'));
        window.addEventListener('pageshow', () => progress.classList.remove('running'));
    }

    // En-tête qui se réduit au défilement + bouton "retour en haut"
    const header = document.getElementById('siteHeader');
    const backToTop = document.getElementById('backToTop');
    const onScroll = () => {
        header?.classList.toggle('scrolled', window.scrollY > 40);
        backToTop?.classList.toggle('visible', window.scrollY > 400);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
    backToTop?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    // Effet "ripple" au clic sur les boutons
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn, .btn-click, .btn-submit, #submit');
        if (!btn) return;
        const rect = btn.getBoundingClientRect();
        const ripple = document.createElement('span');
        const size = Math.max(rect.width, rect.height);
        ripple.className = 'ripple';
        ripple.style.width = ripple.style.height = `${size}px`;
        ripple.style.left = `${e.clientX - rect.left - size / 2}px`;
        ripple.style.top = `${e.clientY - rect.top - size / 2}px`;
        btn.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);
    });

    // Compteurs animés des tableaux de bord
    const counters = document.querySelectorAll('[data-count]');
    if (counters.length) {
        const animate = (el) => {
            const target = parseInt(el.dataset.count, 10) || 0;
            const duration = 1200;
            const start = performance.now();
            const step = (now) => {
                const progressRatio = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progressRatio, 3);
                el.textContent = Math.round(target * eased);
                if (progressRatio < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animate(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });
        counters.forEach((el) => observer.observe(el));
    }
}

/** Effet machine à écrire sur le titre de la page d'accueil */
function initTypewriter() {
    const title = document.getElementById('title');
    if (!title) return;

    const text = title.dataset.text || 'Notre job, vous aider à choisir le vôtre';
    let i = 0;
    const timer = setInterval(() => {
        if (i >= text.length) {
            clearInterval(timer);
            title.classList.add('typed');
            return;
        }
        const span = document.createElement('span');
        span.textContent = text.charAt(i);
        title.append(span);
        i++;
    }, 70);
}

/* ------------------------------------------------------------------ */
/*  Composants Bootstrap, sidebar, confirmations                      */
/* ------------------------------------------------------------------ */

function initBootstrapComponents() {
    document.querySelectorAll('[data-bs-toggle="popover"]').forEach((el) => new bootstrap.Popover(el));
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((el) => new bootstrap.Tooltip(el));

    // Toasts générés côté serveur (messages flash)
    document.querySelectorAll('.toast[data-autoshow]').forEach((el) => {
        new bootstrap.Toast(el, { delay: 5000 }).show();
    });

    // Lien vers une modale absente de la page (ex: utilisateur connecté) : on suit simplement le lien
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-bs-toggle="modal"]');
        if (!trigger) return;
        const target = trigger.getAttribute('data-bs-target');
        if (target && !document.querySelector(target)) {
            const href = trigger.getAttribute('href');
            e.preventDefault();
            e.stopImmediatePropagation();
            if (href && href !== '#') window.location.href = href;
        }
    }, true);

    // Passage d'une modale à l'autre (connexion <-> inscription <-> mot de passe oublié)
    document.addEventListener('click', (e) => {
        const link = e.target.closest('[data-switch-modal]');
        if (!link) return;
        if (openModal(link.dataset.switchModal)) e.preventDefault();
    });

    // Confirmation avant suppression / refus (remplace les onclick="return confirm()")
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (form.dataset.confirm && !window.confirm(form.dataset.confirm)) {
            e.preventDefault();
            e.stopImmediatePropagation();
        }
    }, true);

    // Mémorise la modale d'où vient un formulaire pour la rouvrir en cas d'erreur de validation
    document.addEventListener('submit', (e) => {
        const form = e.target;
        const modal = form.closest('.modal');
        if (!modal?.id || form.dataset.ajax || form.querySelector('input[name="_modal"]')) return;
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = '_modal';
        input.value = modal.id;
        form.appendChild(input);
    });

    // Modale à ouvrir au chargement (redirection vers /login, erreur dans un formulaire en modale...)
    const toOpen = document.body.dataset.openModal;
    if (toOpen) openModal(`#${CSS.escape(toOpen)}`);

    // Afficher / masquer le mot de passe
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-toggle-password]');
        if (!btn) return;
        const input = document.querySelector(btn.dataset.togglePassword);
        if (!input) return;
        const visible = input.type === 'text';
        input.type = visible ? 'password' : 'text';
        btn.querySelector('i')?.classList.toggle('fa-eye', visible);
        btn.querySelector('i')?.classList.toggle('fa-eye-slash', !visible);
    });

    // Indicateur de robustesse du mot de passe (inscription)
    const strengthBar = document.querySelector('[data-strength-bar]');
    const regPassword = document.getElementById('reg-password');
    regPassword?.addEventListener('input', () => {
        const v = regPassword.value;
        let score = 0;
        if (v.length >= 8) score++;
        if (/[A-Z]/.test(v) && /[a-z]/.test(v)) score++;
        if (/\d/.test(v)) score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;
        strengthBar.style.width = `${(score / 4) * 100}%`;
        strengthBar.dataset.level = String(score);
    });
}

function initSidebar() {
    const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    if (!toggleSidebar || !sidebar) return;

    const topNavbar = document.getElementById('topNavbar');
    const contentWrapper = document.getElementById('contentWrapper');
    const backdrop = document.getElementById('sidebarBackdrop');

    // Sur bureau, le sidebar réduit (icônes seules) est mémorisé d'une page à l'autre
    const setCollapsed = (collapsed) => {
        [sidebar, topNavbar, contentWrapper].forEach((el) => el?.classList.toggle('collapsed', collapsed));
        try {
            localStorage.setItem('sidebarCollapsed', collapsed ? '1' : '0');
        } catch {}
    };

    const setMobileOpen = (open) => {
        sidebar.classList.toggle('show', open);
        backdrop?.classList.toggle('show', open);
    };

    try {
        if (localStorage.getItem('sidebarCollapsed') === '1') setCollapsed(true);
    } catch {}

    toggleSidebar.addEventListener('click', () => {
        if (window.innerWidth < 768) {
            setMobileOpen(!sidebar.classList.contains('show'));
        } else {
            setCollapsed(!sidebar.classList.contains('collapsed'));
        }
    });

    // Fermer le sidebar lorsqu'un lien ou le fond est cliqué (en version mobile)
    backdrop?.addEventListener('click', () => setMobileOpen(false));
    sidebar.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) setMobileOpen(false);
        });
    });
}

/* ------------------------------------------------------------------ */
/*  Éditeur Quill (description des offres)                            */
/* ------------------------------------------------------------------ */

function initEditor() {
    const editor = document.getElementById('editor');
    const hidden = document.getElementById('hidden-description');
    if (!editor || !hidden) return;

    const quill = new Quill(editor, {
        theme: 'snow',
        placeholder: 'Décrivez le poste, les missions, le profil recherché...',
        modules: {
            toolbar: [
                [{ header: [2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ color: [] }, { background: [] }],
                ['blockquote', 'link'],
                ['clean'],
            ],
        },
    });

    if (hidden.value) {
        quill.clipboard.dangerouslyPasteHTML(hidden.value);
    }

    // Mode "Code" : édition directe du HTML (nettoyé côté serveur à l'affichage)
    const code = document.getElementById('editor-code');
    const visual = editor.closest('.editor-visual');
    const modeButtons = document.querySelectorAll('[data-editor-mode]');
    let mode = 'visual';

    // Un bloc par ligne pour rendre le HTML lisible
    const formatHtml = (html) => html
        .replace(/(<\/(p|h[1-6]|li|blockquote|pre)>|<br>)/g, '$1\n')
        .replace(/(<(ul|ol)[^>]*>)/g, '$1\n')
        .replace(/(<\/(ul|ol)>)/g, '$1\n')
        .replace(/\n<li/g, '\n  <li')
        .replace(/^<li/, '  <li')
        .trim();

    const sync = () => {
        if (mode === 'code') {
            hidden.value = code.value.trim();
            return;
        }
        hidden.value = quill.getText().trim().length ? quill.root.innerHTML : '';
    };
    quill.on('text-change', sync);
    code?.addEventListener('input', sync);

    const setMode = (next) => {
        if (!code || !visual || next === mode) return;
        if (next === 'code') {
            sync();
            code.value = formatHtml(hidden.value);
            code.style.height = `${Math.max(visual.offsetHeight, 260)}px`;
        } else {
            quill.setContents([]);
            quill.clipboard.dangerouslyPasteHTML(code.value.trim());
        }
        mode = next;
        visual.classList.toggle('d-none', mode === 'code');
        code.classList.toggle('d-none', mode !== 'code');
        modeButtons.forEach((button) => {
            const active = button.dataset.editorMode === mode;
            button.classList.toggle('active', active);
            button.setAttribute('aria-selected', String(active));
        });
        sync();
        (mode === 'code' ? code : quill).focus();
    };
    modeButtons.forEach((button) => button.addEventListener('click', () => setMode(button.dataset.editorMode)));

    // Synchronise le bon formulaire (et non le premier formulaire de la page)
    editor.closest('form')?.addEventListener('submit', sync);
}

/* ------------------------------------------------------------------ */
/*  Formulaires Ajax (connexion, inscription, mot de passe, postuler) */
/* ------------------------------------------------------------------ */

function setLoading(form, loading) {
    const button = form.querySelector('[type="submit"]');
    if (!button) return;
    button.disabled = loading;
    button.classList.toggle('is-loading', loading);
}

function clearErrors(form) {
    form.querySelectorAll('[data-error-for]').forEach((el) => { el.textContent = ''; });
    form.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
    const box = form.querySelector('[data-form-message]');
    if (box) box.innerHTML = '';
}

function showFormMessage(form, message, type = 'success') {
    const box = form.querySelector('[data-form-message]');
    if (!box) {
        showToast(message, type);
        return;
    }
    box.innerHTML = `<div class="alert alert-${type} py-2 mb-0 fade-in-up">${escapeHtml(message)}</div>`;
}

function showErrors(form, errors) {
    let first = null;
    Object.entries(errors).forEach(([field, messages]) => {
        const target = form.querySelector(`[data-error-for="${field}"]`);
        const input = form.querySelector(`[name="${field}"]`);
        if (target) target.textContent = messages[0];
        else showFormMessage(form, messages[0], 'danger');
        input?.classList.add('is-invalid');
        first = first || input;
    });
    first?.focus();

    // Petite secousse pour attirer l'attention
    const shake = form.closest('.box, .card') || form;
    shake.classList.remove('shake');
    void shake.offsetWidth;
    shake.classList.add('shake');
}

function handleAjaxSuccess(form, data) {
    switch (form.dataset.ajax) {
        case 'redirect': {
            showFormMessage(form, data.message || 'Connexion réussie...', 'success');
            setTimeout(() => { window.location.href = data.redirect || '/'; }, 500);
            return true; // garde le bouton en chargement pendant la redirection
        }
        case 'switch-login': {
            // Inscription réussie : on passe directement à la modale de connexion, sans recharger la page
            form.reset();
            const loginForm = document.querySelector('#loginname form');
            if (loginForm) {
                const email = loginForm.querySelector('[name="email"]');
                if (email && data.email) email.value = data.email;
                clearErrors(loginForm);
                showFormMessage(loginForm, data.message, 'success');
                document.querySelector('#loginname').addEventListener('shown.bs.modal', () => {
                    loginForm.querySelector('[name="password"]')?.focus();
                }, { once: true });
            }
            openModal('#loginname');
            showToast(data.message, 'success');
            return false;
        }
        case 'apply': {
            const zone = form.closest('[data-apply-zone]');
            showToast(data.message, 'success');
            if (zone) {
                zone.innerHTML = `<div class="alert alert-success d-inline-flex align-items-center gap-2 mb-0 fade-in-up">
                    <i class="fas fa-circle-check"></i> ${escapeHtml(data.message)}</div>`;
            }
            refreshNotifications();
            return false;
        }
        default: {
            form.reset();
            showFormMessage(form, data.message, 'success');
            return false;
        }
    }
}

function initAjaxForms() {
    document.addEventListener('submit', async (e) => {
        const form = e.target;
        if (!form.matches('form[data-ajax]')) return;
        e.preventDefault();

        clearErrors(form);
        setLoading(form, true);
        let keepLoading = false;

        try {
            const { data } = await axios.post(form.action, new FormData(form));
            keepLoading = handleAjaxSuccess(form, data);
        } catch (error) {
            const status = error.response?.status;
            const data = error.response?.data || {};
            if (status === 422 && data.errors) {
                showErrors(form, data.errors);
            } else if (status === 422 && data.message) {
                showFormMessage(form, data.message, 'danger');
            } else if (status === 419) {
                showFormMessage(form, 'Votre session a expiré. Rechargez la page puis réessayez.', 'danger');
            } else if (status === 429) {
                showFormMessage(form, 'Trop de tentatives. Patientez un instant avant de réessayer.', 'danger');
            } else {
                showFormMessage(form, data.message || 'Une erreur est survenue. Veuillez réessayer.', 'danger');
            }
        } finally {
            if (!keepLoading) setLoading(form, false);
        }
    });
}

/* ------------------------------------------------------------------ */
/*  Notifications (cloche rafraîchie en Ajax)                         */
/* ------------------------------------------------------------------ */

let lastUnread = null;

function renderNotifications(bell, items) {
    const list = bell.querySelector('[data-notif-list]');
    if (!list) return;
    if (!items.length) {
        list.innerHTML = '<div class="notif-empty"><i class="far fa-bell-slash"></i> Aucune notification</div>';
        return;
    }
    list.innerHTML = items.map((n) => `
        <a href="${escapeHtml(n.url)}" class="notif-item ${n.lu ? '' : 'unread'}">
            <span class="notif-icon bg-${escapeHtml(n.couleur)}"><i class="fas ${escapeHtml(n.icone)}"></i></span>
            <span class="notif-text">
                <strong>${escapeHtml(n.titre)}</strong>
                <span>${escapeHtml(n.message)}</span>
                <small>${escapeHtml(n.date)}</small>
            </span>
        </a>`).join('');
}

function updateCounters(unread) {
    document.querySelectorAll('[data-notif-count]').forEach((el) => {
        el.textContent = unread;
        el.classList.toggle('d-none', unread === 0);
    });
}

async function refreshNotifications() {
    const bell = document.querySelector('[data-notif-bell]');
    if (!bell) return;
    try {
        const { data } = await axios.get(bell.dataset.latestUrl);
        if (lastUnread !== null && data.unread > lastUnread) {
            bell.classList.remove('ring');
            void bell.offsetWidth;
            bell.classList.add('ring');
            const newest = data.items.find((n) => !n.lu);
            showToast(newest ? `${newest.titre} : ${newest.message}` : 'Vous avez une nouvelle notification', 'info');
        }
        lastUnread = data.unread;
        updateCounters(data.unread);
        document.querySelectorAll('[data-notif-bell]').forEach((b) => renderNotifications(b, data.items));
    } catch {
        // Session expirée ou réseau indisponible : on réessaiera au prochain intervalle
    }
}

function initNotifications() {
    const bells = document.querySelectorAll('[data-notif-bell]');
    if (!bells.length) return;

    lastUnread = parseInt(bells[0].querySelector('[data-notif-count]')?.textContent || '0', 10);

    bells.forEach((bell) => {
        bell.addEventListener('show.bs.dropdown', refreshNotifications);
        bell.querySelector('[data-notif-read-all]')?.addEventListener('click', async () => {
            try {
                await axios.post(bell.dataset.readAllUrl);
                lastUnread = 0;
                updateCounters(0);
                document.querySelectorAll('.notif-item.unread').forEach((el) => el.classList.remove('unread'));
            } catch {
                showToast('Impossible de marquer les notifications comme lues.', 'danger');
            }
        });
    });

    // Rafraîchissement automatique toutes les 30 secondes (si l'onglet est visible)
    setInterval(() => {
        if (!document.hidden) refreshNotifications();
    }, 30000);
}

/* ------------------------------------------------------------------ */
/*  Page d'accueil : recherche et pagination des offres sans recharger */
/* ------------------------------------------------------------------ */

function initHomeSearch() {
    const section = document.querySelector('[data-home-offers]');
    const form = document.querySelector('[data-home-search]');
    if (!section || !form) return;

    let pending = null;

    // history : 'push' (nouvelle entrée), 'replace' (saisie en direct) ou 'none' (retour arrière)
    const loadOffers = async (url, { scroll = true, history = 'push' } = {}) => {
        const target = new URL(url, window.location.origin);
        target.hash = '';
        // Annule la requête précédente pour ne jamais afficher des résultats périmés
        pending?.abort();
        const controller = new AbortController();
        pending = controller;
        section.classList.add('is-loading');
        try {
            const { data } = await axios.get(target.toString(), {
                headers: { Accept: 'text/html', 'X-Requested-With': 'XMLHttpRequest' },
                signal: controller.signal,
            });
            section.innerHTML = data;
            AOS.refreshHard();
            const newUrl = `${target.pathname}${target.search}#offres`;
            if (history === 'push') window.history.pushState({ homeOffers: true }, '', newUrl);
            if (history === 'replace') window.history.replaceState({ homeOffers: true }, '', newUrl);
            if (scroll) section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } catch (error) {
            if (axios.isCancel(error)) return;
            showToast('Impossible de charger les offres.', 'danger');
        } finally {
            if (pending === controller) {
                section.classList.remove('is-loading');
                pending = null;
            }
        }
    };

    // Remplit les champs du hero à partir de l'URL (suggestions, retour arrière)
    const syncForm = (url) => {
        const params = new URL(url, window.location.origin).searchParams;
        form.elements.titre.value = params.get('titre') ?? '';
        form.elements.localisation.value = params.get('localisation') ?? '';
    };

    const searchUrl = () => {
        const params = new URLSearchParams();
        ['titre', 'localisation'].forEach((name) => {
            const value = form.elements[name].value.trim();
            if (value) params.set(name, value);
        });
        const query = params.toString();
        return `${form.getAttribute('action').split('#')[0]}${query ? `?${query}` : ''}`;
    };

    let typingTimer = null;
    let lastLiveUrl = searchUrl();

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        clearTimeout(typingTimer);
        document.activeElement?.blur();
        lastLiveUrl = searchUrl();
        loadOffers(lastLiveUrl);
    });

    // Filtrage en direct pendant la saisie (sans faire défiler la page ni quitter le champ)
    form.addEventListener('input', () => {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            const url = searchUrl();
            if (url === lastLiveUrl) return;
            lastLiveUrl = url;
            loadOffers(url, { scroll: false, history: 'replace' });
        }, 350);
    });

    document.querySelector('[data-home-suggestions]')?.addEventListener('click', (event) => {
        const link = event.target.closest('a');
        if (!link) return;
        event.preventDefault();
        syncForm(link.href);
        lastLiveUrl = searchUrl();
        loadOffers(link.href);
    });

    // Liens de pagination et "Effacer la recherche" (contenu rechargé dynamiquement)
    section.addEventListener('click', (event) => {
        const link = event.target.closest('.pagination a, [data-home-search-reset]');
        if (!link) return;
        event.preventDefault();
        if (link.matches('[data-home-search-reset]')) {
            syncForm(link.href);
            lastLiveUrl = searchUrl();
        }
        loadOffers(link.href);
    });

    window.addEventListener('popstate', () => {
        syncForm(window.location.href);
        lastLiveUrl = searchUrl();
        loadOffers(window.location.href, { scroll: false, history: 'none' });
    });
}

/* ------------------------------------------------------------------ */
/*  Dashboards : recherche en direct de la barre du haut               */
/*  - sur la page de résultats : la liste [data-live-results] est      */
/*    filtrée sur place ;                                              */
/*  - ailleurs : les résultats s'affichent dans un panneau en haut du  */
/*    contenu, sans changer de page.                                   */
/* ------------------------------------------------------------------ */

function initLiveSearch() {
    const forms = document.querySelectorAll('form[data-live-search]');
    if (!forms.length) return;

    const parser = new DOMParser();
    let pending = null;

    const panelHost = () => document.querySelector('[data-live-search-host]')
        ?? document.querySelector('.main-panel > .container');

    const closePanel = () => document.getElementById('liveSearchPanel')?.remove();

    const openPanel = (html, pageUrl) => {
        const host = panelHost();
        if (!host) return null;
        let panel = document.getElementById('liveSearchPanel');
        if (!panel) {
            panel = document.createElement('section');
            panel.id = 'liveSearchPanel';
            panel.className = 'live-search-panel';
            panel.setAttribute('aria-live', 'polite');
            host.prepend(panel);
        }
        panel.innerHTML = `
            <div class="live-search-panel-head">
                <span><i class="fas fa-magnifying-glass me-2"></i>Résultats de la recherche</span>
                <div class="d-flex align-items-center gap-2">
                    <a href="${escapeHtml(pageUrl)}" class="btn btn-sm btn-outline-primary">Ouvrir la page</a>
                    <button type="button" class="btn-close" aria-label="Fermer les résultats" data-live-search-close></button>
                </div>
            </div>
            <div class="container live-search-panel-body">${html}</div>`;
        return panel;
    };

    forms.forEach((form) => {
        const actionPath = new URL(form.action, window.location.origin).pathname;
        const onResultsPage = () => window.location.pathname === actionPath
            && document.querySelector('[data-live-results]');
        let typingTimer = null;

        const buildUrl = () => {
            const params = new URLSearchParams();
            form.querySelectorAll('input[name]').forEach((input) => {
                const value = input.value.trim();
                if (value) params.set(input.name, value);
            });
            const query = params.toString();
            return `${actionPath}${query ? `?${query}` : ''}`;
        };
        let lastUrl = onResultsPage() ? `${window.location.pathname}${window.location.search}` : actionPath;

        const update = async (url, { scroll = false } = {}) => {
            const isEmpty = !new URL(url, window.location.origin).search;
            // Hors page de résultats, une recherche vide ferme simplement le panneau
            if (!onResultsPage() && isEmpty) {
                pending?.abort();
                closePanel();
                return;
            }

            pending?.abort();
            const controller = new AbortController();
            pending = controller;
            const target = onResultsPage()
                ? document.querySelector('[data-live-results]')
                : document.getElementById('liveSearchPanel');
            target?.classList.add('is-loading');

            try {
                const { data } = await axios.get(url, {
                    headers: { Accept: 'text/html' },
                    responseType: 'text',
                    signal: controller.signal,
                });
                const results = parser.parseFromString(data, 'text/html').querySelector('[data-live-results]');
                if (!results) throw new Error('Zone de résultats introuvable');

                let shown;
                if (onResultsPage()) {
                    shown = document.querySelector('[data-live-results]');
                    shown.innerHTML = results.innerHTML;
                    window.history.replaceState({}, '', url);
                } else {
                    shown = openPanel(results.innerHTML, url);
                }
                AOS.refreshHard();
                if (scroll) shown?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } catch (error) {
                if (axios.isCancel(error)) return;
                showToast('Impossible de charger les résultats.', 'danger');
            } finally {
                if (pending === controller) pending = null;
                document.querySelectorAll('[data-live-results].is-loading, #liveSearchPanel.is-loading')
                    .forEach((el) => el.classList.remove('is-loading'));
            }
        };

        form.addEventListener('input', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                const url = buildUrl();
                if (url === lastUrl) return;
                lastUrl = url;
                update(url);
            }, 350);
        });

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            clearTimeout(typingTimer);
            document.activeElement?.blur();
            lastUrl = buildUrl();
            update(lastUrl, { scroll: true });
        });

        // Liens "Réinitialiser" de la zone de résultats : vident la recherche sans recharger
        document.addEventListener('click', (event) => {
            if (event.defaultPrevented) return;
            const link = event.target.closest('[data-live-results] a[href], #liveSearchPanel .live-search-panel-body a[href]');
            if (!link || new URL(link.href).pathname !== actionPath || new URL(link.href).search) return;
            event.preventDefault();
            form.querySelectorAll('input[name]').forEach((input) => { input.value = ''; });
            lastUrl = actionPath;
            update(actionPath);
        });

        form.addEventListener('live-search:reset', () => {
            clearTimeout(typingTimer);
            lastUrl = actionPath;
        });
    });

    document.addEventListener('click', (event) => {
        if (!event.target.closest('[data-live-search-close]')) return;
        closePanel();
        forms.forEach((form) => {
            form.querySelectorAll('input[name]').forEach((input) => { input.value = ''; });
            form.dispatchEvent(new Event('live-search:reset'));
        });
    });
}

/* ------------------------------------------------------------------ */

document.addEventListener('DOMContentLoaded', () => {
    initAnimations();
    initTypewriter();
    initBootstrapComponents();
    initSidebar();
    initEditor();
    initAjaxForms();
    initNotifications();
    initHomeSearch();
    initLiveSearch();
});
