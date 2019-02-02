<div class="w-100" id="pagination-loading">
    <img src="<?php echo e(secure_asset('site_assets/img/loading.gif')); ?>" style="display: block;margin: 0 auto">
</div>
<footer class="d-none d-sm-block">
    <div class="container">
        <div class="row pb-3">
            <div class="col-md-3">
                All rights reserved for <a href="<?php echo e(secure_url('/')); ?>" class="shoptizer-color">shoptizer 2018 </a>.
            </div>
            <div class="col-md-6">
                <div class="subscribe mx-auto" id="subscribe-form">
                    <input type="text" placeholder="Your Mail" id="subscriber">
                    <button type="button" id="subscribe">Subscribe</button>
                </div>
                <div id="subscribe-message" class="text-center">

                </div>
            </div>
            <div class="col-md-3 ">
                <div class="social float-right">
                    <a href="<?php echo e($base_info->apple_store); ?>"><i class="fab fa-apple"></i></a>
                    <a href="<?php echo e($base_info->google_play); ?>"><i class="fab fa-android"></i></a>
                    <a href="<?php echo e($base_info->facebook); ?>"><i class="fab fa-facebook-f"></i></a>
                    <a href="<?php echo e($base_info->instagram); ?>"><i class="fab fa-instagram"></i></a>
                    <a href="<?php echo e($base_info->youtube); ?>"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div id="top-page"><i class="fas fa-angle-up"></i></div>
        </div>
    </div>
</footer>
</div>

    <script src="<?php echo e(secure_asset('site_assets/js/jquery.js')); ?>"></script>
    <script src="<?php echo e(secure_asset('site_assets/js/popper.js')); ?>"></script>
    <script src="<?php echo e(secure_asset('site_assets/js/bootstrap.js')); ?>"></script>
    <script src="<?php echo e(secure_asset('site_assets/js/totop.js')); ?>"></script>
    <script src="<?php echo e(secure_asset('site_assets/js/all.js')); ?>"></script>
    <script src="<?php echo e(secure_asset('site_assets/slick/slick.js')); ?>" type="text/javascript" charset="utf-8"></script>
    <script> var page = 1   ;var columnIndex = 1; var skip_arr = [];</script>

<?php echo $__env->yieldContent('js'); ?>
<script>
    $('.multiple-items').slick({
        infinite: true,
        dots: true,
        autoplay: true,
        autoplaySpeed: 4000,
        slidesToShow: 2,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }]
        ,
    });
    $('.single-slider').slick({
        infinite: true,
        // slidesToScroll: 1,
        speed: 3000,
    });
</script>
<script>
    $('#subscribe').on('click',function () {
        var email = $('#subscriber').val();
        $('#subscriber').removeClass('text-danger');
        if (email !== "") {  // If something was entered
            if (isValidEmailAddress(email)) {
                $.ajax({
                    url:'/add_subscriber/'+email,
                    type:'get',
                    success:function (data) {
                       $('#subscribe-form').remove();
                        if(data === 'exist') {
                            console.log(data);
                        }
                       if(data === 'added'){
                           $('#subscribe-message').html('<span class="shoptizer-color"><i class="far fa-thumbs-up"></i> Add to our Newsletter List</span>');
                       }
                       if(data === 'exist') {
                           $('#subscribe-message').html('<span class="shoptizer-color"><i class="far fa-thumbs-up"></i> Already in our Newsletter List</span>');
                       }
                    }
                });
            }
            else{
                $('#subscriber').addClass('text-danger');
            }
        }
    });
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    };
</script>
<script>
    $(document).on('click','.view-icon',function () {
        var id = $(this).attr('data-id');
        $.ajax({
            type:'get',
            url:'<?php echo e(secure_url('ajax-product')); ?>'+'/'+id,
            dataType: 'html',
            success:function (data) {
                $('body').css('overflow-y','hidden');
                $('body').append(data)
            }
        });
    });
</script>
<script>
    $(document).on('click','.colse-popup',function () {
        $('body').css('overflow-y','scroll');
        $('.fix-popup').remove();
    });
</script>
<script>
    $(document).on('click','.fa-heart',function () {
       var element= $(this);
       var product_id = $(this).attr('data-id');
       var isGuest = '<?php echo e(auth()->guest()); ?>';
       var current_count = parseInt($('#favorites-count').text());
       if(!isGuest){
           $.ajax({
               url:'/favourite/'+product_id,
               type:'get',
               success:function (data) {
                   if (data['status'] == 'OK'){
                       if(data['data']=="remove from favourite"){
                            element.attr('data-prefix','far');
                            $('#favorites-count').text(--current_count);
                       }else{
                            element.attr('data-prefix','fas');
                           $('#favorites-count').text(++current_count);
                       }
                   }
               }
           });
       }else{
           window.location.href = "<?php echo e(secure_url('sign')); ?>";
       }
    });
