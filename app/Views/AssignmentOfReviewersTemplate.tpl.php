<?php

/////////// Sablona pro zobrazeni uvodni stranky  ///////////


// pripojim objekt pro vypis hlavicky a paticky HTML
require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>
<!-- ------------------------------------------------------------------------------------------------------- -->


<!-- Vypis obsahu sablony -->
<?php

// muze se hodit: strtotime($d['date'])

// hlavicka
$tplHeaders->getHTMLHeader(intval($tplData['uzivatel']['Pravo_ID']));
$res = "";

// zda je prihlaseni admin, objevi se mu clanky, ktere nemaji prirazene recenzenty a muze jednotlivym clankum recenzenty priradit
if(isset($tplData['jeadmin']) && $tplData['jeadmin'] == true) {
    foreach ($tplData['clanky'] as $clanek) {
        $res .= "</br></br>";


        $res .= "<div class='border rounded clanek' >";

        $res .= "<p style='
    font-size: 1.25em; background-color: white; color: green; text-align: center' class='font-weight-bold';><i class='fas fa-tree'></i>".htmlspecialchars($clanek['nadpis'], ENT_QUOTES, 'UTF-8')."</p>";

        $res .= "<div class='text-center'>";
    
        $res .= "<p id='button' onclick='otevritClanek($clanek[ID_PRISPEVEK])' class='btn btn-dark tlacitko-cist'  value='$clanek[ID_PRISPEVEK]' >číst článek</p>";
        $res .= "<p id='button' onclick='otevritRecenzenty($clanek[ID_PRISPEVEK])' class='btn btn-info tlacitko-cist'> přidělit recenzenta </p>";


    
        $res .= "</div>";
        $res .= "</div>";


        $res .= "<div id='clanek$clanek[ID_PRISPEVEK]' class='modal'>
            <div class='modal-content'>
            <button onclick='zavritClanek($clanek[ID_PRISPEVEK])'>Zavřít</button>
            <p>$clanek[text]</p>";
            
                if($clanek['cestaSouboru'] != 'FilesFromUsers/'){
                    $res .= "<a href='$clanek[cestaSouboru]'> Přiložený soubor </a>";
                }

           $res .= "</div>
        </div>";

        $res .= "<div id='clanek_recenzenti$clanek[ID_PRISPEVEK]' class='modal'>
         <div class='modal-content'>
        <button onclick='zavritRecenzenty($clanek[ID_PRISPEVEK])'>Zavřít</button>";
        foreach ($tplData['recenzenti'] as $recenzent) {
            $res .= "<form form action='' method='POST'>";
            $res .= "<input type='hidden' name='id_uzivatel' value='$recenzent[ID_UZIVATEL]'>";
            $res .= "<input type='hidden' name='id_clanek' value='$clanek[ID_PRISPEVEK]'>";

            $res .= "<input type='submit' name='potvrzeni' value='".htmlspecialchars($recenzent['jmeno'], ENT_QUOTES, 'UTF-8')."\"".htmlspecialchars($recenzent['login'], ENT_QUOTES, 'UTF-8')."\"".htmlspecialchars($recenzent['prijmeni'], ENT_QUOTES, 'UTF-8')."'>";
            $res .= "</form>";
        }
        $res .= "</div></div>";



        $res .= "</br>";
    }
} // pokud by se sem dostal neprihlaseny uzivatel pres odkaz, vypise se nasledujici veta
else {
    $res .= "Nemáte přístup k těmto údajům.";
}


   


echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>

<script>
// funkce pro otevreni  a zavreni clanku
function otevritClanek(id) {
    var clanek = document.getElementById("clanek" + id);
    clanek.style.display = "block";
}

function zavritClanek(id) {
    var clanek = document.getElementById("clanek" + id);
    clanek.style.display = "none";
}

// funkce pro zobrazeni recenzentu
function otevritRecenzenty(id) {
    var clanek = document.getElementById("clanek_recenzenti" + id);
    clanek.style.display = "block";
}

function zavritRecenzenty(id) {
    var clanek = document.getElementById("clanek_recenzenti" + id);
    clanek.style.display = "none";
}
</script>