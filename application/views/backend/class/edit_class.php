<h2>Sửa Lớp học</h2> </br>
<?php echo  validation_errors();?>
<div class="col-sm-4">
	<form method="post" action="">
		<div class="form-group" >
			<label >Lớp :</label>
			<input type="text" class="form-control" name="class"  value="<?php echo $class['name'];?>" placeholder="Lớp">
		</div>
		<div class="checkbox">
		    <label>
		      <input type="checkbox" name = "trangthai" <?php echo ($class['publish'] == 0)?" ":'checked=""';?>  > Trạng thái
		    </label>
		</div>
	  <input type="submit" name="edit" class="btn btn-default" value="Sửa lớp học" />
	</form>
</div>