<?php

/////////// Sablona pro zobrazeni uvodni stranky  ///////////


// pripojim objekt pro vypis hlavicky a paticky HTML
require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>
<!-- ------------------------------------------------------------------------------------------------------- -->


<!-- Vypis obsahu sablony -->
<?php

// hlavicka
$tplHeaders->getHTMLHeader($tplData['uzivatel']['Pravo_ID']);


// paticka
$tplHeaders->getHTMLFooter()

?>
