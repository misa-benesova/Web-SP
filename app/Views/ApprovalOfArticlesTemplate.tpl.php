<?php

/////////// Sablona pro zobrazeni stranky, kde se budou schvalovat clanky.  ///////////

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

// vypsani clanku pro recenzenta vcetne moznosti hodnoceni po rozkliknuti clanku
if(isset($tplData['recenzent']) && $tplData['recenzent'] = true){

    if(isset($tplData['clanky']) && $tplData['clanky'] != null){
        foreach ($tplData['clanky'] as $clanek) {
            $res .= "</br></br>";
        
        
            $res .= "<div class='border rounded clanek'>";
        
            $res .= "<p style='font-size: 1.25em; background-color: white; color: green; text-align: center' class='font-weight-bold';><i class='fas fa-tree'></i>".htmlspecialchars($clanek['nadpis'], ENT_QUOTES, 'UTF-8')."</p>";
        
            $res .= "<div class='text-center'>";
            
            $res .= "<p id='button' onclick='otevritClanek($clanek[ID_PRISPEVEK])' class='btn btn-dark tlacitko-cist' value='$clanek[ID_PRISPEVEK]' >číst článek</p>";
        
            
            $res .= "</div>";
            $res .= "</div>";
        
        
            $res .= "<div id='clanek$clanek[ID_PRISPEVEK]' class='modal'>
                    <div class='modal-content'>
                    <button onclick='zavritClanek($clanek[ID_PRISPEVEK])'>Zavřít</button>
                    
                    <p>$clanek[text]</p>";


                    if($clanek['cestaSouboru'] != 'FilesFromUsers/'){
                        $res .= "<a href='$clanek[cestaSouboru]'> Přiložený soubor </a>";
                    }
                    
                   $res .= " <form form action='' method='POST' >
                    
                    <label for='pravopis'>Jazyková kvalita:</label>
                         <select id='pravopis' name='pravopis'>
                            <option value='10'>Velmi dobrá</option>
                            <option value='6'>Dobrá</option>
                            <option value='3'>Špatná</option>
                            <option value='0'>Velmi špatná</option>
                        </select>
                    
                    <label for='technika'>Technická kvalita:</label>
                        <select id='technika' name='technika'>
                           <option value='10'>Velmi dobrá</option>
                           <option value='6'>Dobrá</option>
                           <option value='3'>Špatná</option>
                           <option value='0'>Velmi špatná</option>
                       </select>
                       
                    <label for='doporuceni'>Doporučení:</label>
                         <select id='doporuceni' name='doporuceni'>
                            <option value='10'>Přijmout</option>
                            <option value='6'>Spíše přijmout</option>
                            <option value='3'>Spíše nepřijmout</option>
                            <option value='0'>Nepřijmout</option>
                        </select>
    
                    <input type='hidden' name='id_clanek' value='$clanek[ID_PRISPEVEK]'>
                    <input type='submit' name='hodnoceni' value = 'Odeslat'>
                    </form>
    
                    </div>
                </div>";
        
            $res .= "</br>";
        }
    } else {
        $res .= "Nejsou žádné články ke schválení.";
    }

} // pro pripad, ze dany clovek neni recenzent a dostal se odkazem na stranku se vypise nasledujici veta
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