@extends("front.layouts.app")

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                <li class="breadcrumb-item">Login</li>
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
            <form action="{{ route('account.authenticate') }}" method="post" id="loginForm" name="loginForm">
                @csrf
                <h4 class="modal-title">Login to Your Account</h4>
                <div class="form-group">
                    <input type="text" name="email" class="form-control @error('email') is-invalid  @enderror" value="{{ old('email')}}" placeholder="Email" >
                    @error('email')
                    <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control @error('password') is-invalid  @enderror" placeholder="Password" >
                    @error('password')
                    <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group small">
                    <a href="{{ route('account.forGotPassword') }}" class="forgot-link">Forgot Password?</a>
                </div>
                <input type="submit" class="btn btn-dark btn-block btn-lg" value="Login">
            </form>
            <div class="text-center small">Don't have an account? <a href="{{ route('account.register') }}">Sign up</a></div>
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
