<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani stranky na ktere se da vytvorit clanek.
 */
class MakeArticlesController implements IController
{

    /** @var DatabaseModel $db  Sprava databaze. */
    private $db;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct()
    {
        // inicializace prace s DB
        require_once(DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }
    
    /**
     * Vrati obsah stranky na ktere se da tvorit clanek.
     * @return string Vypis v sablone.
     */
    public function show():string
    {
        global $tplData;


        // kontroluji, zda byl odeslan clanek a zda ma potrebne nalezitosti a ukladam si o tom informace
 
            if (isset($_POST['novyclanek'])) {
            $target_dir = "FilesFromUsers/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $name = $_FILES['fileToUpload']['name'];
            $tplData['uploadOk'] = 1;        


            // presouva soubor do vytvorene slozky FileFromUsers
            if($tplData['uploadOk'] == 1){
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                   $tplData['prijetiSouboru'] = true;
                   $tplData['uploadOk'] = 1;
               } else {
                    $tplData['prijetiSouboru'] = false;
                    $tplData['uploadOk'] = 0;
               }
            }
            
            if (isset($_POST['nadpis']) && isset($_POST['clanek']) && strlen($_POST['clanek'])>0) {
                    // pokusim se prihlasit uzivatele
                    $tplData['uzivatel'] =$this->db->getLoggedUserData();
                    if (isset($tplData['uzivatel'])) {
                        $this->db->addNewArticle($_POST['clanek'], $tplData['uzivatel']['ID_UZIVATEL'], $_POST['nadpis'], $target_file);
                        $tplData['clanek'] = true;
                    }
                } else {
                    $tplData['clanek'] = false;
                }
            }
        
        

        // kontroluji, zda je uzivatel prihlasen, opet abych spravne vypsala hlavicku v template souboru a zaroven zda ma pravo na stranku pristoupit
        if ($this->db->isUserLogged() == true) {
            $tplData['uzivatel'] =$this->db->getLoggedUserData();
        } else {
            $tplData['uzivatel']['Pravo_ID']  = 0;
        }


        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/MakeArticlesTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
}
