<?php

namespace IDW;

/**
 * Tekstblok
 * is een blok met een titel, tekst, mogelijk een knop en afbeeldingen.
 * 
 *
 * Params:
 * string titel; string htype; string tekst, array afbeeldingen, array maak_volgorde, string tekst_bs_class, string afbeeldingen_bs_class
 *
 * @category IDW_Componenten
 * @package  IDW_Componenten
 * @author   Indrukwekkend <info@indrukwekkend.nl>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version  Release: 0.1
 * @access   public
 * @link     https://indrukwekkend.nl
 */
class Tekstblok extends HTML implements HTMLInterface
{
    /**
     * String. Komt in de header.
     *
     * @var $titel
     */
    public $titel;

    /**
     * String. incl. <p>.
     *
     * @var $tekst
     */
    public $tekst;

    /**
     * String Knop. HTML. bedoelt als instance van knop-class->maak()
     *
     * @var $knop
     */
    public $knop;

    /**
     * Array. verzamenling <img>.
     *
     * @var $afbeeldingen
     */
    public $afbeeldingen;

    /**
     * String. bs-kolomclass tekst.
     *
     * @var $tekst_bs_class
     */
    public $tekst_bs_class = 'col-12 col-md-6';
    
    /**
     * String. bs-kolomclass afbeeldingen.
     *
     * @var $afbeeldingen_bs_class
     */
    public $afbeeldingen_bs_class = 'col-12 col-md-6';
    
    /**
     * Array. Volgorde waarop functies worden gedraaid.
     *
     * @var $maak_volgorde
     */
    public $maak_volgorde = ['pakHeader', 'pakTekst', 'pakAfbeeldingen'];


    /**
     * __construct
     *
     * @param array $a
     *
     * @return void
     */
    public function __construct(array $a = [])
    {
        $this->type = "tekstblok";
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
     * pakTekstBS
     * geeft Htype terug indien die bestaat.
     *
     * @return string
     */
    public function pakTekstBS(): string
    {
       return $this->pakBootstrap($this->tekst_bs_class);
    }


    /**
     * pakTekst
     * maakt tekst HTML icnl wrapper indien opgegeven. 
     *
     * @return string
     */
    public function pakTekst(): string
    {
        if ($this->eigenschapBestaat('tekst')) {
          return
          "<div class='
               {$this->pakElementClass('tekst')}
               {$this->pakTekstBS()}
          '>{$this->tekst}{$this->knop}</div>";
        } else {
            return '';
        }
    }

    /**
     * pakAfbeeldingenBS
     * geeft afbeelding bs class
     *
     * @return string
     */
    public function pakAfbeeldingenBS(): string
    {
       return $this->pakBootstrap($this->afbeeldingen_bs_class);
    }


    /**
     * pakAfbeeldingen
     * geeft afbeeldingen in wrapper indien opgegeven. 
     *
     * @return string
     */
    public function pakAfbeeldingen(): string
    {
        if ($this->eigenschapBestaat('afbeeldingen')) {
            $ahtml = implode('', $this->afbeeldingen);
          return
          "<div class='
               {$this->pakElementClass('afbeeldingen')}
               {$this->pakAfbeeldingenBS()}
          '>$ahtml</div>";
        } else {
            return '';
        }
    }


    /**
     * pakHeader print de header
     *
     * @return void
     */
    public function pakHeader() : string
    {
        
        $header_cnf = [
            'hx_binnen' => $this->titel,
            'context'  => 'tekstblok '.$this->context
        ];

        if ($this->heeftHtype()) {
            $header_cnf[] = $this->pakHtype();
        }

        $sectie_header = new Header($header_cnf);
        $sectie_header->maakClassVerz();
        $sectie_header->class_verz[] = $this->pakBootstrap('col-12');

        return $sectie_header->maak();

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



        $this->HTML = "

            <section class='
                {$this->pakClass($this->class)}
            '>
                <div class='{$this->pakElementClass('tuin')} {$this->pakBootstrap('row')}'>
                    {$this->maakVolgensOrde()}
                </div>

            </section>
		";

        return $this->HTML;
    }
}
