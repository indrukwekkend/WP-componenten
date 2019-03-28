<?php

namespace IDW;

/**
 * ArtikelLijst
 *
 * draait Artikel-instances in een lijst uit.
 * array_config geeft configuratie door aan de Artikel class
 * posts is een verzameling
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
     * @var $artikel_config
     */
    public $vereiste_eigenschappen = ['posts'];

    /**
     * String. Titel v/d lijst. Komt in header.
     * @var $artikel_config
     */
    public $lijst_titel;

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
        $this->type = "Artikel lijst";
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
        $postsHTML = array_map(function ($post) use ($ac) {
            $cnf = array_merge($ac, ['post' => $post]);
            return (new Artikel($cnf))->maak();
        }, $posts);

        return implode('', $postsHTML);
    }

    public function pakHeeftLijstTitel(): bool
    {
        if ($this->eigenschapBestaat('lijst_titel')) {
            return !!$this->lijst_titel;
        } else {
            return false;
        }
    }

    public function pakLijstTitel(): string
    {
        if ($this->eigenschapBestaat('lijst_titel')) {
            return $this->lijst_titel;
        } else {
            return '';
        }
    }

    public function pakHtype(): string
    {
        if ($this->eigenschapBestaat('htype')) {
            return $this->htype;
        } else {
            return '';
        }
    }

    public function pakHeaderHTML(): string
    {

        if (!$this->pakHeeftLijstTitel()) {
            return '';
        } else {
            return
            "<header>
                <h{$this->pakHtype()}>
                    {$this->pakLijstTitel()}
                </h{$this->pakHtype()}>
            </header>";
        }
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
            <section class='{$this->pakClass('art-lijst')}'>
                {$this->pakHeaderHTML()}
                {$this->pakPostsHTML($this->posts)}
            </section>
        ";
        return $this->HTML;
    }
}
