<script>
    var search ='{{ request()->search }}';
    $.ajax({
        type:'get',
        url:'web_search',
        data:{search:search},
        dataType:'json',
        success:function (data) {
            data = data['data'];
            console.log(data['products']);

            for (i=0;i< data['shops'].length;i++) {
                var id = '#col' + columnIndex;

                columnIndex++;
                if (columnIndex == 6) {
                    columnIndex = 1;
                }
                var url = '<?php echo e(url('shop')); ?>'+'/'+data['shops'][i]["id"];
                var image = '<?php echo e(url('')); ?>'+'/'+data['shops'][i]["image"];
                var shop = " <div class=\"col-12\">\n" +
                    "                                    <a href='"+url+"'><img src='"+image+"' class='circle w-100'></a>\n" +
                    "                                    <a href='"+url+"'><h5 class='shoptizer-color text-center'>"+data['shops'][i]['title']+"</h5></a>\n" +
                    "                                </div>";
                $(id).append(shop);

            }
           printProducts(data['products'],false,false,false);

        }
    });


</script>