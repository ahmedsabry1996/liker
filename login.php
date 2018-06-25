<?php
ob_start();
session_start();
$user_name = $_POST['username'];

if(!empty($user_name)){
    
    $_SESSION['user_id']=  $user_name;
    header("location:http://localhost/oop_apps/liker");
}

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
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" role="form">

	<div class="form-group">
		<label for="">username</label>
		<input type="text" class="form-control" name="username" placeholder="Input field">
	</div>



	<button type="submit" class="btn btn-primary">Submit</button>
</form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
	</body>
</html>
