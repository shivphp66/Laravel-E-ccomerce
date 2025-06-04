@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Ratings</h1>
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
							<button type="button" onclick="window.location.href='{{route('products.productRating') }}' " class="btn btn-default btn-sm">Reset</button></div>
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
											<th>ID</th>
											<th>Product</th>
											<th>Rating</th>
											<th>Comment</th>
											<th>UserName</th>
											<th width="100">Status</th>
										</tr>
									</thead>
									<tbody>
									@if ($ratings->isnotEmpty())
									@foreach($ratings as $rating)
										<tr>
											<td>{{ $rating->id }}</td>
											<td>{{ $rating->productTitle }}</td>
                                            <td>{{ $rating->rating }}</td>
											<td>{{ $rating->comment }}</td>
											<td>{{ $rating->username }}</td>
							   <td>
								@if ($rating->status==1)
                                <a href="javascript:void(0)" onclick="changeRatingStatus(0,'{{ $rating->id }}')">
								<svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
									<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								</svg>
                                </a>
								@else
                                <a href="javascript:void(0)" onclick="changeRatingStatus(1,'{{ $rating->id }}')">
								 <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
				                 <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
				                 </svg>
                                </a>
								@endif
							</td>
						</tr>
						@endforeach
						@else
						<tr>
						    <td colspan="8">Product Rating Not Found!!</td>
						</tr>
						@endif
					</tbody>
				</table>
			</div>
			<div class="card-footer clearfix">
			 {{ $ratings->onEachSide(10)->links('pagination::bootstrap-5') }}
			</div>
		</div>
	</div>
<!-- /.card -->
</section>
<!-- /.content -->
		@endsection
		@section('customeJS')
		<script>
         function changeRatingStatus(status,ratingId)
		 {
			if(confirm("Are you want to change Product Rating status?")){
				$.ajax({
				url: '{{route("products.updateProductRating")}}',
				method : 'get',
				data: {status:status,ratingId:ratingId},
				dataType : 'JSON',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success:function(responce)
				{
				   if(responce['status']==true){
					window.location.href="{{route('products.productRating') }}";
				   }
			     }
			});
			}
		 }
		</script>
		@endsection
