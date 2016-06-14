<div class="row">
  <div class="col-md-4 col-md-offset-4 main">
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
</div>