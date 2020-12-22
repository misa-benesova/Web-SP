<?php
//////////////////////////////////////////////////////////////
////////////// Vlastni trida pro praci s databazi ////////////////
//////////////////////////////////////////////////////////////

/**
 * Vlastni trida spravujici databazi.
 */
class DatabaseModel
{

    /** @var PDO $pdo  PDO objekt pro praci s databazi. */
    private $pdo;

    /** @var MySession $mySession  Vlastni objekt pro spravu session. */
    private $mySession;
    /** @var string $userSessionKey  Klicem pro data uzivatele, ktera jsou ulozena v session. */
    private $userSessionKey = "current_user_id";


    /**
     * MyDatabase constructor.
     * Inicializace pripojeni k databazi a pokud ma byt spravovano prihlaseni uzivatele,
     * tak i vlastni objekt pro spravu session.
     */

    public function __construct()
    {
        // inicialilzuju pripojeni k databazi - informace beru ze settings
        $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->pdo->exec("set names utf8");
        // inicializuju objekt pro praci se session - pouzito pro spravu prihlaseni uzivatele

        require_once("SessionModel.class.php");
        $this->mySession = new SessionModel();
        // pozn.: v samostatne praci vytvorte pro spravu prihlaseni uzivatele samostatnou tridu.
    }


    ///////// Funkce, tykajici se uzivatelu /////////////


    /**
     * Ziskani vsech recenzentu.
     *
     * @return array  Pole s recenzenty.
     */
    public function getReviewers()
    {
        $prepstmt = $this->pdo->prepare("SELECT * FROM ".TABLE_UZIVATEL." WHERE Pravo_ID = :pravo");
        try {
            $prepstmt->bindValue(":pravo", '2');
            $prepstmt->execute();
            $vysledek = $prepstmt->fetchAll(PDO::FETCH_NAMED);
            return $vysledek;
        } catch (\Throwable $error) {
            return null;
        }
    }

    /**
        * Smazani uzivatele z db.
        *
        * @param int $id  ID uzivatele.
        * @return bool    Odstranen v poradku?
        */
    public function deleteUser($id)
    {
        $prepstmt = $this->pdo->prepare("DELETE FROM ".TABLE_UZIVATEL." WHERE ID_UZIVATEL = :id");
        try {
            $prepstmt->bindValue(":id", $id);
            $prepstmt->execute();
            return true;
        } catch (\Throwable $error) {
            return false;
        }
    }

    /**
     * Ziskani vsech clanku prihlaseneho autora.
     *
     * @param int $id  ID uzivatele
     * @return array   Pole s clanky autora.
     */
    public function getAuthorsArticles($id)
    {
        $prepstmt = $this->pdo->prepare("SELECT * FROM ".TABLE_PRISPEVEK." WHERE Uzivatel_ID = :id");
        try {
            $prepstmt->bindValue(":id", $id);
            $prepstmt->execute();
            $vysledek = $prepstmt->fetchAll(PDO::FETCH_NAMED);
            return $vysledek;
        } catch (\Throwable $error) {
            return null;
        }
    }

    /**
       * Ziskani vsech uzivatelu aplikace.
       *
       * @return array    Pole se vsemi uzivateli.
       */
    public function getAllUsers()
    {
        // ziskam vsechny uzivatele z DB razene dle ID a vratim je

        $prepstmt = $this->pdo->prepare("SELECT * FROM ".TABLE_UZIVATEL." ORDER BY id_uzivatel DESC");
        try {
            $prepstmt->execute();
            $vysledek = $prepstmt->fetchAll(PDO::FETCH_NAMED);
            return $vysledek;
        } catch (\Throwable $error) {
            return null;
        }
    }

    /**
         * Vytvoreni noveho uzivatele v databazi.
         *
         * @param string $login     Login.
         * @param string $jmeno     Jmeno.
         * @param string $email     E-mail.
         * @param int $idPravo      Je cizim klicem do tabulky s pravy.
         * @return bool             Vlozen v poradku?
         */
    public function addNewUser(string $login, string $heslo, string $jmeno, string $email, int $idPravo, string $prijmeni)
    {
        $prepstmt = $this->pdo->prepare("INSERT INTO ".TABLE_UZIVATEL." (login, heslo, jmeno, email, Pravo_ID, prijmeni) VALUES (:login, :heslo, :jmeno, :email, :idPravo, :prijmeni)");
        try {
            $prepstmt->bindValue(":login", $login);
            $prepstmt->bindValue(":heslo", $heslo);
            $prepstmt->bindValue(":jmeno", $jmeno);
            $prepstmt->bindValue(":email", $email);
            $prepstmt->bindValue(":idPravo", $idPravo);
            $prepstmt->bindValue(":prijmeni", $prijmeni);
            $prepstmt->execute();
            return true;
        } catch (\Throwable $error) {
            return false;
        }
    }

