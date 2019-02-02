@php
    $column=3;
    $fields=[
    ['name'=>'name','type'=>'text','title'=>'Name','column'=>$column],
    ['name'=>'serial_number','type'=>'number','title'=>'Serial Number','column'=>$column],
    ['name'=>'shop_id','type'=>'select','title'=>'Shop','column'=>$column,'model'=>['name'=>'title','data'=>\App\Shop::get()]],
    ['name'=>'priorty','type'=>'number','title'=>'Priorty','column'=>$column],
    ['name'=>'price','type'=>'number','title'=>'Price','column'=>$column],
    ['name'=>'discount','type'=>'number','title'=>'Discount','column'=>$column],
    ['name'=>'discount_type','type'=>'static_select','title'=>'Discount Type','column'=>$column,'model'=>['name'=>'title','data'=>[['id'=>'pound','name'=>'pound'],['id'=>'percentage','name'=>'percentage']]]],
    ['name'=>'start','type'=>'text','title'=>'Discount Start','class'=>'datepicker','column'=>$column],
    ['name'=>'end','type'=>'text','title'=>'Discount End','class'=>'datepicker','column'=>$column],
    ['name'=>'recommendation','type'=>'checkbox','title'=>'Recommendation','column'=>2],
    ['name'=>'published','type'=>'checkbox','title'=>'Publish','column'=>2],
    ['name'=>'description','type'=>'textarea','title'=>'description','column'=>12],
    ['name'=>'image','type'=>'image','title'=>'Image','column'=>4],
    ['name'=>'photos','type'=>'multi_images','title'=>'Images','column'=>4],
    ['name'=>'tag','type'=>'text','title'=>'Tags','column'=>4,'id'=>'tags','data-role'=>'tagsinput','value'=>$tags],
    ['name'=>'category','type'=>'multiselect','title'=>'Category','column'=>4,'model'=>['name'=>'name','data'=>\App\Category::get()]],
    ['name'=>'preparing_days','type'=>'number','title'=>'Preparing Days','column'=>4],
    ['type'=>'extra','path'=>'admin.products.productitem','extra_js_file'=>'product','value'=>[]],

    ];
@endphp
@if($blade=='create')
@include('admin.stamp.create',['page_title'=>'Product','url'=>'product','fields'=>$fields])
@elseif($blade=='edit')
    @include('admin.stamp.edit',['page_title'=>'Product','url'=>'product','fields'=>$fields,'data'=>$product])
@endif
