<?php

/////////// Sablona pro zobrazeni stranky s tvorenim clanku.  ///////////


// pripojim objekt pro vypis hlavicky a paticky HTML
require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>
<!-- ------------------------------------------------------------------------------------------------------- -->


<!-- Vypis obsahu sablony -->
<?php

// hlavicka
$tplHeaders->getHTMLHeader(intval($tplData['uzivatel']['Pravo_ID']));

$res = "";

//pokud napsal uzivatel clanek, vypise se informace zda bylo vyplneno vse a zda byl prijat ke zpracovani
if (isset($tplData['clanek'])) {
    if ($tplData['clanek'] == true) {
        $res .= "<p> Článek byl přijat ke zpracování. </p>";
    }

    else if(isset($tplData['prijetiSouboru'])){
        if ($tplData['clanek'] == false && $tplData['prijetiSouboru'] == false){
            $res .= "<p> Nastala chyba při nahrání souboru. </p>";
        }
        if ($tplData['clanek'] == true && $tplData['prijetiSouboru'] == true){
            $res .= "<p> Soubor a článek byli v pořádku přijati ke zpracovaní. </p>";
        }
        if ($tplData['clanek'] == true && $tplData['prijetiSouboru'] == false){
            $res .= "<p> Nastala chyba při nahrání souboru. </p>";
        }
        if ($tplData['clanek'] == false && $tplData['prijetiSouboru'] == true){
            $res .= "<p> Zapomněl/a jste na nadpis či článek. </p>";
        }
    }

    else if ($tplData['clanek'] == false) {
        $res .= "<p> Zapomněl/a jste na nadpis či článek. </p>";
    }
    
}


// zda je uzivatel autor objevi se editor na napsani clanku
if ($tplData['uzivatel']['Pravo_ID'] == 3) {
    $res .= "<form class=' md-textarea '  form action='' method='POST' id='clanekForm' enctype='multipart/form-data'>

<table>
    <tr><td><p class='registrace'> Nadpis článku <input type='text' size='80' name='nadpis' required></p></td></tr>
</table>

<textarea id='editor' name='clanek' form='clanekForm' rows='50' cols='120'>
  Prostor pro Váš článek. 
</textarea>

<input type='submit' name='novyclanek' value='Odeslat článek'>
<input form='clanekForm' type='file' name='fileToUpload'  id='fileToUpload'>
</form>";

} // zda se sem dostal nejaky uzivatel pres odkaz a nema pravo, vypise se nasledujici veta
else {
    $res .= "Nemáte přístup k těmto údajům.";
}

echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>

<script>
// editor pro psani clanku
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
</script>