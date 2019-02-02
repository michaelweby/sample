$(window).ready(function () {


$(window).on('scroll', function() {
    var sign = $(window).scrollTop() > 500 ? '' : '-';
    $('#top-page').stop().animate({right: sign + '50px'}, "slow");
    if($(window).scrollTop() > 500) {
        $('footer').stop().animate({bottom: '0px'}, "slow").addClass('fixed-footer');
        $('#demo').removeClass('show');
    }else{
        $('footer').stop().animate({bottom: sign + '60px'}, "slow").removeClass('fixed-footer');
        $('#demo').addClass('show');
    }
    $(window).scrollTop() > 501? $('header').stop().animate({top:  '0px'}, "slow").addClass('fixed-header'):$('header').stop().animate({top: sign + '60px'}, "slow").removeClass('fixed-header');
});

$('#top-page').on('click',function () {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    $('#top-page').animate({ right: '-50px' }, "slow");
});
});