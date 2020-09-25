<?php
require_once("includes/db.php");
$logonSuccess = false;

// verify user's credentials
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $logonSuccess = (WishDB::getInstance()->verify_wisher_credentials($_POST['user']));
    if ($logonSuccess == true) {
        session_start();
        $_SESSION['user'] = $_POST['user'];
        header('Location: редактироватьДанныеОПациенте.php');
        exit;
    }
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>регистратура</title>
    </head>
    <body>
        <form action="регистратура2.php" method="GET" name="Регистратура">
            показать данные о пациенте: <input type="text" name="user"/>
            <input type="submit" value="показать" />
        </form>
        зарегестрировать нового пациента <a href="регистрацияНовыхПациентов.php">зарегестрировать</a>
        <form name="logon" action="index.php" method="POST" >
            введите ФИО пациента данные которого вы хотите отредактировать: <input type="text" name="user"/>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (!$logonSuccess)
                    echo "неверное имя";
            }
            ?>
            <input type="submit" value="редактировать"/>
        </form>
    </body>
</html>
