@extends("front.layouts.app")

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                <li class="breadcrumb-item">Reset Password</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-10">
    <div class="container">
        @if (Session::has('success'))
                <div class="col-md-6" style="margin-left: 25%;">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {!! Session::get('success') !!}
                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
        @endif

        @if (Session::has('error'))
        <div class="col-md-6" style="margin-left: 25%;">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {!! Session::get('error') !!}
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
     @endif

        <div class="login-form">
            <form action="{{ route('account.doProcessResetPassword') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <h4 class="modal-title">Reset Password</h4>
                <div class="form-group">
                    <input type="password" name="new_password" class="form-control @error('new_password') is-invalid  @enderror"  placeholder="New Password" >
                    @error('new_password')
                    <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" class="form-control @error('confirm_password') is-invalid  @enderror" placeholder="Confirm Password" >
                    @error('confirm_password')
                    <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <input type="submit" class="btn btn-dark btn-block btn-lg" value="Reset">
            </form>
            <div class="form-group text-center">
                <a href="{{ route('account.login') }}">Login</a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
   /*$("#loginForm").submit(function(event){
      event.preventDefault();
      $.ajax({
             url: '{{ route("account.saveRegister") }}',
             type : 'post',
             data : $(this).serializeArray(),
             datatype: 'json',
             success:function(response){
                if(response.status == true){
                 window.location.href="{{ route('account.authenticate') }}";
                }

                var errors = response.errors;

                if(response.status == false){
                    if(errors.email){
                        $("#email").siblings("p").addClass("invalid-feedback").html(errors.email);
                        $("#email").addClass("is-invalid");
                    }else{
                        $("#email").siblings("p").removeClass("invalid-feedback").html('');
                        $("#email").removeClass("is-invalid");
                    }
                    if(errors.password){
                        $("#password").siblings("p").addClass("invalid-feedback").html(errors.password);
                        $("#password").addClass("is-invalid");
                    }else{
                        $("#password").siblings("p").removeClass("invalid-feedback").html('');
                        $("#password").removeClass("is-invalid");
                    }

                }
                 else{
                        $("#email").siblings("p").removeClass("invalid-feedback").html('');
                        $("#email").removeClass("is-invalid");

                        $("#password").siblings("p").removeClass("invalid-feedback").html('');
                        $("#password").removeClass("is-invalid");

                    }

             },
             error:function(jQXHR,execption){
             console.log("Something went rong");
             }

      });

   });*/

</script>

@endsection
