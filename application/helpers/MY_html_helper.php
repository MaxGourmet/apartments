<?php
if (!function_exists('div')) {
    function div($text, $attributes = [])
    {
        $attributes = implode(" ", $attributes);
        return "<div $attributes>$text</div>";
    }
}
if (!function_exists('span')) {
    function span($text, $attributes = [])
    {
        $attributes = implode(" ", $attributes);
        return "<span $attributes>$text</span>";
    }
}