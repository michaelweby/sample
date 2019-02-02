<script>
    $(window).scroll(function() {

        if ($(document).height() <= ($(window).height() + $(window).scrollTop())) {

            var theurl = '/productPaginate/'+'{{ $product->id }}'+'/'+page;

            $('#pagination-loading').show();
            $.ajax({
                type: 'get',
                url: theurl,
                data:{page:page},
                dataType: 'json',
                success: function (data) {
                    data=data['data'];
                    printProducts(data,false,false,true)
                    $('#pagination-loading').remove();
                }
            });
            page+=1;
        }
    });
</script>