<script>
    $(window).scroll(function() {

        if ($(document).height()-200 <= ($(window).height() + $(window).scrollTop())) {
            var _token = '<?php echo e(csrf_token()); ?>';
            var theurl = 'homePaginate';
            $('#pagination-loading').show();
            $.ajax({
                type: 'post',
                url: theurl,
                data:{_token:_token,page:page,avoid:skip_arr},
                dataType: 'json',
                success: function (data) {
                    printProducts(data,false,false,true)
                    $('#pagination-loading').remove();
                }
            });
            page+=1;
        }
    });
</script>