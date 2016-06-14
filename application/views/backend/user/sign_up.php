<div class="container">
  <div class="row">
    <form class="form-signin" action="" method="post">
      <h3><b>Sign Up</b></h3>
      <?php echo  validation_errors();?>
      <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" class="form-control"  name="name" placeholder="Name" value="<?php echo set_value('email', '')?>">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control"  name="email" placeholder="Email" value="<?php echo set_value('email', '')?>">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control"  name="password" placeholder="Password">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password confirmation</label>
        <input type="password" class="form-control" name="password_confirmation" placeholder="Password">
      </div>
      <input type="submit" class="btn btn-primary" name="sign-up" value="Sign up" />
    </form>
  </div>
</div> <!-- /container -->