</script>
<script>
    function printProducts(data,is_ad,get_void,is_animate) {
        console.log(data);
        for (i=0;i< data.length;i++){
            var id = '#col'+columnIndex;
            var ad = '';
            columnIndex++;
            if (columnIndex == 6){
                columnIndex = 1;
            }
            var stars = '';

            for(star = 0 ;star < Math.floor(data[i]['rate']);star++){
                stars += '<i class="fas fa-star"></i>';
            }
            var fraction = data[i]['rate']%1;
            if (fraction > 0 ){
                stars += '<i class="fas fa-star-half-alt"></i>';
                for(star = 0 ;star < 4-data[i]['rate'];star++){
                    stars += '<i class="far fa-star"></i>';
                }

            }else{
                for(star = 0 ;star < 5-data[i]['rate'];star++){
                    stars += '<i class="far fa-star"></i>';
                }
            }
            var discount ='';
            var price =data[i]['price'];
            if (data[i]['runningDiscount']){
                discount = '<span class="discount-tag">'+data[i]['discount']['valuePercentage']+'% Off</span>';
                price ='<span class="discount inline-block product-discount">'+data[i]['price']+' EGP </span> <br>'+ data[i]['discount']['new_price'];
            }
            if(get_void){
                skip_arr.push(data[i]['id']);
            }

            var isFavorite = data[i]['isFavourite']?'fas':'far';

            var image = '<?php echo e(secure_url('')); ?>'+'/'+data[i]["image"];

            var url = '<?php echo e(secure_url('product')); ?>'+'/'+data[i]["id"];
            if (is_ad) {
                ad = ' <span class="ad">Ad</span>';
                url += '?ad=true';
            }
            var quick_cart = '';
            if (data[i]["quickCart"] === true){
                quick_cart = 'class="quick-add" data-item-id="'+data[i]['item']["id"]+'"';
            }else{
                quick_cart = 'href="'+url+'"';
            }


            var animate = '';
            if(is_animate){
                animate = ' animated  fadeInDown ';
            }
            var product = '<div class="col-xs-12 product'+animate+'" data-id="'+id+'">\n' +
                '                                <div class="row product-body">\n' +ad+ // print ad tag
                '                                    <span class="actions">\n' +
                '                                        <a '+quick_cart+'>\n' +
                '                                            <img src="<?php echo e(secure_asset("site_assets/img/cart.png")); ?>" class="product-cart">\n' +
                '                                        </a>\n' +
                '                                        <a>\n' +
                '                                            <i class="'+isFavorite+' fa-heart shoptizer-color" data-id="'+data[i]["id"]+'"></i>\n' +
                '                                        </a>\n' +
                '                                    </span>\n' +
                '                                    <span class="view-icon" data-id='+ data[i]["id"]+'>\n' +
                '                                            <img src="<?php echo e(secure_asset("site_assets/img/eye.png")); ?>">\n' +
                '                                    </span>\n' +discount+
                '                                <img class="img-fluid" src="'+image+'">\n' +
                '                                <a href='+url+' class="product-link"></a>'+
                '                            </div>\n' +
                '                            <div class="col-sm-12">\n' +
                '                                <span>'+data[i]['name']+' </span>\n' +
                '                                <h6 class="shoptizer-color price">'+price+' EGP</h6>\n' +
                '                            </div>\n' +
                '                            <div class="col-xs-12 p-rate">\n' +stars+'</div>\n' +
                '                        </div>';
            $(id).append(product);
        }
    }
</script>
<script>
    $(document).on('click','.quick-add',function () {
        var item_id = $(this).attr('data-item-id');
        if(!"<?php echo e(auth()->guest()); ?>") {
            $.ajax({
                type: 'get',
                url: '/add_cart/' + item_id,
                success: function (data) {

                    if (data['data'] !== 'already in cart') {
                        var cart = parseInt($('#cart-count').html()) + 1;
                        $('#cart-count').html(cart);
                    }

                }
            });
        }else{
            window.location.href = "<?php echo e(secure_url('sign')); ?>";
        }
    });
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4&appId=241110544128";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

</body>
</html>