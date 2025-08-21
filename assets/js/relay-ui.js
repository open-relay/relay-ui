/**
 * Relay UI - Client-Side Engine v1.0.0
 * A lightweight, dependency-free engine to hydrate static components.
 */
class RelayUI {
    /**
     * Initializes the engine.
     */
    constructor() {
        this.actions = new Map();
        this.init();
    }

    /**
     * Registers a dynamic action that can be triggered by a component.
     * @param {string} actionName The name of the action (e.g., 'show-modal').
     * @param {(element: HTMLElement) => void} callback The function to execute.
     */
    register(actionName, callback) {
        if (typeof callback !== 'function') {
            console.error(`[RelayUI] Action "${actionName}" requires a valid callback function.`);
            return;
        }
        this.actions.set(actionName, callback);
    }

    /**
     * Initializes the global event listener using event delegation.
     */
    init() {
        document.addEventListener('click', (event) => {
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

// Expose a single, global instance.
window.Relay = new RelayUI();