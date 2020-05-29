<section class = "content">
	<div class = "row">
		<div class = "col-md-6">
			<div class = "box box-primary">
				<div class = "box-header with-border">
					<h3 class = "box-title">Add Category</h3>
				</div>

				<form id = "category_form">
					<div class ="box-body">
						<div class="form-group">
		                  <label for="exampleInputEmail1">Add Category</label>
		                  <input type="text" class="form-control" id="category" required="required">
		                </div>
					</div>

					<div class = "box-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	$("#category_form").submit(function(e){
		 e.preventDefault()
		 var category = $('#category').val()
		 $.post( "<?php echo base_url('api/category/store_add_category'); ?>",{ category: category}, function(data) {
	  		console.log(data)
		})
	})
</script>