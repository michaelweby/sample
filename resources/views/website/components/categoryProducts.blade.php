<script>
    $.ajax({
        type:'get',
        url:'/category_products/'+'{{ $category->id }}',
        dataType:'json',
        success:function (data) {
            data = data['data'];

            printProducts(data['ads'],true,false,false);
            page++;
            printProducts(data['products'],false,true,false);

        }
    });


</script>