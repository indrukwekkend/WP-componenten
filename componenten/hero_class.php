<?php

namespace IDW;

/**
 * Hero
 * print een hero.
 *
 * @category IDW_Componenten
 * @package  IDW_Componenten
 * @author   Indrukwekkend <info@indrukwekkend.nl>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version  Release: 0.1
 * @access   public
 * @link     https://indrukwekkend.nl
 */
class Hero extends HTML implements HTMLInterface
{
    
    // TRAIT
    use Titel;

    /**
     * String. Komt onder de titel.
     *
     * @var $slagzin
     */
    public $slagzin;

    /**
     * String. Volledig <img> element
     *
     * @var $achtergrond
     */
    public $achtergrond;

    /**
     * String. HTML van Knop class wordt aangeraden.
     *
     * @var $knop
     */
    public $knop;

    /**
     * Array. Lijst met verplichte
     *
     * @var $vereiste_eigenschappen
     */
    public $vereiste_eigenschappen = ['achtergrond'];

    /**
     * __construct
     *
     * @param array $a
     *
     * @return void
     */
    public function __construct(array $a = [])
    {
        $this->type = "hero";
        parent::__construct($a);
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
        } else {
            trigger_error('htype onbekend hero', E_USER_WARNING);
            return '1';
        }
    }

    /**
     * heeftSlagin
     * geeft true terug als slagzin bestaat.
     *
     * @return bool
     */
    public function heeftSlagzin(): bool
    {
        return $this->eigenschapBestaat('slagzin');
    }

    /**
     * pakSlagzin
     * geeft slagzin terug indien die bestaat.
     *
     * @return string
     */
    public function pakSlagzin(): string
    {
        if ($this->eigenschapBestaat('slagzin')) {
            return "
                <p class='{$this->pakElementClass('slagzin')}'>{$this->slagzin}</p>
            ";
        } else {
            return '';
        }
    }

    /**
     * pakTitelEnSlagzin
     * geeft een tuin terug met daarin de titel en slagzin
     * als één van de twee bestaan.
     *
     * @return string
     */
    public function pakTitelEnSlagzin(): string
    {
        if (!$this->heeftSlagzin() && !$this->heeftTitel()) {
            return '';
        } else {
            return "
                <div class='{$this->pakElementClass('tekstvlak')}'>
                    {$this->pakTitel()}
                    {$this->pakSlagzin()}
                </div>
            ";
        }

    }

    /**
     * pakAchtergrond
     * geeft de achtergrond terug in .__achtergrond
     *
     * @return string
     */
    public function pakAchtergrond(): string
    {
        return "
            <div class='
                {$this->pakElementClass('achtergrond')}
                {$this->pakBootstrap('col-12')}
            '>
                {$this->achtergrond}
            </div>
        ";
    }

    /**
     * heeftKnop
     * geeft true als knop eigenschap bestaat.
     *
     * @return bool
     */
    public function heeftKnop(): bool
    {
        return $this->eigenschapBestaat('knop');
    }

    /**
     * pakKnop
     * geeft knop in .__knop-tuin indien knop bestaat
     *
     * @return string
     */
    public function pakKnop(): string
    {
        if ($this->eigenschapBestaat('knop')) {
            return "
                <div class='{$this->pakElementClass('knop-tuin')}'>
                    {$this->knop}
                </div>
            ";
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

        $this->HTML = "

            <div class='
                {$this->pakBootstrap('row')}
                {$this->pakClass($this->class)}
            '>

                {$this->pakAchtergrond()}

                <div class='
                    {$this->pakElementClass('binnen')}
                    {$this->pakBootstrap('col-8 offset-2')}
                '>

                    {$this->pakTitelEnSlagzin()}
                    {$this->pakKnop()}

                </div>

            </div>
		";

        return $this->HTML;
    }
}
