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
									  <option {{ ($shippingcharge->country_id ==$country->id )?'selected' : ''}} value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                    <option {{ ($shippingcharge->country_id =='rest_of_world')?'selected' : ''}} value="rest_of_world">Rest of the World</option>
                                    @endif
								</select>
                                <p></p>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="mb-3">
								<input type="text" value="{{ $shippingcharge->amount }}" name="amount" id="amount" class="form-control" placeholder="Amount">
								<p></p>
							</div>
						</div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-primary">Update</button>
                        <div class="col-md-4">
					</div>
				  </div>
			   </div>
             </form>
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
				url : '{{route('shipping.update',$shippingcharge->id)}}',
				method : 'put',
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

      </script>
      @endsection
