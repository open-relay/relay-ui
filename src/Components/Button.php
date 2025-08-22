<?php

namespace Relay\UI\Components;

use function Relay\UI\Support\cn;

/**
 * Renders a highly configurable, accessible button component.
 */
class Button extends Component
{
    private string $variant = 'default';
    private string $size = 'default';
    private ?string $icon = null;
    private bool $disabled = false;

    public function __construct(private string $label)
    {
    }

    public static function make(string $label): self
    {
        return new self($label);
    }

    public function variant(string $variant): self
    {
        if (in_array($variant, ['default', 'destructive', 'outline'])) {
            $this->variant = $variant;
        }
        return $this;
    }

    public function size(string $size): self
    {
        if (in_array($size, ['sm', 'default', 'lg'])) {
            $this->size = $size;
        }
        return $this;
    }

    public function disabled(bool $is_disabled = true): self
    {
        $this->disabled = $is_disabled;
        return $this;
    }

    public function onClick(string $action): self
    {
        return $this->attribute('data-action', $action);
    }

    public function withIcon(string $icon_svg_html): self
    {
        $this->icon = $icon_svg_html;
        return $this;
    }

    public function render(): void
    {
        $this->attributes['class'] = cn(
            'inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors',
            [
                'bg-red-600 text-white hover:bg-red-700' => $this->variant === 'destructive',
                'border border-gray-300 bg-transparent hover:bg-gray-100' => $this->variant === 'outline',
                'bg-blue-600 text-white hover:bg-blue-700' => $this->variant === 'default',
            ],
            [
                'h-9 px-3' => $this->size === 'sm',
                'h-11 px-8' => $this->size === 'lg',
                'h-10 py-2 px-4' => $this->size === 'default',
            ],
            ['opacity-50 cursor-not-allowed' => $this->disabled],
            $this->custom_classes
        );

        $this->attributes['disabled'] = $this->disabled;
        ?>
        <button <?= $this->render_attributes() ?>>
            <?php if ($this->icon) : ?>
                <?= $this->icon ?>
            <?php endif; ?>
            <span><?= esc_html($this->label) ?></span>
        </button>
        <?php
    }
}
