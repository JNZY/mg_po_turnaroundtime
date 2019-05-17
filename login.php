
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    
    
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-reboot.min.css">
</head>

<body>

    <div class="page-layout">

    
    <div class="loader conceal">
        <i class="fa fa-cog fa-spin fa-3x fa-fw spin"></i>
    </div>

    <h2 class="text-center head">Login</h2>

    <form action="logic/login.php" method="POST" class="container">


        <div class="form-group">
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
        </div>
        
        <div class="form-group">
            <label class="text-center">Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" name='login' class="log-button">Login</button>
        <a href="forgetPassword.php"><small>Forget Password</small></a>
        <br>
        <br>
    </form>
       
</div>
</html>

