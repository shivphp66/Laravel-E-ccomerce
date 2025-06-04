@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Products</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('products.create') }}" class="btn btn-primary">New Product</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
					@include('admin.message')
						<div class="card">
						<form method="get" action="">
							<div class="card-header">
							<div class="card-title">
							<button type="button" onclick="window.location.href='{{route('products.index') }}' " class="btn btn-default btn-sm">Reset</button>
							</div>
								<div class="card-tools">								
									<div class="input-group input-group" style="width: 250px;">
										<input type="text" name="keyword" value="{{Request::get('keyword')}}" class="form-control float-right" placeholder="Search">
					
										<div class="input-group-append">
										  <button type="submit" name="search" class="btn btn-default">
											<i class="fas fa-search"></i>
										</button>
										</div>
									  </div>
                                </form>

								</div>
							</div>
							<div class="card-body table-responsive p-0">								
								<table class="table table-hover text-nowrap">
									<thead>
										<tr>
											<th width="60">ID</th>
											<th width="80"></th>
											<th>Product</th>
											<th>Price</th>
											<th>Qty</th>
											<th>SKU</th>
											<th width="100">Status</th>
											<th width="100">Action</th>
										</tr>
									</thead>
									<tbody>
									@if ($product->isnotEmpty())
									@foreach($product as $row)	

									@php 
									    $productImge = $row->product_image->first();									
									@endphp
										<tr>
											<td>{{ $row->id }}</td>
											<td>
											@if(!empty($productImge->image))											
											<img src="{{asset('uploads/product/small/'.$productImge->image )}}" class="img-thumbnail" width="50" >
										   @else
										   <img src="{{asset('admin-assets/img/default-150x150.png')}}" class="img-thumbnail" width="50" >
											
											@endif
										    </td>
											<td><a href="#">{{ $row->title }}</a></td>
											<td>{{ $row->price }}</td>
											<td>{{ $row->qty }}</td>
											<td>{{ $row->sku }}</td>											
											<td>
								@if ($row->status)				
								<svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
									<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								</svg>
								@else
								 <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
				                 <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
				                 </svg>
								@endif
							</td>
							<td>
								<a href="{{ Route('products.edit',$row->id) }}">
									<svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
										<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
									</svg>
								</a>
								<a href="#" onclick="productDelete({{ $row->id}})" class="text-danger w-4 h-4 mr-1">
									<svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
										<path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
									</svg>
								</a>
							</td>
						</tr>
						@endforeach
						@else
						<tr>
						    <td colspan="8">Product NOT Found!!</td>
						</tr>
						@endif
					</tbody>
				</table>										
			</div>
			<div class="card-footer clearfix">

			{{ $product->onEachSide(10)->links('pagination::bootstrap-5') }}
				
			</div>
		</div>
	</div>
<!-- /.card -->
</section>
<!-- /.content -->
		@endsection
		
		@section('customeJS')
		<script>
         function productDelete(id)
		 {
			var url = '{{route("products.delete","ID")}}';
			var newUrl = url.replace("ID",id);
			if(confirm("Are you want to delete Product?")){
				$.ajax({
				url : newUrl,
				method : 'delete',
				data: {},
				dataType : 'JSON',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success:function(responce)
				{
			     //console.log(responce);                  
				   if(responce['status']==true){
					window.location.href="{{route('products.index') }}";
				    }
			     }
			}); 
			}
		 }
		</script>
		@endsection