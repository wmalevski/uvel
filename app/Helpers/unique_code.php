<?php

if (!function_exists('unique_code')) {
    /**
     *
     * Generate a unique string of characters
     * uses str_random() helper for generating the random string
     *
     * @param     $table - name of the table
     * @param     $col - name of the column that needs to be tested
     * @param int $chars - length of the random string
     *
     * @return string
     */
    function unique_code($table, $col)
    {
        if (DB::table($table)->count()) {
            $number = DB::table($table)->latest()->first()->id;
            $number++;
        } else {
            $number = 1;
        }

        return sprintf("%04d", $number);;
    }
}

?>
