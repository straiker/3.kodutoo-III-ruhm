<?php
require_once "../config.php";

$email_error = "";
$pswd_error = "";
$mysqli = new mysqli($servername, $username, $password, $db);

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if (isset($_POST['login'])) {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            echo "Sisesta email ja parool!";
        } else {
            $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
            $stmt->bind_param("ss",$_POST['email'], $_POST['password']);
            $stmt->bind_result($did, $uname, $pass, $fname, $lname, $email);
            $stmt->execute();

            if($stmt->fetch()){
                echo "Email ja parool õiged, kasutaja id=" .$did;
            }else{
                echo "Wrong credentials";
            }
            $stmt->close();
        }
    }

    if(isset($_POST['register'])){
        if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['first_name']) || empty($_POST['last_name'])) {
            echo "Täida nõutud väljad * !";
        } else {
            $stmt = $mysqli->prepare("INSERT INTO users (email, first_name, last_name, password) values (?,?,?,?)");
            $stmt->bind_param("ssss",$_POST['email'], $_POST['first_name'], $_POST['last_name'], $_POST['password']);
            $stmt->execute();
            $stmt->close();
            echo "loodud";
        }
    }
}
?>
<html>
<head></head>
<body>
<div id="index.php">
    <h1>Login</h1>
    <form action="index.php" method="post">
        <input type="email" name="email" id="email" placeholder="Email"><br>
        <input type="password" name="password" id="password" placeholder="password"><br>
        <input type="submit" name="login" value="Login">
    </form>
</div>
<div id="login_intro">
    <h1>Welcome!</h1>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nec ipsum risus. In vitae purus rutrum, aliquet sapien at, volutpat metus. Maecenas luctus est ut erat rhoncus, sit amet placerat ipsum malesuada. Nam et felis orci. Aenean sit amet mi et turpis mattis ultrices et in tortor. Suspendisse dictum justo elit, sit amet hendrerit ex consectetur nec. In leo leo, tempor vitae maximus sit amet, lacinia ut orci.
    </p>
    <p>
        Proin lacinia hendrerit lobortis. Mauris ut quam nisl. Mauris fermentum accumsan orci, id condimentum massa molestie quis. Suspendisse porttitor ligula vel turpis pharetra ultricies. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis consequat condimentum tristique. Nam accumsan libero id odio eleifend lobortis.
    </p>
</div>

<div id="registration_form">
    <h1>Register new user</h1>
    <form action="index.php" method="post">
        <label for="email">E-mail *</label><input type="email" name="email" placeholder="somename@somepath.ext"><br>
        <label for="password">Password *</label><input type="password" name="password" placeholder="password"><br>
        <label for="text">Eesnimi *</label><input type="text" name="first_name" placeholder="Rait"><br>
        <label for="text">Perenimi *</label><input type="text" name="last_name" placeholder="Avastu"><br>
        <input type="submit" name="register" value="Register">
    </form>
</div>
</body>

</html>

