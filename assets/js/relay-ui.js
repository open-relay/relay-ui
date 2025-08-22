/**
 * Relay UI - Client-Side Engine v1.0.0
 */
class RelayUI {
    constructor() {
        this.actions = new Map();
        document.addEventListener('DOMContentLoaded', () => this.init());
    }

    register(actionName, callback) {
        if (typeof callback !== 'function') {
            console.error(`[RelayUI] Action "${actionName}" requires a valid callback function.`);
            return;
        }
        this.actions.set(actionName, callback);
    }

    init() {
        document.body.addEventListener('click', (event) => {
            const triggerElement = event.target.closest('[data-action]');
            if (!triggerElement) return;

            const actionName = triggerElement.dataset.action;
            if (this.actions.has(actionName)) {
                event.preventDefault();
                this.actions.get(actionName)(triggerElement);
            }
        }, true);
    }
}

window.Relay = new RelayUI();

window.Relay.register('modal:open', (triggerElement) => {
    const targetSelector = triggerElement.dataset.target;
    if (!targetSelector) {
        console.error('[RelayUI] modal:open trigger requires a `data-target` attribute.');
        return;
    }
    const modalElement = document.querySelector(targetSelector);
    if (!modalElement) {
        console.error(`[RelayUI] modal:open could not find target: ${targetSelector}`);
        return;
    }

    const data = triggerElement.dataset;
    const titleEl = modalElement.querySelector('[data-modal-title]');
    const bodyEl = modalElement.querySelector('[data-modal-body]');
    const confirmEl = modalElement.querySelector('[data-modal-confirm]');

    if (titleEl && data.title) titleEl.textContent = data.title;
    if (bodyEl && data.body) bodyEl.innerHTML = data.body;
    if (confirmEl && data.confirmUrl) confirmEl.href = data.confirmUrl;

    modalElement.classList.remove('hidden');
    modalElement.classList.add('flex');
});

window.Relay.register('modal:close', (triggerElement) => {
    const modalElement = triggerElement.closest('[role="dialog"]');
    if (modalElement) {
        modalElement.classList.add('hidden');
        modalElement.classList.remove('flex');
    }
});