@extends("front.layouts.app")
@section('content')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('front.account.common.sidebar')
                </div>
                <div class="col-md-9">
                    @include('front.account.common.message')
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="" name="changePasswordForm" id="changePasswordForm">
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
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-dark">Save</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('customJs')
<script>
        $("#changePasswordForm").submit(function(e){
            e.preventDefault();

            $.ajax({
                url: '{{ route("account.updatePassword")}}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){
                    if(response.status == true){
                        $("#password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $("#old_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                         window.location.href="{{route('account.changePassword')}}";
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
