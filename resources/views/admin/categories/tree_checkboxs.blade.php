@foreach( (new \App\Category())->tree() as $category)
    <div class="row">
        <input type="checkbox" value="{{ $category->id }}"> {{$category->name}}
        {{ (new \App\Category())->treeDepth($category) }}

    </div>
@endforeach