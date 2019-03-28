<?php

namespace IDW;

/**
 * HTML
 *
 * Basis voor alle HTML compontenten.
 * Abstract, dient alleen verlengt te worden.
 * Kan zetten & pakken of controle is uitgevoerd.
 * Kan zetten & pakken wat status is.
 * Vereist() controleert of vereiste properties bestaan.
 * Pak_class() geeft class property terug met evt. extra string.
 * maakVolgensVolgorde voert rendermethoden op volgorde uit
 * Print echoot de HTML.
 *
 * @category IDW_Componenten
 * @package  IDW_Componenten
 * @author   Indrukwekkend <info@indrukwekkend.nl>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version  Release: 0.1
 * @access   public
 * @link     https://indrukwekkend.nl
 */
abstract class HTML extends BasisClass
{

    /**
     * Bool. Controle functie gedraaid of niet.
     * @var $gecontroleerd
     */
    public $gecontroleerd = false;

    /**
     * Bool. Controle functie succesvol gepasseerd of niet.
     * @var $controle_status
     */
    public $controle_status;

    /**
     * String. 'Naam' van Class zoals Knop, Artikel.
     * @var $type
     */
    public $type = '';

    /**
     * String. Basis van class attribute van HTML component.
     * @var $class
     */
    public $class = '';

    /**
     * Bool. HTML property gemaakt of niet.
     * @var $gemaakt
     */
    public $gemaakt = false;

    /**
     * Array. Executievolgorde van (bepaalde) rendermethoden.
     * @var $maak_volgorde
     */
    public $maak_volgorde = [];

    /**
     * String. HTML string, de uiteindelijke component.
     * @var $HTML
     */
    public $HTML = '';

    public $vereiste_eigenschappen = [];

    /**
     * __construct
     *
     * @param  mixed $a
     *
     * @return void
     */
    public function __construct($a = [])
    {
        parent::__construct($a);
    }

    /**
     * controleSucces
     * geeft terug of compontent gecontroleerd is.
     *
     * @return bool
     */
    protected function controleSucces(): bool
    {
        return $this->controle_status;
    }

    /**
     * registreerControle
     * zet gecontroleerd eigenschap
     * zet controle_succes eigenschap
     *
     * @param  bool $status
     *
     * @return bool
     */
    protected function registreerControle(bool $status = true): bool
    {
        $this->gecontroleerd = true;
        $this->controle_status = $status;
        return $status;
    }

    /**
     * controleer
     * Nabewerking en/of nacontrole
     *
     * @return bool
     */
    public function controleer(): bool
    {
        $this->registreerControle();
        return true;
    }

    /**
     * vereist
     * controleert of vereiste properties bestaan,
     * triggert anders warning
     *
     * @param  array $vereisten_lijst
     *
     * @return bool
     */
    protected function vereist(array $vereisten_lijst = array()): bool
    {
        $error_verz = [];
        foreach ($vereisten_lijst as $vereist) {
            if (!$this->eigenschapBestaat($vereist)) {
                $error_verz[] = $this->naam . ' vereist eigenschap ' . $vereist;
            }
        }
        if (count($error_verz) > 0) {
            foreach ($error_verz as $et) {
                trigger_error($et, E_USER_WARNING);
            }
            return false;
        } else {
            return true;
        }
    }

    /**
     * pakClass
     * geeft class property terug evt. met extra string er aan.
     *
     * @param  mixed $extra_class_string
     *
     * @return string
     */
    protected function pakClass(string $extra_class_string = ''): string
    {
        if ($this->eigenschapBestaat('class')) {
            return (string) $this->class . ' ' . $extra_class_string;
        } else {
            return $extra_class_string;
        }
    }

    /**
     * zetGemaakt
     * zet de gemaakt status.
     *
     * @param  mixed $status
     *
     * @return bool
     */
    protected function zetGemaakt(bool $status = true): bool
    {
        $this->gemaakt = $status;
        return $status;
    }

    /**
     * isGemaakt
     * geeft gemaakt status.
     *
     * @return bool
     */
    protected function isGemaakt(): bool
    {
        return $this->gemaakt;
    }

    /**
     * maakVolgensOrde
     * voert rendermethoden uit volgens maak_volgorde property
     * en geeft HTML terug.
     *
     * @return string
     */
    protected function maakVolgensOrde(): string
    {
        // DIT ZOU EEN REDUCER MOETEN ZIJN
        // MAAR KAN NIET GOED GENOEG PHP :(

        $op_volgorde = [];
        foreach ($this->maak_volgorde as $methode) {
            $op_volgorde[] = call_user_func(array($this, $methode));
        }
        return implode('', $op_volgorde);
    }

    /**
     * print
     * de HTML.
     *
     * @return void
     */
    public function print()
    {
        if (!$this->isGemaakt()) {
            $this->maak();
        }
        echo $this->HTML;
    }
}
