<?php echo  validation_errors();?>
<div class="col-sm-4">
	<h2>Xóa Lớp học</h2> </br>
	<form method="post" action="">
		<div class="form-group" >
			<label >Lớp :</label>
			<input type="text" class="form-control" name="class"  value="<?php echo $class['name'];?>" placeholder="Lớp">
		</div>
	  <input type="submit" name="delete" class="btn btn-default" value="Xóa lớp học" />
	</form>
</div>