<?php

use IDW\Knop as Knop;
use IDW\Artikel as Artikel;
use IDW\ArtikelLijst as ArtikelLijst;
use IDW\Header as Header;

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

        <style>
            img {
                width: 100%;
                height: auto;
            }
        </style>

        <h1>Indrukwekkend Compontenten</h1>

        <?php if (
            !get_field('terugval_afbeelding', 'option') &&
            !get_field('ta_afbeelding', 'option')
        ) {
            trigger_error(
                'JOOO. Ik verwacht dat je een optie pagina hebt met daarin een ACF veld genaamd "terugval_afbeelding" of "ta_afbeelding"! Image veld, teruggeven als array.',
                E_USER_WARNING
            );
        } ?>

        <section class="idw-cmp-sectie">

            <header><h2>knop Class.</h2></header>

            <div class='idw-cmp-sectie__brood'>
            
                <p>Dit is de knop class - wat zal ik schrijven?.</p>

                <?php
                $knop_class = new Knop([
                    'link' => site_url(),
                    'context' => 'superknop',
                    'tekst' => 'Dit is de knop Yo'
                    // 'extern'        => false, // facultatief
                ]);

                $knop_class->print();
                ?>
            </div>

        </section>




        <section class="idw-cmp-sectie">

            <header><h2>Artikel <strong>lijst</strong> Class.</h2></header>

            <div class='idw-cmp-sectie__brood'>
            
                <p>De structuur van Agitatie.</p>

                <?php
                $alle_posts = get_posts([
                    'posts_per_page' => 10,
                    'post_type' => 'post'
                ]);

                $artikel_lijst = new ArtikelLijst([
                    'posts' => $alle_posts,
                    'titel' => "VETTE POSTS TOCH!!!",
                    'context' => 'blauw groot',
                    'artikel_config' => [
                        'context' => 'blauw groot',
                        'stuk_klassen' => 'col-4'
                    ]
                ]);
                $artikel_lijst->print();
                ?>
            </div>

        </section>

        <section class="idw-cmp-sectie">

            <header><h2>Artikel Class.</h2></header>

            <div class='idw-cmp-sectie__brood'>
            
                <p>Het geheim achter Agitatie.</p>

                <?php
                $twee_posts = get_posts([
                    'posts_per_page' => 2,
                    'post_type' => 'post'
                ]);

                $eerste_vd_2 = new Artikel([
                    'post' => $twee_posts[0],
                    'context' => 'bier'
                ]);
                $eerste_vd_2->print();

                $tweede_vd_2 = new Artikel(['post' => $twee_posts[1]]);
                $tweede_vd_2->print();?>
            </div>

        </section>




    </div>

<?php
}

add_action('admin_menu', 'IDW_cmp_admin_hook');
