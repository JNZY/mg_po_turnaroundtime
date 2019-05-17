<!DOCTYPE html>
<html>

<!-- 
    Local
-->
<link rel="stylesheet" type="text/css" href="assets/style.css">
<link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/bootstrap-grid.min.css">
<link rel="stylesheet" type="text/css" href="assets/bootstrap-reboot.min.css">

<title> supplier_po_kpi </title>
<body>



<div class="page-layout">
    <form action="logic/logout.php" method="post">
        <a href="login.php" class="ml-0 log-button" name="logout">Logout</a>

    </form>
  <form action="logic/admin.php" method="post" class="container">
        <h2 class="text-center head">Admin</h2>

            <label class="text-center">User ID</label>
        <input type="text" name="username" required>


            <label class="text-center" required>Password</label>
        <input type="password" name="password" required>


            <label>Location</label>
                        <select name="locations" required>
                        <option value="">Select Location</option>

                          <?php 

                          require_once('config.php');
                          date_default_timezone_set('Asia/Singapore');

                          $ora = wms_uat();


                            $secondQuery = " SELECT code from whsloc where facility_id in ('LB','PB','SI','LT','BD')
                              union all
                              select TO_CHAR(store) from store@mgrmst where store not in ('1333','1110','2003','1111','2014','2015','2017','3008','3011','3013','5002','5003','5004','5005','5006','5007','5008','5009','5010','6007','6008','6015','7006','7007','7008','7173','7176','7300','7400','9001','9002','9003','9004','9006','9007','9009','9100','9101','9102','9103','9104','9105','9106','9107','9108','9109','9999')
                              ";

                                $secondQueryRes=$ora->prepare($secondQuery); 
                                $secondQueryRes->execute();


                              while ($row=$secondQueryRes->fetch(PDO::FETCH_ASSOC)) {
                                  $codes=$row['CODE'];

              
                                  echo '<option value="'.$codes.'">'.$codes.'</option>';
                              }
                          ?>
                        </select>

            <label>Location Type</label>
            <select name="location_type" required>
            <option value="">SelectType</option>
            <option value="WH">Warehouse</option>
            <option value="ST">Store</option>
            </select>

            <label>User Type</label>
            <select name="user_type" required>
            <option value="">Select User Type</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
            </select>

           
        <input type="submit" class="log-button ml-0" name="submit" value="CREATE">

    </form>
</div>
<!-- 
    Bootstrap js
-->
<script src="assets/bootstrap.bundle.min.js"></script>
<script src="assets/bootstrap.min.js"></script>

</body>
</html>
