<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style type="text/css">
    body {
      padding: 0px;
      margin: 3px;
    }
    .layout {
      /*background-color: #676767;*/
      width: 220px;
      padding: 0px;
      margin:0px;
    }
    .title {
      /*background-color: #000;
      color: #fff;*/
      margin-top: 15px;
      padding: 0px;
      margin: 13px 0px 0px 0px;
      font-size: 13px;
    }
    .center {
      text-align: center;
    }
    .bold {
      font-weight: bold;
      padding: 0px; 
    }
    .logo {
      background-color: #000;
      width: 45px;
      height: 45px;
      float: right;
      padding: 0px;
      margin: 0px;
    }
    .form {
      margin: 0 auto;
      padding: 0px;
      display: inline-block;
    }
    .form-group {
      margin-bottom: 2px;
    }
    .form-group input {
      width: 98%;
      background-color: none;
      filter: none;
      border: 1px solid #676767;
    }
    .form-group select {
      width: 99%;
      background-color: none;
      filter: none;
      border: 1px solid #000;
    }
    .error {
      color: red;
      margin:0;
      padding:0;
    }
    button {
      margin-top: 5px;
      width: 100%;
      background-color: #668cff;
      border: 1px solid #676767;
      padding: 2px;
      color:#fff;
    }
    .red {
      color: red;
    }
  </style>
</head>
<body>
  <div class="layout">
    <img src="http://10.190.2.241/first/assets/logo.jpg" class="logo">
    <p class="title center bold">Transport Turnaround Time</p>

    <form class="form" action="logic/login.php" method="POST">
      <div class="form-group">
        <label>Username:</label>
        <input type="text" name="username">
      </div>
      <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password">
      </div>
      <div class="form-group">
        <label>Location:</label>
        <select name="locations">
          <option>Select Location</option>
                        <?php 
                        require_once('config.php');
                        date_default_timezone_set('Asia/Singapore');

                        $ora = wms_uat();


                          $secondQuery = " SELECT code || ' - ' || facility_id whname,  substr(code,1,5) code4 from whsloc where facility_id in ('LB','PB','SI','LT','BD')
          union all
          select TO_CHAR(store)  || ' - ' || store_name stname , substr(store,1,4) code4 from store@mgrmsp where store not in ('1333','1110','2003','1111','2014','2015','2017','3008','3011','3013','5002','5003','5004','5005','5006','5007','5008','5009','5010','6007','6008','6015','7006','7007','7008','7173','7176','7300','7400','9001','9002','9003','9004','9006','9007','9009','9100','9101','9102','9103','9104','9105','9106','9107','9108','9109','9999')
                            ";

                              $secondQueryRes=$ora->prepare($secondQuery); 
                              $secondQueryRes->execute();


                            while ($row=$secondQueryRes->fetch(PDO::FETCH_ASSOC)) {
                                $codes=$row['CODE4'];
                                $names = $row['WHNAME'];

            
                                echo '<option value="'.$codes.'">'.$names.'</option>';
                            }
                        ?>
        </select>
      </div>
      <small class="red">
       <?php           
          if (isset($_SESSION['errorLogin']))
          {
              echo $_SESSION['errorLogin'];
          } 
            unset($_SESSION['error_Login']);
          ?>
        </small>
      <button type="submit" name="login">Login</button>
      <!-- <p class="error">Error</p> -->
    </form>
  </div>
</body>
<script type="text/javascript" src="assets/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $('input').focus(function () {
      $('.error').empty();
    });
  }); 
</script>
</html>