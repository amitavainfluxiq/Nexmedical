
$( document ).ready(function() {
    var theHeight = $(window).height()-60;


    $(".contract_waitingdiv1").css("min-height", theHeight);

    if($(window).width() > 1199 )  {


    $(".contract_waitingdiv_block1").css("min-height", theHeight);

    }






   /*$(".quiz_question ").each(function(){


        alert('text 1 text 1 text 1 text 1');
        $(this).find('span').eq(0).css('font-size','18px');

   });*/


});
