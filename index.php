<?php
include_once "dbconnect.php";
 $query = "SELECT sp.id , u.group , u.name as username, sp.name as productname , s.quantity ,
            s.price , s.sum , sp.price as sprice , s.date 
            FROM sells s
            join sell_products sp on s.prod_uniqid=sp.uniqid
            join users u on sp.user_id=u.id
            limit 100;
          ";
  $sum = "SELECT SUM(sum) from sells";

$result = mysqli_query($conn, $query);
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
</head>
<body>
<br /><br />
<div class="container" style="width:100%;">
  <div class="col-md-3">
    <input type="text" name="from_date" id="from_date" class="form-control" placeholder="საწყისი თარიღი" />
  </div>
  <div class="col-md-3">
    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="საბოლოო თარირი" />
  </div>
  <div class="col-md-5">
    <input type="button" name="filter" id="filter" value="ჩვენება" class="btn btn-info" />
  </div>
  <div style="clear:both"></div>
  <br/>
  <div id="order_table">
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
      <?php
      while($row = mysqli_fetch_array($result))
      {
      ?>
        <tr>
          <td><?php echo $row["id"]; ?></td>
          <td><?php echo $row["group"]; ?></td>
          <td><?php echo $row["username"]; ?></td>
          <td><?php echo $row["productname"]; ?></td>
          <td><?php echo $row["quantity"]; ?></td> 
          <td><?php echo $row["price"]; ?></td>
          <td><?php echo $row["sum"]; ?></td>
          <td><?php echo $row["sprice"]; ?></td>
          <td><?php echo $row["date"]; ?></td>
        </tr>
        
      <?php
      }
      ?>

<?php
$sumquery = "SELECT SUM(sum) as finalsum from sells";
$result1 = mysqli_query($conn, $sumquery);
?>
<?php
while($roww = mysqli_fetch_array($result1)){
  ?>
  <td><?php echo 'ჯამი: ' . $roww["finalsum"]; ?></td> 
  <?php
  }
  ?>


    </table>
  </div>
</div>
</body>
 </html>
 <script>  
  $(document).ready(function(){  
        $.datepicker.setDefaults({  
            dateFormat: 'yy-mm-dd'   
        });  
        $(function(){  
            $("#from_date").datepicker();  
            $("#to_date").datepicker();  
        });  
        $('#filter').click(function(){  
            var from_date = $('#from_date').val();  
            var to_date = $('#to_date').val();  
            if(from_date != '' && to_date != '')  
            {  
                  $.ajax({  
                      url:"filter.php",  
                      method:"POST",  
                      data:{from_date:from_date, to_date:to_date},  
                      success:function(data)  
                      {  
                            $('#order_table').html(data);  
                      }  
                  });  
            }  
            else  
            {  
                  alert("აირჩიეთ თარირი");  
            }  
        });  
  });  
 </script>


