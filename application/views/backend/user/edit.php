<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <base href="http://localhost/sample_app/" ">
     <title>Sign Up</title>
    <link href="template/fontend/css/bootstrap.min.css" rel="stylesheet">
    <link href="template/fontend/css/dashboard.css" rel="stylesheet">
    <link href="template/fontend/css/signin.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Sample App</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Home</a></li>
            <li><a href="#">Help</a></li>
            <li><a href="index.php/authentication/login">Login</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>
    <div class="container">
      <div class="row">
        <form class="form-signin" action="" method="post">
          <h3><b>Edit</b></h3>
          <?php echo  validation_errors();?>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control"  name="email" placeholder="Email" value="<?php echo $authentication['email'];?>">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control"  name="password" placeholder="Password">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password confirmation</label>
            <input type="password" class="form-control" name="password_confirmation" placeholder="Password">
          </div>
          <input type="submit" class="btn btn-primary" name="edit" value="Edit" />
        </form>
      </div>
    </div> <!-- /container -->
  </body>
</html>

