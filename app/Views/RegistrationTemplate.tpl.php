<?php

/////////// Sablona pro zobrazeni registracni stranky. ///////////


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

// zda doslo k registraci uzivatele, tak se zde vypise informace o tom, jestli probehla v poradku
if(isset($tplData['ulozeni'])){

    if($tplData['ulozeni'] == true ){
        $res .= "<p> OK: Uživatel byl přidán do databáze </p>";
    } 
    
    if($tplData['ulozeni'] == false ){
        $res .= "<p> ERROR: Uložení uživatele se nezdařilo. </p>";
    } 

}

if(isset($tplData['atributy'])){
    $res .= "<p> Nebyly správně vpsány veškeré atributy. </p>"; 
}

// registracni formular pro neprihlasene uzivatele
if($tplData['jePrihlasen'] == false){
    $res .= "<p style=font-size:medium;> Máte nějaký zajímavý nápad na článek? Přidejte se k nám a přispějte ke znalostem ostatních. </p><form class='registrace' form action='' method='POST' oninput='x.value=(pas1.value==pas2.value)?'OK':'Nestejná hesla''>
<table>
    <tr><td>Login:</td><td><input type='text' name='login' required></td></tr>
    <tr><td>Heslo 1:</td><td><input type='password' name='heslo' id='pas1' required></td></tr>
    <tr><td>Heslo 2:</td><td><input type='password'name='heslo2' id='pas2' required></td></tr>
    <tr><td>Jméno:</td><td><input type='text' name='jmeno' required></td></tr>
    <tr><td>Příjmení:</td><td><input type='text' name='prijmeni' required></td></tr>
    <tr><td>E-mail:</td><td><input type='email' name='email' required></td></tr>

</table>

<input type='submit' name='potvrzeni' value='Registrovat'>
</form>";
} else {
    $res .= "Jste již registrován.";
}
echo $res;





// paticka
$tplHeaders->getHTMLFooter()

?>
