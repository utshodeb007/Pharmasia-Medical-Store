<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === 'tonmoydeb2949@gmail.com' && $password === 'Tonmoy007') {
        $_SESSION['admin'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login | Pharmasia</title>

<link rel="stylesheet" href="../assets/css/style.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,Helvetica,sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(-45deg,#071528,#0d2746,#d51d28,#ff5757);
    background-size:400% 400%;
    animation:bg 12s ease infinite;
}

@keyframes bg{
0%{background-position:0% 50%;}
50%{background-position:100% 50%;}
100%{background-position:0% 50%;}
}

.admin-login{

    width:420px;
    max-width:90%;
    padding:40px;
    border-radius:25px;
    background:rgba(255,255,255,.12);
    backdrop-filter:blur(15px);
    border:1px solid rgba(255,255,255,.2);
    box-shadow:0 20px 45px rgba(0,0,0,.35);
    text-align:center;
}

.logo{

    width:80px;
    height:80px;
    border-radius:50%;
    background:#d51d28;
    color:#fff;
    font-size:32px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    margin-bottom:20px;
}

.admin-login h1{

    color:#fff;
    margin-bottom:8px;
}

.admin-login p{

    color:#ddd;
    margin-bottom:25px;
}

.input-group{

    position:relative;
    margin-bottom:20px;
}

.input-group input{

    width:100%;
    padding:15px;
    border:none;
    border-radius:12px;
    outline:none;
    background:rgba(255,255,255,.15);
    color:#fff;
    font-size:15px;
}

.input-group input::placeholder{

    color:#eee;
}

.toggle{

    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    color:white;
    font-size:18px;
}

.login-btn{

    width:100%;
    padding:15px;
    border:none;
    border-radius:12px;
    background:#d51d28;
    color:#fff;
    font-size:17px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
}

.login-btn:hover{

    background:#b9141f;
    transform:translateY(-2px);
}

.error{

    background:#ffebee;
    color:#c62828;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
}

.back{

    display:block;
    margin-top:20px;
    color:white;
    text-decoration:none;
    font-weight:bold;
}

.back:hover{

    color:#ffb3b3;
}

</style>

</head>

<body>

<form method="POST" class="admin-login">

<div class="logo">
💊
</div>

<h1>Admin Login</h1>

<p>Welcome Back</p>

<?php if(isset($error)){ ?>

<div class="error">
<?php echo $error; ?>
</div>

<?php } ?>

<div class="input-group">

<input
type="email"
name="email"
placeholder="Email Address"
required>

</div>

<div class="input-group">

<input
type="password"
name="password"
id="password"
placeholder="Password"
required>

<span class="toggle" onclick="togglePassword()">👁</span>

</div>

<button class="login-btn">

Login

</button>

<a href="../index.php" class="back">

← Back to Website

</a>

</form>

<script>

function togglePassword(){

var password=document.getElementById("password");

if(password.type==="password"){

password.type="text";

}else{

password.type="password";

}

}

</script>

</body>
</html>