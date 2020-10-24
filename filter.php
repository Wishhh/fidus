<?php
include_once "dbconnect.php";
if(isset($_POST["from_date"], $_POST["to_date"]))
 {
    $output = '';
    $query = "SELECT sp.id , u.group , u.name as username, sp.name as productname , s.quantity ,
        s.price , s.sum , sp.price as sprice , s.date
        FROM sell_products sp
        join sells s on s.prod_uniqid=sp.uniqid
        join users u on s.user_id=u.id
        WHERE date BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'
    ";
    $result = mysqli_query($conn, $query);
    $output .= '
        <table class="table table-bordered">
        <tr>
        <th width="5%">ID</th>
        <th width="5%">სალარო</th>
        <th width="15%">მოლარე</th>
        <th width="15%">პროდუქცია</th>
        <th width="5%">რაოდენობა</th>
        <th width="5%">ფასი</th>
        <th width="5%">ჯამი</th>
        <th width="5%">თვითღ.ჯამი</th>
        <th width="5%">თარიღი</th>
        </tr>
    ';
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $output .= '
            <tr>
            <td>'.$row["id"].'</td>
            <td>'.$row["group"].'</td>
            <td>'.$row["username"].'</td>
            <td>'.$row["productname"].'</td>
            <td>'.$row["quantity"].'</td> 
            <td>'.$row["price"].'</td>
            <td>'.$row["sum"].'</td>
            <td>'.$row["sprice"].'</td>
            <td>'.$row["date"].'</td>
            </tr>
            ';
        }
    }

    else{
        $output .= '
            <tr>
                <td colspan="5">No Order Found</td>
            </tr>
        ';
    }
    $output .= '</table>';
    echo $output;
    $sumquery = "SELECT SUM(sum) as finalsum from sells";
    $result1 = mysqli_query($conn, $sumquery); 
    while($roww = mysqli_fetch_array($result1)){
      echo ' ჯამი:  <td>'.$roww["finalsum"].'</td>';
      }
}
?>