<?php
function registreer_optie_pagina_en_velden(){

    if (function_exists('acf_add_options_page')) {
    
        acf_add_options_page(array(
            'page_title' => 'Opties',
            'menu_title' => 'Opties',
            'menu_slug' => 'opties',
            'capability' => 'edit_posts',
            'redirect' => false
        ));
    
        // acf_add_options_sub_page(array(
        // 	'page_title' 	=> 'Theme Header Settings',
        // 	'menu_title'	=> 'Header',
        // 	'parent_slug'	=> 'theme-general-settings',
        // ));
    }     

    acf_add_local_field_group(array(
        'key' => 'group_5c9ca77c4205f',
        'title' => 'categorie afbeelding',
        'fields' => array(
            array(
                'key' => 'field_5c9ca7b91417e',
                'label' => 'categorie afbeelding',
                'name' => 'cat_afb',
                'type' => 'image',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => ''
                ),
                'return_format' => 'array',
                'preview_size' => 'lijst',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => ''
            )
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'category'
                )
            ),
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'post_tag'
                )
            )
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => ''
    ));

    acf_add_local_field_group(array(
        'key' => 'group_5ca72cf07e127',
        'title' => 'terugval afbeelding',
        'fields' => array(
            array(
                'key' => 'field_5ca72d0077c81',
                'label' => 'terugval_afbeelding',
                'name' => 'terugval_afbeelding',
                'type' => 'image',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
                'library' => 'all',
                'min_width' => 0,
                'min_height' => 0,
                'min_size' => 0,
                'max_width' => 0,
                'max_height' => 0,
                'max_size' => 0,
                'mime_types' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'opties',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

}