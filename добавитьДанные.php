<?php
session_start();
if (!array_key_exists("user", $_SESSION)) {
    header('Location: index.php');
    exit;}
require_once("includes/db.php");
$пациентID = WishDB::getInstance()->get_пациент_id_by_ФИО($_SESSION['user']);
$wishDescriptionIsEmpty = false;
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if (array_key_exists("back", $_POST)) {
        header('Location: редактироватьДанныеОПациенте.php' );        exit;
    } else
    if ($_POST['данные'] == "") {
        $wishDescriptionIsEmpty =  true;
    } else {
        WishDB::getInstance()->insert_wish($пациентID, $_POST['данные'], $_POST['пол'],$_POST['адрес'],$_POST['телефон'],$_POST['болезнь']);
        header('Location: редактироватьДанныеОПациенте.php' );        exit;    }}?>
<html>
    <header>
        <title>добавьте данные!</title>
    </header>
    <body>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST"){   
        $данные = array("возраст" => $_POST['данные']);
        $пол = array("пол" => $_POST['пол']);
        $адрес = array("адрес" => $_POST['адрес']);
        $телефон = array("телефон" => $_POST['телефон']);
        $болезнь = array("болезнь" => $_POST['болезнь']);        }
        else {
        $данные = array("возраст" => "");
        $пол = array("пол" => "");
        $адрес = array("адрес" => "");
        $телефон = array("телефон" => "");
        $болезнь = array("болезнь" => "");        } ?>
        <form name="ДобавитьДанные" action="добавитьДанные.php" method="POST">
            укажите возраст пациента: <input type="text" name="данные"  value="<?php echo $данные['возраст'];?>" /><br/>
            <?php
            if ($wishDescriptionIsEmpty) echo "пожалуйста введите возраст<br/>";
            ?>
            укажите пол пациента: <input type="text" name="пол" value="<?php echo $пол['пол']; ?>"/><br/>
            укажите адрес пациента: <input type="text" name="адрес" value="<?php echo $адрес['адрес']; ?>"/><br/>
            укажите телефон пациента: <input type="text" name="телефон" value="<?php echo $телефон['телефон']; ?>"/><br/>
            укажите болезнь пациента: <input type="text" name="болезнь" value="<?php echo $болезнь['болезнь']; ?>"/><br/>            
            <input type="submit" name="сохранитьИзменения" value="сохранить"/>
            <input type="submit" name="назад" value="вернутся назад"/>
        </form>
    </body>
</html>

