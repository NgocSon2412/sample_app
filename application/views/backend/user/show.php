<div class="row">
  <aside class="col-md-4">
    <section class="user_info">
      <h1>
        <?php echo $user['name'];?>
      </h1>
    </section>
    <section class="stats">
      <div class="stats">
        <a href= "index.php/users/show/<?php echo $user['id'];?>/following">
          <strong id="following" class="stat">
            <?php echo count($this->Model_relationship->followings($user['id'])) ;?>
          </strong>
          following
        </a>
        <a href= "index.php/users/show/<?php echo $user['id'];?>/followers">
          <strong id="followers" class="stat">
            <?php echo count($this->Model_relationship->followers($user['id'])) ;?>
          </strong>
          followers
        </a>
      </div>
    </section>
    <?php 
      if($authentication['id'] == $user['id']) {
        ?>
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
        <?php 
      }elseif ($this->Model_relationship->following($authentication['id'],$user['id'])) {
        ?>
        <form action = "index.php/relationships/delete" method = "post">
          <input type="hidden" name="method" value="<?php echo $user['id'];?>" />
          <input type="submit" name="unfollow" value="Unfollow" class="btn" />
        </form>
        <?php
      }else{
        ?>
        <form action = "index.php/relationships/create" method = "post">
          <input type="hidden" name="method" value="<?php echo $user['id'];?>" />
          <input type="submit" name="follow" value="follow" class="btn btn-primary" />
        </form>
        <?php
      }
    ?>   
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
            <span class="user"><a href="http://localhost/sample_app/index.php/users/show/<?php echo $value['user_id']?>"><?php echo $user['name'];?></a></span></br>
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
              <a class = "delete" href= "index.php/microposts/delete/<?php echo $value['id'];?>?redirect=<?php echo base64_encode($this->my_string->fullurl());?>">Delete</a></br>
              <?php
              }
            ?>      
            </span>
          </li>
          <?php if(($this->Model_relationship->following($authentication['id'],$user['id'])) || ($authentication['id']) == $user['id']) {
            ?>
            <?php
              if ($this->Model_like->check_liking($authentication['id'],$value['id'])) {       
                  ?>
                  <form action = "index.php/likes/delete" method = "post" style="display:inline">
                    <input type="hidden" name="post_id" value="<?php echo $value['id'];?>" />
                    <input type="hidden" name="method" value="<?php echo $this->my_string->fullurl();?>" />
                    <input type="submit" name = "unlike" class="btn btn-link" value="Unlike">
                  </form>
                  <?php
                }else{
                  ?>
                  <form action = "index.php/likes/create" method = "post" style="display:inline">
                    <input type="hidden" name="post_id" value="<?php echo $value['id'];?>" />
                    <input type="hidden" name="method" value="<?php echo $this->my_string->fullurl();?>" />
                    <input type="submit" name = "like" class="btn btn-link" value="Like">
                  </form>
                  <?php
                }
            ?>   
            <input type="submit" class="btn btn-link btn-comment" value="Comment">
            <p><b><?php echo $this->Model_like->count_like($value['id']);?> Like </b></p>
            <div class = "all_comment">
              <div class="comment_form">
                <div class="form-group">
                  <form action="index.php/comments/create" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $value['id'];?>" />
                    <input type="hidden" name="method" value="<?php echo $this->my_string->fullurl();?>" />
                    <input placeholder="Write a comment..." class="form-control" type="text" name="content" id="comment_content" />
                    <input type="submit" class="comment btn btn-default " value="Comment" name="comment">
                  </form>  
                </div>
              </div>
            <?php
            if (isset($list_comments) && count($list_comments)) {
              foreach ($list_comments as $key => $value1) {
                foreach ($value1 as $key => $val) {
                  if($val['post_id'] == $value['id']) {
                    ?>
                    <li class ="comments" id="comment-<?php echo $val['comment_id']?>" style="border-top: 1px solid #fff;">
                      <span class="user"><a href="http://localhost/sample_app/index.php/users/<?php echo $val['user_id']?>"><?php echo $val['name'];?></a></span>:
                      <span class="content">
                        <?php echo $val['content']?> </br>          
                      </span>
                      <span class="timestamp">
                      <?php
                        $post_time=strtotime($val['comment_created_at']) ;
                        $now = time();
                        if (($now - $post_time) < 60) {
                          echo "Posted less than a minute ago." ;
                        }else {
                          echo 'Posted ' . timespan($post_time, $now) . ' ago';
                        }
                      ?>
                      <?php
                        if (($authentication['id'] == $val['user_id'])||($authentication['id'] == $value['user_id'])) {
                          ?>
                          <a class = "delete" href= "index.php/comments/delete/<?php echo $val['comment_id'];?>?redirect=<?php echo base64_encode($this->my_string->fullurl());?>">Delete</a>
                          <?php
                        }
                      ?>
                      </span>
                    </li>
                    <?php
                  }
                }
              }
            }
          ?>
          </div>
            <?php
          }
          ?>
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
    $(".btn-comment").click(function(){
        $(".all_comment").toggle();
    });
});
</script>

