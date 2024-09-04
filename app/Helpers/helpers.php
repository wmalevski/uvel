<?php

if( ! function_exists('isDev') ){
    /**
     *
     * Check the current environment
     *
     * @return bool
     */
    function isDev()
    {
        $isDev = strtolower(config('app.env')) == 'development';
        $isLocal = strtolower(config('app.env')) == 'local';

        return ($isDev || $isLocal);
    }
}

?>
