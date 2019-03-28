<?php

namespace IDW;

/**
 * Artikel
 *
 * draait posts en category-objecten uit, met name geschikt voor lijsten.
 * Vereist slechts een post of category object maar voor alles aan te passen.
 * Geen of wel taxonomieen; wel of geen datum, wel of geen afbeelding.
 *
 * Params:
 * object post; string afbeelding; bool geen_afbeelding; bool geen_tekst; bool geen_datum;
 * bool geen_taxonomieen; array uit_te_sluiten_taxonomieen; bool is_categorie; int exc_lim (excerpt limit);
 * string afb_formaat; string htype; array maak_volgorde;
 *
 * @category IDW_Componenten
 * @package  IDW_Componenten
 * @author   Indrukwekkend <info@indrukwekkend.nl>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version  Release: 0.1
 * @access   public
 * @link     https://indrukwekkend.nl
 */
class Artikel extends HTML implements HTMLInterface
{
    /**
     * Null of string. Als string: volledige <img> element.
     * @var $afbeelding
     */
    public $afbeelding;

    /**
     * Bool. Bepaalt printen afbeelding en lees meer na tekst..
     * @var $geen_tekst
     */
    public $geen_afbeelding = false;

    /**
     * Bool. Bepaalt printen samenvatting.
     * @var $geen_tekst
     */
    public $geen_tekst = false;

    /**
     * Bool. Bepaalt printen datum.
     * @var $geen_datum
     */
    public $geen_datum = false;

    /**
     * Bool. Bepaalt printen taxonomieen.
     * @var $geen_taxonomieen
     */
    public $geen_taxonomieen = false;

    /**
     * Array. In tax print functie worden deze standaard uitgesloten.
     * @var $geen_taxonomieen
     */
    public $uit_te_sluiten_taxonomieen = ['post_format', 'post_tag'];

    /**
     * String. Per taxonomie, de waarden.
     * @var $geen_taxonomieen
     */
    protected $taxonomie_waarden;

    /**
     * Bool. Of het een categorie
     * @var $is_categorie
     */
    public $is_categorie;

    /**
     * Integer. Bepaalt lengte samenvatting.
     * @var $exc_lim
     */
    public $exc_lim = 300;

    /**
     * String. Formaat van de afbeelding.
     * @var $afb_formaat
     */
    public $afb_formaat = 'lijst';

    /**
     * String. Koptype zoals h2, h3.
     * @var $exc_lim
     */
    public $htype = '3';

    /**
     * String. De samenvatting HTML + evt. lees meer.
     * @var $tekstHTML
     */
    protected $tekstHTML;

    /**
     * Array. Standaard volgorde van maakVolgensOrde methode.
     * @var $maak_volgorde
     */
    public $maak_volgorde = ['pakArtVoor', 'pakArtAchter'];

    /**
     * Array. Gebruikt tijdens controle voor minimum aantal argumenten.
     * @var $vereiste_eigenschappen
     */
    public $vereiste_eigenschappen = ['post'];

    /**
     * __construct
     *
     * @param  mixed $config
     *
     * @return void
     */
    public function __construct($config)
    {
        $this->type = "Artikel";
        parent::__construct($config);
    }

    /**
     * controleer
     * loopt na of post object is meegegeven,
     *
     * @return bool
     */
    public function controleer(): bool
    {
        if (!$this->vereist($this->vereiste_eigenschappen)) {
            $this->registreerControle(false);
            trigger_error(
                "controle {$this->type} mislukt. Zie console voor object eigenschappen",
                E_USER_NOTICE
            );
            echo $this->pakDebugConsole($this);
            return false;
        }

        $this->registreerControle(true);
        return true;
    }

    /**
     * pakOfMaakIsCategorie
     * geeft is_categorie terug als die bestaat
     * en maakt die aan als dat niet zo is.
     *
     * @return bool
     */
    protected function pakOfMaakIsCategorie(): bool
    {
        if (!$this->eigenschapBestaat('is_categorie')) {
            // normale post heeft deze eigenschap niet.
            $this->is_categorie = property_exists($this->post, 'name');
        }
        return $this->is_categorie;
    }

    /**
     * pakTitel
     * categorie en post hebben net een andere titel. Geeft de juiste terug.
     *
     * @return string
     */
    public function pakTitel(): string
    {
        if ($this->pakOfMaakIsCategorie()) {
            return $this->post->name;
        } else {
            return $this->post->post_title;
        }
    }

    /**
     * maakPermalink
     * bepaalt afhankelijk van of dit een categorie danwel een post is wat de permalink is.
     *
     * @return string
     */
    public function maakPermalink(): string
    {
        if ($this->pakOfMaakIsCategorie()) {
            $this->permalink = get_category_link($this->post->term_id);
        } else {
            $this->permalink = get_permalink($this->post->ID);
        }
        return $this->permalink;
    }

