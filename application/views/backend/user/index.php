<h3>All users (<?php echo $count;?>)</h3>
<ol class="users">
  <?php if (isset($list_users) && count($list_users)) {
    foreach ($list_users as $key => $value) {
      ?>
      <li id="micropost-<?php echo $value['id']?>">
        <span class="user"><a href="http://localhost/sample_app/index.php/users/show/<?php echo $value['id']?>"><?php echo $value['name'];?></a></span> 
        <?php 
          if ($authentication['role_id'] == 1) {
            ?>
            | <a class = "delete" href= "index.php/users/delete/<?php echo $value['id'];?>?redirect=<?php echo base64_encode($this->my_string->fullurl());?>">Delete</a>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $(".delete").click(function(){
        confirm("You sure?");
    });
});
</script>