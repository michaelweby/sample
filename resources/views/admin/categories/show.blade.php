@extends('admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Shop
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                     <span class="col-md-3">
                                        Icon : <img src="{{ url(@$category->image) }}" class="col-xs-12">
                                     </span>
                                    <span class="col-md-3">
                                        Cover:  <img src="{{ @url($category->cover) }}" class="col-xs-12">
                                    </span>
                                </div>
                                <div class="row" style="margin-top: 15px">
                                    <span class="col-md-3">
                                        Parent :  @if($category->parent) {{ $category->parent }} @else Main @endif
                                    </span>
                                    <span class="col-md-3">
                                        url:  {{ @$category->url }}
                                    </span>
                                    <span class="col-md-6">
                                        Description:  {{ @$category->description}}
                                    </span>
                                    <span class="col-md-3">
                                        Elite:  @if($category->elite) yes @else No @endif
                                    </span>

                                </div>

                            </div>

                            <div class="col-md-12">
                                <h1>Products</h1>
                                @forelse( $category->products as $product)
                                    <a href="{{ url(PATH.'/product/'.$product->id) }}" class="btn btn-success col-md-3" style="margin: 5px;"><h5>{{ $product->name }}</h5></a>
                                @empty
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection