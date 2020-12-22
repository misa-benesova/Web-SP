<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani stranky, ktera umoznuje prirazeni recenzentu.
 */
class AssignmentOfReviewersController implements IController {

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
     * Vrati obsah stranky, ktera umoznuje prirazeni recenzentu.
     * @return string Vypis v sablone.
     */
    public function show():string {
        global $tplData;

        //pokud byl prirazen recenzent, volam prislusnou metodu, aby se zmena projevila
        if(isset($_POST['potvrzeni'])){
            $this->db->updateArticleReviewer(intval($_POST['id_uzivatel']), intval($_POST['id_clanek']));
        }

        //kontroluji zda je uzivatel prihlasen a zda je admin, pokud ano, ukladam si clanky a recenzenty
        if ($this->db->isUserLogged() == true){
            $tplData['uzivatel'] = $this->db->getLoggedUserData();
            if($tplData['uzivatel']['Pravo_ID'] == 1){
                $tplData['jeadmin'] = true;
                $tplData['clanky'] = $this->db->getNewArticles();
                $tplData['recenzenti'] = $this->db->getReviewers();
            }
            
        } else {
            $tplData['jeprihlasen'] = false;
            $tplData['uzivatel']['Pravo_ID'] = 0;
        }

        
        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/AssignmentOfReviewersTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
    
}

?>