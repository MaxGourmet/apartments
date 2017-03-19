<?php
if (!function_exists('div')) {
    function div($text, $attributes = [])
    {
        $attributes = _attributes_to_string($attributes);
        return "<div $attributes>$text</div>";
    }
}
if (!function_exists('span')) {
    function span($text, $attributes = [])
    {
        $attributes = _attributes_to_string($attributes);
        return "<span $attributes>$text</span>";
    }
}