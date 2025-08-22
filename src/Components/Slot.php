<?php

// src/Components/Slot.php

namespace Relay\UI\Components;

/**
 * A simple component that holds and renders a block of raw HTML content.
 * This is the foundation for creating customizable "slots" in other components.
 */
class Slot extends Component
{
    /**
     * @param string $content The raw HTML content for the slot.
     */
    public function __construct(private string $content = '')
    {
    }

    /**
     * Factory method to create a new Slot instance.
     *
     * @param string $content The raw HTML content. The developer is responsible for ensuring it's safe.
     * @return self
     */
    public static function make(string $content = ''): self
    {
        return new self($content);
    }

    /**
     * Renders the raw HTML content of the slot.
     */
    public function render(): void
    {
        echo $this->content;
    }
}
