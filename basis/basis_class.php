<?php

namespace IDW;

/**
 * BasisClass
 *
 * Basis voor nagenoeg alle andere classes.
 * Zet array om naar object properties.
 * Bevat debug methodes debug() en pakDebugConsole().
 * Bevat simpele checkmethode voor bestaan eigenschap.
 *
 * Een abstract class dien je niet direct te gebruiken maar te extenden.
 *
 * @category IDW_Componenten
 * @package  IDW_Componenten
 * @author   Indrukwekkend <info@indrukwekkend.nl>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version  Release: 0.1
 * @access   public
 * @link     https://indrukwekkend.nl
 */
abstract class BasisClass
{
    /**
     * __construct
     *
     * @param array $a Een array die als properties op het object komen.
     *
     * @return void
     */
    public function __construct(array $a = [])
    {
        foreach ($a as $k => $v) {
            $this->$k = $v;
        }
    }

    /**
     * EigenschapBestaat
     * controleert bestaan eigenschap op dit object.
     * True indien property exists and !is_null
     *
     * @param string $eigenschap_naam De naam van de eigenschap
     *
     * @return bool
     */
    protected function eigenschapBestaat(string $eigenschap_naam): bool
    {
        return property_exists($this, $eigenschap_naam) and !is_null($this->$eigenschap_naam);
    }

    /**
     * Debug
     * var dumpt het object binnen <pre> tags
     *
     * @param mixed $debug Hetgeen gevardumpt wordt
     *
     * @return string
     */
    public function pakDebug(): string
    {

        ob_start();
        echo "<pre>";
        var_dump($this);
        echo "</pre>";
        return ob_get_clean();

    }

    /**
     * pakDebugConsole
     * geeft string tbv console.log terug met het huidige object json encoded,
     * als geen parameter is meegegeven.
     *
     * @param mixed $debug Hetgeen gelogd wordt
     *
     * @return string
     */
    public function pakDebugConsole(): string
    {
        return "<script>console.log(" . json_encode($this) . ");</script>";
    }
}
