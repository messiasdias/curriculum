import $ from "jquery"


$(document).ready(()=>{

    setTimeout( function(){
       $(this).scrollTop(0)
    }, 10)

})


$(document).scroll(function(){

    if( ( $(this).scrollTop() >= 200 ) && ( window.innerWidth <= 768 ) ){
        $('.img-content-fixed').show()
    }else{
        $('.img-content-fixed').hide()
    }

    if($(this).scrollTop() >= ($('.right').height() - 100)  ){
        $('.btn').addClass('btn-relative')
    }else{
        $('.btn').removeClass('btn-relative')
    }

})