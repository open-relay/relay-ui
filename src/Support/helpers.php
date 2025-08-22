<?php

namespace Relay\UI\Support;

if (!function_exists('Relay\UI\Support\cn')) {
    /**
     * Intelligently merges CSS classes from strings and conditional arrays.
     *
     * This utility function is inspired by JavaScript libraries like clsx and tailwind-merge.
     * It processes any number of arguments, filters out falsy values, and returns a
     * clean, space-separated string of unique CSS classes.
     *
     * @param mixed ...$args A dynamic list of strings or arrays of classes.
     * - A string 'class-a class-b' will be added.
     * - An array ['class-a', 'class-b'] will be added.
     * - A conditional array ['class-c' => true, 'class-d' => false] will only add 'class-c'.
     * @return string A compiled string of unique CSS classes.
     */
    function cn(...$args): string
    {
        $classes = [];

        foreach ($args as $arg) {
            if (is_string($arg) && !empty($arg)) {
                $classes[] = $arg;
            } elseif (is_array($arg)) {
                foreach ($arg as $key => $value) {
                    if (is_int($key) && is_string($value) && !empty($value)) {
                        $classes[] = $value;
                    } elseif (is_string($key) && !empty($key) && $value) {
                        $classes[] = $key;
                    }
                }
            }
        }

        return implode(' ', array_unique(explode(' ', implode(' ', $classes))));
    }
}
