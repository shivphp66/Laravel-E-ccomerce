<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-5">
<div class="row justify-content-center">
 
    <div class="col-sm-6">
    @include('admin.message')
    <div class="card mt-2 p-2">
  <h2>Admin Panel</h2>
  <form action="{{ route('admin.authenticate') }}" method="post">
    @csrf
    
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" value="{{ old('email')}}" class="form-control @error('email') is-invalid @enderror " id="email" placeholder="Enter Email" name="email">
      @error('email')
              <p class="invalid-feedback errors">{{ $message }} </p>
      @enderror
    </div>

    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" value="{{ old('password')}}" class="form-control @error('password') is-invalid @enderror " id="password" placeholder="Enter password" name="password">
      @error('password')
              <p class="invalid-feedback errors">{{ $message }} </p> 
      @enderror
    </div>
   
    <button type="submit" class="btn btn-dark">Submit</button>
  </form>
   </div>
   </div>
   </div>
   </div>

</body>
</html>