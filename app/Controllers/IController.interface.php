<?php

/**
 * Rozhrani pro vsechny ovladace (kontrolery).
 */
interface IController {

    /**
     * slouzi k vypsani sablony jednotlivych stranek
     *
     * @return string  HTML prislusne stranky.
     */
    public function show():string;

}

?>