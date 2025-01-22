<?php

include_once("lib.php");
$id = $_GET['category'];
$items = Item::GetItems($id);
foreach($items as $item)    
{
    $item->Draw();
}

?>