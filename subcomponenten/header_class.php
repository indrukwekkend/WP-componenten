<?php

namespace IDW;

/**
 * HeaderClass
 *
 * print een header met een <hx> uit.
 * 
 * Params:
 * string hx_binnen; string htype
 *
 * @category IDW_Componenten
 * @package  IDW_Componenten
 * @author   Indrukwekkend <info@indrukwekkend.nl>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version  Release: 0.1
 * @access   public
 * @link     https://indrukwekkend.nl
 */
class Header extends HTML implements HTMLInterface
{

    /**
     * String. Komt in <hx>.
     * @var $hx_binnen
     */
    public $hx_binnen;

    /**
     * String. Bepaalt of 't h1, h2, h3 wordt. Standaard h2.
     * @var $artikel_config
     */
    public $htype = '2';

    /**
     * __construct
     *
     * @param  mixed $config
     *
     * @return void
     */
    public function __construct($config)
    {
        parent::__construct($config);
        $this->type = "header";
    }

    /**
     * pakHeeftHxBinnen
     * geeft true indien hx_binnen bestaat en niet leeg is.
     *
     * @return bool
     */
    public function pakHeeftHxBinnen(): bool
    {
        if ($this->eigenschapBestaat('hx_binnen')) {
            return !empty($this->hx_binnen);
        } else {
            return false;
        }
    }

    /**
     * pakHxBinnen
     * geeft hx_binnen indien die bestaat
     *
     * @return string
     */
    public function pakHxBinnen(): string
    {
        if ($this->eigenschapBestaat('hx_binnen')) {
            return $this->hx_binnen;
        } else {
            return '';
        }
    }

    /**
     * pakHtype
     * geeft htype indien die bestaat.
     *
     * @return string
     */
    public function pakHtype(): string
    {
        if ($this->eigenschapBestaat('htype')) {
            return $this->htype;
        } else {
            return '';
        }
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
            return 'geen controle';
        }

        if (!$this->pakHeeftHxBinnen()) {
            $this->HTML = '';
        } else {
            $this->HTML =
            "<header class='{$this->pakClass()}'>
                <h{$this->pakHtype()} class='{$this->pakElementClass('header-kop')}'>
                    {$this->pakHxBinnen()}
                </h{$this->pakHtype()}>
            </header>";
        }
        return $this->HTML;
    }
}
