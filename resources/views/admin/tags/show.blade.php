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
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <span class="col-md-6">
                                        {{ $tag->name}}<br>
                                    </span>
                                </div>


                            </div>

                            <form class="col-md-12" method="post" action="{{url(PATH.'/tag_products/'.$tag->id) }}">
                                {{ csrf_field() }}
                                <h1>Products</h1><span>
                                    Attached Products : {{ count($tag_products) }}
                                </span>
                                <select class="select2" multiple name="products[]" style="width: 100%">
                                    @forelse( $products as $product)
                                        <option @if(in_array($product->id,$tag_products->all())) selected @endif value="{{ $product->id }}"> {{ $product->name }} </option>
                                    @empty
                                    @endforelse
                                </select>
                                <button type="submit" class="btn btn-primary">Save products</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection