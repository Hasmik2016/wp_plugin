<?php
    if(!function_exists('printr'))
    {
        function printr($mixed)
        {
            echo '<pre>';
            print_r($mixed);
            echo '</pre>';
        }
    }
?>