    /**
        * Updatuje uzivatelovo pravo.
        *
        * @param int $idUzivatel   Uzivatelovo id.
        * @param int $idPravo      Nove pravo, ktere je mu prideleno.
        * @return bool Je pravo v poradku upraveno?
        */
    public function updateUserRight(int $idUzivatel, int $idPravo)
    {
        $prepstmt = $this->pdo->prepare("UPDATE ".TABLE_UZIVATEL." SET PRAVO_ID = :idPravo WHERE ID_UZIVATEL = :idUzivatel");
        try {
            $prepstmt->bindValue(":idPravo", $idPravo);
            $prepstmt->bindValue(":idUzivatel", $idUzivatel);
            $prepstmt->execute();
            return true;
        } catch (\Throwable $error) {
            return false;
        }
    }

    /**
     * Updatuje recenzenta clanku.
     *
     * @param int $idUzivatel   Recenzentovo id.
     * @param int $idClanek     Id clanku, kteremu se prideluje recenzent.
     * @return bool Je clanek v poradku upraven?
     */
    public function updateArticleReviewer(int $idUzivatel, int $idClanek)
    {
        $prepstmt = $this->pdo->prepare("UPDATE ".TABLE_PRISPEVEK." SET prideleny_recenzent_ID = :idUzivatel WHERE ID_PRISPEVEK = :idClanek");
        try {
            $prepstmt->bindValue(":idUzivatel", $idUzivatel);
            $prepstmt->bindValue(":idClanek", $idClanek);
            $prepstmt->execute();
            return true;
        } catch (\Throwable $error) {
            return false;
        }
    }

    ////////////////////////////////////////////////////////////

    ///////////// Sprava prihlaseni uzivatele //////////////////

    /**
         * Overi, zda muse byt uzivatel prihlasen a pripadne ho prihlasi.
         *
         * @param string $login     Login uzivatele.
         * @param string $heslo     Heslo uzivatele.
         * @return bool             Byl prihlasen?
         */
    public function userLogin(string $login, string $heslo)
    {
        $prepstmt = $this->pdo->prepare("SELECT * FROM ".TABLE_UZIVATEL." WHERE login = :login AND heslo= :heslo");
        try {
            $prepstmt->bindValue(":login", $login);
            $prepstmt->bindValue(":heslo", $heslo);
            $prepstmt->execute();
            $vysledek = $prepstmt->fetchAll(PDO::FETCH_NAMED);
        } catch (\Throwable $error) {
            return null;
        }

        // ziskal jsem uzivatele
        if (count($vysledek)) {
            // ziskal - ulozim ho do session
            $_SESSION[$this->userSessionKey] = $vysledek[0]['ID_UZIVATEL']; // beru prvniho nalezeneho a ukladam jen jeho ID
            return true;
        } else {
            // neziskal jsem uzivatele
            return false;
        }
    }

    /**
     * Odhlasi soucasneho uzivatele.
     */
    public function userLogout()
    {
        unset($_SESSION[$this->userSessionKey]);
    }

    /**
     * Test, zda je nyni uzivatel prihlasen.
     *
     * @return bool     Je prihlasen?
     */
    public function isUserLogged()
    {
        return isset($_SESSION[$this->userSessionKey]);
    }

    /**
     * Pokud je uzivatel prihlasen, tak vrati jeho data,
     * ale pokud nebyla v session nalezena, tak vypisu chybu.
     *
     * @return mixed|null   Data uzivatele nebo null.
     */
    public function getLoggedUserData()
    {
        if ($this->isUserLogged()) {
            // ziskam data uzivatele ze session
            $userId = $_SESSION[$this->userSessionKey];
            // pokud nemam data uzivatele, tak vypisu chybu a vynutim odhlaseni uzivatele
            if ($userId == null) {
                // nemam data uzivatele ze session - vypisu jen chybu, uzivatele odhlasim a vratim null
                echo "SEVER ERROR: Data přihlášeného uživatele nebyla nalezena, a proto byl uživatel odhlášen.";
                $this->userLogout();
                // vracim null
                return null;
            } else {
                // nactu data uzivatele z databaze
                $prepstmt = $this->pdo->prepare("SELECT * FROM ".TABLE_UZIVATEL." WHERE id_uzivatel = :userId ");
                try {
                    $prepstmt->bindValue(":userId", $userId);
                    $prepstmt->execute();
                    $vysledek = $prepstmt->fetchAll(PDO::FETCH_NAMED);
                } catch (\Throwable $error) {
                    return null;
                }

                // mam data uzivatele?
                if (empty($vysledek)) {
                    // nemam - vypisu jen chybu, uzivatele odhlasim a vratim null
                    echo "ERROR: Data přihlášeného uživatele se nenachází v databázi (mohl být smazán), a proto byl uživatel odhlášen.";
                    $this->userLogout();
                    return null;
                } else {
                    // protoze DB vraci pole uzivatelu, tak vyjmu jeho prvni polozku a vratim ziskana data uzivatele
                    return $vysledek[0];
                }
            }
        } else {
            // uzivatel neni prihlasen - vracim null
            return null;
        }
    }


