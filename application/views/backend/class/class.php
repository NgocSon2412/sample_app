<h2 class="">Quản Lí danh sách lớp</h2>
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
<form method="post" action="">
    <div class="table-responsive" ">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th><div><label><input type="checkbox" id="checkAll"></label></div></th>
            <th>Lớp</th>
            <th>Ngày lập</th>
            <th>Ngày cập nhật</th>
            <th>Trạng thái</th>
            <th>id</th>
            <th>Thực hiện</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if(isset($list_class) && count($list_class)) {
            foreach ($list_class as $key => $value) {
              ?>
              <tr>
                <td><input type="checkbox" class = "ch" name= "checkbox[]" value = "<?php echo $value['id'];?>"/></td>
                <td><a href = "index.php/admin_class/show_class/<?php echo $value['id'];?>"> <?php echo $value['name'];?></a></td>
                <td><?php echo gmdate('H:i:s d/m/Y',strtotime($value['created_at'])+2*3600);?></td>
                <td><?php echo (($value['updated_at'] != '0000-00-00 00:00:00')? gmdate('H:i:s d/m/Y',strtotime($value['updated_at'])+2*3600) : '-');?></td>
                <td class = "center"><a href = "index.php/admin_class/set/publish/<?php echo $value['id'];?>/<?php echo (($value['publish']==0)? 1: 0) ;?>?redirect=<?php echo base64_encode($this->my_string->fullurl());?>"><img  class="img-responsive" src="template/fontend/image/<?php echo (($value['publish']==1)? 'right_icon.png':'wrong_icon.png' );?> "</a></td>
                <td><?php echo $value['id'];?></td>
                <td>
                  <a href= "index.php/admin_class/edit_class/<?php echo $value['id'];?>?redirect=<?php echo base64_encode($this->my_string->fullurl());?>">Sửa</a> | 
                  <a href= "index.php/admin_class/delete_class/<?php echo $value['id'];?>?redirect=<?php echo base64_encode($this->my_string->fullurl());?>">Xóa</a>
                  </td>
              </tr>
            <?php
            }
          } else {
            echo '<tr><td colspan="7">Không có dữ liệu</td></tr>';    
          }
          ?>
        </tbody>
      </table>
    </div>
    <div class="col-sm-8" style="padding-left:0px;">
      <div class="col-sm-4" style="padding-left:0px;">
        <select class="form-control" name="action" id="select-action">
          <option value="">Chọn thao tác ...</option>
          <option value="delete">Delete</option>
          <option value="publish">Publish</option>
          <option value="unpublish">Unpublish</option>
        </select>
      </div>
      <div class="col-sm-4" style="padding-left:0px;">
        <a href="#" id="link-submit" class="btn btn-default">Thực hiện</a>
        <input  style="display:none;" type="submit" name="submit" id = "btn-submit" class="btn btn-default" value="thực hiện" /> 
      </div>
    </div>
    <div class="col-sm-4" style="padding-left:0px;">
      <?php echo isset($list_pagination)? $list_pagination : ''; ?>    
    </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#link-submit").click(function(){
        if($("#select-action").val() == 'delete') {
          var fag = confirm("Bạn có muốn xóa lựa chọn!");
          if(fag == true) {
            $("#btn-submit").click();    
          } 
        }else {
          $("#btn-submit").click();
        }
         // alert($("#select-action").val());
        return false;
    });
    $("#checkAll").change(function () {
      $(".ch").prop('checked', $(this).prop("checked"));
  });
});

</script>