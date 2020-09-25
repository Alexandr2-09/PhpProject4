<?php
session_start();
if (!array_key_exists("user", $_SESSION)) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
    </head>
    <body>
        Hello <?php echo $_SESSION['user']; ?><br/>
        <table border="black">
             <th>Возраст</th>
             <th>Пол</th>
             <th>Адрес</th>
             <th>Телефон</th>
             <th>Болезнь</th>
            <?php
            require_once("includes/db.php");
            $пациентID = WishDB::getInstance()->get_пациент_id_by_ФИО($_SESSION['user']);
            $result = WishDB::getInstance()->get_данныеОПациенте_by_пациент_id($пациентID);
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>" . htmlentities($row['возраст']) . "</td>";
                echo "<td>" . htmlentities($row['пол']) . "</td>\n";
                echo "<td>" . htmlentities($row['адрес']) . "</td>\n";
                echo "<td>" . htmlentities($row['телефон']) . "</td>\n";
                echo "<td>" . htmlentities($row['болезнь']) . "</td></tr>\n";
                $wishID = $row['id'];
                echo "<td>WishID=" . $wishID . "</td>";
                //цикл остается открытым
                ?>
                <td>
                    <form name="editWish" action="добавитьДанные.php" method="GET">
                        <input type="hidden" name="wishID" value="<?php echo $wishID; ?>"/>
                        <input type="submit" name="editWish" value="Edit"/>
                    </form>
                </td>
                <td>
                    <form name="deleteWish" action="deleteWish.php" method="POST">
                        <input type="hidden" name="wishID" value="<?php echo $wishID; ?>"/>
                        <input type="submit" name="deleteWish" value="Delete"/>
                    </form>
                </td>
                <?php
                echo "</tr>\n";
            }
            mysqli_free_result($result);
            ?>
        </table>
        <form name="добавитьНовыеДанные" action="добавитьДанные.php">
            <input type="submit" value="добавить"/>
        </form>
        <form name="backToMainPage" action="index.php">
            <input type="submit" value="вернутся в главное меню"/>
        </form>

    </body>
</html>
