<?php

namespace IDWNuts;

function maak_afbeelding($post, string $af = 'lijst', bool $is_categorie = false, string $class = '')
{

    if ($is_categorie) {
        $afb_verz = get_field('cat_afb', 'category_' . $post->term_id);

        $img = "<img
			 src='{$afb_verz['sizes'][$af]}'
			 alt='{$afb_verz['alt']}'
			 height='{$afb_verz['sizes'][$af . '-width']}'
             width='{$afb_verz['sizes'][$af . '-height']}'
             class='$class'
		 />";
    } else {
        if (has_post_thumbnail($post->ID)) {
            $img = get_the_post_thumbnail($post, $af, ['class' => $class]);
        } else {
            $img_f = get_field('terugval_afbeelding', 'option') || get_field('ta_afbeelding', 'option');
            $w = $af . '-width';
            $h = $af . '-height';
            $img = "
                 <img
                     class='$class'
					 src='{$img_f['sizes'][$af]}'
					 alt='{$img_f['alt']}'
					 width='{$img_f['sizes'][$w]}'
					 height='{$img_f['sizes'][$h]}'
				 />";
        }
    }

    return $img;
}

function maak_excerpt($post, $lim = 300)
{
    if (
        property_exists($post, 'post_excerpt') and
        $post->post_excerpt !== ""
    ) {
        return beperk_woordental($lim, $post->post_excerpt);
    } elseif (property_exists($post, 'post_content')) {
        return strip_tags(beperk_woordental($lim, $post->post_content));
    } elseif (property_exists($post, 'description')) {
        return strip_tags(beperk_woordental($lim, $post->description));
    } else {
        return '';
    }
}

function beperk_woordental($lim = 300, $tekst = '')
{
    $charlength = $lim;
    $r = "";

    if (mb_strlen($tekst) > $charlength) {
        $subex = mb_substr($tekst, 0, $charlength - 3);
        $exwords = explode(' ', $subex);
        $excut = -mb_strlen($exwords[count($exwords) - 1]);
        if ($excut < 0) {
            $r .= mb_substr($subex, 0, $excut);
        } else {
            $r .= $subex;
        }
        $r = rtrim($r);
        $r .= '...';

        return $r;
    } else {
        return $tekst;
    }
}

function appendChildBefore($orig, $child)
{
    //werk alleen bij HTML één niveau diep.
    $expl = explode('>', $orig);
    $tnaam = substr($expl[0], 1);
    return $expl[0] . ">$child</$tnaam>";
}

function voeg_attr_in($orig = '', $invoeging = '')
{
    $e = explode(' ', $orig);
    $e[0] = $e[0] . " " . $invoeging;
    return implode(' ', $e);
}
