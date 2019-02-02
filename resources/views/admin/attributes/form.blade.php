@php
    $column=12;
    $fields=[
    ['name'=>'name','type'=>'text','title'=>'Name','column'=>$column],
    ['type'=>'multifield','title'=>'Attribute','name'=>'attr'],
   // ['type'=>'extra','path'=>'admin.products.productitem','value'=>[]],
    ];
@endphp
@if($blade=='create')
@include('admin.stamp.create',['page_title'=>'Attribute','url'=>'attribute','fields'=>$fields])
@elseif($blade=='edit')
    @include('admin.stamp.edit',['page_title'=>'Attribute','url'=>'attribute','fields'=>$fields,'data'=>$product])
@endif
