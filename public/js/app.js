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

    loadPagination();

    $('#button-media').click(function (){
        $('#media').toggle("slow", "swing");
    })

})(jQuery);

function loadPagination(){

    const collection = $('.div-tricks');
    let loader = collection.find('#loader');
    loader.find('.fa-spinner').hide();

    let numberTricksPagination = collection.data('number-tricks-pagination');
    const url = collection.data('url');
    const totalTricks = collection.data('total-tricks');
    const totalPages = Math.ceil(totalTricks / numberTricksPagination);
    let currentPage = 1;

    loader.on('click', function () {

        loader.find('.fa-arrow-down').hide();
        loader.find('.fa-spinner').show();


        setTimeout(function () {

            $.post(url + numberTricksPagination, function(data){

                if (data !== '') {

                    collection.find($('#loader')).before(data);

                    numberTricksPagination+= 9;
                    currentPage++;

                } else {
                    loader.html('<div class="alert alert-warning" role="alert">Oops, il n\'y a plus de contenu.</div>');
                }

                loader.find('.fa-spinner').hide();

                if (totalPages !== currentPage) {
                    setTimeout(function () {
                        loader.find('.fa-arrow-down').show();
                    }, 300);
                }
            });
        }, 1500);
    });
}