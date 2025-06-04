@extends("front.layouts.app")

@section('content')
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
        @include('front.account.common.message')
        <div class="row">
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" name="profileForm" id="profileForm" action="">
                        <div class="row">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                 <input type="text" name="name" value="{{$user->name}}" id="name" placeholder="Enter Your Name" class="form-control">
                                 <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="text" name="email" value="{{$user->email}}" id="email" placeholder="Enter Your Email" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" value="{{$user->phone}}" id="phone" placeholder="Enter Your Phone" class="form-control">
                                <p></p>
                            </div>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-dark">Update</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Address</h2>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" name="userAddressForm" id="userAddressForm" action="">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="first_name">First Name</label>
                                 <input type="text" name="first_name" value="{{(!empty($useraddress->first_name))?$useraddress->first_name:'' }}" id="first_name" placeholder="Enter First Name" class="form-control">
                                 <p></p>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="last_name">Last Name</label>
                                 <input type="text" name="last_name" value="{{(!empty($useraddress->last_name))? $useraddress->last_name :''}}" id="last_name" placeholder="Enter Last Name" class="form-control">
                                 <p></p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email">Email</label>
                                <input type="text" name="email" value="{{(!empty($useraddress->email))? $useraddress->email:'' }}" id="email_error" placeholder="Enter Your Email" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="mobile">Mobile</label>
                                <input type="text" name="mobile" value="{{(!empty($useraddress->mobile))? $useraddress->mobile:''}}" id="mobile" placeholder="Enter Phone" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="country">Country</label>
                                <select name="country" id="country"class="form-control">
                                    <option value="">Select</option>
                                    @if ($countries->isNotEmpty())
                                       @foreach ($countries as $country)
                                       <option {{ (!empty($useraddress->country_id) && $country->id==$useraddress->country_id)?'selected' : ''}} value="{{ $country->id }}">{{ $country->name }}</option>
                                       @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>

                            <div class="mb-3">
                                <label for="address">address</label>
                                <input type="text" name="address" value="{{(!empty($useraddress->address))?$useraddress->address :'' }}" id="address" placeholder="Enter Address" class="form-control">
                                <p></p>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="apartment">Apartment</label>
                                <input type="text" name="apartment" value="{{(!empty($useraddress->apartment))? $useraddress->apartment:'' }}" id="apartment" placeholder="Enter Apartment" class="form-control">
                                <p></p>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="city">City</label>
                                <input type="text" name="city" value="{{ (!empty($useraddress->city))? $useraddress->city :'' }}" id="city" placeholder="Enter City" class="form-control">
                                <p></p>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="state">State</label>
                                <input type="text" name="state" value="{{(!empty($useraddress->state))? $useraddress->state :''}}" id="state" placeholder="Enter State" class="form-control">
                                <p></p>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="zip">Zip</label>
                                <input type="text" name="zip" value="{{(!empty($useraddress->zip))?$useraddress->zip :'' }}" id="zip" placeholder="Enter Zip" class="form-control">
                                <p></p>
                            </div>

                            <div class="d-flex">
                                <button type="submit" class="btn btn-dark">Update</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
    $("#profileForm").submit(function(e){
        e.preventDefault();
        $.ajax({
              url:'{{ route("account.updateProfile")}}',
              data: $(this).serializeArray(),
              type:'post',
              datatype:'json',
              success:function(response){
                if(response.status == true){
                    $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#phone").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                     window.location.href="{{ route('account.profile')}}"
                }
                else{
                    var error = response.errors;
                    if(error.name){
                      $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.name);
                    }
                    else{
                        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(error.email){
                      $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.email);
                    }
                    else{
                        $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(error.phone){
                      $("#phone").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.phone);
                    }
                    else{
                        $("#phone").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                }

              }
        });
    });

    $("#userAddressForm").submit(function(e){
        e.preventDefault();
        $.ajax({
              url:'{{ route("account.updateUserAddress")}}',
              data: $(this).serializeArray(),
              type:'post',
              datatype:'json',
              success:function(response){
                if(response.status == true){
                    $("#first_name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#last_name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#email_error").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#mobile").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#country").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#address").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#city").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#state").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#zip").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    window.location.href="{{ route('account.profile')}}"
                }
                else{
                    var error = response.errors;
                    if(error.first_name){
                      $("#first_name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.first_name);
                    }
                    else{
                        $("#first_name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(error.last_name){
                      $("#last_name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.last_name);
                    }
                    else{
                        $("#last_name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(error.email){
                      $("#email_error").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.email);
                    }
                    else{
                        $("#email_error").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(error.mobile){
                      $("#mobile").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.mobile);
                    }
                    else{
                        $("#mobile").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(error.country){
                      $("#country").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.country);
                    }
                    else{
                        $("#country").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(error.address){
                      $("#address").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.address);
                    }
                    else{
                        $("#address").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(error.city){
                      $("#city").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.city);
                    }
                    else{
                        $("#city").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(error.state){
                      $("#state").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.state);
                    }
                    else{
                        $("#state").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(error.zip){
                      $("#zip").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.zip);
                    }
                    else{
                        $("#zip").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                 }
            }
        });
    });
</script>
@endsection
