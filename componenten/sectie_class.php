<?php

namespace IDW;

/**
 * SectieSimpel
 * print een simpele sectie
 *
 * Params:
 * string link, string class, string tekst, bool extern, string ikoon, array maak_volgorde
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
     * @var $titel
     */
    public $titel;

    /**
     * String. Inhoud HTML blob van sectie.
     * @var $broodHTML
     */
    public $broodHTML;

    /**
     * __construct
     *
     * @param  array $a
     *
     * @return void
     */
    public function __construct(array $a = [])
    {
        $this->type = "sectie-simpel";
        parent::__construct($a);
    }

    public function heeftHtype()
    {
        return $this->eigenschapBestaat('htype');
    }

    public function pakHtype()
    {
        if ($this->eigenschapBestaat('htype')) {
            return $this->htype;
        }
    }

    public function zetBroodHTML(string $broodHTML)
    {
        if (!$this->eigenschapBestaat('broodHTML')) {
            $this->broodHTML = $broodHTML;
        } else {
            $this->broodHTML .= $broodHTML;
        }
        
    }

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
                {$this->pakClass()}
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
