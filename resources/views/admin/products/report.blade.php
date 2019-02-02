@extends('admin.master')
@section('content')
    <form method="post" action="{{ url(PATH.'/product_report') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="form-group col-md-3 ">
                <label>From</label>
                <input type="text" class="datepicker form-control" required autocomplete="off" name="start">
            </div>
            <div class="form-group col-md-3 ">
                <label>To</label>
                <input type="text" class="datepicker form-control" required autocomplete="off" name="end">
            </div>
            <div class="form-group col-md-3 ">
                <label>Products</label>
                <select class="select2 form-control" name="product_id">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2 ">
                <button type="submit" class="btn btn-success pull-right">Get</button>
            </div>
        </div>
    </form>
    <div class="col-sm-12">
        @if(isset($total))
            <h2>Total in Completed Orders : {{ $total['completed'] }}</h2>
            <h2>Total in Pending Orders : {{ $total['pending'] }}</h2>
        @endif
    </div>

@endsection

@section('js')
    <link rel="stylesheet" href="{{ url('css/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <script src="{{ url('css/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('.datepicker').datepicker({
            autoclose: true
        })
    </script>
@endsection