    ///////////////////////////////////////////////////////////////////////////////////

    /////////////// Ostatni funkce - spravujici clanky a jine funkcionality ///////////


    /**
        * Ziskani vsech clanku, ktere cekaji na schvaleni.
        *
        * @param int $id  ID uzivatele
        * @return array   Pole s clanky.
        */
    public function getArticlesToApproval($id)
    {
        $prepstmt = $this->pdo->prepare("SELECT * FROM ".TABLE_PRISPEVEK." WHERE prideleny_recenzent_ID = :id");
        try {
            $prepstmt->bindValue(":id", $id);
            $prepstmt->execute();
            $vysledek = $prepstmt->fetchAll(PDO::FETCH_NAMED);
            return $vysledek;
        } catch (\Throwable $error) {
            return null;
        }
    }


    /**
     * Ziskani vsech clanku, ktere jsou schvaleny a mohou se publikovat.
     *
     * @return array  Pole s clanky.
     */
    public function getAllArticles()
    {
        $prepstmt = $this->pdo->prepare("SELECT * FROM ".TABLE_PRISPEVEK." WHERE stav = :stav");
        try {
            $prepstmt->bindValue(":stav", 'schváleno');
            $prepstmt->execute();
            $vysledek = $prepstmt->fetchAll(PDO::FETCH_NAMED);
            return $vysledek;
        } catch (\Throwable $error) {
            return null;
        }
    }

    /**
     * Ziskani vsech novych clanku, ktere potrebuji pridelit recenzenta.
     *
     * @return array  Pole s clanky.
     */
    public function getNewArticles()
    {
        $prepstmt = $this->pdo->prepare("SELECT * FROM ".TABLE_PRISPEVEK." WHERE prideleny_recenzent_ID = :cislo OR prideleny_recenzent_ID= :text");
        try {
            $prepstmt->bindValue(":cislo", '0');
            $prepstmt->bindValue(":text", 'NULL');
            $prepstmt->execute();
            $vysledek = $prepstmt->fetchAll(PDO::FETCH_NAMED);
            return $vysledek;
        } catch (\Throwable $error) {
            return null;
        }
    }

    /**
     * Ziskani zaznamu vsech prav uzivatelu.
     *
     * @return array    Pole se vsemi pravy.
     */
    public function getAllRights()
    {
        $prepstmt = $this->pdo->prepare("SELECT * FROM ".TABLE_PRAVO." ");
        try {
            $prepstmt->execute();
            $vysledek = $prepstmt->fetchAll(PDO::FETCH_NAMED);
            return $vysledek;
        } catch (\Throwable $error) {
            return null;
        }
    }

    /**
         * Vytvoreni noveho clanku v databazi.
         *
         * @param string $text       Obsah clanku.
         * @param int $Uzivatel_ID   Autorovo ID.
         * @param string $nadpis     Nadpis clanku.
         * @param string $cesta      Cesta k prilozenemu souboru.
         * @return bool  Je clanek vlozen v poradku?
         */
    public function addNewArticle(string $text, int $Uzivatel_ID, string $nadpis, string $cesta)
    {
        $prepstmt = $this->pdo->prepare("INSERT INTO ".TABLE_PRISPEVEK." (text, prideleny_recenzent_ID, stav, Uzivatel_ID, nadpis, cestaSouboru) VALUES (:text, :prideleny_recenzent_ID, :stav, :Uzivatel_ID, :nadpis, :cesta)");
        try {
            $prepstmt->bindValue(":text", $text);
            $prepstmt->bindValue(":prideleny_recenzent_ID", 'NULL');
            $prepstmt->bindValue(":stav", 'NULL');
            $prepstmt->bindValue(":Uzivatel_ID", $Uzivatel_ID);
            $prepstmt->bindValue(":nadpis", $nadpis);
            $prepstmt->bindValue(":cesta", $cesta);
            $prepstmt->execute();
            return true;
        } catch (\Throwable $error) {
            return false;
        }
    }



    /**
     * Updatuje status clanku.
     *
     * @param int $idClanek     Id clanku, kteremu se prideluje recenzent.
     * @param string $stav      Na jaky stav se ma upravit clanek.
     * @return bool Je status v poradku upraven?
     */
    public function updateArticleStatus(int $idClanek, string $stav)
    {
        
        $prepstmt = $this->pdo->prepare("UPDATE ".TABLE_PRISPEVEK." SET stav = :stav, prideleny_recenzent_ID = :id WHERE ID_PRISPEVEK = :idClanek");
        try {
            $prepstmt->bindValue(":stav", $stav);
            $prepstmt->bindValue(":id", '-1');
            $prepstmt->bindValue(":idClanek", $idClanek);

            $prepstmt->execute();
            return true;
        } catch (\Throwable $error) {
            return false;
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////

}
