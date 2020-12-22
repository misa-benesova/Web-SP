<?php

///// globalni nastaveni /////


/// zde se pripojuji k databazi ///


define("DB_SERVER", "localhost"); // server
define("DB_NAME", "websp"); // nazev databaze
define("DB_USER","root"); // uzivatel databaze
define("DB_PASS",""); // heslo uzivatele



// nazvy tabulek v DB

//tabulka s uzivateli
define("TABLE_UZIVATEL", "uzivatel");
//tabulka s pravy
define("TABLE_PRAVO", "pravo");
//tabulka s prispevky
define("TABLE_PRISPEVEK", "prispevek");




/// dostupne stranky webu ///

// adresar kontroleru
const DIRECTORY_CONTROLLERS = "app/Controllers";

// adresar modelu
const DIRECTORY_MODELS = "app/Models";

// adresar sablon
const DIRECTORY_VIEWS = "app/Views";

// defaultni webova stranka
const DEFAULT_WEB_PAGE_KEY = "uvod";





// dostupne webove stranky
const WEB_PAGES = array(

    // uvodni stranka
    "uvod" => array(
        "title" => "Konference o ochraně životního prostředí",

        // kontroler
        "file_name" => "IntroductionController.class.php",
        "class_name" => "IntroductionController",
    ),

    // clanky/prispevky od autoru
    "prispevky" => array(
        "title" => "Články k tématům konference",

        // kontroler
        "file_name" => "ArticlesTemplateController.class.php",
        "class_name" => "ArticlesTemplateController",
    ),

     // témata konference
     "temata" => array(
        "title" => "Témata konference pro rok 2021",

        // kontroler
        "file_name" => "ThemesTemplateController.class.php",
        "class_name" => "ThemesTemplateController",
    ),
 
    //// sprava uzivatelu ////
    "sprava" => array(
        "title" => "Správa uživatelů",

        // kontroler
        "file_name" => "UserManagementController.class.php",
        "class_name" => "UserManagementController",
    ),

    // registrace
    "registrace" => array(
        "title" => "Registrace",

        // kontroler
        "file_name" => "RegistrationController.class.php",
        "class_name" => "RegistrationController",
    ),

    // prihlaseni
    "prihlaseni" => array(
        "title" => "Přihlášení",

        // kontroler
        "file_name" => "LoginController.class.php",
        "class_name" => "LoginController",
    ),

    // tvoreniclanku
    "tvoreni" => array(
        "title" => "tvoreni",

        // kontroler
        "file_name" => "MakeArticlesController.class.php",
        "class_name" => "MakeArticlesController",
    ),

    "prideleni" => array(
        "title" => "Přidělení článků",

        // kontroler
        "file_name" => "AssignmentOfReviewersController.class.php",
        "class_name" => "AssignmentOfReviewersController",
    ),

    "schvalovani" => array(
        "title" => "Schválení článků",

        // kontroler
        "file_name" => "ApprovalOfArticlesController.class.php",
        "class_name" => "ApprovalOfArticlesController",
    ),

    "mojeClanky" => array(
        "title" => "Moje články",

        // kontroler
        "file_name" => "MyArticlesController.class.php",
        "class_name" => "MyArticlesController",
    ),
   
);



?>