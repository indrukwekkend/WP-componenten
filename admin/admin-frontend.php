<?php

use IDW\Knop as Knop;
use IDW\Artikel as Artikel;
use IDW\ArtikelLijst as ArtikelLijst;
use IDW\Header as Header;
use IDW\SectieSimpel as SectieSimpel;

function IDW_cmp_admin_hook()
{
    add_menu_page(
        'idw-componenten',
        'Indrukwekkend componenten',
        'manage_options',
        'idw-componenten',
        'IDW_cmp_print_admin_pagina'
    );
}

function IDW_cmp_print_admin_pagina()
{
    ?>
    
    <div class='wrap container'>
    
        <link href='/wp-content/plugins/idw-componenten/bootstrap/bootstrap-reboot.css' rel='stylesheet'>
        <link href='/wp-content/plugins/idw-componenten/bootstrap/bootstrap-grid.css' rel='stylesheet'>
        <link href='/wp-content/plugins/idw-componenten/bootstrap/bootstrap.css' rel='stylesheet'>
        <link href='/wp-content/plugins/idw-componenten/css/componenten-basis.css' rel='stylesheet'>

        <style>
            img {
                width: 100%;
                height: auto;
            }
        </style>

        <h1>Indrukwekkend Compontenten</h1>

        <?php
        if (
            !get_field('terugval_afbeelding', 'option') &&
            !get_field('ta_afbeelding', 'option')
        ) {
            trigger_error(
                'JOOO. Ik verwacht dat je een optie pagina hebt met daarin een ACF veld genaamd "terugval_afbeelding" of "ta_afbeelding"! Image veld, teruggeven als array.',
                E_USER_WARNING
            );
        }

        ////////////////////////////////////////////
        ////////////////////////////////////////////

        $knop_sectie = new SectieSimpel([
            'titel' => 'De knop Class.'
        ]);

        $knop_sectie->zetBroodHTML('<p>Ik kom in de brood YO</p>');

        $knop_class = new Knop([
            'link'      => site_url(),
            'class'     => 'btn-primary btn-lg',
            'context'   => 'demo',
            'tekst'     => 'Dit is een primare knop'
        ]);
        $knop_sectie->zetBroodHTML($knop_class->maak());

        $knop_class2 = new Knop([
            'link'      => site_url(),
            'class'     => 'btn-success',
            'tekst'     => 'Dit is een success knop'
        ]);
        $knop_sectie->zetBroodHTML($knop_class2->maak());

        $knop_sectie->print();

        ////////////////////////////////////////////
        ////////////////////////////////////////////

        $artikel_lijst_sectie = new SectieSimpel([
            'titel' => 'Artikel <strong>lijst</strong> Class.'
        ]);

        $alle_posts = get_posts([
            'posts_per_page' => 10,
            'post_type' => 'post'
        ]);

        $artikel_lijst = new ArtikelLijst([
            'posts' => $alle_posts,
            'context' => 'blauw groot',
            'artikel_config' => [
                'context' => 'blauw groot',
                'stuk_klassen' => 'col-4'
            ]
        ]);

        $artikel_lijst_sectie->zetBroodHTML($artikel_lijst->maak());

        $artikel_lijst_sectie->print();

        ////////////////////////////////////////////
        ////////////////////////////////////////////

        $twee_posts = get_posts([
            'posts_per_page' => 2,
            'post_type' => 'post'
        ]);

        $eerste_vd_2 = new Artikel([
            'post' => $twee_posts[0],
            'context' => 'bier'
        ]);
        $tweede_vd_2 = new Artikel([
            'post' => $twee_posts[1]
        ]);

        $artikel_sectie = new SectieSimpel([
            'titel' => 'Artikel Class.',
            'broodHTML' => $eerste_vd_2->maak() . $tweede_vd_2->maak()
        ]);

        $artikel_sectie->print();
        ?>       






    </div>

<?php
}

add_action('admin_menu', 'IDW_cmp_admin_hook');
