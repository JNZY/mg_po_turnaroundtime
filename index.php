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
      margin: 0px 0px 0px 0px;
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
  <div class="layout"><center>
    <img src="http://10.190.2.241/first/assets/logo.jpg" style="margin: 0px;" height="60" width="60">
  </center>
    <p class="title center bold">Transport Turnaround Time</p><br>

    <form class="form" action="logic/login.php" method="POST">
      <div class="form-group">
        <label>Username:</label>
        <input type="text" name="username">
      </div>
      <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password">
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