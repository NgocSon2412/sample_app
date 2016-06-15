<div class="row">
  <aside class="col-md-4">
    <section class="user_info">
      <h1>
        <?php echo $user['name'];?>
      </h1>
    </section>
    <section class="stats">
      <div class="stats">
        <a href="/users/1/following">
          <strong id="following" class="stat">
            56
          </strong>
          following
        </a>
        <a href="/users/1/followers">
          <strong id="followers" class="stat">
            40
          </strong>
          followers
        </a>
      </div>
    </section>
    <section class="micropost_form">
      <form action="index.php/microposts/create" method="post">
        <div class="form-group">
          <label >Title</label>
          <input type="text" class="form-control" id="" placeholder="Title" name="title">
        </div>
        <div class="form-group">
          <label >Content</label>
          <textarea class="form-control" rows="5" id="" name="content"></textarea>
        </div>
        <input type="hidden" name="method" value="<?php echo $this->my_string->fullurl();?>" />
        <input type="submit" class="btn btn-default" value="Post" name="post">
      </form>
    </section>
  </aside> 
  <div class="col-md-8">
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
    // echo "ID:" .$authentication['id']."</br>";
    // echo "Name:" .$authentication['name']."</br>";
    // echo "Email:".$authentication['email']."</br>";  
    ?> 
    <h3>Microposts (<?php echo $count;?>)</h3>
    <ol class="microposts">
      <?php if (isset($list_microposts) && count($list_microposts)) {
        foreach ($list_microposts as $key => $value) {
          ?>
          <li id="micropost-<?php echo $value['id']?>">
            <span class="user"><a href="http://localhost/sample_app/index.php/users/<?php echo $value['user_id']?>"><?php echo $user['name'];?></a></span></br>
            <span class="title">
              Title:<?php echo $value['title'];?></br>     
            </span>
            <span class="content">
              Content: <?php echo $value['content']?> </br>          
            </span>
            <span class="timestamp">
            <?php
              $post_time=strtotime($value['created_at']) ;
              $now = time();
              if (($now - $post_time) < 60) {
                echo "Posted less than a minute ago." ;
              }else {
                echo 'Posted ' . timespan($post_time, $now) . ' ago';
              }
            ?>
            <?php 
              if ($authentication['id'] == $value['user_id']) {
              ?>
              <a class = "delete" href= "index.php/microposts/delete/<?php echo $value['id'];?>?redirect=<?php echo base64_encode($this->my_string->fullurl());?>">Delete</a>
              <?php
              }
            ?>
              
            </span>
          </li>
         <?php 
        }
      }
      ?>    
    </ol>
    <div class="col-sm-4 col-sm-offset-8" style="padding-left:0px;">
      <?php echo isset($list_pagination)? $list_pagination : ''; ?>    
    </div>
  </div>
</div>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $(".delete").click(function(){
        confirm("You sure?");
    });
});
</script>

