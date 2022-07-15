<?php
    if(isset($_POST['search'])){
        $search = $_POST['search'];
        $mysqli = new mysqli('localhost','root','','store');
        $sql = "SELECT * FROM users WHERE (id LIKE '%$search%') OR (first_name LIKE '%$search%') OR (last_name LIKE '%$search%')";
        $result = $mysqli->query($sql);
        $num_rows = $result->num_rows;
        $data = $result->fetch_object();
        if($num_rows > 0){
            echo <<<html
                <tr>
                    <th>$data->id</td>
                    <td>$data->email</td>
                    <td>$data->first_name</td>
                    <td>$data->last_name</td>
                </tr>
            html;
        }else{
            echo '<span class="mt-3 mx-auto d-inline-block">ไม่พบข้อมูลที่ต้องการ</span>';
        }
    }
?>