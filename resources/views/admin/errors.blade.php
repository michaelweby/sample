
@if(count($errors) > 0)
    <div class="errors-container alert-danger">
    <ul>

    @foreach($errors->all() as $error)

        <li> {{ $error }}</li>
    @endforeach
    </ul>
    </div>
@endif
