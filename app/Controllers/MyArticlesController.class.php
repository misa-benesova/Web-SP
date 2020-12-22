<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani stranky s clanky autora.
 */
class MyArticlesController implements IController {

    /** @var DatabaseModel $db  Sprava databaze. */
    private $db;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        // inicializace prace s DB
        require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }
    
    /**
     * Vrati obsah stranky s clanky autora.
     * @return string  Vypis v sablone.
     */
    public function show():string {
        global $tplData;

        // kontroluji, zda je uzivatel prihlasen a zda je autor, pokud ano, nactu vsechny jeho clanky z db
        if($this->db->isUserLogged()){
            $tplData['uzivatel'] = $this->db->getLoggedUserData();
            if($tplData['uzivatel']['Pravo_ID'] == 3){
                $tplData['clanky'] = $this->db->getAuthorsArticles(intval($tplData['uzivatel']['ID_UZIVATEL']));
                $tplData['autor'] = true;
            }
        } else {
            $tplData['uzivatel']['Pravo_ID'] = 0;
        }

        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/MyArticlesTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
    
}

?>