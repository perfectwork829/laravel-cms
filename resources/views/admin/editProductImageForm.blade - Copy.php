<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="editProductImagesModalLabel">Edit Image</h4>
</div>
  {!! Form::open(array('url' =>'admin/addNewProductAttribute', 'name'=>'editImageFrom', 'id'=>'editImageFrom', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
	  {!! Form::hidden('products_id',  $result[0]->products_id, array('class'=>'form-control', 'id'=>'products_id')) !!}
	  {!! Form::hidden('id',  $result[0]->id, array('class'=>'form-control', 'id'=>'id')) !!}
	  {!! Form::hidden('oldImage',  $result[0]->image , array('id'=>'oldImage')) !!}
<div class="modal-body">

   <div class="form-group">
	  <label for="name" class="col-sm-2 col-md-4 control-label">Image</label>
	  <div class="col-sm-10 col-md-8">
		  {!! Form::file('newImage', array('id'=>'newImage')) !!}<br>
		  <img src="{{asset('').$result[0]->image}}" alt="" width=" 100px">
	  </div>
	</div>

   <div class="form-group">
	  <label for="name" class="col-sm-2 col-md-4 control-label">Sort Order</label>
	  <div class="col-sm-10 col-md-8">
		   {!! Form::text('sort_order',  $result[0]->sort_order, array('class'=>'form-control', 'id'=>'sort_order')) !!}
	  </div>
	</div>


	<div class="form-group">
	  <label for="name" class="col-sm-2 col-md-4 control-label">Description</label>
	  <div class="col-sm-10 col-md-8">
		 {!! Form::textarea('htmlcontent',  $result[0]->htmlcontent, array('class'=>'form-control', 'id'=>'htmlcontent', 'colspan'=>'3' )) !!}
	  </div>
	</div>
	<div class="alert alert-danger addError" style="display: none; margin-bottom: 0;" role="alert"><i class="icon fa fa-ban"></i>Please choose an image. </div>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-primary" id="updateProductImage">Update Image</button>
</div>
  {!! Form::close() !!}