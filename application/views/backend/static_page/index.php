<div class="row">
  <aside class="col-md-4">
    <section class="user_info">
      <h1>
        Admin
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
    // print_r($list_microposts);      
    ?> 
    <h3>Microposts (<?php echo $count;?>)</h3>
    <ol class="microposts">
      <?php if (isset($list_microposts) && count($list_microposts)) {
        foreach ($list_microposts as $key => $value) {
          ?>
          <li id="micropost-<?php echo $value['id']?>">
            <span class="user"><a href="/users/1">Admin</a></span></br>
            <span class="title">
              Title:<?php echo $value['title'];?></br>     
            </span>
            <span class="content">
              Content: <?php echo $value['content']?> </br>          
            </span>
            <span class="timestamp">
              Posted 5 days ago.
              <a data-confirm="You sure?" data-remote="true" rel="nofollow" data-method="delete" href="/microposts/343">delete</a>
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

