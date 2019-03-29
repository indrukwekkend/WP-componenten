<?php

namespace IDW;

use \IDW\Header as Header;

/**
 * ArtikelLijst
 *
 * draait Artikel-instances in een lijst uit.
 * array_config geeft configuratie door aan de Artikel class
 * posts is een verzameling.
 * 
 * De artikel_config eigenschap gaat naar de afzonderlijke artikelen.
 * Plaats in stuk_klassen een string of array met klassen voor de verschillende artikelen.
 *
 * Params:
 * array artikel_config; array posts; string lijst_titel; string htype; string class
 *
 * @category IDW_Componenten
 * @package  IDW_Componenten
 * @author   Indrukwekkend <info@indrukwekkend.nl>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version  Release: 0.1
 * @access   public
 * @link     https://indrukwekkend.nl
 */
class ArtikelLijst extends HTML implements HTMLInterface
{
    /**
     * Array. Configuratie die meegegeven wordt aan alle artikelen in deze lijst.
     * @var $artikel_config
     */
    public $artikel_config = [];

    /**
     * Array. Verzameling posts
     * @var $posts
     */
    public $posts = [];

    /**
     * Array. Verplichte eigenschappen in dit object.
     * @var $vereiste_eigenschappen
     */
    public $vereiste_eigenschappen = ['posts'];

    /**
     * String. Titel v/d lijst. Komt in header.
     * @var $titel
     */
    public $titel;

    /**
     * String. Bepaalt of 't h1, h2, h3 wordt. Standaard h2.
     * @var $artikel_config
     */
    public $htype = '2';

    /**
     * __construct
     *
     * @param  mixed $config
     *
     * @return void
     */
    public function __construct($config)
    {
        $this->type = "artikel-lijst";
        parent::__construct($config);
    }

    /**
     * pakPostsHTML
     * mapt de posts mbv de Artikel class en geeft de gezamenlijke HTML terug.
     *
     * @return string
     */
    public function pakPostsHTML(array $posts): string
    {

        $ac = $this->artikel_config;
        $postsHTMLverz = array_map(function ($post, $index) use ($ac) {
            $ecnf = ['post' => $post];
            $cnf = array_merge($ac, $ecnf);
            $dit_artikel = new Artikel($cnf);
            $dit_artikel->zetIndex($index);
            return $dit_artikel->maak();
        }, $posts, array_keys($posts));

        $postsHTML = implode('', $postsHTMLverz);

        return 
        "<div class='row {$this->pakElementClass('artikel-groep')}'>
            $postsHTML
        </div>";
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

        $sectie_header = new Header([
            'hx_binnen' => $this->titel,
            'htype'     => $this->htype,
            'context'   => $this->context
        ]);

        $this->HTML = "
            <section class='row {$this->pakClass()}'>
                <div class='col'>
                    {$sectie_header->maak()}
                </div>
                <div class='col'>
                    {$this->pakPostsHTML($this->posts)}
                </div>
            </section>
        ";
        return $this->HTML;
    }
}
