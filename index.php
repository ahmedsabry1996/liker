<?php
ob_start();
require_once 'code/Liker.php';
$liker = new Liker();

if(!isset($_SESSION['user_id'])){
    
    header("location:http://localhost/oop_apps/Liker/login.php");
    die();
}

 $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<!-- Bootstrap CSS -->
    <link rel="stylesheet" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
	</head>
	<body>
		<h1 class="text-center"></h1>
        <div class="container">

        <div class="row text-center" >
           <div class="col-sm-4" id="posts">
            <?php  $liker->fetchPosts(); ?>
<br>
    <a href="logout.php?u=<?php echo $_SESSION['user_id'];?>" class="btn btn-warning">logout</a>

        </div></div>

    
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/ajax.js"></script>
	</body>
</html>
