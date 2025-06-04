
@extends("front.layouts.app")

@section('content')

<section class="container">

    <div class="col-md-12 text-center py-5">
        @if (Session::has('success'))
        <div class="alert alert-success">
          {{Session::get('success') }}

        </div>
        @endif
      <h2 class="success">Thank You!</h2>
      <p>Your Order id is : {{ $id}}</p>

    </div>
</section>

@endsection
