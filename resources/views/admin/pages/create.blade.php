@extends('admin.layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Page</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('pages.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form method="POST" name="pagesForm" id="pagesForm">
        <div class="card">
            <div class="card-body">

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
                            <label for="email">Slug</label>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" class="summernote" cols="30" rows="10"></textarea>
                            <p></p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Block</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="pb-5 pt-3">
            <button class="btn btn-primary">Create</button>
            <a href="{{ route('pages.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </form>
    </div>
    <!-- /.card -->
</section>
@endsection
@section('customeJS')
<script>
    $("#pagesForm").submit(function(e){
        e.preventDefault();
        $.ajax({
              url:'{{ route("pages.store")}}',
              data: $(this).serializeArray(),
              type:'post',
              datatype:'json',
              success:function(response){
                if(response.status == true){
                    $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $("#content").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    window.location.href="{{ route('pages.index')}}"
                }
                else{
                    var error = response.errors;
                    if(error.name){
                      $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.name);
                    }
                    else{
                        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(error.slug){
                      $("#slug").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.slug);
                    }
                    else{
                        $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(error.content){
                      $("#content").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.content);
                    }
                    else{
                        $("#content").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                }
              }
          });
      });


      $('#name').change(function(){
        var element = $(this);
        $("button[type=submit]").prop('disabled',true);
        $.ajax({
                url : '{{route('getSlug')}}',
                method : 'get',
                data: {title:element.val()},
                dataty : 'JSON',
                success:function(responce){
                    $("button[type=submit]").prop('disabled',false);
                    //console.log(responce);
                    if(responce['status'] == true){
                        $("#slug").val(responce["slug"]);

                    }
                }
          });
        });
    </script>
    @endsection
