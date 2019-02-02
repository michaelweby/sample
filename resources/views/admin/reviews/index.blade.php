@extends('admin.master')
@section('content')
    <!-- Content Header (Page header) -->
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
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-hover table-striped datatable">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Product</th>
                                <th>Review</th>
                                <th>Stars</th>
                                <th>hidden</th>
                                <th>hide</th>
                                <th>actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reviews as $row)
                                <tr>
                                    <td>{{ $row->user->first_name }}</td>
                                    <td>{{ $row->product->name }}</td>

                                    <td>{{ $row->review }}</td>
                                    <td>{{ $row->stars }}</td>
                                    <td class="visibility" data-id="{{ $row->id }}">
                                        @if($row->hidden)
                                            <span class="text-red">hidden</span>
                                        @else
                                            <span class="text-green">visible</span>
                                        @endif
                                    </td>
                                    <td class="visibility-btn" data-id="{{ $row->id }}">
                                        @if($row->hidden)
                                            <span class="btn btn-primary show-btn" data-id="{{ $row->id }}">show</span>
                                        @else
                                            <span class="btn btn-primary hide-btn" data-id="{{ $row->id }}">hide</span>
                                        @endif
                                    </td>
                                    <td>
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
                                                <form method="post" action="{{url(PATH.'/products/'.$row->product->id.'/reviews/'.$row->id) }}">
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
        $(document).on('click','.hide-btn',function () {
            var id = $(this).attr('data-id');
            var _token = '{{ csrf_token() }}';
            $.ajax({
                type:'post',
                url:'/{{ PATH }}/review/hide/'+id,
                data:{_token:_token},
                dataType:'json',
                success:function (data) {
                    $('td.visibility[data-id='+id+']').html('<span class="text-red">hidden</span>');
                    $('td.visibility-btn[data-id='+id+']').html('<span class="btn btn-primary show-btn" data-id="'+id+'">show</span>');
                }
            });
        });
        $(document).on('click','.show-btn',function () {
            var id = $(this).attr('data-id');
            var _token = '{{ csrf_token() }}';
            $.ajax({
                type:'post',
                url:'/{{ PATH }}/review/show/'+id,
                data:{_token:_token},
                dataType:'json',
                success:function (data) {
                    $('td.visibility[data-id='+id+']').html('<span class="text-green">visible</span>');
                    $('td.visibility-btn[data-id='+id+']').html('<span class="btn btn-primary hide-btn" data-id="'+id+'">hide</span>');
                }
            });
        });
    </script>
@endsection