<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");


/**
 * Ovladac zajistujici vypsani stranky s prihlasenim/odhlasenim.
 */
class LoginController implements IController {

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
     * Vrati obsah stranky s prihlasenim/odhlasenim.
     * @return string Vypis v sablone.
     */
    public function show():string {
        global $tplData;


        // kontroluji, zda se uzivatel prihlasil a ukladam si informaci o tom, zda to probehlo v poradku
        if(isset($_POST['action'])){
            // prihlaseni
            if($_POST['action'] == 'login' && isset($_POST['login']) && isset($_POST['heslo'])){
                // pokusim se prihlasit uzivatele
                $res =$this->db->userLogin($_POST['login'], $_POST['heslo']);
                if($res){
                    $tplData['prihlaseni'] = true;
                } else {
                    $tplData['prihlaseni'] = false;
                }
            }
            // odhlaseni
            else if($_POST['action'] == 'logout'){
                // odhlasim uzivatele
                $this->db->userLogout();
                $tplData['odhlaseni'] = true;
            }
            // neznama akce
            else {
                $tplData['odhlaseni'] = false;
            }
            
        }

        //kontroluji zda je uzivatel prihlasen, abych mohla pripadne zmenit hlavicku a tlacitko na odhlasit
        if($this->db->isUserLogged()){
            $tplData['jeprihlasen'] = true;
            $tplData['uzivatel'] = $this->db->getLoggedUserData();
        } else {
            $tplData['uzivatel']['Pravo_ID'] = 0;
        }
        
        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/LoginTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
    
}

?>