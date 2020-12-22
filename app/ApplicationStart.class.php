<?php

// vstupni bod webu

class ApplicationStart {

    // inicializace webu

    public function __construct()
    {
        // nactu rozhrani kontroleru
        require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");
    }

    //spusteni webu
    public function appStart(){

        // zde se testuje, zda je dostupna dana stranka, jinak se nastavi defaultni
        if(isset($_GET["page"]) && array_key_exists($_GET["page"], WEB_PAGES)){
            $pageKey = $_GET["page"]; // nastavim pozadovane
        } else {
            $pageKey = DEFAULT_WEB_PAGE_KEY; // defaulti klic
        }

        
        // pripravim si data ovladace
        $pageInfo = WEB_PAGES[$pageKey];


        // nacteni odpovidajiciho kontroleru, jeho zavolani a vypsani vysledku
        // pripojim souboru ovladace
        require_once(DIRECTORY_CONTROLLERS ."/". $pageInfo["file_name"]);


        // nactu ovladac a bez ohledu na prislusnou tridu ho typuju na dane rozhrani
        /** @var IController $controller  Ovladac prislusne stranky. */
        $controller = new $pageInfo["class_name"];
        
        // zavolam prislusny ovladac a vypisu jeho obsah
        echo $controller->show();

    }
}

?>

