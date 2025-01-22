<?php
if (!isset($_SESSION['radmin'])) {
    echo "<h3/><span style='color:red;'>For 
Administrators Only!
 </span><h3/>";
    exit();
}

AdminForm::AddCategory($_POST);
AdminForm::CategoryForm();
echo "<hr>";
AdminForm::ItemForm();

if (isset($_POST['addItemProduct'])) {


    $tempPath = $_FILES['itemPhoto']['tmp_name'];
    if (is_uploaded_file($tempPath)) {
        $path = "./wwwroot/images/" . $_FILES['itemPhoto']['name'];
        $result = move_uploaded_file($tempPath, $path);
        if ($result == true) {
            $name = $_POST['itemName'];
            $categoryId = $_POST['category'];
            $price = $_POST['itemPrice'];
            $pricesale = $_POST['itemPriceSale'];
            $description = $_POST['itemDescription'];
            $item = new Item($name, $categoryId, $price, $pricesale, $description, 5, $path, 0);
            $item->Add();
        }
    }
}


class AdminForm
{
    static function AddCategory($array)
    {
        if (isset($array['newCategory'])) {
            Category::Add($array['newCategory']);
        }
    }

    static function CategoryForm()
    {
?>
        <form method="post" accept="index.php?page=admin">
            <input type="text" name="newCategory">
            <input type="submit" value="Save Category">
        </form>


    <?php

    }

    static function ItemForm()
    {

    ?>
        <form method="post"
            accept="index.php?page=admin"
            enctype="multipart/form-data">


            <?php
            $array = Category::GetAll();
            echo "<select name='category'>";
            foreach ($array as $key => $item) {
                echo "<option value='$item[0]'>$item[1]</option>";
            }
            echo "</select>";
            ?>
            <div>
                <label>Имя:</label>
                <input type="text" name="itemName">
            </div>
            <div>
                <label>Цена:</label>
                <input type="number" name="itemPrice">
            </div>
            <div>
                <label>Цена со скидкой:</label>
                <input type="number" name="itemPriceSale">
            </div>
            <div>
                <label>Описание:</label>
                <textarea maxlength="300" name="itemDescription"></textarea>
            </div>
            <div>
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                <input type="file" name="itemPhoto" accept="image/*">
            </div>
            <div>
                <input type="submit" name="addItemProduct" value="Добавить">
            </div>
        </form>
<?php

    }
}

?>