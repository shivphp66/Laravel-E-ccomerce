@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
	<section class="content-header">					
		<div class="container-fluid my-2">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Update Category</h1>
				</div>
				<div class="col-sm-6 text-right">
					<a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="container-fluid">
		<form method="post" action="" id="CategoryForm" name="CategoryForm">
			@csrf
			<div class="card">
				<div class="card-body">								
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="name">Name</label>
								<input type="text" name="name" id="name" value="{{ $category->name }}" class="form-control" placeholder="Name">
								<p></p>	
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="slug">Slug</label>
								<input type="text" name="slug" value="{{ $category->slug }}" id="slug" class="form-control" placeholder="Slug" readonly>
								<p></p>	
							</div>
						</div>
						<div class="col-md-6">
						   <div class="mb-3">
						   <input type="hidden" name="image_id" id="image_id" value="">
							 <label for="status">Image</label>
						     <div id="image" class="dropzone dz-clickable">
							 <div class="dz-message needsclick">    
							  <br>Drop files here or click to upload.<br><br>                                            
						   </div>
						</div>
						</div>

                        @if(!empty($category->image))
                        <div>
                        <img src="{{ asset('uploads/category/thumb/'.$category->image ) }}" widht="150" height="150">

                        </div>
                      @endif
						</div>

                        
						<div class="col-md-6">
							<div class="mb-3">
								<label for="status">Status</label>
								<select name="status" id="status" class="form-control"> 
									<option {{ $category->status ==1 ? 'selected':'' }} value="1">Active</option>
									<option {{ $category->status ==0 ? 'selected':'' }} value="0">Deactive</option>
								</select>	
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="mb-3">
								<label for="showHome">show On Home</label>
								<select name="showHome" id="showHome" class="form-control"> 
									<option {{ $category->showHome =='Yes' ? 'selected':'' }} value="Yes">Yes</option>
									<option {{ $category->showHome =='No' ? 'selected':'' }} value="No">No</option>
								</select>	
							</div>
						</div>
					</div>
				</div>							
			</div>
			
			<div class="pb-5 pt-3">
				<button type="submit" class="btn btn-primary">Update</button>
				<a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
			</div>
			
			</form>
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
		@endsection
		
		@section('customeJS')
		<script>
		$('#CategoryForm').submit(function(event){
			event.preventDefault();
			var element = $(this);
			$("button[type=submit]").prop('disabled',true);
			$.ajax({
				url : '{{route('categories.update',$category->id)}}',
				method : 'put',
				data: element.serializeArray(),
				dataType : 'JSON',
				success:function(responce){
			     //console.log(responce); 
                 $("button[type=submit]").prop('disabled',false);
				if(responce['status']==true){
					window.location.href="{{route('categories.index') }}";

					$('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
				}
				else{
                    if(responce['notFound']==true){
                        window.location.href="{{ route('categories.index') }}";
                    }
                    
					var errors = responce['errors'];
					if(errors['name']){
						$('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
					
					}else{
						$('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
					}
					if(errors['slug']){
						$('#slug').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['slug']);
					
					}else{
						$('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
					} 
				}
	
				}, error:function(jqXHR, exception){
					console.log('something went rowng!!'); 
				}
				
			});					 
		});
     
	$('#name').change(function(){
		var element = $(this);
		$("button[type=submit]").prop('disabled',true);
		$.ajax({
				url : '{{route('getSlug')}}',
				method : 'get',
				data: {title:element.val()},
				dataType : 'JSON',
				success:function(responce){
					$("button[type=submit]").prop('disabled',false);
					//console.log(responce); 

					if(responce['status'] == true){
						$("#slug").val(responce["slug"]);

					}
				} 

				});

	       });

		   Dropzone.autoDiscover = false;    
			const dropzone = $("#image").dropzone({ 
				init: function() {
					this.on('addedfile', function(file) {
						if (this.files.length > 1) {
							this.removeFile(this.files[0]);
						}
					});
				},
				url:  "{{ route('temp-images.create') }}",
				maxFiles: 1,
				paramName: 'image',
				addRemoveLinks: true,
				acceptedFiles: "image/jpeg,image/png,image/webp,image/gif",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}, success: function(file, response){
					$("#image_id").val(response.image_id);
					//console.log(response)
				}
			});
		</script>
		
		@endsection