<?php  

if( ! function_exists('unique_number') ){
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
    function unique_number($table, $col, $chars = 4){

        $unique = false;
        $tested = [];

        do{
            $start_string = '1';
            for($i = 0; $i < $chars; $i++) {
                $start_string .= '0';
            };

            $end_string = '9';
            for($i = 0; $i < $chars; $i++) {
                $end_string .= '9';
            };

            // for ($i=0;$i<=$chars;$i++){
            //     $random .= mt_rand(1,9);
            // }

            //$random = mt_rand(1000,9999);

            $random = floor(floatval($start_string) + lcg_value()*(abs(floatval($end_string) - floatval($start_string))));

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


        return $random;
    }
}

?>