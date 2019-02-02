<script>

    $.ajax({
        type:'get',
        url:'/shop_product/'+'{{ $shop->id }}',
        dataType:'json',
        success:function (data) {
            data = data['data'];
            printProducts(data['products'],false,false,true)
            page++;
        }
    });


</script>