import $ from "jquery"


$(document).ready(()=>{

    setTimeout( function(){
       $(this).scrollTop(0)
    }, 10)

})


$(document).scroll(function(){

    //console.log( $(this).scrollTop(), $('.right').height()-1 )

    if($(this).scrollTop() >= ($('.right').height() - 50)  ){
        $('.btn').addClass('btn-relative')
    }else{
        $('.btn').removeClass('btn-relative')
    }

})