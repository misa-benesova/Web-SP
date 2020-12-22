<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani stranky se spravou uzivatelu.
 */
class UserManagementController implements IController {

    // pripojeni k db
    public function __construct() {
        // inicializace prace s DB
        require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }

    /**
     * Vrati obsah stranky se spravou uzivatelu.
     * @return string  Vypis v sablone.
     * 
     * 
     */
    public function show():string {
        global $tplData;

        // kontroluji zda je uzivatel prihlasen a zda je admin, pokud ano, ukladam si veskera prava a uzivatele
        if ($this->db->isUserLogged() == true){
            $tplData['uzivatel'] = $this->db->getLoggedUserData();
            if($tplData['uzivatel']['Pravo_ID'] == 1){
                $tplData['jeadmin'] = true;
                $tplData['prava'] =  $this->db->getAllRights();
                $tplData['uzivatel']=  $this->db->getLoggedUserData();
            }
        } else {
            $tplData['jeprihlasen'] = false;
            $tplData['uzivatel']['Pravo_ID'] = 0;
        }

        // zde zjistuji, zda doslo k uprave nektereho uzivatele (presneji jeho prava) a zde tu zmenu promitnu do databaze
        if(isset($_POST['sprava'])){
            if($_POST['sprava'] == 'administrator'){
                if($this->db->updateUserRight(intval($_POST['id']), 1) == true){
                    $tplData['administrator'] = true;
                } else {
                    $tplData['administrator'] = false;
                }
            }

            if($_POST['sprava'] == 'recenzent'){
                if($this->db->updateUserRight(intval($_POST['id']), 2) == true){
                    $tplData['recenzent'] = true;
                } else {
                    $tplData['recenzent'] = false;
                }
            }

            if($_POST['sprava'] == 'autor'){
                if($this->db->updateUserRight(intval($_POST['id']), 3) == true){
                    $tplData['autor'] = true;
                } else {
                    $tplData['autor'] = false;
                }
            }

            if($_POST['sprava'] == 'smazat'){
                if($this->db->deleteUser(intval($_POST['id'])) == true){
                    $tplData['vymazani'] = true;
                } else {
                    $tplData['vymazani'] = false;
                }
            }
        }

        // nactu si prava vsech uzivatelu
        $tplData['uzivatele'] = $this->db->getAllUsers();
        
        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/UserManagementTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
    
}

?>