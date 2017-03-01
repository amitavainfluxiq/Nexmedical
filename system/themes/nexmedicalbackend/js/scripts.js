$( document ).ready(function() {

    //alert('text 1 text 1 text 1 text 1');

    var theHeight = $(window).height()-60;


    $(".contract_waitingdiv1").css("min-height", theHeight);







  /*  var doctorpageHeight = $(window).height();

    alert(doctorpageHeight);*/

    if($(window).width() > 1199 )  {


    $(".contract_waitingdiv_block1").css("min-height", theHeight);

    }






   /*$(".quiz_question ").each(function(){


        alert('text 1 text 1 text 1 text 1');
        $(this).find('span').eq(0).css('font-size','18px');

   });*/


   //$('.big_icon').removeAttr('onclick');
  /*  $('.big_icon').click(function(){

        //alert(9);
        setInterval(function(){
            $('#jonbox_content').find('.icon_button').eq(1).remove();
            $('#jonbox_content').find('.icon_button').eq(0).css('display','block');
            $('#jonbox_content').find('h2').eq(0).css('documents_table','inherit');
        },1000);
    });*/




    $(".menuicon").click(function(){
        $(".menu_block2_ullink").toggleClass("removemenu");
    });

});
