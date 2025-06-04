@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Update Product</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->

					<div class="container-fluid">
					<form method="post" action="" name="productForm" id="productForm">
						@csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" value="{{ $product->title }}" id="title" class="form-control" placeholder="Title">
													<p class="error"></p>
                                                </div>
                                            </div>
											<div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="slug">Slug</label>
                                                    <input type="text" name="slug" id="slug" value="{{ $product->slug }}" class="form-control" placeholder="Slug">
													<p class="error"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="short_description">Short Description</label>
                                                    <textarea name="short_description" id="short_description" cols="30" rows="10" class="summernote" placeholder="Short Description">{{ $product->short_description }}</textarea>
													<p class="error"></p>
												</div>
                                            </div>

											<div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description">{{ $product->description }}</textarea>
													<p class="error"></p>
												</div>
                                            </div>

											<div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="shipping_returns">Shipping and Returns</label>
                                                    <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote" placeholder="Shipping and Returns">{{ $product->shipping_returns }}</textarea>
													<p class="error"></p>
												</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Media</h2>
                                        <div id="image" class="dropzone dz-clickable">
                                            <div class="dz-message needsclick">
                                                <br>Drop files here or click to upload.<br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="row" id="product-gallery">
									@if($ProductImage->isNotEmpty())
									@foreach($ProductImage as $image)
									<div class="col-md-3" id="image-row-{{$image->id}}"><div class="card">
										<input type="hidden" name="array_image[]" value="${response.image_id}">
										<img src="{{ asset('uploads/product/small/'.$image->image) }}" class="card-img-top" alt="...">
										<div class="card-body">
										<a href="javascript:void(0);" onclick="deleteImage({{$image->id}})" class="btn btn-danger">Remove</a>
										</div>
										</div>
									</div>
                                    @endforeach
									@endif
                               </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Pricing</h2>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="price">Price</label>
                                                    <input type="text" name="price" value="{{ $product->price }}" id="price" class="form-control" placeholder="Price">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="compare_price">Compare at Price</label>
                                                    <input type="text" name="compare_price" value="{{ $product->compare_price }}" id="compare_price" class="form-control" placeholder="Compare Price">
                                                    <p class="error"></p>
													<p class="text-muted mt-3">
                                                        To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Inventory</h2>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="sku">SKU (Stock Keeping Unit)</label>
                                                    <input type="text" name="sku" value="{{ $product->sku }}" id="sku" class="form-control" placeholder="sku">
													<p class="error"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="barcode">Barcode</label>
                                                    <input type="text" name="barcode" id="barcode" value="{{ $product->barcode }}" class="form-control" placeholder="Barcode">
													<p class="error"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="No" {{ ($product->track_qty == 'Yes')? 'checked' : '' }}>
                                                        <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="number" min="0" name="qty" value="{{ $product->qty }}"  id="qty" class="form-control" placeholder="Qty">
													<p class="error"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Related product</h2>
                                        <div class="mb-3">

                                            <select class="related-products w-100" name="related_products[]" id="related_products" multiple>
                                              @if(!empty($relatedProduct))
											  @foreach($relatedProduct as $relProduct)
											     <option selected value="{{ $relProduct->id }}" >{{ $relProduct->title }}</option>
												 @endforeach
											  @endif
										</select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Product status</h2>
                                        <div class="mb-3">
                                            <select name="status" id="status" class="form-control">
                                                <option {{ $product->status ==1 ? "selected" : "" }} value="1">Active</option>
                                                <option {{ $product->status ==0 ? "selected" : "" }} value="0">Block</option>
                                            </select>
											<p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="h4  mb-3">Product category</h2>
                                        <div class="mb-3">
                                            <label for="category">Category</label>
                                            <select name="category" id="category" class="form-control">
											<option value="">Select Category</option>
												@foreach($categories as $category)
                                                <option {{ $product->category_id ==$category->id ? 'selected': '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
											<p class="error"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label for="subcategory">Sub category</label>
                                            <select name="sub_category" id="sub_category" class="form-control">
											<option value="">Select Sub Category</option>
											@foreach($subcategories as $subcategory)
                                                <option {{ ($product->sub_category_id==$subcategory->id) ? 'selected' :'' }} value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                                @endforeach
                                            </select>
											<p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Product brand</h2>
                                        <div class="mb-3">
                                            <select name="brand_id" id="brand_id" class="form-control">
                                                <option value="">Select Brand</option>
                                                @foreach($brands as $brand)
                                                <option {{ ($product->brand_id==$brand->id) ? 'selected': '' }} value="{{ $brand->id }}">{{ $brand->name }}</option>
                                               @endforeach
                                            </select>
											<p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Featured product</h2>
                                        <div class="mb-3">
                                            <select name="is_featured" id="is_featured" class="form-control">
                                                <option {{ ($product->is_featured=='No') ? 'selected': '' }} value="No">No</option>
                                                <option {{ ($product->is_featured=='Yes') ? 'selected': '' }} value="Yes">Yes</option>
                                            </select>
											<p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="pb-5 pt-3">
							<button type="submit" class="btn btn-primary">Update</button>
							<a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
						</form>
					</div>

					<!-- /.card -->
				</section>

	<!-- /.content -->
		@endsection

		@section('customeJS')
		<script>
			$('.related-products').select2({
			ajax: {
					url : '{{ route("products.getProducts") }}',
					tags : true,
					multiple : true,
					minimumInputLength: 3,
					allowClear: true,
					dataType : 'JSON',
					processResults:function(data){
						return {
						   results: data.tags
						};
					}
			}
		});

		$('#productForm').submit(function(event){
			event.preventDefault();
			var element = $(this);
			//$("button[type=submit]").prop('disabled',true);
			$.ajax({
				url : '{{route("products.update",$product->id)}}',
				method : 'PUT',
				data: element.serializeArray(),
				dataType : 'JSON',
				success:function(responce){
			     //console.log(responce);
                 //$("button[type=submit]").prop('disabled',false);
				if(responce['status']==true){
                    $('.error').removeClass('is-invalid').removeClass('invalid-feedback').html("");
					$("input[type='text'],select,input[type='number']").removeClass('is-invalid');
					window.location.href="{{route('products.index') }}";
				}
				else{
					var errors = responce['errors'];
					$.each(errors, function(key,value){
					$(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(value);
					});
				}

				}, error:function(jqXHR, exception){
					console.log('something went rowng!!');
				}
			});
		});

	$('#title').change(function(){
		var element = $(this);
		$("button[type=submit]").prop('disabled',true);
		$.ajax({
				url : '{{route('getSlug')}}',
				method : 'get',
				data: {title:element.val()},
				dataty : 'JSON',
				success:function(responce){
					$("button[type=submit]").prop('disabled',false);
					//console.log(responce);
					if(responce['status'] == true){
						$("#slug").val(responce["slug"]);
					}
				  }
				});
	      });

		   $('#category').change(function(){
			var category_id =  $(this).val();
			$.ajax({
					url : '{{route("products-subcategories.index")}}',
					method : 'get',
					data: { category_id:category_id },
					dataty : 'JSON',
					success:function(responce){
						//console.log(responce);
						if(responce['status'] == true){
							$("#sub_category").find("option").not(":first").remove();
							$.each(responce['subCategory'],function(key, item){
								$("#sub_category").append(`<option value='${item.id} '>${item.name}</option>`);
							});
						}
					} , error:function()
					     {
							console.log(responce);
						   }

					});

			});

		   Dropzone.autoDiscover = false;
			const dropzone = $("#image").dropzone({
				url:  "{{ route('product-images.update') }}",
				maxFiles: 10,
				paramName: 'image',
				params : {'product_id':'{{$product->id }}'},
				addRemoveLinks: true,
				acceptedFiles: "image/jpeg,image/png,image/webp,image/gif",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}, success: function(file, response){
					//$("#image_id").val(response.image_id);
					//console.log(response)

                  var html = `<div class="col-md-3" id="image-row-${response.image_id}"><div class="card">
				              <input type="hidden" name="array_image[]" value="${response.image_id}">
					          <img src="${response.ImagePath}" class="card-img-top" alt="...">
					          <div class="card-body">
						      <a href="javascript:void(0);" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Remove</a>
					          </div>
					          </div></div>`;
					         $("#product-gallery").append(html);
				          },
						  complete:function(file){
                              this.removeFile(file);
						  }
			         });

             function deleteImage(id){
                $("#image-row-"+id).remove();
				if(confirm("are you delete image?")){
				$.ajax({
					url:'{{route("product-images.destroy")}}',
					type : 'delete',
                     data : {id:id},
					success:function(responce){
						if(responce.status == true){
							alert(responce.message);
						}
						else{
							alert(responce.message);
						}
					}
				});
			   }
			}
			  $("#track_qty").on('change', function() {
				if ($(this).is(':checked')) {
					$(this).attr('value', 'Yes');
				} else {
					$(this).attr('value', 'No');
				}
				var ck = $('#track_qty').val();
				});

		</script>
		@endsection
