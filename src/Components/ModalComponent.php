<?php

namespace Relay\UI\Components;

use function Relay\UI\Support\cn;

/**
 * Renders a fully customizable, accessible modal dialog component.
 */
class ModalComponent extends Component
{
    private ?Component $header = null;
    private ?Component $body = null;
    private ?Component $footer = null;

    public function __construct(private string $id)
    {
        $this->header = Slot::make(
            sprintf('<h3 id="%s-title" class="text-xl font-semibold">Modal Title</h3>', esc_attr($this->id))
        );
    }

    public static function make(string $id): self
    {
        return new self($id);
    }

    public function withHeader(Component $component): self
    {
        $this->header = $component;
        return $this;
    }

    public function withBody(Component $component): self
    {
        $this->body = $component;
        return $this;
    }

    public function withFooter(Component $component): self
    {
        $this->footer = $component;
        return $this;
    }

    public function render(): void
    {
        $this->attributes['class'] = cn(
            'fixed inset-0 z-50 hidden items-center justify-center p-4',
            $this->custom_classes
        );
        $this->attributes['id'] = $this->id;
        $this->attributes['role'] = 'dialog';
        $this->attributes['aria-modal'] = 'true';
        $this->attributes['aria-labelledby'] = $this->id . '-title';

        ?>
        <div <?= $this->render_attributes() ?>>
            <div data-action="modal:close" class="absolute inset-0 bg-black/60" aria-label="Close modal"></div>
            <div class="relative w-full max-w-lg bg-white rounded-lg shadow-xl">
                <?php if ($this->header) : ?>
                    <div class="flex items-center justify-between p-4 border-b">
                        <?php $this->header->render(); ?>
                        <button data-action="modal:close" class="p-1 text-gray-500 hover:text-gray-800" aria-label="Close">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                <?php endif; ?>
                <?php if ($this->body) : ?>
                    <div class="p-6">
                        <?php $this->body->render(); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->footer) : ?>
                    <div class="flex justify-end gap-2 p-4 border-t bg-gray-50">
                        <?php $this->footer->render(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
