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
    /**
     * String. Komt in de hero
     *
     * @var $titel
     */
    public $titel;

    /**
     * String. Bepaalt koptype.
     *
     * @var $htype
     */
    public $htype = '1';

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
     * heeftTitel
     * true indien titel bestaat.
     *
     * @return string
     */
    public function heeftTitel(): bool
    {
        return $this->eigenschapBestaat('titel');
    }

    /**
     * pakTitel
     * geeft titel terug indien die bestaat.
     *
     * @return string
     */
    public function pakTitel(): string
    {
        if ($this->heeftTitel()) {
            $h = $this->pakHtype();
            return "
                <h$h class='{$this->pakElementClass('titel')}' >{$this->titel}</h$h>
            ";
        } else {
            return '';
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

    public function heeftKnop(): bool
    {
        return $this->eigenschapBestaat('knop');
    }

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
