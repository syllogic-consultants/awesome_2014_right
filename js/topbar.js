jQuery(document).ready(function($) {
    //set element ID/classes in vars
    var social      = '.topbar-description';
    var nav         = 'nav#primary-navigation';
    var headerMain  = '.header-main';
    var siteHead    = '#site-header img';
    var header      = '#masthead';
    var main        = '#main';
    
    //margin fix for masthead function
    var mastFix = function() {
        $(header).css({
            marginTop: $('#wpadminbar').height() + 'px'
        });
    };
    mastFix();
    //ensure that #wpadminbar doesn't move
    $('#wpadminbar').css( 'position', 'fixed' );


    //function for changing sizes
    $(function(){
        $(header).data('size','big');
    });

    //the main scroll function
    $(window).scroll(function(){
        //set container of the nav element
        var $nav = $(header);
        //when scrolled away from top
        if ($('body').scrollTop() || $('html').scrollTop() > 0) {
            if ($nav.data('size') == 'big') {
                mastFix();
                $( social ).css('display', 'none');
                $( nav ).css({
                    display: 'inline',
                    top: '0px',
                });
                if ($(siteHead).length > 0) $( siteHead ).fadeOut("fast");
                $( headerMain ).fadeOut("fast");
                $( nav ).animate({
                    paddingRight: $( 'h1.site-title' ).width() + 45 + 'px',
                }), {queue:false, duration:600};
                $( nav ).css('top', '0px');
                $nav.data('size','small').stop().animate({
                    height:'48px'
                }, 600);
                $( headerMain ).animate({
                    left:200, opacity:"show"}, 600);
                if ($(siteHead).length > 0) $( siteHead ).animate({
                      height:'48px', opacity:"show"}, 600);
            }
        }
        //when scrolled back
        else {
            if ($nav.data('size') == 'small') {
                mastFix();
                $( social ).css('display', 'inline');
                $( nav ).animate({
                    display: 'block',
                    top: '40px',
                }), {queue:false, duration:600}; ;
                $( nav ).animate({
                    paddingRight: '30px',
                }), {queue:false, duration:600};
                $nav.data('size','big').stop().animate({
                    height:'88px'
                }, 600);
                if ($(siteHead).length > 0) $( siteHead ).animate({
                      height:'85px'}, 600);
            }
        }
    });
    //Function to fixing margin for #main
    var marginFix = function() {
        $(main).css({
            marginTop: $(header).height() + 'px',
        });
    };
    //do marginFix and again on window resize along with mastFix
    marginFix();
    $( window ).resize(function() {
        marginFix();
        mastFix();
    });


}); //end jQuery noConflict wrapper