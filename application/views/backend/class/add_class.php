<div class="col-sm-4">
	<h2>Thêm Lớp học</h2> </br>
	<?php echo  validation_errors();?>
	<form method="post" action="">
	  <div class="form-group" >
	    <label >Lớp :</label>
	    <input type="text" class="form-control" name="class"  value="<?php echo set_value('class', '')?>" placeholder="Lớp">
	    <div class="checkbox">
		    <label>
		      <input type="checkbox" name = "trangthai" checked=""> Trạng thái
		    </label>
		</div>
	  </div>
	  <input type="submit" name="add_class" class="btn btn-default" value="Thêm lớp học" />
	</form>
</div>