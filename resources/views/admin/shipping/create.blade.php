@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid my-2">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Create Shipping</h1>
				</div>
				<div class="col-sm-6 text-right">
					<a href="{{ route('shipping.create') }}" class="btn btn-primary">Back</a>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="container-fluid">
            @include('admin.message')
		<form method="post" action="" id="shippingForm" name="shippingForm">
			@csrf
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<div class="mb-3">
								<select name="country" id="country" class="form-control">
								 <option value="">Select Country</option>
                                    @if ($countries->isNotEmpty())
                                     @foreach ($countries as $country )
									  <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                    <option value="rest_of_world">Rest of the World</option>
                                    @endif
								</select>
                                <p></p>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="mb-3">
								<input type="text" name="amount" id="amount" class="form-control" placeholder="Amount">
								<p></p>
							</div>
						</div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-primary">Create</button>
                        <div class="col-md-4">
					</div>
				  </div>
			   </div>
             </form>
           </div>
         </div>
          <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>Country</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if ($shippingcharges->isNotEmpty())

                    @foreach ($shippingcharges as $shippingcharge)
                        <tr>
                            <td>{{ $shippingcharge->id }}</td>
                            <td>{{ ($shippingcharge->country_id =='rest_of_world')?'Rest of the World': $shippingcharge->name}}</td>
                            <td>{{ '₹'.$shippingcharge->amount }}</td>
                            <td>
                                <a href="{{ route('shipping.edit',$shippingcharge->id) }}" class="btn btn-primary">Edit</a>
                                <a href="javascript:void(0)" onclick="deleteShipping({{ $shippingcharge->id }})" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
              </table>
          </div>
         </div>
        </div>
		<!-- /.card -->
	</section>

		@endsection
		@section('customeJS')
		<script>
		$('#shippingForm').submit(function(event){
			event.preventDefault();
			var element = $(this);
			$("button[type=submit]").prop('disabled',true);
			$.ajax({
				url : '{{route('shpping.store')}}',
				method : 'POST',
				data: element.serializeArray(),
				dataty : 'JSON',
				success:function(responce){
			     //console.log(responce);
                 $("button[type=submit]").prop('disabled',false);
				if(responce['status']==true){
					window.location.href="{{route('shipping.create') }}";

					$('#country').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    $('#amount').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
				}
				else{
					var errors = responce['errors'];
					if(errors['country']){
						$('#country').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['country']);

					}else{
						$('#country').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
					}
					if(errors['amount']){
						$('#amount').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['amount']);

					}else{
						$('#amount').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
					}
				  }

				}, error:function(jqXHR, exception){
					console.log('something went rowng!!');
				}

			});
		});

        function deleteShipping(id)
        {
			var url = '{{route("shipping.destroy","ID")}}';
			var newUrl = url.replace("ID",id);
			if(confirm("Are you want to delete shipping?")){
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
					window.location.href="{{route('shipping.create') }}";
				    }
			     }
			});
			}
		 }



      </script>
      @endsection
