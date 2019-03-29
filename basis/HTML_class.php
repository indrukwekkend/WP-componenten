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
     * String. Gebruikt in BEM-variant class.
     * @var $context
     */
    public $context;

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

    /**
     * Array. Lijst met verplichte
     * @var $vereiste_eigenschappen
     */
    public $vereiste_eigenschappen = [];

    /**
     * Integer. In lijst context gebruikt voor stuk_klasse opzoeken.
     * @var $index
     */
    public $index = 0;

    /**
     * Array. Class verzameling
     * @var $class_verz
     */
    public $class_verz;

    /**
     * Bool. Bepaalt al dan niet gebruiken van Bootstrap classes.
     * @var $bootstrap
     */
    public $bootstrap = true;

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
                $error_verz[] = $this->type . ' vereist eigenschap ' . $vereist;
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
     * maakClassVerz
     * is een BEM machine! Aan de hand van type & evt. context string & evt. extra_class_string arg.
     * wordt een verzameling CSS classes gemaakt tbv. hoofdelement component
     * die ook gebruikt worden voor de elementklassen, na bewerking.
     *
     * @param  string $extra_class_string
     *
     * @return array
     */
    protected function maakClassVerz(string $extra_class_string = ''): array
    {
        if ($this->eigenschapBestaat('context')) {
            $t = $this->type;
            $this->class_verz = array_map(function ($context) use ($t) {
                return $t . '--' . $context;
            }, explode(' ', $this->context));
        } else {
            $this->class_verz = [];
        }

        $this->class_verz[] = $this->type;

        if (!empty($extra_class_string)) {
            $this->class_verz[] = $extra_class_string;
        }

        return $this->class_verz;
    }

    /**
     * pakClassVerz
     * haalt de class_verz op indien die bestaat
     *
     * @return array
     */
    protected function pakClassVerz(): array
    {
        if (!$this->eigenschapBestaat('class_verz')) {
            $this->maakClassVerz();
        }
        return $this->class_verz;
    }

    /**
     * pakElementClassVerz
     * maakt recursief voor iedere context een element BEM class aan
     * adhv de class_verz
     *
     * @param  string $element_naam
     *
     * @return array
     */
    protected function pakElementClassVerz(string $element_naam = ''): array
    {
        return array_map(function ($class) use ($element_naam) {
            $expl = explode('--', $class);
            if (count($expl) > 1) {
                return "{$expl[0]}__$element_naam--{$expl[1]}";
            } else {
                return "{$expl[0]}__$element_naam";
            }
        }, $this->pakClassVerz());
    }

    /**
     * pakElementClass
     * return als string de elementClassVerz
     *
     * @param  string $element_naam
     *
     * @return string
     */
    protected function pakElementClass(string $element_naam = ''): string
    {
        return trim(implode(' ', $this->pakElementClassVerz($element_naam)));
    }

    /**
     * pakStukKlasse
     * is relevant in lijst context. Dan zijn stuk_klassen en index gegeven.
     * stuk klassen kan een string of array zijn. Afhankelijk van de index
     * van dit object in de lijst wordt stuk klasse teruggegeven. Indien de lijst
     * langer is dan de stuk klassen verzameling wordt per modules terug gegeven.
     *
     * @return string
     */
    protected function pakStukKlasse(): string
    {
        if (
            $this->eigenschapBestaat('stuk_klassen') &&
            $this->eigenschapBestaat('index')
        ) {
            $st = [];
            if (!is_array($this->stuk_klassen)) {
                $st = [$this->stuk_klassen];
            } else {
                $st = $this->stuk_klassen;
            }

            $index = $this->pakIndex();
            $cst = count($st);

            if ($index + 1 <= $cst) {
                return $st[$index];
            } else {
                $mod = $index % $cst;
                return $st[$mod];
            }
        } else {
            return "";
        }
    }

    /**
     * zetIndex
     * zet de index.
     *
     * @param  int $index
     *
     * @return void
     */
    protected function zetIndex(int $index): int
    {
        $this->index = $index;
        return $index;
    }

    /**
     * pakIndex
     * pakt de index.
     *
     * @return int
     */
    protected function pakIndex(): int
    {
        return $this->index;
    }

    /**
     * heeftBootstrap
     * geeft true als bootstrap is true
     *
     * @return bool
     */
    protected function heeftBootstrap(): bool
    {
        return $this->bootstrap;
    }

    /**
     * pakBootstrap
     * geeft de ingegeven string terug indien heeftBootstrap
     *
     * @param  string $bootstrap_class
     *
     * @return string
     */
    protected function pakBootstrap(string $bootstrap_class = ''): string
    {
        if ($this->heeftBootstrap()) {
            return $bootstrap_class;
        } else {
            return '';
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
        if (!$this->eigenschapBestaat('class_verz')) {
            $this->maakClassVerz($extra_class_string);
        }

        return trim(implode(' ', $this->pakClassVerz())) .
            ' ' .
            $this->pakStukKlasse();
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
