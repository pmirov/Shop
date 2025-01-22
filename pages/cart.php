
<form method="post" action="index.php?page=cart">

<?php

    $name = "cart";
    if(isset($_SESSION['name']) && $_SESSION['name'] != "")
    {
        $name = $_SESSION['name'];
    }

    $lenght = strlen($name);
    $total = 0;
    foreach($_COOKIE as $key => $value)
    {
        if(substr($key,0,$lenght) == $name)
        {
            $item = Item::Show($value);
            $total += $item->price;
            $item->DrawCart();
        }
    }
    echo "<div>Total: $total руб.</div>";

?>
<input type="submit" name="pay" value="Купить">

</form>


<script src="./wwwroot/js/main.js"></script>

<?php

if(isset($_POST['pay']))

{
    foreach($_POST AS $key=>$value)
    {
        if(substr($key,0,5) == "item_")
        {
           
        }
    }

    $name = "cart";
    if(isset($_SESSION['name']) && $_SESSION['name'] != "")
    {
        $name = $_SESSION['name'];
    }

    $length = strlen($name);
    foreach($_COOKIE as $key => $value)
    {
        if(substr($key,0,$length) == $name)
        {
            unset($_COOKIE[$key]);
            
        }
    }
    echo "<script>";
    echo "deleteCoockie(`$name`);";
    echo "window.location=document.URL;";
    echo "</script>";
}
?>