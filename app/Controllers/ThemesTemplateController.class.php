<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani stranky s tematy.
 */
class ThemesTemplateController implements IController {

    /**
     * Vrati obsah stranky s tematy.
     * @return string Vypis v sablone.
     */

    public function __construct() {
        // inicializace prace s DB
        require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    public function show():string {
       global $tplData;

        // kontroluji, zda je uzivatel prihlasen, zde proto abych vypsala pote spravnou hlavicku
        if($this->db->isUserLogged() == true){
            $tplData['uzivatel'] = $this->db->getLoggedUserData();
        } else {
            $tplData['uzivatel']['Pravo_ID'] = 0;
        }

         //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/ThemesTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
    
}

?>