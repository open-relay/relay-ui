<?php

namespace Relay\UI\Components;

/**
 * An abstract base class for all UI components.
 *
 * Provides a foundational, fluent API for managing HTML attributes and
 * merging default and user-provided CSS classes.
 */
abstract class Component
{
    protected array $attributes = [];
    protected array $custom_classes = [];

    /**
     * Sets custom CSS classes from the user to be merged with component defaults.
     *
     * @param string|array $classes A space-separated string or an array of classes.
     * @return static The component instance for fluent method chaining.
     */
    public function classes(string|array $classes): static
    {
        $this->custom_classes = array_merge($this->custom_classes, is_array($classes) ? $classes : explode(' ', $classes));
        return $this;
    }

    /**
     * Conditionally adds CSS classes to the component.
     *
     * This powerful helper allows for applying classes within a fluent chain
     * without needing a separate if-statement, keeping your view logic clean.
     *
     * @param bool $condition The condition to evaluate.
     * @param string|array $classes The classes to apply if the condition is true.
     * @return static The component instance for fluent method chaining.
     */
    public function classIf(bool $condition, string|array $classes): static
    {
        if ($condition) {
            $this->classes($classes);
        }
        return $this;
    }


    /**
     * Sets a key-value HTML attribute for the component.
     *
     * @param string $key The attribute key (e.g., 'id', 'data-action').
     * @param mixed $value The attribute value. Boolean `true` will render a valueless attribute, `false` will skip it.
     * @return static The component instance for fluent method chaining.
     */
    public function attribute(string $key, mixed $value): static
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * Compiles and returns the final string of HTML attributes.
     *
     * @return string The compiled HTML attribute string, ready for rendering.
     */
    protected function render_attributes(): string
    {
        $attr_strings = [];
        foreach ($this->attributes as $key => $value) {
            if ($value === false) {
                continue;
            }
            if ($value === true) {
                $attr_strings[] = esc_attr($key);
                continue;
            }
            $attr_strings[] = sprintf('%s="%s"', esc_attr($key), esc_attr((string) $value));
        }
        return implode(' ', $attr_strings);
    }

    /**
     * Renders the component's final HTML output to the browser.
     * This method must be implemented by all concrete child components.
     */
    abstract public function render(): void;
}
