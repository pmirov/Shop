<select name="categoryId" id="selectId">
    <option value="-1">Все товары</option>

<?php

    $array = Category::GetAll();
    foreach ($array as $value)
    {
        echo "<option value='$value[0]'>$value[1]</option>";
    }

?>

</select>

<div id="content" class="col-12"></div>

<script>
    let select = document.getElementById('selectId');
    select.onchange = GetContent;
    let ajax = new XMLHttpRequest();

    function GetContent()
    {
        ajax.open ("get", "pages/getContent.php?category=" + select.value,true);
        ajax.onreadystatechange = SaveData;
        ajax.send();
    }
    let content = document.getElementById("content");
    function SaveData()
    {
        if (ajax.readyState == 4 && ajax.status == 200)
        {
           content.innerHTML = ajax.responseText;
        }
    }


</script>

<script src="./wwwroot/js/main.js"></script>