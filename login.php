<!DOCTYPE html>
<html lang="en">
<head>
<title>TraffX - Login</title>
<meta charset="utf-8">
<link href = style.css rel = "stylesheet">
    
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
    var setting = "b1";
    $(document).ready(function(){
                      $("#go").click(function(){
                                       document.adjust.submit();
                                     });
                      $("#register").click(function(){
                                         window.open ('register.php','_self',false);
                                           });
    });
                                          
</script>
    
    
</head>
<body>
<div id="nav">
<img src = "logo.gif" width = "250px" style="margin-left:50px;float:right;"/>
<div id ="buttons">
<div class="tabs" id="register">Register</div>
</div>
 <div id="master">
<div id="content">
          <center>
            <form action = "scripts/checklogin.php" method = "post" id = "adjust" name = "adjust">
            <table style="font-size:200%;">
                <tr>
                    <td>Username</td>
                    <td><input type = text style="width:300px;height:40px;background-color:black;color:white;font-size:100%" name = "username"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type = password style="width:300px;height:40px;background-color:black;color:white;font-size:100%;" name = "password"></td>
                </tr>
                </table>
    </form>

      <div id = "go">
          LOGIN
      </div>
      </center>
</div>
<br>
</div>
</body>
</html>

