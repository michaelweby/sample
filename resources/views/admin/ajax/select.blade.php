@php($i = 0)
<option></option>
@foreach($options as $option)
    <option value="{{ $option->id }}">item {{ ++$i }} => price :{{ $option->price }} | storage : {{ $option->amount }}
        [
        @foreach($option->attribute as $attr)
          <bold>{{ json_decode($attr,true)['value'] }}</bold>@if(!$loop->last) ,@endif
        @endforeach ]
    </option>
@endforeach