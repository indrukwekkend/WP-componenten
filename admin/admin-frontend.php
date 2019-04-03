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

        <link href='<?php echo plugins_url()?>/idw-componenten/bootstrap/bootstrap-reboot.css' rel='stylesheet'>
        <link href='<?php echo plugins_url()?>/idw-componenten/bootstrap/bootstrap-grid.css' rel='stylesheet'>
        <link href='<?php echo plugins_url()?>/idw-componenten/bootstrap/bootstrap.css' rel='stylesheet'>
        <link href='<?php echo plugins_url()?>/idw-componenten/css/componenten-basis.css' rel='stylesheet'>

        <style>
            img {
                width: 100%;
                height: auto;
            }
            p {
                font-size: 16px;
            }
        </style>

        <h1>Indrukwekkend Compontenten</h1>

        <?php
        if (!get_field('terugval_afbeelding', 'option')
            && !get_field('ta_afbeelding', 'option')
        ) {
            trigger_error(
                'JOOO. Ik verwacht dat je een optie pagina hebt met daarin een ACF veld genaamd "terugval_afbeelding" of "ta_afbeelding"! Image veld, teruggeven als array.',
                E_USER_WARNING
            );
        }

        ///////////////////////////////////////////
        ///////////////////////////////////////////

        $sectie_sectie = new SectieSimpel(
            [
            'titel' => 'De sectie Class.'
            ]
        );

        $sectie_sectie->zetBroodHTML(
            "
            <p>Ik heb niet echt veel om het lichaam.</p>
            <h3>Maar als je me lief behandeld</h3>
            <p>mag je wel wat HTML in me stoppen</p>
        "
        );

        $sectie_sectie->print();



        ////////////////////////////////////////////
        ////////////////////////////////////////////

        $knop_sectie = new SectieSimpel(
            [
            'titel' => 'De knop Class.'
            ]
        );

        //$knop_sectie->zetBroodHTML('<p>Ik kom in de brood YO</p>');

        $knop_class = new Knop(
            [
            'link'      => site_url(),
            'class'     => 'btn-primary btn-lg',
            'context'   => 'demo',
            'tekst'     => 'Dit is een primare knop'
            ]
        );
        $knop_sectie->zetBroodHTML($knop_class->maak());
        $knop_sectie->zetBroodHTML($knop_class->pakDebugConsole($knop_class));

        $knop_class2 = new Knop(
            [
            'link'      => site_url(),
            'class'     => 'btn-success',
            'tekst'     => 'Dit is een success knop'
            ]
        );
        $knop_sectie->zetBroodHTML($knop_class2->maak());

        $knop_class3 = new Knop(
            [
            'link'      => site_url(),
            'class'     => 'btn-danger',
            'tekst'     => 'Ik heb een ikoon',
            'ikoon'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M20.5 11H19V7c0-1.1-.9-2-2-2h-4V3.5C13 2.12 11.88 1 10.5 1S8 2.12 8 3.5V5H4c-1.1 0-1.99.9-1.99 2v3.8H3.5c1.49 0 2.7 1.21 2.7 2.7s-1.21 2.7-2.7 2.7H2V20c0 1.1.9 2 2 2h3.8v-1.5c0-1.49 1.21-2.7 2.7-2.7 1.49 0 2.7 1.21 2.7 2.7V22H17c1.1 0 2-.9 2-2v-4h1.5c1.38 0 2.5-1.12 2.5-2.5S21.88 11 20.5 11z"/></svg>'
            ]
        );
        $knop_sectie->zetBroodHTML($knop_class3->maak());

        $knop_class4 = new Knop(
            [
            'link'      => site_url(),
            'class'     => 'btn-primary',
            'tekst'     => 'Ik heb een ikoon rechts...!',
            'maak_volgorde'=> ['pakTekst', 'pakIkoon'],
            'ikoon'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M20.5 11H19V7c0-1.1-.9-2-2-2h-4V3.5C13 2.12 11.88 1 10.5 1S8 2.12 8 3.5V5H4c-1.1 0-1.99.9-1.99 2v3.8H3.5c1.49 0 2.7 1.21 2.7 2.7s-1.21 2.7-2.7 2.7H2V20c0 1.1.9 2 2 2h3.8v-1.5c0-1.49 1.21-2.7 2.7-2.7 1.49 0 2.7 1.21 2.7 2.7V22H17c1.1 0 2-.9 2-2v-4h1.5c1.38 0 2.5-1.12 2.5-2.5S21.88 11 20.5 11z"/></svg>'
            ]
        );
        $knop_sectie->zetBroodHTML($knop_class4->maak());

        $knop_sectie->print();



        ////////////////////////////////////////////
        ////////////////////////////////////////////

        $artikel_lijst_sectie = new SectieSimpel(
            [
            'titel' => 'Artikel <strong>lijst</strong> Class.'
            ]
        );

        $artikel_lijst_sectie->zetBroodHTML(
            "
        <p><strong>Serieus veel gedonder BEM en bootstrap door elkaar</strong></p>
        <p>Maar kan er wel leuke ongein mee uithalen</P>
        "
        );

        $alle_posts = get_posts(
            [
            'posts_per_page' => 10,
            'post_type' => 'post'
            ]
        );

        $artikel_lijst = new ArtikelLijst(
            [
            'posts' => $alle_posts,
            'context' => 'blauw groot',
            'artikel_config' => [
                'context' => 'blauw groot',
                'stuk_klassen' => [
                    'col-12 col-lg-6',
                    'col-12 col-lg-3',
                    'col-12 col-lg-3',
                    'col-12 col-lg-4',
                    'col-12 col-lg-3',
                    'col-12 col-lg-5',
                    'col-12 col-lg-4',
                    'col-12 col-lg-4',
                    'col-12 col-lg-4',
                ]
            ]
            ]
        );

        $artikel_lijst_sectie->zetBroodHTML($artikel_lijst->maak());

        $artikel_lijst_sectie->print();

        ////////////////////////////////////////////
        ////////////////////////////////////////////

        $twee_posts = get_posts(
            [
            'posts_per_page' => 10,
            'post_type' => 'post'
            ]
        );

        $eerste_vd_2 = new Artikel(
            [
            'post' => $twee_posts[0],
            'context' => 'bier'
            ]
        );
        $tweede_vd_2 = new Artikel(
            [
            'post' => $twee_posts[1]
            ]
        );

        $derde_artikel = new Artikel(
            [
            'post'              => $twee_posts[2],
            'geen_afbeelding'   => true,
            ]
        );
        $derde_artikel->post->post_title = "Ik heb geen afbeelding";

        $vierde_artikel = new Artikel(
            [
            'post'              => $twee_posts[3],
            'geen_datum'   => true,
            ]
        );
        $vierde_artikel->post->post_title = "Ik heb geen datum";

        $vijfde_artikel = new Artikel(
            [
            'post'              => $twee_posts[4],
            'geen_datum'        => true,
            'geen_taxonomieen'  => true,
            'geen_tekst'        => true,
            ]
        );
        $vijfde_artikel->post->post_title = "Ik heb een plaatje en een titel";

        $artikel_sectie = new SectieSimpel(
            [
            'titel' => 'Artikel Class.',
            'broodHTML' => implode(
                '', [
                $eerste_vd_2->maak(),
                $tweede_vd_2->maak(),
                $derde_artikel->maak(),
                $vierde_artikel->maak(),
                $vijfde_artikel->maak()
                ]
            )
            ]
        );

        $artikel_sectie->print();
        ?>






    </div>

    <?php
}

add_action('admin_menu', 'IDW_cmp_admin_hook');
