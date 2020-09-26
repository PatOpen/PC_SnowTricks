(function ($) {
    "use strict";

    $('#button-media').click(function (){
        $('#media').toggle("slow", "swing");
    })

    $('#backTop').hide();
    $(window).scroll(function (){
        $('#backTop').each(function () {
            let topWindow = $(window).scrollTop();
            if (topWindow > 800){
                $('#backTop').show();
            }else{
                $('#backTop').hide();
            }
        })
    });

    $('span#modifier').tooltip({title: 'Modifier', placement: 'top', offset: '0 , 5'})
    $('span#supprimer').tooltip({title: 'Supprimer', placement: 'top', offset: '0 , 5'})

    $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function () {
        if (
            location.pathname.replace(/^\//, "") ===
                this.pathname.replace(/^\//, "") &&
            location.hostname === this.hostname
        ) {
            let target = $(this.hash);
            target = target.length
                ? target
                : $("[name=" + this.hash.slice(1) + "]");
            if (target.length) {
                $("html, body").animate(
                    {
                        scrollTop: target.offset().top - 72,
                    },
                    1000,
                    "easeInOutExpo"
                );
                return false;
            }
        }
    });

    // Closes responsive menu when a scroll trigger link is clicked
    $(".js-scroll-trigger").click(function () {
        $(".navbar-collapse").collapse("hide");
    });

    // Activate scrollspy to add active class to navbar items on scroll
    $("body").scrollspy({
        target: "#mainNav",
        offset: 74,
    });

    // Collapse Navbar
        let navbarCollapse = function () {
            if ($("#mainNav").offset().top > 100) {
                $("#mainNav").addClass("navbar-shrink");
            } else {
                $("#mainNav").removeClass("navbar-shrink");
            }
        };

    navbarCollapse();

    $(window).scroll(navbarCollapse);
})(jQuery); // End of use strict
