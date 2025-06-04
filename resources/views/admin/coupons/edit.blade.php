@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid my-2">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Update Coupon</h1>
				</div>
				<div class="col-sm-6 text-right">
					<a href="{{ route('coupons.index') }}" class="btn btn-primary">Back</a>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="container-fluid">
		<form method="post" action="" id="CouponForm" name="CouponForm">
			@csrf
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="code">Code</label>
								<input type="text" value="{{ $coupenCode->code }}" name="code" id="code" class="form-control" placeholder="Coupon code">
								<p></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="name">Coupon Code Name</label>
								<input type="text" value="{{ $coupenCode->name }}" name="name" id="name" class="form-control" placeholder="Coupon Code Name">
								<p></p>
							</div>
						</div>

                        <div class="col-md-12">
							<div class="mb-3">
								<label for="description">Discription</label>
								<textarea name="description" id="description" class="form-control" placeholder="Description">{{ $coupenCode->description }}</textarea>
								<p></p>
							</div>
						</div>

                        <div class="col-md-6">
							<div class="mb-3">
								<label for="max_uses">Max uses</label>
								<input type="number" value="{{ $coupenCode->max_uses }}"  name="max_uses" id="max_uses" class="form-control" placeholder="Max uses">
								<p></p>
							</div>
						</div>

                        <div class="col-md-6">
							<div class="mb-3">
								<label for="max_uses_user">Max Uses User</label>
								<input type="number" value="{{ $coupenCode->max_uses_user }}" name="max_uses_user" id="max_uses_user" class="form-control" placeholder="Max Uses User">
								<p></p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-3">
								<label for="type">type</label>
								<select name="type" id="type" class="form-control">
									<option {{ ($coupenCode->type == 'percent') ? 'selected' : '' }} value="percent">Percent</option>
									<option  {{ ($coupenCode->type == 'fixed') ? 'selected' : '' }} value="fixed">Fixed</option>
								</select>
							</div>
						</div>
                        <div class="col-md-6">
							<div class="mb-3">
								<label for="discount_amount">Discount Amount</label>
								<input type="number" value="{{ $coupenCode->discount_amount }}" name="discount_amount" id="discount_amount" class="form-control" placeholder="Discount Amount">
								<p></p>
							</div>
						</div>

                        <div class="col-md-6">
							<div class="mb-3">
								<label for="min_amount">Min Amount</label>
								<input type="number" value="{{ $coupenCode->min_amount }}" name="min_amount" id="min_amount" class="form-control" placeholder="Min Amount">
								<p></p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-3">
								<label for="status">status</label>
								<select name="status" id="status" class="form-control">
									<option {{ ($coupenCode->status == '1') ? 'selected' : '' }} value="1">Active</option>
									<option {{ ($coupenCode->status == '0') ? 'selected' : '' }} value="0">Block</option>
								</select>
							</div>
						</div>

                        <div class="col-md-6">
							<div class="mb-3">
								<label for="starts_at">Starts At</label>
								<input type="text" value="{{ $coupenCode->starts_at }}" name="starts_at" id="starts_at" class="form-control" placeholder="Starts At">
								<p></p>
							</div>
						</div>

                        <div class="col-md-6">
							<div class="mb-3">
								<label for="min_amount">Expires At</label>
								<input type="text" value="{{ $coupenCode->expires_at }}"  name="expires_at" id="expires_at" class="form-control" placeholder="Expires At">
								<p></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="pb-5 pt-3">
				<button type="submit" class="btn btn-primary">Update</button>
				<a href="{{ route('coupons.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
			</div>

			</form>
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
		@endsection

		@section('customeJS')
		<script>

         $(document).ready(function(){
            $('#starts_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });

            $('#expires_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
        });


		$('#CouponForm').submit(function(event){
			event.preventDefault();
			var element = $(this);
			$("button[type=submit]").prop('disabled',true);
			$.ajax({
				url : '{{route("coupons.update",$coupenCode->id)}}',
				method : 'put',
				data: element.serializeArray(),
				dataty : 'JSON',
				success:function(responce){
			     //console.log(responce);
                 $("button[type=submit]").prop('disabled',false);
				if(responce['status']==true){
					window.location.href="{{route('coupons.index') }}";

					$('#code').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    $('#discount_amount').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
				}
				else{
					var errors = responce['errors'];
					if(errors['code']){
						$('#code').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['code']);

					}else{
						$('#code').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
					}
					if(errors['discount_amount']){
						$('#discount_amount').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['discount_amount']);

					}else{
						$('#discount_amount').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
					}

                    if(errors['status']){
						$('#status').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['status']);

					}else{
						$('#status').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
					}


                    if(errors['type']){
						$('#type').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['type']);

					}else{
						$('#type').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
					}

                    if(errors['starts_at']){
						$('#starts_at').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['starts_at']);

					}else{
						$('#starts_at').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
					}

                    if(errors['expires_at']){
						$('#expires_at').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['expires_at']);

					}else{
						$('#expires_at').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
					}
				}

				}, error:function(jqXHR, exception){
					console.log('something went rowng!!');
				}

			   });
		     });

		</script>

		@endsection
