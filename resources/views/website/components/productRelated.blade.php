<script>
    $.ajax({
        type:'get',
        url:'/product_related/'+'{{ $product->id }}',
        dataType:'json',
        success:function (data) {
            console.log(data['data']);
            data = data['data'];

            printProducts(data['ads'],true,false,false);
            page++;
            printProducts(data['related'],false,true,false);
        }
    });


</script>