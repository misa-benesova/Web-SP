<?php


/////////// Sablona pro zobrazeni stranky s prihlasenim/odhlasenim ///////////


// pripojim objekt pro vypis hlavicky a paticky HTML
require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();
global $tplData;

?>
<!-- ------------------------------------------------------------------------------------------------------- -->


<!-- Vypis obsahu sablony -->
<?php

// hlavicka
$tplHeaders->getHTMLHeader(intval($tplData['uzivatel']['Pravo_ID']));
$res = "";

// pokud se uzivatel prihlasoval, vypise se informace zda uspesne ci ne
if(isset($tplData['prihlaseni'])){

    if($tplData['prihlaseni'] == true ){
        $res .= "<p> Přihlášení se zdařilo. </p>";
    } 
    
    if($tplData['prihlaseni'] == false ){
        $res .= "<p> Přihlášení se nezdařilo. </p>";
    } 

}

// pokud se uzivatel odhlasoval, vypise se informace zda uspesne ci ne
if(isset($tplData['odhlaseni'])){

    if($tplData['odhlaseni'] == true ){
        $res .= "<p> Odhlášení se zdařilo. </p>";
    } 
    
    if($tplData['odhlaseni'] == false ){
        $res .= "<p> Odhlášení se nezdařilo. </p>";
    } 

}


// pokud je uzivatel prihlasen, vidi tlacitko na odhlaseni
if(isset($tplData['jeprihlasen'])){

    $res .= "<form class='registrace' form action='' method='POST'>
    <input type='hidden' name='action' value='logout'>
    <input type='submit' name='potvrzeni' value='Odhlásit'>
    </form>";

} // pokud uzivatel prihlasen neni, vidi tlacitko na to se prihlasit
else{
    $res .= "<form class='registrace' form action='' method='POST'>
    <table>
        <tr><td>Login:</td><td><input type='text' name='login'></td></tr>
        <tr><td>Heslo:</td><td><input type='password' name='heslo'></td></tr>
    </table>
    <input type='hidden' name='action' value='login'>
    <input type='submit' name='potvrzeni' value='Přihlásit'>
    </form>";
}
echo $res;


// paticka
$tplHeaders->getHTMLFooter()

?>
