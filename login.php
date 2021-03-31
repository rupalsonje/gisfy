<?php
    session_start();
    include('db_connect.php');

    $username = '';
    $error = array('username'=>'','pass'=>'');
    if(isset($_POST['submit'])){
        if(empty($_POST['username'])){
            $error['username']='username is required';
        }
        else{
            $username = htmlspecialchars($_POST['username']);
        }
        if(empty($_POST['pass'])){
            $error['pass']='password is required';
        }
        else{
            $pass = htmlspecialchars($_POST['pass']);
        }
        
        if(array_filter($error)){
        }
        else{
            $username = mysqli_real_escape_string($conn,$_POST['username']);
            $pass = mysqli_real_escape_string($conn,$_POST['pass']);
            $pass = md5($pass);
            $sql = "SELECT * FROM `login` WHERE username= '$username' AND passw='$pass'";

            $result = mysqli_query($conn,$sql);

            if(mysqli_num_rows($result) == 1){
                $data=mysqli_fetch_assoc($result);
                $_SESSION['username']=$data['username'];
                $_SESSION['success'] = "You are now logged in";
                header('location: index.html');
                mysqli_free_result($result);
                mysqli_close($conn);
            }
            else{
                $error['pass'] = "Incorrect username or password";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://kit.fontawesome.com/d3535522b2.js" crossorigin="anonymous"></script>
    <title>login</title>
</head>
<body>
<div class="main">
    <p class="sign" style="text-align:center;">Sign in</p>
        <form class="form1" method="POST" action="login.php">
        <input class="un " type="text" name="username" style="text-align:center;" placeholder="Username" value="<?php echo $username ?>">
        <p class="error" style="text-align:center;"><?php echo $error['username'] ;?></p>
        <input id="pwd" class="pass" name="pass" type="password" required style="text-align:center;" placeholder="Password">
        <!--      Show/hide password  -->
        <span>
            <i class="fas fa-eye white" aria-hidden="true"  type="button" id="eye"></i>
        </span>
        <p class="error" style="text-align:center;"><?php echo $error['pass'];?></p>
        <button type="submit" name="submit" class="submit"><a style="text-align:center;" name="submit" >Sign in</a></button>
        <p class="forgot" style="text-align:center;"><a href="#">Forgot Password?</p>
        </form>            
    </div>
    
    <script>
    function show() {
        var p = document.getElementById('pwd');
        var eye = document.getElementById('eye');
        p.setAttribute('type', 'text');
        eye.classList.add('black');
        eye.classList.remove('white');    
    }

    function hide() {
        var eye = document.getElementById('eye');
        var p = document.getElementById('pwd');
        p.setAttribute('type', 'password');
        eye.classList.remove('black');
        eye.classList.add('white');
    }

    var pwShown = 0;

    document.getElementById("eye").addEventListener("click", function () {
        if (pwShown == 0) {
            pwShown = 1;
            show();
        } else {
            pwShown = 0;
            hide();
        }
    }, false);
    </script>
</body>
</html>