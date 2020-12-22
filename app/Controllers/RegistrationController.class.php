<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani registracni stranky.
 */
class RegistrationController implements IController {

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
     * Vrati obsah registracni stranky.
     * @return string Vypis v sablone.
     */
    public function show():string {
        global $tplData;

        // zde kontroluji, zda je registracni formular vyplnen se vsemi nalezitostmi a ukladam si informaci,  zda je v poradku vyplnen ci ne
        if(isset($_POST['potvrzeni'])){
            if(isset($_POST['login']) && isset($_POST['heslo']) && isset($_POST['heslo2'])
            && isset($_POST['jmeno']) && isset($_POST['email']) && isset($_POST['prijmeni']) 
            && $_POST['heslo'] == $_POST['heslo2']
            && $_POST['login'] != "" && $_POST['heslo'] != "" && $_POST['jmeno'] != "" && $_POST['email'] != ""
            && $_POST['prijmeni'] != ""
            
        ){
                $res = $this->db->addNewUser($_POST['login'], $_POST['heslo'], $_POST['jmeno'], $_POST['email'], 3 ,$_POST['prijmeni']);
                if($res){
                    $tplData['ulozeni'] = true;
                } else {
                    $tplData['ulozeni'] = false;
                }
            } else {
                $tplData['atributy'] = false;
            }
            
        }

        // kontroluji, zda je uzivatel prihlasen, zde proto abych vypsala pote spravnou hlavicku a zaroven vedela, zda se ma pote vypsat registarcni formular
        if($this->db->isUserLogged() == true){
            $tplData['uzivatel'] = $this->db->getLoggedUserData();
            $tplData['jePrihlasen'] = true;

        } else {
            $tplData['uzivatel']['Pravo_ID'] = 0;
            $tplData['jePrihlasen'] = false;

        }

        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/RegistrationTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
    
}

?>