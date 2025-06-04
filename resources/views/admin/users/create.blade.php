@extends('admin.layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create User</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form method="POST" name="userForm" id="userForm" >
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Password">Password</label>
                            <input type="text" name="password" id="password" class="form-control" placeholder="Password">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Block</option>
                            </select>
                            <p></p>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                   </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
@endsection
@section('customeJS')
<script>
    $("#userForm").submit(function(e){
        e.preventDefault();
        $.ajax({
              url:'{{ route("users.store")}}',
              data: $(this).serializeArray(),
              type:'post',
              datatype:'json',
              success:function(response){
                if(response.status == true){
                    $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#phone").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    window.location.href="{{ route('users.index')}}"
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
    </script>
    @endsection
