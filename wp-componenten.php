<?php

/*
Plugin Name: wp componenten
Plugin URI: https://github.com/indrukwekkend/WP-componenten
Description: Beste. Componenten. Oooooit.
Author: Sjerp van Wouden / Indrukwekkend
Version: 0.1
Author URI: https://indrukwekkend.nl
*/

register_activation_hook(__FILE__, 'IDW_componenten_voorwaarden');

add_action('after_setup_theme', 'registreer_lijst_formaat', 99);
add_action('after_setup_theme', 'registreer_optie_pagina_en_velden');

add_action('init', 'registreer_componenten_stijlen');

function registreer_componenten_stijlen()
{
    wp_register_style("idw-basis-componenten-stijl", plugins_url("WP-componenten/css/componenten-basis.css"), array(), null);
    wp_enqueue_style("idw-basis-componenten-stijl");
}

function registreer_lijst_formaat()
{
    if (!has_image_size('lijst')) {
        add_image_size('lijst', 720, 450);
    }
}


require 'basis/acf.php';
require 'basis/gereedschap.php';
require 'basis/basis_class.php';
require 'basis/HTML_interface.php';
require 'basis/HTML_class.php';

require 'subcomponenten/header_class.php';
require 'subcomponenten/titel_trait.php';

require 'componenten/knop_class.php';
require 'componenten/artikel_class.php';
require 'componenten/artikel_lijst_class.php';
require 'componenten/sectie_class.php';
require 'componenten/hero_class.php';
require 'componenten/tekstblok_class.php';

require 'admin/installatie.php';
require 'admin/admin-frontend.php';
