<?php

namespace IDW;

/**
 * Knop
 * rendert een anker met een tekst en evt een ikoon.
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
class Knop extends HTML implements HTMLInterface
{
    /**
     * String. Volledig <img> element.
     * @var $ikoon
     */
    public $ikoon = '';

    /**
     * String. Tekst van knop.
     * @var $ikoon
     */
    public $tekst = '';

    /**
     * String. Href attribute van anker.
     * @var $link
     */
    public $link = '#';

    /**
     * Bool. Bepaalt of target=_blank
     * @var $extern
     */
    public $extern = false;

    /**
     * Array. Standaard volgorde van maakVolgensOrde methode.
     * @var $maak_volgorde
     */
    public $maak_volgorde = ['pakIkoon', 'pakTekst'];

    /**
     * __construct
     *
     * @param  array $a
     *
     * @return void
     */
    public function __construct(array $a = [])
    {
        $this->type = "btn";
        parent::__construct($a);
    }

    /**
     * pakIkoon
     * geeft de ikoon property
     *
     * @return string
     */
    protected function pakIkoon(): string
    {
        return $this->ikoon;
    }

    /**
     * pakTargetAttr
     * als extern property true, geeft target=_blank
     *
     * @return string
     */
    protected function pakTargetAttr(): string
    {
        return $this->extern ? " target='_blank' " : "";
    }

    /**
     * pakHrefAttr
     * geeft de href attribute terug.
     *
     * @return string
     */
    protected function pakHrefAttr(): string
    {
        return "href='{$this->link}'";
    }

    /**
     * pakClassAttr
     * wrapt de pakClass functie
     * geeft de class attribute terug
     * met extra class 'knop'.
     *
     * @return string
     */
    protected function pakClassAttr(): string
    {
        return "class='{$this->pakClass($this->class)}'";
    }

    /**
     * pakTekst
     * geeft tekst property terug.
     *
     * @return string
     */
    protected function pakTekst(): string
    {
        return $this->tekst;
    }

    /**
     * controleer
     * of aan bepaalde voorwaarde zijn voldaan, in dit geval of er
     * of wel een tekst, of wel een ikoon zijn meegegeven.
     *
     * @return bool
     */
    public function controleer(): bool
    {
        if (empty($this->pakTekst()) && empty($this->pakIkoon())) {
            $this->registreerControle(false);
            echo $this->pakDebugConsole($this);
            trigger_error(
                "Knop class heeft ofwel een tekst of een ikoon nodig. 
            Zie de console voor de eigenschappen van de knop.",
                E_USER_WARNING
            );
        } else {
            $this->registreerControle(true);
        }
        return false;
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
			<a 

				{$this->pakTargetAttr()}
				{$this->pakHrefAttr()}
				{$this->pakClassAttr()}

			>
				<span>

				{$this->maakVolgensOrde()}
					
				</span>
			</a>
		";

        return $this->HTML;
    }
}
