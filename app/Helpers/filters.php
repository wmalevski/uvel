<?php

if (!function_exists('filter_products')) {
    /**
     *
     * Filter products.
     *
     * @return string
     */
    function filter_products($type, $id)
    {
        if (isset($_GET[$type]) && in_array($id, $_GET[$type])) {
            return 'selected';
        }
    }
}