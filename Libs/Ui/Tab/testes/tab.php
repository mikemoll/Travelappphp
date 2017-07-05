<?php
include '../Ui.php';
$tab = new Tabs_Ui('aba1teste');
$tab->addTab('controle','id');
$tab->addTab('controle1','id1');
$tab->addTab('controle2','id2');
$tab->addTab('controle3','id3');
$tab->addTab('controle4','id4');
$tab->addTab('controle5','id5');
$tab->addTab('controle6','id6');
$tab->addTab('controle7','id7');

echo($tab->render());