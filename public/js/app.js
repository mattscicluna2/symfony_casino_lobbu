(function($){
    "use strict";

    $(window).on('load', function(){
        //preloader
        $(".preloader").delay(300).animate({
            "opacity" : "0"
        }, 500, function() {
            $(".preloader").css("display","none");
        });

        new WOW().init();

        $('.nice-select').niceSelect();

        //On order filter change go to page
        $(".games-order-filter").change(function(){
            window.location.href = "/games/1/" + $(this).val() + "/" + $(".games-search-text").val();
        });

        //On search filter change go to page
        $(".games-search-text").on('keypress', function (e) {
            if(e.which === 13){
                window.location.href = "/games/1/"+ $(".games-order-filter").val() + "/" + $(this).val();
            }
        });

        $(".hero").on('mousemove',function(e) {
            parallaxIt(e, ".el-1", -45);
            parallaxIt(e, ".el-2", -25);
            parallaxIt(e, ".el-3", -50);
            parallaxIt(e, ".el-4", -35);
            parallaxIt(e, ".el-5", -60);
            parallaxIt(e, ".el-6", -40);
            parallaxIt(e, ".el-7", -45);
            parallaxIt(e, ".el-8", -35);
            parallaxIt(e, ".el-9", -50);
            parallaxIt(e, ".el-10", -35);
            parallaxIt(e, ".el-11", -40);
        });

        function parallaxIt(e, target, movement) {
            var $this = $(".hero");
            var relX = e.pageX - $this.offset().left;
            var relY = e.pageY - $this.offset().top;

            TweenMax.to(target, 1, {
                x: (relX - $this.width() / 2) / $this.width() * movement,
                y: (relY - $this.height() / 2) / $this.height() * movement
            });
        }

        $(".inner-hero").on('mousemove',function(e) {
            parallaxIt2(e, ".el-1", -15);
            parallaxIt2(e, ".el-2", -25);
            parallaxIt2(e, ".el-3", -18);
            parallaxIt2(e, ".el-4", -10);
            parallaxIt2(e, ".el-5", -15);
            parallaxIt2(e, ".el-6", -25);
        });

        function parallaxIt2(e, target, movement) {
            var $this = $(".inner-hero");
            var relX = e.pageX - $this.offset().left;
            var relY = e.pageY - $this.offset().top;

            TweenMax.to(target, 1, {
                x: (relX - $this.width() / 2) / $this.width() * movement,
                y: (relY - $this.height() / 2) / $this.height() * movement
            });
        }
    });

    $(window).on("scroll", function() {
        if ($(this).scrollTop() > 200) {
            $(".scroll-to-top").fadeIn(200);
        } else {
            $(".scroll-to-top").fadeOut(200);
        }
    });

    // Animate the scroll to top
    $(".scroll-to-top").on("click", function(event) {
        event.preventDefault();
        $("html, body").animate({scrollTop: 0}, 300);
    });

})(jQuery);
