import $ from "jquery"

let breakpoints =  {
    large: 1024,
    medium: 786,
    small: 468,
}


let dom = { 

    image : function (){
        if( window.innerWidth >= breakpoints.medium ){
            $('.left>.img-content').html( $('.right>.img-content').html() )
        }
    },


    avatar: function  () {

        if( ( $(document).scrollTop() >= 100 ) && ( window.innerWidth <= breakpoints.medium ) ){
            $('#avatar').html( $('.right>.img-content').html() )
            $('#avatar').show()
        }else{
            $('#avatar').hide()
        }
    },


    btn: function(){
        if($(document).scrollTop() >= ($('.right').height() - 100)  ){
            $('.btn').addClass('btn-relative')
        }else{
            $('.btn').removeClass('btn-relative')
        }
    }
}   


//On Ready
$(document).ready(()=>{

    setTimeout( function(){
       $(this).scrollTop(0)
    }, 10)

    dom.image()
})

//On Scroll
$(document).scroll( function(){
    dom.avatar();
    dom.btn()
})

//export
export default { dom:dom, breakpoints: breakpoints}