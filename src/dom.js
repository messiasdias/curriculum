import $ from "jquery"

let breakpoints =  {
    large: 1024,
    medium: 786,
    small: 468,
}


let dom = { 
    // < 
    scroolIsSml: function($num){
        return ($(document).scrollTop() < $num);
    },
    // >=
    scroolIsBig: function($num){
        return ($(document).scrollTop() >= $num);
    },

    isSmall: function(){
        return window.innerWidth < breakpoints.medium
    },

    isMedium: function(){
        return (window.innerWidth >= breakpoints.medium) && (window.innerWidth < breakpoints.large)
    },

    isLarge: function(){
        return window.innerWidth >= breakpoints.large
    },

    avatar: function  () {
        if(dom.isSmall()) { 
            if( dom.scroolIsBig(200) && dom.scroolIsSml($('.right').height()) ){
                if (!$('#avatar').is(":visible")) {
                    $('#avatar').html($('.right>.img-content').html())
                    $('#avatar').show()
                }
            }else{
                $('#avatar').hide()
            }
        }else{
            $('#avatar').hide()
        }
    },

    btn: function(){

       if( dom.isSmall()  ){

            if( dom.scroolIsBig( 800 ) | dom.scroolIsBig( $('.right').height() )  ){
                $('.btn').removeClass('btn-fixed-lg')
                $('.btn').removeClass('btn-fixed-md')
                $('.btn').addClass('btn-relative')
            }else{
                $('.btn').removeClass('btn-fixed-lg')
                $('.btn').removeClass('btn-relative')
                $('.btn').addClass('btn-fixed-md')
            }
        }
        
        if ( dom.isMedium() ){
            $('.btn').addClass('btn-fixed-lg')

            if( dom.scroolIsSml( 200 )  ){
                $('.btn').removeClass('btn-relative')
                $('.btn').removeClass('btn-fixed-md')
            }
        } 


        if( dom.isLarge() ){
            $('.btn').removeClass('btn-fixed-md')
            $('.btn').removeClass('btn-relative')
            $('.btn').addClass('btn-fixed-lg')
        }

    }


}   


//On Ready
$(document).ready( function() {
    setTimeout( function(){
       $(this).scrollTop(0)
    }, 10)
    dom.btn()
    dom.avatar()
})

//On Scroll
$(document).scroll( function(){
    dom.avatar()
    dom.btn()
})

//On Resize
$(window).resize( function(){
    dom.avatar()
    dom.btn()
})




//export
export default { dom:dom, breakpoints: breakpoints}