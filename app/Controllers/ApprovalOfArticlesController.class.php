<?php
// zde nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajisti vypsani stranky pro schvaleni clanku.
 */
class ApprovalOfArticlesController implements IController
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
     * Vrati obsah stranky pro schvaleni clanku.
     * @return string  Vypis v sablone.
     */
    public function show():string
    {
        global $tplData;

       
        // zde se overi, zda bude clanek schvalen nebo ne, podle vstupu od recenzenta
        if (isset($_POST['hodnoceni'])) {
            $soucet = 0;
            $soucet += intval($_POST['pravopis']) + intval($_POST['technika']) + intval($_POST['doporuceni']);
            if ($soucet > 16) {
                $this->db->updateArticleStatus(intval($_POST['id_clanek']), "schváleno");
            } else {
                $this->db->updateArticleStatus(intval($_POST['id_clanek']), "zamítnuto");
            }
        }


        // kontroluji zda je uzivatel prihlasen a zda je recenzent, pokud ano, ulozim si clanky z databaze, ktere ma zrecenzovat
        if ($this->db->isUserLogged()) {
            $tplData['uzivatel'] = $this->db->getLoggedUserData();
            if ($tplData['uzivatel']['Pravo_ID'] == 2) {
                $tplData['clanky'] = $this->db->getArticlesToApproval(intval($tplData['uzivatel']['ID_UZIVATEL']));
                $tplData['recenzent'] = true;
            }
        } else {
            $tplData['uzivatel']['Pravo_ID'] = 0;
        }

        
        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/ApprovalOfArticlesTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
}
