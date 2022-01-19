<?php
$mysqli = new mysqli('localhost', 'root', 'root1', 'cloud');
$result= mysqli_query($mysqli, "SELECT * FROM `booster_3` order by id desc LIMIT 1");
//$result1= mysqli_num_rows($count);
while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }


echo json_encode($emparray);
mysqli_close($connection);
exit;
?>
