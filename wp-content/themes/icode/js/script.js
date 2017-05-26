/* 
 * script.js
 */

var errUserName     = 'Please enter your name'
,   errTwitter      = 'Please enter your twitter username'
,   errMessage      = 'Please enter your message'
,   errEmail    = 'Please enter your email address'
,   errInvalidEmail = 'Please enter a valid email address'
,   errDefault  = 'Please fill this field'
,   errFailed   = 'Oops, something went wrong. Please try again!'
,   subscribeSuccess = 'Subscribed successfully';

var tmpObj = {};

// Doc. ready
jQuery(document).ready(function($){
    // Search - Load more
    $(document).on('click', '.load-more', function() {
       var dataAttr = $('#search-key').attr('data-attr')
       ,    split = dataAttr.split('`')
       ,    total = split[0]
       ,    startLimit = split[1]
       ,    perPage     = split[2]
       ,    data        = split[3];
       
       $('.load-more').fadeOut('slow').html('Loading ...').delay(1000).fadeIn('slow');
       
       // Calculate Next Start Limit.
       startLimit = parseInt( startLimit )+parseInt( perPage );
       $('#search-key').attr('data-attr', total+'`'+startLimit+'`'+perPage+'`'+data);
       
       $.get( tmplUri+'/ajax/search-more.php', { total: total, startLimit: startLimit, perPage: perPage, data:data }, function( results ){
           $('.load-more').remove();
           $('#search-posts').append( results );
       });
       
    });
    
    // Contact Us
    $(document).on('submit', '.form', function(e){
        tmpObj = {};
        $('.global-msg').remove();
        
        var $this = $(this)
        ,   err     = false
        ,   dataAttr      = $this.attr('data-attr')
        ,   msg = '';
        
        if( typeof dataAttr == 'undefined' || dataAttr == '' ) return false;
        
        /*
         * Validate the input fields. 
         */
        if( autoValidate( $this ) ){
        
            /*
             * Send an Ajax
             */
            $.post(tmplUri+'/ajax/'+dataAttr+'.php', {data: $this.serializeArray()}, function(results){
            //$.post(tmplUri+'/ajax/'+dataAttr+'.php', {data: 'KKLK'}, function(results){
                //console.log('TmpObj: '+JSON.stringify(tmpObj));
                if(/success/ig.test(results)) {
                    switch( dataAttr ) {
                        case 'contact':
                            msg = 'Thanks for your feedback. We will get back you soon.';
                        break;    

                        default:
                            msg = 'Thank you for submitting! We will get back you soon.';
                        break;    
                    }
                }else {
                    msg = 'Oops, something went wrong! Please try again.';
                }
                
                $('header').after('<span class="errBox global-msg" >'+msg+'</span>');
                $('html, body').animate({
                    scrollTop: $('.global-msg').offset().top-($('header').height()+60)
                }, 1400);
                clear();
            });
        }
        
        e.preventDefault();
        return false;
    });
    
    // Search
    $('.searchOptions .selectMenu').selectmenu({
        change: function(){
            $('#advanced-search-value').val( $(this).val() );
            $('.searchMain form').submit();
        }
    });
    
    // Comments
    $('#comments .replyBox input[type="submit"], #comment-submitBtn').on('click', function(e){
        tmpObj = {};
        $('.global-msg').remove();
        
        var $this = $(this)
        ,   err     = false
        ,   id      =   $this.attr('id')
        ,   hiddenVal = $('#hidden').val();
        
        // Post Id
        tmpObj.postId = hiddenVal;
        
        if( id == 'comment-submitBtn' ){
            /*
             * Comment Form 
             */
            var parentId = 'comment-submit';
            tmpObj.commentParent = 0;
            tmpObj.commentEmail = $('#'+parentId+' .comment-email').val();
            tmpObj.commetAuthorTwitter = $('#'+parentId+' .comment-twitter').val();
            
        }else{
            var commentId = $this.attr('data-id')
            ,   parentId = 'comment-'+commentId
            ,   commentEmail = $('#'+parentId+' .comment-email').val();
            
            tmpObj.commentParent = commentId;
            
            /*
             * Check whether the Email / Twitter 
             */
            if( validateEmail( commentEmail ) ) tmpObj.commentEmail = commentEmail;
            else tmpObj.commetAuthorTwitter = commentEmail;
        }
        
        tmpObj.commentAuthor = $('#'+parentId+' .comment-author').val();
        tmpObj.content = $('#'+parentId+' textarea').val();
        
        /*
         * Validate the input fields. 
         */
        if( autoValidate( $('#'+parentId) ) ){
        
            /*
             * Send an Ajax
             */
            $.post(tmplUri+'/ajax/comments.php', {data: tmpObj}, function(results){
                //console.log('TmpObj: '+JSON.stringify(tmpObj));
                $('header').after('<span class="errBox global-msg" >Thanks for your comment. It will be published immediately after it has been approved.</span>');
                $('html, body').animate({
                    scrollTop: $('.global-msg').offset().top-($('header').height()+60)
                }, 1400);
                
                // Make as default as "Reply Box"
                var $arrowBtn = $('.showComments > div > span i.fa-reply')
                $arrowBtn.removeClass('active');
		$arrowBtn.parent().siblings('.replyBox').slideUp();
                
                /*
                 * clear Input fields
                 */
                clearInputFields( $('#'+parentId) );
                
                clear();
            });
        }
        
        e.preventDefault();
        return false;
    });
    
    
    // Subscribe 
    $('#subscribe input[type="submit"]').on('click', function(){
        $('.errBox').remove();
        
        var $this   = $(this)
        ,   email = $('#subscribe-email').val()
        
        if( email == '' ) {
            $('#subscribe-email').before('<span class="errBox">'+errEmail+'</span>');
            return false;
        }else if(!validateEmail(email)){
            $('#subscribe-email').before('<span class="errBox">'+errInvalidEmail+'</span>');
            return false;
        }
        
        // Send Ajax.
        $.post(tmplUri + '/ajax/subscribe.php', {email: email}, function(results){
            if(/success/ig.test(results)){
                // Success
                console.log('Success');
                $('#subscribe-email').before('<span class="errBox">'+subscribeSuccess+'</span>');
            }else{
                console.log('Error');
                $('#subscribe-email').before('<span class="errBox">'+errFailed+'</span>');
            }
            clear();
        })
        
    })
});


