<?php

declare(strict_types=1);

namespace Relay\UI;

/**
 * Renders a highly configurable, accessible button component.
 */
class Button extends Component
{
    private string $label;
    private string $variant = 'default';
    private string $size = 'default';
    private ?string $icon = null;
    private bool $disabled = false;

    /**
     * Creates a new Button instance with a required label.
     *
     * @param string $label The button's visible text.
     * @return self The new Button instance.
     */
    public static function make(string $label): self
    {
        $instance = new self();
        $instance->label = $label;
        return $instance;
    }

    /**
     * Sets the visual style of the button.
     *
     * @param 'default'|'destructive'|'outline' $variant The button variant.
     * @return self
     */
    public function variant(string $variant): self
    {
        $this->variant = $variant;
        return $this;
    }
    
    /**
     * Sets the size of the button.
     *
     * @param 'sm'|'default'|'lg' $size The button size.
     * @return self
     */
    public function size(string $size): self
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Prepends an SVG icon to the button's label.
     *
     * @param string $icon_svg_html Raw SVG HTML for the icon.
     * @return self
     */
    public function withIcon(string $icon_svg_html): self
    {
        $this->icon = $icon_svg_html;
        return $this;
    }

    /**
     * Sets the disabled state of the button.
     *
     * @param bool $is_disabled Defaults to true.
     * @return self
     */
    public function disabled(bool $is_disabled = true): self
    {
        $this->disabled = $is_disabled;
        return $this;
    }

    /**
     * Assigns a JavaScript action hook via a data-attribute.
     *
     * @param string $action The name of the action for the JS engine to find.
     * @return self
     */
    public function onClick(string $action): self
    {
        return $this->attribute('data-action', $action);
    }
    
    /**
     * Renders the final button HTML.
     */
    public function render(): void
    {
        $this->class('inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors');
        
        $this->class(match($this->variant) {
            'destructive' => 'bg-error text-white hover:opacity-90',
            'outline'     => 'border border-border bg-transparent hover:bg-surface',
            default       => 'bg-accent text-background hover:bg-accent/90',
        });
        
        $this->class(match($this->size) {
            'sm'      => 'h-9 px-3',
            'lg'      => 'h-11 px-8',
            default   => 'h-10 py-2 px-4',
        });
        
        if ($this->disabled) {
            $this->class('opacity-50 cursor-not-allowed');
            $this->attribute('disabled', 'true');
        }

        printf(
            '<button %s>%s<span class="mx-1">%s</span></button>',
            $this->render_attributes(),
            $this->icon ?? '',
            esc_html($this->label)
        );
    }
}