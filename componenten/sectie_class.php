<?php

namespace IDW;

/**
 * SectieSimpel
 * print een simpele sectie.
 *
 * via zetBroodHTML('html') voeg je HTML toe aan de brood (deel onder kop, boven voet)
 *
 * Params:
 * string titel; string htype; string broodHTML
 *
 * @category IDW_Componenten
 * @package  IDW_Componenten
 * @author   Indrukwekkend <info@indrukwekkend.nl>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version  Release: 0.1
 * @access   public
 * @link     https://indrukwekkend.nl
 */
class SectieSimpel extends HTML implements HTMLInterface
{
    /**
     * String. Komt in de header.
     *
     * @var $titel
     */
    public $titel;

    /**
     * String. Inhoud HTML blob van sectie.
     *
     * @var $broodHTML
     */
    public $broodHTML;

    /**
     * __construct
     *
     * @param array $a
     *
     * @return void
     */
    public function __construct(array $a = [])
    {
        $this->type = "sectie-simpel";
        parent::__construct($a);
    }

    /**
     * heeftHtype
     * geeft true terug in htype bestaat.
     *
     * @return bool
     */
    public function heeftHtype(): bool
    {
        return $this->eigenschapBestaat('htype');
    }

    /**
     * pakHtype
     * geeft Htype terug indien die bestaat.
     *
     * @return string
     */
    public function pakHtype(): string
    {
        if ($this->eigenschapBestaat('htype')) {
            return $this->htype;
        }
    }

    /**
     * zetBroodHTML
     * is DE functie om html toe te voegen aan secties.
     * Wordt allemaal achter elkaar geplakt.
     * Geeft na executie broodHTML product terug.
     *
     * @param string $broodHTML
     *
     * @return string
     */
    public function zetBroodHTML(string $broodHTML): string
    {
        if (!$this->eigenschapBestaat('broodHTML')) {
            $this->broodHTML = $broodHTML;
        } else {
            $this->broodHTML .= $broodHTML;
        }
        return $this->broodHTML;

    }

    /**
     * pakBroodHTML
     * geeft broodHTML terug indien het bestaat.
     *
     * @return string
     */
    public function pakBroodHTML(): string
    {
        if ($this->eigenschapBestaat('broodHTML')) {
            return $this->broodHTML;
        } else {
            return '';
        }
    }

    /**
     * maak
     * bouwt de component
     * indien de controle succesvol was
     *
     * @return string
     */
    public function maak(): string
    {
        $this->controleer();

        if (!$this->controleSucces()) {
            return '';
        }

        $header_cnf = [
            'hx_binnen' => $this->titel
        ];

        if ($this->heeftHtype()) {
            $header_cnf[] = $this->pakHtype();
        }

        $sectie_header = new Header($header_cnf);
        $sectie_header->maakClassVerz();
        $sectie_header->class_verz[] = $this->pakBootstrap('col-12');

        $this->HTML = "

            <section class='
                {$this->pakBootstrap('row')}
                {$this->pakClass($this->class)}
            '>

                {$sectie_header->maak()}

                <div class='
                    {$this->pakElementClass('brood')}
                    {$this->pakBootstrap('col-12')}
                '>

                    {$this->pakBroodHTML()}

                </div>

            </section>
		";

        return $this->HTML;
    }
}
