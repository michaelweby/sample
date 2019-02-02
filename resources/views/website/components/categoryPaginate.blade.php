<script>
    $(window).scroll(function() {

        if ($(document).height()-200 <= ($(window).height() + $(window).scrollTop())) {
            var _token = '{{ csrf_token() }}';
            var theurl = '/categoryPaginate/'+'{{ $category->id }}'+'/'+page;
            $('#pagination-loading').show();
            $.ajax({
                type: 'get',
                url: theurl,
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