    /**
     * pakOfMaakPermalink
     * geeft de permalink, als die bestaat, anders roept het maakPermalink aan.
     *
     * @return string
     */
    protected function pakOfMaakPermalink(): string
    {
        if (!$this->eigenschapBestaat('permalink')) {
            $this->maakPermalink();
        }
        return $this->permalink;
    }

    /**
     * pakGeenAfbeelding
     * geeft eigenschap geen_afbeelding terug.
     *
     * @return bool
     */
    public function pakGeenAfbeelding(): bool
    {
        return $this->geen_afbeelding;
    }

    /**
     * pakOfMaakAfbeeldingFormaat
     * geeft de afbeeldingformaat terug.
     *
     * @return string
     */
    public function pakOfMaakAfbeeldingFormaat(): string
    {
        return $this->afb_formaat;
    }

    /**
     * pakOfMaakAfbeelding
     * geeft afbeelding indien gedefinieerd
     * anders wordt die gemaakt.
     *
     * @return string
     */
    public function pakOfMaakAfbeelding(): string
    {
        // als al uitgevoerd of extern gezet.
        if (!empty($this->afbeelding)) {
            return $this->afbeelding;
        } else {
            return $this->maakAfbeelding();
        }
    }

    /**
     * maakAfbeelding
     * gebruikt IDWNuts\maak_afbeelding en zet de afbeelding eigenschap.
     *
     * @return string
     */
    public function maakAfbeelding(): string
    {
        $this->afbeelding = \IDWNuts\maak_afbeelding(
            $this->post,
            $this->pakOfMaakAfbeeldingFormaat(),
            $this->pakOfMaakIsCategorie()
        );

        return $this->afbeelding;
    }

    /**
     * pakGeenTekst
     * geeft geen_tekst terug;
     *
     * @return bool
     */
    public function pakGeenTekst(): bool
    {
        if ($this->eigenschapBestaat("geen_tekst")) {
            return $this->geen_tekst;
        } else {
            return false;
        }
    }

    /**
     * pakTekstHTML
     * als Artikel heeft tekst, geeft de tekstHTML indien die bestaat, anders wordt het aangemaakt.
     *
     * @return string
     */
    public function pakOfMaakTekstHTML(): string
    {
        if ($this->pakGeenTekst()) {
            return '';
        }
        if (!$this->eigenschapBestaat('tekstHTML')) {
            return $this->maakTekstHTML();
        } else {
            return $this->tekstHTML;
        }
    }

    /**
     * maakTekstHTML
     * maak de tekstHTML eigenschap
     * indien geen afbeelding wordt gebruikt
     * wordt er een lees meer achter gezet.
     *
     * @return string
     */
    public function maakTekstHTML(): string
    {
        $exc = \IDWNuts\maak_excerpt($this->post, $this->exc_lim);

        // als geen afbeelding, dan lees-meer achter tekst zodat klikbaarheid duidelijker is.
        $this->tekstHTML =
            "<p>$exc" .
            ($this->pakGeenAfbeelding()
                ? "<span class='lees-meer'>Meer
                </span>"
                : '') .
            "</p>";
        return $this->tekstHTML;
    }

    /**
     * pakHeeftDatum
     * geeft false terug indien pakOfMaakIsCategorie;
     * geeft geen_datum terug indien die bestaat, zo niet, false.
     *
     * @return bool
     */
    public function pakHeeftDatum(): bool
    {
        if ($this->pakOfMaakIsCategorie()) {
            return false;
        }
        if ($this->eigenschapBestaat('geen_datum')) {
            return $this->geen_datum;
        } else {
            return false;
        }
    }

    /**
     * pakDatum
     * maakt HTML van post datum indien heeft datum.
     *
     * @return string
     */
    public function pakDatum(): string
    {
        if ($this->pakHeeftDatum()) {
            return '';
        }

        $tijd = get_the_date(get_option('date_format'), $this->post->ID);
        return "<time class='post-datum'>$tijd</time>";
    }

    /**
     * maakTaxlijst
     * maak de taxonomie lijst, met bepaalde taxen uitgesloten, van deze posttype.
     * Slaat dit op in een global zodat de volgende Artikel-instance met deze posttype
     * het van daar op kan halen.
     *
     * @return array
     */
    public function maakTaxlijst(): array
    {
        $lijst = get_object_taxonomies($this->post);
        $p_lijst = array();

        foreach ($lijst as $l) {
            if (!in_array($l, $this->uit_te_sluiten_taxonomieen)) {
                $p_lijst[] = $l;
            }
        }

        $GLOBALS[$this->post->post_type . '-taxlijst'] = $p_lijst;
        return $p_lijst;
    }

