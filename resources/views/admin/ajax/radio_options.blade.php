<label class="col-xs-12" style="margin-top: 20px">Create A new One</label>
<div class="form-group">
    <span class="col-md-1"><input name="shipping_id" id="shipping-new" value="0" type="radio" selected=""></span>
    <label for="shipping-new">
    <span class="col-md-3">
        <label>Name : </label>
        <input value="{{ $user->first_name }}" name="shipping_first_name" class="form-control" placeholder="First Name">
        <input value="{{ $user->last_name }}" name="shipping_last_name"  class="form-control" placeholder="Last Name">
    </span>
    <span class="col-md-4">Address:  <input value="{{ $user->address }}" name="shipping_address" class="form-control" placeholder="Address"></span>
    <span class="col-md-4">Phone: <input value="{{ $user->phone }}" name="shipping_phone" class="form-control" placeholder="Phone"></span>
    <span class="col-md-4">Email: <input value="{{ $user->email }}" name="shipping_email" class="form-control" placeholder="Email"></span>
    </label>
</div>

@forelse($shippings as $shipping)
    <div class="col-xs-12">
    <span class="col-md-1"><input name="shipping_id" value="{{ $shipping->id }}" type="radio" id="shipping-{{ $shipping->id }}" ></span>
    <label for="shipping-{{ $shipping->id }}">
        <span class="col-md-3">Name : {{ $shipping->first_name . ' '. $shipping->last_name }}</span>
        <span class="col-md-4">Address: {{ $shipping->address }}</span>
        <span class="col-md-4">Phone: {{ $shipping->phone }}</span>
        <span class="col-md-4">Email: {{ $shipping->email }}</span>
    </label>
    </div>
@empty

@endforelse

