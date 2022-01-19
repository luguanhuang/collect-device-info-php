<?php
$mysqli = new mysqli('localhost', 'root', 'root1', 'cloud');
$data = mysqli_query($mysqli, "SELECT * FROM `booster_3` order by id desc LIMIT 1");
echo "<table><tr>
    <th>ID</th>
    <th>channel</th>
    <th>data_1</th>
    <th>data_3</th>
    <th>data_5</th>
    <th>data_7</th>
    <th>data_9</th>
    <th>data_11</th>
    <th>data_13</th>
    </tr>";
while($row = $data->fetch_assoc()){


    $user_id = $row['id'];
    $channel = $row['channel'];
    $data1 = $row['data_1'];
    $data2 = $row['data_2'];
    $data3 = $row['data_3'];
    $data4 = $row['data_4'];
    $data5 = $row['data_5'];
    $data6 = $row['data_6'];
    $data7 = $row['data_7'];
    $data8 = $row['data_8'];
    $data9 = $row['data_9'];
    $data10 = $row['data_10'];
    $data11 = $row['data_11'];
    $data12 = $row['data_12'];
    $data13 = $row['data_13'];
    $data14 = $row['data_14'];
    $data15 = $row['data_15'];
    $data16 = $row['data_16'];
    $data17 = $row['data_17'];
    $data18 = $row['data_18'];
    $data19 = $row['data_19'];
    $data20 = $row['data_20'];
    $data21 = $row['data_21'];   
    $data22 = $row['data_22']; 
    $data23 = $row['data_23'];
    $data24 = $row['data_24'];
    $data25 = $row['data_25'];
    $data26 = $row['data_26'];
    $data27 = $row['data_27'];
    $data28 = $row['data_28'];
    $data29 = $row['data_29'];
    $data30 = $row['data_30'];
    $data31 = $row['data_31'];
    $data32 = $row['data_32'];




    echo "<tr>
    <td>$user_id</td>
    <td>$channel</td>
    <td>$data1</td>
<td>$data1</td>
<td>$data2</td>
<td>$data3</td>
<td>$data4</td>
<td>$data5</td>
<td>$data6</td>
<td>$data7</td>
<td>$data8</td>
<td>$data8</td>
<td>$data10</td>
<td>$data11</td>
<td>$data12</td>
<td>$data13</td>
<td>$data14</td>
<td>$data15</td>
<td>$data16</td>
<td>$data17</td>
<td>$data18</td>
<td>$data19</td>
<td>$data20</td>
<td>$data21</td>
<td>$data22</td>
<td>$data23</td>
<td>$data24</td>
<td>$data25</td>
<td>$data26</td>
<td>$data27</td>
<td>$data28</td>
<td>$data29</td>
<td>$data30</td>
<td>$data31</td>

<td>$data32</td>



";
}
echo "</tr></table>";
?>
