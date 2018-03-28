<?php  

if( ! function_exists('unique_random') ){
    /**
     *
     * Generate a unique random string of characters
     * uses str_random() helper for generating the random string
     *
     * @param     $table - name of the table
     * @param     $col - name of the column that needs to be tested
     * @param int $chars - length of the random string
     *
     * @return string
     */
    function unique_random($table, $col, $chars = 4){

        $unique = false;
        $tested = [];

        do{

            $random = str_random($chars);

            if( in_array($random, $tested) ){
                continue;
            }

            $count = DB::table($table)->where($col, '=', $random)->count();

            $tested[] = $random;

            if( $count == 0){
                $unique = true;
            }

        }
        while(!$unique);


        return strtoupper($random);
    }
}

?>