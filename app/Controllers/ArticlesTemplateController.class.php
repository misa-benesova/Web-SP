<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani stranky s clanky.
 */
class ArticlesTemplateController implements IController {

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
     * Vrati obsah stranky s clanky.
     * @return string  Vypis v sablone.
     */
    public function show():string {
        global $tplData;


        // zjistim, zda je uzivatel prihlasen a zda je autor
        if($this->db->isUserLogged()){
            $tplData['uzivatel'] = $this->db->getLoggedUserData();

            if($tplData['uzivatel']['Pravo_ID'] == 3){
                $tplData['prihlaseni'] = true;
            }

        } else {
            $tplData['uzivatel']['Pravo_ID'] = 0;
        }
        

        // nactu clanky z databaze
        $tplData['clanky'] = $this->db->getAllArticles();

        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/ArticlesTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
    
}

?>