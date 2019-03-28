<?php

function IDW_componenten_voorwaarden()
{
    if (!function_exists('acf_register_block')) :
        trigger_error('IDW componenten vereist ACF >= 5.8', E_USER_WARNING);
        die();
    endif;

    // meer
}
