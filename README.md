# ⚙️ Relay UI

A fluent, object-oriented UI component library for building professional-grade WordPress interfaces.

## Overview

Relay UI is a system, philosophy, and toolkit for building UIs with clean, decoupled, object-oriented PHP and a lightweight JavaScript engine.

## Core Principles

- **Fluent & Object-Oriented**: Build UIs with a chainable PHP API
- **Decoupled & Performant**: Static HTML skeleton with minimal JavaScript (<1KB)
- **Headless & Unstyled**: Compatible with utility-class frameworks like Tailwind CSS
- **Developer-First**: Built for extensibility and customization

## Installation

```bash
composer require your-name/relay-ui
```

## Quick Start Guide

### 1. Load the Engine

```php
require_once __DIR__ . '/vendor/autoload.php';
```

### 2. Enqueue JavaScript

```php
add_action('admin_enqueue_scripts', function() {
    $script_path = plugin_dir_url(__FILE__) . '../vendor/your-name/relay-ui/assets/js/relay-ui.js';
    wp_enqueue_script('relay-ui-engine', $script_path, [], '1.0.0', true);
});
```

### 3. Create Components

```php
use Relay\UI\Button;

Button::make('Save Changes')
    ->variant('default')
    ->size('lg')
    ->onClick('save-plugin-settings')
    ->render();
```

## Components

### Button Component

```php
use Relay\UI\Button;

// Basic button
Button::make('Click Me')->render();

// Variant with size
Button::make('Delete')
    ->variant('destructive')
    ->size('sm')
    ->render();

// Advanced usage
Button::make('Learn More')
    ->variant('outline')
    ->attribute('data-user-id', '123')
    ->onClick('show-help-modal')
    ->render();
```

## JavaScript API

Register actions in your admin script:

```javascript
if (window.Relay) {
  window.Relay.register("save-plugin-settings", (buttonElement) => {
    buttonElement.textContent = "Saving...";
    buttonElement.disabled = true;

    // AJAX logic here

    setTimeout(() => {
      buttonElement.textContent = "Save Changes";
      buttonElement.disabled = false;
    }, 2000);
  });
}
```
