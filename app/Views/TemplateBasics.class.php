<?php

// trida vypisujici HTML hlavicku a paticku stranky.

class TemplateBasics
{

    /**
     *  Vrati vrsek stranky az po oblast, ve ktere se vypisuje obsah stranky.
     *  @param string $pageTitle    Nazev stranky.
     */
    public function getHTMLHeader($pravo)
    {
        ?>

        <!doctype html>
        <html>   
 
        <head>
            <!-- nastaveni viewportu, kvuli responzivnimu designu a Boostrapu -->
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <!-- pripojeni Bootstrapu -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="stylesheet" href="http://127.0.0.1:8080/app/WebStyle/Style.css">

            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <meta charset='utf-8'>
                
            </head>
            <body>
                




        <!-- vytvoreni menicka -->     
        <img class="wrapper" src="http://127.0.0.1:8080/Pictures/PozadiWeb2.png" alt="české lesy">
        <p class="mobil-text">Konference o životním prostředí</p>
        <?php

    echo "<nav class='navbar navbar-expand-sm bg-dark navbar-dark'>";

    

        if ($pravo == 1) {
            echo "<ul class='navbar-nav'>";

            foreach (WEB_PAGES as $key => $pInfo) {
                if ($pInfo['title'] == 'Konference o ochraně životního prostředí') {
                    echo "<li class='nav-item'><a class='nav-link' style='color:white' href='index.php?page=$key'> 
                 <img src=http://127.0.0.1:8080/Pictures/domecek.jpg width=30 height=30>
                    </a></li>";
                } elseif ($pInfo['title'] == 'Registrace') {
                    continue;
                } elseif ($pInfo['title'] == 'Přihlášení') {
                    echo "<li class='nav-item'><a class='nav-link' href='index.php?page=$key'>Odhlášení<i class='fas fa-sign-in-alt'></i></a></li>";
                } elseif ($pInfo['title'] == 'tvoreni') {
                    continue;
                } elseif ($pInfo['title'] == 'Schválení článků') {
                    continue;
                } elseif ($pInfo['title'] == 'Moje články') {
                    continue;
                } else {
                    echo "<li class='nav-item'><a class='nav-link' style=color:white href='index.php?page=$key'>$pInfo[title]</a></li>";
                }
            }

            echo "</ul></nav>";
        }

        if ($pravo == 2) {
            echo "<ul class='navbar-nav'>";

            foreach (WEB_PAGES as $key => $pInfo) {
                if ($pInfo['title'] == 'Konference o ochraně životního prostředí') {
                    echo "<li class='nav-item'><a class='nav-link' style='color:white' href='index.php?page=$key'> 
                 <img src=http://127.0.0.1:8080/Pictures/domecek.jpg width=30 height=30>
                    </a></li>";
                } elseif ($pInfo['title'] == 'Registrace') {
                    continue;
                } elseif ($pInfo['title'] == 'Přihlášení') {
                    echo "<li class='nav-item'><a class='nav-link' href='index.php?page=$key'>Odhlášení<i class='fas fa-sign-in-alt'></i></a></li>";
                } elseif ($pInfo['title'] == 'tvoreni') {
                    continue;
                } elseif ($pInfo['title'] == 'Správa uživatelů') {
                    continue;
                } elseif ($pInfo['title'] == 'Přidělení článků') {
                    continue;
                } elseif ($pInfo['title'] == 'Moje články') {
                    continue;
                } else {
                    echo "<li class='nav-item'><a class='nav-link' style=color:white href='index.php?page=$key'>$pInfo[title]</a></li>";
                }
            }

            echo "</ul></nav>";
        }

        if ($pravo == 3) {
            echo "<ul class='navbar-nav'>";

            foreach (WEB_PAGES as $key => $pInfo) {
                if ($pInfo['title'] == 'Konference o ochraně životního prostředí') {
                    echo "<li class='nav-item'><a class='nav-link' style='color:white' href='index.php?page=$key'> 
                 <img src=http://127.0.0.1:8080/Pictures/domecek.jpg width=30 height=30>
                    </a></li>";
                } elseif ($pInfo['title'] == 'Registrace') {
                    continue;
                } elseif ($pInfo['title'] == 'Přihlášení') {
                    echo "<li class='nav-item'><a class='nav-link' href='index.php?page=$key'>Odhlášení<i class='fas fa-sign-in-alt'></i></a></li>";
                } elseif ($pInfo['title'] == 'tvoreni') {
                    continue;
                } elseif ($pInfo['title'] == 'Správa uživatelů') {
                    continue;
                } elseif ($pInfo['title'] == 'Přidělení článků') {
                    continue;
                } elseif ($pInfo['title'] == 'Schválení článků') {
                    continue;
                } else {
                    echo "<li class='nav-item'><a class='nav-link' style=color:white href='index.php?page=$key'>$pInfo[title]</a></li>";
                }
            }

            echo "</ul></nav>";
        }

        if ($pravo == 0) {
            foreach (WEB_PAGES as $key => $pInfo) {
                echo "<ul class='navbar-nav'>";

                if ($pInfo['title'] == 'Konference o ochraně životního prostředí') {
                    echo "<li class='nav-item'><a class='nav-link' style='color:white' href='index.php?page=$key'> 
                 <img src=http://127.0.0.1:8080/Pictures/domecek.jpg width=30 height=30>
                    </a></li>";
                } elseif ($pInfo['title'] == 'Registrace') {
                    echo "<li class='nav-item'><a class='nav-link' href='index.php?page=$key'>$pInfo[title]</a></li>";
                } elseif ($pInfo['title'] == 'Přihlášení') {
                    echo "<li class='nav-item'><a class='nav-link' href='index.php?page=$key'>$pInfo[title]<i class='fas fa-sign-in-alt'></i></a></li>";
                } elseif ($pInfo['title'] == 'tvoreni') {
                    continue;
                } elseif ($pInfo['title'] == 'Správa uživatelů') {
                    continue;
                } elseif ($pInfo['title'] == 'Přidělení článků') {
                    continue;
                } elseif ($pInfo['title'] == 'Schválení článků') {
                    continue;
                } elseif ($pInfo['title'] == 'Moje články') {
                    continue;
                } else {
                    echo "<li class='nav-item'><a class='nav-link' style=color:white href='index.php?page=$key'>$pInfo[title]</a></li>";
                }
            }

            echo "</ul></nav>";
        } ?>
             
         
        
        <?php
    }


    
   
    
    /**
     *  Vrati paticku stranky.
     */
    public function getHTMLFooter()
    {
        ?>
       
        </br>
        </br>
        </br>
    
        
        <div class="footer bg-dark" >
            <p>Semestrální práce KIV/WEB, Michaela Benešová, 2020</p>
        </div>

        <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>

 
        </html>
        <?php
    }
}

?>

