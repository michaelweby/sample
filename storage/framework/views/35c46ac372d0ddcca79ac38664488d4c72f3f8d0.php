<script>
    $.ajax({
        type:'get',
        url:'homeData',
        dataType:'json',
        success:function (data) {
            console.log(data);
            printProducts(data['ads'],true,false,false);
            printProducts(data['products'],false,true,false);


        }
    });


</script>