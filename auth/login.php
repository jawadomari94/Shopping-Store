<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php

    if(isset($_SESSION['username'])){
        echo "<script>window.location.href='".APPURL."'</script>";


    }

        if(isset($_POST['submit'])){
            if(empty($_POST['username']) OR empty($_POST['mypassword'])){

                echo "<script>alert('one or more inputs ar empty');</script>";

         }else{
            //assgin inputs
            $username = $_POST['username'];
            $password = $_POST['mypassword'];

            //query
            $query = $conn->query("SELECT * FROM users WHERE username='$username'");
            $query->execute();

            $fetch = $query->fetch(PDO::FETCH_ASSOC);

            //validating
            if($query->rowCount() > 0){
                //echo $query->rowCount();

                if(password_verify($password, $fetch['mypassword'])){
                    echo "logged in";
                    $_SESSION['username'] = $fetch['username'];
                    $_SESSION['email'] = $fetch['email'];
                    $_SESSION['user_id'] = $fetch['id'];
                    $_SESSION['image'] = $fetch['image'];

                    echo "<script>window.location.href='".APPURL."'</script>";


                }else{
                    echo "<script>alert('username or password is wrong');</script>";
                }
            }else{
                echo "<script>alert('This email is not registered');</script>";
            }




         }
        }

?>

    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL; ?>/assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Login Page
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>

                    <div class="card card-login mb-5">
                        <div class="card-body">
                            <form class="form-horizontal" method="POST" action="login.php">
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <input class="form-control" name="username" type="text" required="" placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input class="form-control" name="mypassword" type="password" required="" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                                        <!-- <div class="checkbox">
                                            <input id="checkbox0" type="checkbox" name="remember">
                                            <label for="checkbox0" class="mb-0"> Remember Me? </label>
                                        </div> -->
                                        <!-- <a href="login.html" class="text-light"><i class="fa fa-bell"></i> Forgot password?</a> -->
                                    </div>
                                </div>
                                <div class="form-group row text-center mt-4">
                                    <div class="col-md-12">
                                        <button type="submit" name="submit" class="btn btn-primary btn-block text-uppercase">Log In</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require "../includes/footer.php"; ?>
