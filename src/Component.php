<?php

declare(strict_types=1);

namespace Relay\UI;

/**
 * An abstract base class for all UI components.
 *
 * Provides a foundation for handling HTML attributes and CSS classes
 * in a structured and fluent way.
 */
abstract class Component
{
    protected array $attributes = [];
    protected array $classes = [];

    /**
     * Appends one or more CSS classes to the component.
     *
     * @param string $class_string A space-separated string of classes.
     * @return static The instance of the component for method chaining.
     */
    public function class(string $class_string): static
    {
        $this->classes = array_merge($this->classes, explode(' ', $class_string));
        return $this;
    }

    /**
     * Sets a key-value HTML attribute for the component.
     *
     * @param string $key The attribute key (e.g., 'id', 'data-action').
     * @param string $value The attribute value.
     * @return static The instance of the component for method chaining.
     */
    public function attribute(string $key, string $value): static
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * Compiles and renders the final string of HTML attributes.
     * Automatically handles the 'class' attribute.
     *
     * @return string The compiled HTML attribute string.
     */
    protected function render_attributes(): string
    {
        $this->attributes['class'] = esc_attr(implode(' ', array_unique($this->classes)));

        $attr_strings = [];
        foreach ($this->attributes as $key => $value) {
            $attr_strings[] = sprintf('%s="%s"', $key, esc_attr($value));
        }
        return implode(' ', $attr_strings);
    }

    /**
     * Renders the component's final HTML output.
     * Must be implemented by all child components.
     */
    abstract public function render(): void;
}