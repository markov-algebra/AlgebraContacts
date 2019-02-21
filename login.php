<?php

require_once 'core/init.php';

Helper::getHeader('Algebra Contacts', 'main-header');

require 'notifications.php';

$conn = new mysqli('localhost', 'root', '', 'algebra_contacts');


if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}
 
$username = $password = "";
$username_err = $password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
       
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = $conn->prepare($sql)){
            
            $stmt->bind_param("s", $param_username);
            
            $param_username = $username;
            
            
            if($stmt->execute()){
               
                $stmt->store_result();
                
               
                if($stmt->num_rows == 1){                    
                    
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                           
                            session_start();
                            
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            
                            header("location: dashboard.php");
                        } else{
                           
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
      
        $stmt->close();
    }
    
    
    $conn->close();
}


?>
 

<div class="row">
    <div class="col-xs-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Sign In</h3>
            </div>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" value="<?php echo $username; ?>"id="username" name="username" placeholder="Username" autofocus>
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </div>
                    <p>If you don't have an account, please <a href="register.php">Register</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
Helper::getFooter();
?>