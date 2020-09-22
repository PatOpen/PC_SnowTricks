(function ($) {
    "use strict";

    $('span#modifier').tooltip({title: 'Modifier', placement: 'top', offset: '0 , 5'})
    $('span#supprimer').tooltip({title: 'Supprimer', placement: 'top', offset: '0 , 5'})

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



})(jQuery);