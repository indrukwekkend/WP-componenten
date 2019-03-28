<?php

namespace IDW;

/**
 * ArtikelLijst
 *
 * draait Artikel-instances in een lijst uit.
 *
 * Params:
 * string afbeelding; bool geen_afbeelding; bool geen_tekst; bool geen_datum;
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
class ArtikelLijst extends HTML implements HTMLInterface
{

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
