<?php
    namespace myLaravelFirstApp\Helpers;

    class Helper
    {
        public static function timeElapsedString( $time )
        {
            $time_difference = time() - $time;

            if( $time_difference < 1 ) { return 'just now'; }
            $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                        30 * 24 * 60 * 60       =>  'month',
                        24 * 60 * 60            =>  'day',
                        60 * 60                 =>  'hour',
                        60                      =>  'minute',
                        1                       =>  'second'
            );

            foreach( $condition as $secs => $str )
            {
                $d = $time_difference / $secs;

                if( $d >= 1 )
                {
                    $t = round( $d );
                    return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
                }
            }
        }
    }
?>