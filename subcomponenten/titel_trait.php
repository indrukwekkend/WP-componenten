<?php

namespace IDW;

trait Titel
{

    /**
     * String. tekst in de titel.
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
}
