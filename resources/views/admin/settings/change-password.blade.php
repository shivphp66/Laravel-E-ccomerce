@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid my-2">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Change Password</h1>
				</div>
				<div class="col-sm-6 text-right">
					<a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Back</a>
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
            <form method="POST" action="" name="changePasswordForm" id="changePasswordForm">
			@csrf
			<div class="card">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="mb-3">
                            <label for="name">Old Password</label>
                            <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                           <p></p>
                        </div>
                        <div class="mb-3">
                            <label for="name">New Password</label>
                            <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">
                            <p></p>
                        </div>
                        <div class="mb-3">
                            <label for="name">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control">
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
			<div class="pb-5 pt-3">
				<button type="submit" class="btn btn-primary">Update</button>
				<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark ml-3">Cancel</a>
			</div>
		</form>
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
		@endsection
		@section('customeJS')
		<script>
		$("#changePasswordForm").submit(function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("admin.updatePassword")}}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){
                    if(response.status == true){
                        $("#password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $("#old_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                         window.location.href="{{route('admin.showChangePassword')}}";
                    }

                    else{
                        var error = response.errors;
                        if(error.old_password){
                            $("#old_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.old_password);
                         }
                         else{
                            $("#old_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                        if(error.new_password){
                            $("#new_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.new_password);
                         }
                         else{
                            $("#new_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                        if(error.confirm_password){
                            $("#confirm_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.confirm_password);
                         }
                         else{
                            $("#confirm_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                       }
                      }
                    });

                });

		</script>
		@endsection
