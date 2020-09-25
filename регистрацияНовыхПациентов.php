<?php
/** подключение бд */
require_once("includes/db.php");

/**переменные */
$userIsEmpty = false;


/* * проверка на запрос страницы*/
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    /** Check whether the user has filled in the wisher's name in the text field "user" */
    if ($_POST['user']==""){
        $userIsEmpty = true;
    }
    
    /* * создать подключение к бд*/
    
    $wisherID = WishDB::getInstance()->get_пациент_id_by_ФИО($_POST['user']);
     
    /* * запись новых данных в бд*/
    if (!$userIsEmpty) {
        WishDB::getInstance()->create_пациен($_POST['user']);
        session_start();
        $_SESSION['user'] = $_POST['user'];
        header('Location: редактироватьДанныеОПациенте.php' );
        exit;
    }
}
?>

<html>
    <head><meta charset=UTF-8"></head>
    <body>
        приветствуем!<br>
        <form action="регистрацияНовыхПациентов.php" method="POST">
            ФИО нового пациента: <input type="text" name="user"/><br/>
            <?php
                                /** если строка имени не заполнена*/
            if ($userIsEmpty) {
                echo ("введите ФИО пациента, пожалуйста");
                echo ("<br/>");
            }
            ?>
            <input type="submit" value="зарегестрировать"/>  
        </form>
    </body>
</html>
