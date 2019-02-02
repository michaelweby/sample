
@foreach($result as $row)



    <tr>
        <td>{{ $row->serial_number }}</td>
        <td>{{ $row->name }}</td>

        <td>{{ @$row->shop->title }}</td>
        <td>
            {{--@forelse($row->categories as $category)--}}
                {{--{{ $category->name }}@if(!$loop->last) , @endif--}}
            {{--@empty--}}
                {{--NO Categories--}}
            {{--@endforelse--}}
        </td>
        <td style="text-align: center">
            {{--@if($row->runningDiscount())--}}
                {{--{{ $row->discount }} {{ $row->discount_type == 'pound'?'£':'%' }}<br>--}}
                {{--{{ $row->start->format('d-M-Y') }} <br>to<br> {{ $row->end->format('d-M-Y') }}--}}
            {{--@endif<br>--}}
        </td>
        {{--<td><a href="{{ url(PATH.'/products/'.$row->id.'/reviews') }}">--}}
                {{--{{ count($row->reviews) }} <br>--}}
                {{--{{ number_format($row->reviews()->avg('stars') ,2)}}--}}
                {{--<i class="glyphicon glyphicon-star"></i>--}}
            {{--</a></td>--}}
        <td><a href="{{ url(PATH.'/product/'.$row->id) }}"
               class="btn btn-primary btn-flat">Show</a>
            <a data-toggle="modal" data-target="#delete{{ $row->id }}"
               class="btn btn-danger btn-flat search-row">Delete</a></td>

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

