/* 
 * script.js (admin)
 */

var $ = jQuery
,   fadeDelay = 1000; 

$(document).ready(function(){
    
    /*
     * Header Logo
     */
    $('#logo-remove-btn').on('click', function() {
        $('#header-logo').removeClass('none').attr('name', 'header-logo');
        $(this).remove();
        $('#header-logo-img, #hidden-header-logo').remove();
        $('#theme-options form input[type="submit"]').trigger('click');
        return false;
        
    });
    
    $('#theme-options form input[type="submit"]').on('click', function(){
            console.log( 'Clicked!!' );
          $('#theme-options form').removeAttr('onsubmit').submit(); 
    });
    
   $('#theme-options-menu span').on('click', function(){
       var dataAttr = $(this).attr('data-attr');
       $('#theme-options-menu span').removeClass('active');
       $('.panel').hide().removeClass('active');
       $(this).addClass('active').fadeIn(fadeDelay, function(){
           $('#panel-'+dataAttr).fadeIn(fadeDelay).addClass('active'); 
       });
   }); 
});



