@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid my-2">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Create Banner</h1>
				</div>
				<div class="col-sm-6 text-right">
					<a href="{{ route('banners.index') }}" class="btn btn-primary">Back</a>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="container-fluid">
		<form method="post" action="" id="bannerForm" name="bannerForm">
			@csrf
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
								<label for="title">Title</label>
								<input type="text" name="title" value="{{ $banner->title }}" id="title" class="form-control" placeholder="Title">
								<p></p>
							</div>
						</div>
						<div class="col-md-12">
                            <div class="mb-3">
                                <label for="description">Content</label>
                                <textarea name="content" id="content" cols="30" rows="10" class="summernote" placeholder="Content">{{ $banner->content }}</textarea>
                                <p class="error"></p>
                            </div>
                        </div>
						<div class="col-md-12">
						   <div class="mb-3">
						   <input type="hidden" name="banner_image" id="banner_image" value="">
							 <label for="status">Image</label>
						     <div id="image" class="dropzone dz-clickable">
							 <div class="dz-message needsclick">
							  <br>Drop files here or click to upload.<br><br>
						   </div>
						</div>
						</div>
                        @if(!empty($banner->banner_image))
                        <div>
                        <img src="{{ asset('uploads/banner/large/'.$banner->banner_image ) }}" widht="150" height="150">
                        </div>
                      @endif
						</div>
						<div class="col-md-3">
							<div class="mb-3">
								<label for="status">Status</label>
								<select name="status" id="status" class="form-control">
									<option {{($banner->status ==1)?'selected' : ''}} value="1">Active</option>
									<option {{($banner->status ==0)?'selected' : ''}} value="0">Deactive</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="pb-5 pt-3">
				<button type="submit" class="btn btn-primary">Update</button>
				<a href="{{ route('banners.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
			</div>
		</form>
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
		@endsection

		@section('customeJS')
		<script>
		$('#bannerForm').submit(function(event){
			event.preventDefault();
			var element = $(this);
			$("button[type=submit]").prop('disabled',true);
			$.ajax({
				url : "{{route('banners.update',$banner->id)}}",
				method : 'put',
				data: element.serializeArray(),
				dataty : 'JSON',
				success:function(responce){
			     //console.log(responce);
                 $("button[type=submit]").prop('disabled',false);
				if(responce['status']==true){
					window.location.href="{{route('banners.index') }}";

					$('#title').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    $('#content').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
				}
				else{
					var errors = responce.errors;
					if(errors.title){
						$('#title').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.title);

					}else{
						$('#title').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
					}
					if(errors.content){
						$('#content').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.content);

					}else{
						$('#content').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
					}
				}

				}, error:function(jqXHR, exception){
					console.log('something went rowng!!');
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
				acceptedFiles: "image/jpeg,image/png,image/gif",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}, success: function(file, response){
					$("#banner_image").val(response.image_id);
					 //console.log(response)
				}
			});
		</script>

		@endsection
