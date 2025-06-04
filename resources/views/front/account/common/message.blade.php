@if(Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
<h5><i class="icon fas fa-ban"></i> Error! :  {{ Session::get('error') }}</h5>

</div>
@endif

@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
<h5><i class="icon fas fa-check"></i> Success : {{ Session::get('success') }} </h5>

</div>
@endif
