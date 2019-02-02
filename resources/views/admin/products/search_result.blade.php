@extends('admin.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Products
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Monthly Recap Report</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a class="btn btn-success btn-flat  pull-right"
                           href="{{ url(PATH.'/product/create') }}">Add</a>
                        <form class="col-md-4" action="{{ url(PATH.'/search_products') }}" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-9">
                                <input class="form-control" name="search" placeholder="shop title or owner">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">search</button>
                            </div>
                        </form>
                        <button class="btn btn-primary" id="product-search">Search</button>
                        <table class="table table-hover table-striped datatable" id="example2">
                            <thead>
                            <tr>
                                <th>Serial Number</th>
                                <th>Name</th>
                                <th>Shop</th>
                                <th>Categories</th>
                                <th>Running Discount</th>
                                <th>Reviews</th>
                            </tr>
                            </thead>
                            <tbody id="tbody">

                            @foreach($products as $row)
                                <tr>
                                    <td>{{ $row->serial_number }}</td>
                                    <td>{{ $row->name }}</td>

                                    <td>{{ @$row->shop->title }}</td>
                                    <td>
                                        @forelse($row->categories as $category)
                                            {{ $category->name }}@if(!$loop->last) , @endif
                                        @empty
                                            NO Categories
                                        @endforelse
                                    </td>
                                    <td style="text-align: center">
                                        @if($row->runningDiscount())
                                            {{ $row->discount }} {{ $row->discount_type == 'pound'?'£':'%' }}<br>

                                            {{ @$row->start->format('d-M-Y') }} <br>to<br> {{ @$row->end->format('d-M-Y') }}
                                        @endif<br>
                                    </td>
                                    <td><a href="{{ url(PATH.'/products/'.$row->id.'/reviews') }}">
                                            {{ count($row->reviews) }} <br>
                                            {{ number_format($row->reviews()->avg('stars') ,2)}}
                                            <i class="glyphicon glyphicon-star"></i>
                                        </a></td>
                                    <td><a href="{{ url(PATH.'/product/'.$row->id) }}"
                                           class="btn btn-primary btn-flat">Show</a>
                                        <a data-toggle="modal" data-target="#delete{{ $row->id }}"
                                           class="btn btn-danger btn-flat">Delete</a></td>
                                </tr>
                                <div id="delete{{ $row->id }}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Delete Category</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ 'Delete ' . $row->name }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="{{ url(PATH.'/product/'.$row->id) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger btn-flat">Delete</button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>

    <!-- /.content -->
@endsection
@section('js')
    <script>
        $('#product-search').on('click',function () {
            var search = $('#search-box').val();
            var _token = '{{ csrf_token() }}';
            var table = 'products';
            var column ='name';
            if(search != ''){
                $.ajax({
                    type:'post',
                    url:'/{{ PATH }}/searchTable',
                    data:{_token:_token,search:search,table:table,column:column},
                    dataType:'html',
                    success:function (result) {
                        $('#tbody').html(result);
                    }
                });
            }

        });
        $(document).on('click','.search-row',function () {
            $($(this).attr('data-target')).addClass('in');
            $($(this).attr('data-target')).style('display','block');
        });
    </script>
@endsection
