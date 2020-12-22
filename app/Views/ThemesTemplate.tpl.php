<?php

/////////// Sablona pro zobrazeni stranky s tematy konference.  ///////////


// pripojim objekt pro vypis hlavicky a paticky HTML
require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>
<!-- ------------------------------------------------------------------------------------------------------- -->


<!-- Vypis obsahu sablony -->
<?php


// hlavicka
$tplHeaders->getHTMLHeader(intval($tplData['uzivatel']['Pravo_ID']));

//vysani jednotlivych prednasek na konferenci
$res = "<p style=font-size:1.20em;padding-left:40px > Letošní ročník bude nabitý velmi zajímavými tématy a my Vám zde přinášíme soupis všeho co budete moci navštívit.</p> <p> 
<table class='table' style=padding-left:40px>
  <thead class='thead-dark'>
    <tr>
      <th scope='col'>Místnost</th>
      <th scope='col'>Téma</th>
      <th scope='col'>Čas</th>
      <th scope='col'>Přednášející</th>
    </tr>
  </thead>
  <tbody>
  <tr>
      <th scope='row'>410</th>
      <td>Zahájení konference.</td>
      <td>13:30-13:45</td>
      <td>všichni účinkující z celého dne</td>
    </tr>
    <tr>
      <th scope='row'>220</th>
      <td>Jak šetřit životní prostředí.</td>
      <td>14:00 - 15:00</td>
      <td>Bc. Tomáš Šťastný</td>
    </tr>
    <tr>
      <th scope='row'>220</th>
      <td>Co můžu udělat já?</td>
      <td> 15:15 - 16:00</td>
      <td>Bc. Josef Doležal</td>
    </tr>
    <tr>
      <th scope='row'>325</th>
      <td>Naučte se recyklovat.</td>
      <td>15:15 - 17:00</td>
      <td>Bc. Tomáš Šťastný</td>
    </tr>
    <tr>
      <th scope='row'>327</th>
      <td>Naše lesy, naše příroda.</td>
      <td>17:15-18:00</td>
      <td>Bc. Josef Doležal</td>
    </tr>
    <tr>
      <th scope='row'>405</th>
      <td>Než bude pozdě.</td>
      <td>18:00-19:00</td>
      <td>Jana Nováková</td>
    </tr>
    <tr>
      <th scope='row'>405</th>
      <td>Příroda naší Plzně aneb závěrečná řeč.</td>
      <td>19:15-19:30</td>
      <td>všichni účinkující z celého dne</td>
    </tr>
  </tbody>
</table>
</p> <p style=font-size:1.0em;padding-left:40px>Pořadatel si vyhrazuje nárok na případné změny v programu.</p>";
echo $res;



// paticka
$tplHeaders->getHTMLFooter()

?>
