<?

include_once 'Flexigrid.php';
include_once 'Button.php';
include_once 'Column/Image.php';

$grid = new Grid_Flexigrid('id','teste.php');

$button = new Grid_Button;
$button->setDisplay('Salvar','aaaaaaa','');

$grid->addButton($button);

$column = new Grid_Column_Image;
$column->setDisplay('aaaaaa', 'aaaa', 'aaaaaa.jpg');


$grid->addColumn($column);

die($grid->render());





?>