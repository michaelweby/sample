@extends('admin.master')
@section('content')
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ url(PATH.'/finance_report') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-3 ">
                            <label>From</label>
                            <input type="text" class="datepicker form-control" autocomplete="off" name="start">
                        </div>
                        <div class="form-group col-md-3 ">
                            <label>To</label>
                            <input type="text" class="datepicker form-control" autocomplete="off" name="end">
                        </div>
                        <div class="form-group col-md-3 ">
                            <label>Shop</label>
                            <select class="select2 form-control" name="shop_id">
                                <option value="0">For all shops</option>
                                @foreach($shops as $shop)
                                    <option value="{{ $shop->id }}">{{ $shop->title .' - '. $shop->owner->name() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2 ">
                            <button type="submit" class="btn btn-success pull-right">Get</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @if($orders)
        <div class="row">
            <div class="col-md-6">
                <h4>Total Orders : {{ count($orders) }}</h4>
                <h4> Total : {{ $orders->sum('total') }}</h4>
                <h4> Shop Commision : {{ $orders->sum('total') - ($orders->sum('total') * $shop->commission)/100 }}</h4>
                <h4> Shop Revenue : {{ ($orders->sum('total') * $shop->commission)/100 }}</h4>
            </div>
        </div>

    @endif

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