    /**
     * pakGeenTaxonomieen
     * geeft als is_categorie of als geen_taxonomieen terug: geen taxonomieen.
     *
     * @return bool
     */
    public function pakGeenTaxonomieen(): bool
    {
        if ($this->pakOfMaakIsCategorie()) {
            return false;
        }
        if ($this->eigenschapBestaat('geen_taxonomieen')) {
            return $this->geen_taxonomieen;
        } else {
            return false;
        }
    }

    /**
     * maakTaxonomieMetWaarden
     * creeert een string met per taxonomie alle waarden.
     * Welke taxonomieen de de post type heeft wordt opgezocht of aangemaakt.
     *
     * @return string
     */
    public function maakTaxonomieMetWaarden(): string
    {
        $tl_str = $this->post->post_type . '-taxlijst';
        // niet iedere keer opnieuw doen.
        if (!array_key_exists($tl_str, $GLOBALS)) {
            $this->maakTaxlijst();
        }

        $terms = wp_get_post_terms($this->post->ID, $GLOBALS[$tl_str]);

        $overslaan = array('Geen categorie', 'Uncategorized');

        $print_ar = array();

        $this->taxonomie_waarden = '';

        if (count($terms)):
            foreach ($terms as $term):
                if (in_array($term->name, $overslaan)) {
                    continue;
                }

                if (array_key_exists($term->taxonomy, $print_ar)) {
                    $print_ar[$term->taxonomy][] = $term->name;
                } else {
                    $print_ar[$term->taxonomy] = array($term->name);
                }
            endforeach;

            //

            if (count($print_ar)) {
                $teller = 0;

                foreach ($print_ar as $tax_naam => $tax_waarden):
                    if ($tax_naam === 'category') {
                        $tax_naam = 'categorie';
                    }

                    // als geen datum, dan eerste tax waarde geen streepje links.

                    $str = "- ";

                    if ($this->geen_datum && $teller < 1) {
                        $str = "";
                        $teller++;
                    }

                    $this->taxonomie_waarden .=
                        "<span class='tax tekst-zwart'> $str" .
                        strtolower(implode(', ', $tax_waarden)) .
                        "</span>";
                endforeach; // iedere print_ar
            }
        endif; // als count terms

        return $this->taxonomie_waarden;
    }

    /**
     * pakOfMaakTaxonomieMetWaarden
     * als taxonomieen geprint dienen te worden, pakt taxonomie_waarden
     * of maakt die aan.
     *
     * @return string
     */
    public function pakOfMaakTaxonomieMetWaarden(): string
    {
        if ($this->pakGeenTaxonomieen()) {
            return '';
        }

        if (!$this->eigenschapBestaat('taxonomie_waarden')) {
            return $this->maakTaxonomieMetWaarden();
        }

        return $this->taxonomie_waarden;
    }

    /**
     * pakExtraClass
     * geeft extra classes voor de component mee aan de hand van object eigenschappen
     *
     * @return string
     */
    public function pakExtraClass(): string
    {
        $r = 'art-c ';
        if ($this->geen_afb) {
            $r .= 'geen-afb ';
        }
        if ($this->geen_tekst) {
            $r .= 'geen-tekst ';
        }
        if ($this->geen_datum) {
            $r .= 'geen-datum ';
        }
        return trim($r);
    }

    /**
     * pakArtVoor
     * Indien afbeelding, print bovenkant artikel.
     *
     * @return string
     */
    public function pakArtVoor(): string
    {
        if ($this->pakGeenAfbeelding()):
            return '';
        else:
            return "<div class='art-voor'>
                <a href='{$this->pakOfMaakPermalink()}'>
                    {$this->pakOfMaakAfbeelding()}
                </a>
            </div>";
        endif;
    }

    /**
     * pakArtAchter
     * maakt header, datum, taxonomieen, tekst.
     *
     * @return void
     */
    public function pakArtAchter(): string
    {
        return "<div class='art-achter'>
            <a href='{$this->pakOfMaakPermalink()}'>
                <header>
                    <h{$this->htype}>{$this->pakTitel()}</h{$this->htype}>
                    {$this->pakDatum()}
                    {$this->pakOfMaakTaxonomieMetWaarden()}
                </header>
                {$this->pakOfMaakTekstHTML()}
            </a>
        </div>
        ";
    }

    /**
     * maak
     * controleert de component en maakt de HTML.
     * @return string
     */
    public function maak(): string
    {
        $this->controleer();

        if (!$this->controleSucces()) {
            return '';
        }

        $this->HTML = "
            <article class='{$this->pakClass($this->pakExtraClass())}'>
                {$this->maakVolgensOrde()}
            </article>
        ";
        return $this->HTML;
    }
}
