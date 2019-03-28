<?php

use IDW\Knop as Knop;
use IDW\Artikel as Artikel;

function IDW_cmp_admin_hook(){
    add_menu_page( 'idw-componenten', 'Indrukwekkend componenten', 'manage_options', 'idw-componenten', 'IDW_cmp_print_admin_pagina' );
}

function IDW_cmp_print_admin_pagina (){ ?>
    
    <div class='wrap'>
    
        <h1>Indrukwekkend Compontenten</h1>

        <?php 
        
        if (!get_field('terugval_afbeelding', 'option') && !get_field('ta_afbeelding', 'option')) {
            trigger_error('JOOO. Ik verwacht dat je een optie pagina hebt met daarin een ACF veld genaamd "terugval_afbeelding" of "ta_afbeelding"! Image veld, teruggeven als array.', E_USER_WARNING);
        }
                
        ?>

        <section class="idw-cmp-sectie">

            <header><h2>knop Class.</h2></header>

            <div class='idw-cmp-sectie__brood'>
            
                <p>Dit is de knop class - wat zal ik schrijven?.</p>

                <?php 

                    $knop_class = new Knop([
                        'link'          => site_url(),
                        'class'         => 'superknop',
                        'tekst'         => 'Dit is de knop Yo',
                        // 'extern'        => false, // facultatief
                    ]);

                    $knop_class->print();
                
                ?>
            </div>

        </section>


        <section class="idw-cmp-sectie">

            <header><h2>Artikel Class.</h2></header>

            <div class='idw-cmp-sectie__brood'>
            
                <p>Het geheim achter Agitatie.</p>

                <?php 

                    $alle_posts = get_posts([
                        'posts_per_page' => 10,
                        'post_type'     => 'post'
                    ]);

                    foreach ($alle_posts as $post) {
                        (new Artikel([
                            'post'      => $post,
                            'maak_volgorde' => ['pakArtAchter', 'pakArtVoor']
                        ]
                        ))->print();
                    }
                
                ?>
            </div>

        </section>


    </div>

<?php }

add_action('admin_menu', 'IDW_cmp_admin_hook');