<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <body>
        данные о пациенте <?php echo $_GET['user']."<br/>";?>
        <?php
        require_once("includes/db.php");
        
        $пациентID = WishDB::getInstance()->get_пациент_id_by_ФИО($_GET['user']);
        if (!$пациентID) {
            exit("пациент " .$_GET['user']. " не найден пожалуста, перепроверьте имя" );
        }
        ?>
        <table border="black">
            <tr>
                <th>Возраст</th>
                <th>Пол</th>
                <th>Адрес</th>
                <th>Телефон</th>
                <th>Болезнь</th>
            </tr>
            <?php
            $result = WishDB::getInstance()->get_данныеОПациенте_by_пациент_id($пациентID);
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>" . htmlentities($row['возраст']) . "</td>";
                echo "<td>" . htmlentities($row['пол']) . "</td>\n";
                echo "<td>" . htmlentities($row['адрес']) . "</td>\n";
                echo "<td>" . htmlentities($row['телефон']) . "</td>\n";
                echo "<td>" . htmlentities($row['болезнь']) . "</td></tr>\n";
            }
            mysqli_free_result($result);
            ?>
        </table>
    </body>
</html>
