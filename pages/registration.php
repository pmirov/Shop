<?php

Registration::ShowForm();

Registration::Create($_POST, $_FILES);

class Registration
{
    static function Create($array,$file)
    {
        if(!isset($array['userLogin'],
                 $array['userPassword1'],
                 $array['userPassword2']))
            {
                return;
            } 
        if($array['userPassword1'] != $array['userPassword2'])
        {
            echo "Ошибка пароль 1 не равен пароль 2";
            return;
        }
        
        if(is_uploaded_file($file['userFoto']['tmp_name']))
        {
            $path="./wwwroot/images/".$file['userFoto']['name'];
            move_uploaded_file($file['userFoto']['tmp_name'],$path);
        }
        $obj = new Customer($array['userLogin'],$array['userPassword1'],1,0,0,$path);
        $obj->WriteDB();
    }

    static function ShowForm()
    {
        
?>
    <form action="index.php?page=reg" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
        <div>
            <label>Логин</label>
            <input type="text" name="userLogin">
        </div>
        <div>
            <label>Пароль</label>
            <input type="password" name="userPassword1">
        </div>
        <div>
            <label>Пароль</label>
            <input type="password" name="userPassword2">
        </div>
        <div>
            <label>Картинка</label>
            <input type="file" name="userFoto" accept="image/*">
        </div>
        <input type="submit" value="Регистрация">
    </form>
<?php

    }
}


?>