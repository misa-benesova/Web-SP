<?php

/////////// Sablona pro zobrazeni stranky s clanky autora.  ///////////


// pripojim objekt pro vypis hlavicky a paticky HTML
require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>
<!-- ------------------------------------------------------------------------------------------------------- -->


<!-- Vypis obsahu sablony -->
<?php


// hlavicka
$tplHeaders->getHTMLHeader(intval($tplData['uzivatel']['Pravo_ID']));
global $tplData;

$res = "";

// zda je prihlaseny uzivatel autor, vypisi se jeho clanky a jejich stav
if(isset( $tplData['autor']) &&  $tplData['autor'] == true){


        foreach ($tplData['clanky'] as $clanek) {
            $res .= "</br></br>";
        
        
            $res .= "<div class='border rounded clanek' >";
        

            if ($clanek['stav'] !=  "schváleno" ){
                $res .= "Počkejte na vyjádření recenzenta.";
            } else {
                $res .= $clanek['stav'];
            }


        
            $res .= "<p style='
            font-size: 1.25em; background-color: white; color: green; text-align: center' class='font-weight-bold';><i class='fas fa-tree'></i>".htmlspecialchars($clanek['nadpis'], ENT_QUOTES, 'UTF-8')."</p>";
        
            $res .= "<div class='text-center'>";
            
            $res .= "<p id='button' onclick='otevritClanek($clanek[ID_PRISPEVEK])' class='btn btn-dark tlacitko-cist'  value='$clanek[ID_PRISPEVEK]' >číst článek</p>";
        
        
            
            $res .= "</div>";
            $res .= "</div>";
    
            $res .= "<div id='clanek$clanek[ID_PRISPEVEK]' class='modal'>
                    <div class='modal-content'>
                    <button onclick='zavritClanek($clanek[ID_PRISPEVEK])'>Zavřít</button>
                    <p>$clanek[text]</p>";
                        
                       

                        if($clanek['cestaSouboru'] != 'FilesFromUsers/'){
                            $res .= "<a href='$clanek[cestaSouboru]'> Přiložený soubor </a>";
                        }

                        

                    $res .= "</div> </div>";
        
            $res .= "</br>";       
        }
    
    

} // zda se na tuto stranku dostane neopravneny uzivatel, vypise se tato veta
else {
    $res .= "Nemáte přístup k těmto údajům.";
}


echo $res;


// paticka
$tplHeaders->getHTMLFooter()

?>

<script>
// funkce pro otevreni a zavreni clanku

function otevritClanek(id) {
    var clanek = document.getElementById("clanek" + id);
    clanek.style.display = "block";
}

function zavritClanek(id) {
    var clanek = document.getElementById("clanek" + id);
    clanek.style.display = "none";
}


</script>