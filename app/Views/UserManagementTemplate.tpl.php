<?php

/////////// Sablona pro zobrazeni stranky se spravou uzivatelu.  ///////////


// pripojim objekt pro vypis hlavicky a paticky HTML
require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>
<!-- ------------------------------------------------------------------------------------------------------- -->


<!-- Vypis obsahu sablony -->
<?php


// hlavicka
$tplHeaders->getHTMLHeader(intval($tplData['uzivatel']['Pravo_ID']));
$tplData;
$res = "";


// zda je uzivatel admin a provedl nejakou akci, napise se zda probehla v poradku, zaroven se vypisi vsichni prihlaseni uzivatele a jejich udaje - muze zmenit pravo
if(isset($tplData['jeadmin']) && $tplData['jeadmin'] == true){

    if (isset($tplData['vymazani'])){
        if ($tplData['vymazani'] == true){
            $res .= "<p class='alert alert-success' role='alert' >Uživatel smazán.</p>";
        } else if ($tplData['vymazani'] == false) {
            $res .= "<p class='alert alert-danger' role='alert'> Chyba. Zkuste to ještě jednou.</p>";
        }
    }
    
    if (isset($tplData['administrator'])){
        if ($tplData['administrator'] == true){
            $res .= "<p class='alert alert-success' role='alert' >Uživatel upraven na administratora.</p>";
        } else if ($tplData['administrator'] == false) {
            $res .= "<p class='alert alert-danger' role='alert> Chyba. Zkuste to ještě jednou.</p>";
        }
    }
    
    if (isset($tplData['autor'])){
        if ($tplData['autor'] == true){
            $res .= "<p class='alert alert-success' role='alert' >Uživatel upraven na autora.</p>";
        } else if ($tplData['autor'] == false) {
            $res .= "<p class='alert alert-danger' role='alert'> Chyba. Zkuste to ještě jednou.</p>";
        }
    }
    
    if (isset($tplData['recenzent'])){
        if ($tplData['recenzent'] == true){
            $res .= "<p class='alert alert-success' role='alert' >Uživatel upraven na recenzenta.</p>";
        } else if ($tplData['recenzent'] == false) {
            $res .= "<p class='alert alert-danger' role='alert'> Chyba. Zkuste to ještě jednou.</p>";
        }
    }
    
    
    $res .= "<table class='table' style='padding-left:40px; width: 60%'>
    <thead class='thead-dark' style='text-align:center'>
    </br>
    <tr>
      <th scope='col'>Login</th>
      <th scope='col'>Jméno</th>
      <th scope='col'>Příjmení</th>
      <th scope='col'>email</th>
      <th scope='col'>právo</th>
      <th scope='col'>správa</th>
    </tr>
    </thead>
    <tbody>";
    
    foreach ($tplData['uzivatele'] as $uzivatel) {
        $res .= "<tr>
        <th scope='row'>".htmlspecialchars($uzivatel['login'], ENT_QUOTES, 'UTF-8')."</th>
        <td>".htmlspecialchars($uzivatel['jmeno'], ENT_QUOTES, 'UTF-8')."</td>
        <td>".htmlspecialchars($uzivatel['prijmeni'], ENT_QUOTES, 'UTF-8')."</td>
        <td>".htmlspecialchars($uzivatel['email'], ENT_QUOTES, 'UTF-8')."</td>";
    
        foreach ($tplData['prava'] as $p) {
            if ($p['ID_PRAVO'] == $uzivatel['Pravo_ID']) {
                $res .= "<td>$p[nazev]</td>";
            }
        }
    
        $res .= "<td><form class='registrace' form action='' method='POST'>
        <input type='hidden' name='id' value = $uzivatel[ID_UZIVATEL]>
        <input type='submit' name='sprava' value='administrator'>
        <input type='submit' name='sprava' value='recenzent'>
        <input type='submit' name='sprava' value='autor'>
        <input type='submit' name='sprava' value='smazat'>
        </form></td>";
    
        $res .= "</tr>";
    }
    
    
    
    
    $res .= "</tbody> 
            </table>";
    
    

} // zda se na tuto stranku dostane kdokoliv jiny nez admin, vypise se nasledujici veta
else  {
    $res .= "Nemáte přístup k těmto údajům.";
}



echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>