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
  echo "ID:" .$authentication['id']."</br>";
  echo "Name:" .$authentication['name']."</br>";
  echo "Email:".$authentication['email']."</br>";
?>
