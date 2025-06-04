
@extends("front.layouts.app")

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
        <form method="POST" name="orderForm" id="orderForm" action="">
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{ (!empty($customerAadress))? $customerAadress->first_name : ''}}" name="first_name" id="first_name" class="form-control" placeholder="First Name">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{ (!empty($customerAadress))? $customerAadress->last_name : ''}}" name="last_name" id="last_name" class="form-control" placeholder="Last Name">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{ (!empty($customerAadress))? $customerAadress->email : ''}}" name="email" id="email" class="form-control" placeholder="Email">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="country" id="country" class="form-control">
                                            <option value="">Select a Country</option>
                                           @if ($countries->isNotEmpty())
                                             @foreach ($countries as $country)
                                             <option value="{{$country->id}}" {{(!empty($customerAadress) && $country->id==$customerAadress->country_id) ?'selected':'' }}>{{$country->name}}</option>
                                             @endforeach
                                           @endif
                                        </select>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea  name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control">{{ (!empty($customerAadress)) ? $customerAadress->address :'' }}</textarea>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{ (!empty($customerAadress))? $customerAadress->apartment : ''}}" name="apartment" id="apartment" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" value="{{ (!empty($customerAadress))? $customerAadress->city : ''}}"  name="city" id="city" class="form-control" placeholder="City">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" value="{{ (!empty($customerAadress))? $customerAadress->state : ''}}"  name="state" id="state" class="form-control" placeholder="State">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" value="{{ (!empty($customerAadress))? $customerAadress->zip : ''}}" name="zip" id="zip" class="form-control" placeholder="Zip">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{ (!empty($customerAadress))? $customerAadress->mobile : ''}}" name="mobile" id="mobile" class="form-control" placeholder="Mobile No.">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control">{{ (!empty($customerAadress))? $customerAadress->notes : ''}}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summery</h3>
                    </div>
                    <div class="card cart-summery">
                        <div class="card-body">
                            @foreach (Cart::content() as $item)
                            <div class="d-flex justify-content-between pb-2">
                                <div class="h6">{{ $item->name}}</div>
                                <div class="h6">₹{{ $item->price * $item->qty}}</div>
                            </div>
                            @endforeach

                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>₹{{ Cart::subtotal() }}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Discount</strong></div>
                                <div class="h6"><strong id="discount">₹{{number_format($discount,2)}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong id="totalShippingCharge">₹{{number_format($totalShippingCharge,2)}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong id="grandTotal">₹{{ number_format($grandTotal,2) }}</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Coupon Code" class="form-control" name="discount_code" id="discount_code">
                        <p></p>
                        <button class="btn btn-dark" type="button" id="apply-discount">Apply Coupon</button>

                    </div>
                     <div id="discount-response-wrapper">
                     @if (Session()->has('code'))
                      <div class="mt-4" id="discount-response">
                        <strong>{{ Session()->get('code')->code }}</strong>
                        <a class="btn btn-sm btn-danger" id="remove-discount"><i class="fa fa-times" ></i></a>
                      </div>
                      @endif
                     </div>

                    <div class="card payment-form ">
                        <h3 class="card-title h5 mb-3">Payment Method</h3>
                        <div>
                           <input checked type="radio" name="payment_method" value="COD" id="payment_method_one">
                           <label for="payment_method_one" class="form-check-lavel">COD</label>
                        </div>
                        <div>
                        <input type="radio" name="payment_method" value="stripe" id="payment_method_two">
                        <label for="payment_method_two" class="form-check-lavel">Stripe</label>
                     </div>

                        <div class="card-body p-0 d-none" id="card_payment-form">
                            <div class="mb-3">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">CVV Code</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                        </div>
                    </div>
                    <!-- CREDIT CARD FORM ENDS HERE -->

                </div>
            </div>
        </form>
        </div>
    </section>
    @endsection
    @section('customJs')
    <script>
       $('#payment_method_one').click(function(){
          if($(this).is(":checked") == true)
           $('#card_payment-form').addClass('d-none');
       });

       $('#payment_method_two').click(function(){
          if($(this).is(":checked") == true)
           $('#card_payment-form').removeClass('d-none');
       });

      $("#orderForm").submit(function(event){
        event.preventDefault();

        $.ajax({
              url:'{{ route("front.processCheckout")}}',
              type:'post',
              data: $(this).serializeArray(),
              datatype:'json',
              success:function(response){
              var error = response.errors;
              if(response.status == false){
                if(error.first_name){
                   $("#first_name").addClass('is-invalide').siblings("p").addClass('text-danger').html(error.first_name);
                }
                else{
                    $("#first_name").removeClass('is-invalide').siblings("p").removeClass('text-danger').html('');
                }

                if(error.last_name){
                   $("#last_name").addClass('is-invalide').siblings("p").addClass('text-danger').html(error.last_name);
                }
                else{
                    $("#last_name").removeClass('is-invalide').siblings("p").removeClass('text-danger').html('');
                }

                if(error.email){
                   $("#email").addClass('is-invalide').siblings("p").addClass('text-danger').html(error.email);
                }
                else{
                    $("#email").removeClass('is-invalide').siblings("p").removeClass('text-danger').html('');
                }

                if(error.country){
                   $("#country").addClass('is-invalide').siblings("p").addClass('text-danger').html(error.country);
                }
                else{
                    $("#country").removeClass('is-invalide').siblings("p").removeClass('text-danger').html('');
                }
                if(error.address){
                   $("#address").addClass('is-invalide').siblings("p").addClass('text-danger').html(error.address);
                }
                else{
                    $("#address").removeClass('is-invalide').siblings("p").removeClass('text-danger').html('');
                }
                if(error.city){
                   $("#city").addClass('is-invalide').siblings("p").addClass('text-danger').html(error.city);
                }
                else{
                    $("#city").removeClass('is-invalide').siblings("p").removeClass('text-danger').html('');
                }
                if(error.state){
                   $("#state").addClass('is-invalide').siblings("p").addClass('text-danger').html(error.state);
                }
                else{
                    $("#state").removeClass('is-invalide').siblings("p").removeClass('text-danger').html('');
                }

                if(error.zip){
                   $("#zip").addClass('is-invalide').siblings("p").addClass('text-danger').html(error.zip);
                }
                else{
                    $("#zip").removeClass('is-invalide').siblings("p").removeClass('text-danger').html('');
                }

                if(error.mobile){
                   $("#mobile").addClass('is-invalide').siblings("p").addClass('text-danger').html(error.mobile);
                }
                else{
                    $("#mobile").removeClass('is-invalide').siblings("p").removeClass('text-danger').html('');
                }
            }
            else{
                 window.location.href="{{url('/thanks/')}}/"+response.orderId;
            }

            }
           });

        });

       $("#country").change(function(){
        $.ajax({
              url:'{{ route("front.getOrderSummery")}}',
              type:'post',
              data: { country_id:$(this).val() },
              datatype:'json',
              success:function(response){
               if(response.status == true){
                  $("#totalShippingCharge").html('₹'+ response.shippingCharge);
                  $("#grandTotal").html('₹'+ response.grandTotal);
               }
              }
            });
          });

          $("#apply-discount").click(function(){
            $.ajax({
                url:'{{ route("front.applyDiscount")}}',
                type:'post',
                data: { code:$("#discount_code").val(), country_id:$("#country").val() },
                datatype:'json',
                success:function(response){
                    if(response.status == true){
                    $("#totalShippingCharge").html('₹'+ response.shippingCharge);
                    $("#grandTotal").html('₹'+ response.grandTotal);
                    $("#discount").html('₹'+ response.discount);
                    $("#discount-response-wrapper").html(response.discoutString);
                   }
                   else{
                       $("#discount-response-wrapper").html("<span class='text-danger'>"+response.error+"</span>");
                   }
                }

                });
            });

            $("body").on('click',"#remove-discount",function(){
                $.ajax({
                    url:'{{ route("front.removeCoupen")}}',
                    type:'post',
                    data: {country_id:$("#country").val() },
                    datatype:'json',
                    success:function(response){
                        if(response.status == true){
                        $("#totalShippingCharge").html('₹'+ response.shippingCharge);
                        $("#grandTotal").html('₹'+ response.grandTotal);
                        $("#discount").html('₹'+ response.discount);
                        $("#discount-response").html('');
                        $("#discount_code").val('');
                        }
                      }
                    });
                 });



    </script>

    @endsection

