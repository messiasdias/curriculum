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

        if( window.innerWidth <= breakpoints.medium ) { 

            if(  ( $(document).scrollTop() > 200 )  &&
                ( $(document).scrollTop() < ($('.right').height() ) )  ){
                
                $('#avatar').html( $('.right>.img-content').html() )
                $('#avatar').show('fast')

            }else{
                $('#avatar').hide()
            }

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
    console.log( $('.right').height() , $(document).scrollTop() )
})

//export
export default { dom:dom, breakpoints: breakpoints}