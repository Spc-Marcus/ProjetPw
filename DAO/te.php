<?php
require_once("TrajetDAO.php");

$dbFile = '../DB/Donne.db';
$pdo = new PDO('sqlite:' . $dbFile);
$dao=new TrajetDAO();
$dao->setConnect($pdo);
$as=$dao->getAll("Laval");

echo "<table>";
    echo "<tr><th>loc</th></tr>";
    foreach ($as as $a) {
        echo "<tr>";
        echo "<td>" . $a['Localisation'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
?>