// Functions

function autoValidate( $parentId ){
    var err = 0;
    $('.errBox').remove();
    
    $parentId.find('.req').each(function(){
        var errMsg = ''
        ,   dataAttr = $(this).attr('data-type')
        ,   value = $(this).val();

        if( dataAttr != 'undefined' && dataAttr != '' ){
            switch( dataAttr ){
                case 'username':
                case 'name':    
                    if( value == '' ) errMsg = errUserName;
                break;    

                case 'email':
                    if( value == '' ) errMsg = errEmail;
                    else if( !validateEmail( value ) ) errMsg = errInvalidEmail;
                break;

                case 'twitter':
                    if( value == '' ) errMsg = errTwitter;
                break;

                case 'message':
                    if( value == '' ) errMsg = errMessage;
                break;
                
                default:
                    if( value == '' ) errMsg = errDefault;
                break;
            }

        }

        if( errMsg != '' ){
            err++;
            $(this).parent('div').before('<span class="errBox">'+errMsg+'</span>');
        }
    });
    
    if( err == 0 ){
        return true;
    }else{
        return false;
    }

 } // autoValidate()

function clearInputFields( $this ) {
    // Clear Input fields.
    $this.find('*').filter(':input').not(':input[type="submit"],:input[type="button"],:input[type="reset"]').each(function(){
        $(this).val('');
    });
}

function clear(){
    window.setTimeout( function(){
        $( '.errBox, .global-msg' ).fadeOut( 700, function(){ $( '.errBox, .global-msg' ).remove(); });
    }, 7000 );
}

function validateEmail( email ){
     var objRegExp = /^[a-z0-9]([a-z0-9_\-\.]*)@([a-z0-9_\-\.]*)(\.[a-z]{2,3}(\.[a-z]{2}){0,2})$/i;
     return objRegExp.test( email );
}

