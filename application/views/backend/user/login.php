<div class="container">
  <form class="form-signin" action="" method="post">
    <?php
    $message_flashdata = $this->session->flashdata('message_flashdata');;
    if(isset($message_flashdata) && count($message_flashdata)) {
      if($message_flashdata['type'] == 'seccessful') {
      ?>
        <p style="color:#5cb85c;"><?php echo $message_flashdata['message'];?></p>
      <?php
      }
      else if($message_flashdata['type'] == 'error') {
      ?>
        <p style="color:red;"><?php echo $message_flashdata['message'];?></p>
      <?php
      }
    }
    // print_r($list_class);
  ?>
    <h2 class="form-signin-heading">Đăng nhập</h2>
    <?php echo  validation_errors();?>
    <label for="inputEmail">Tài khoản :</label>
    <input type="email" id="inputEmail" class="form-control" name= "email" placeholder="Email address"  value="<?php echo set_value('email', '')?>" required autofocus>
    <label for="inputPassword" class="password">Mật khẩu:</label><a href="http://localhost/sample_app/index.php/authentication/forgot_password">(forgot password)</a>
    <input type="password" id="inputPassword" class="form-control" name = "password" placeholder="Password" required>
    <div class="checkbox">
      <label>
        <input type="checkbox" value="1" name="remember"> Remember me
      </label>
    </div>
    <input class="btn btn-lg btn-primary btn-block" type="submit" name = "login" value="Đăng nhập" />
    New user? <a href="http://localhost/sample_app/index.php/authentication/sign_up" type="submit"> Sign up now!</a>
  </form>
</div> <!-- /container -->
