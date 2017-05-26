/* 
 * base.js 
 * Purpose : Common functionalities.
 */

var sidePanelArr = '';

/** Prototypes **/
Date.prototype.addDays = function( count ) {
    var time    = this.getTime()
    ,   newTime = new Date( time + ( count * 24 * 60 * 60 * 1000 ) );
    
    return this.setTime( newTime.getTime() );
}

/** Functions **/

function objToArr( obj ) {
    Object.keys( obj ).map( function( i, index ){
       console.log( i + ' : ' + obj[i] ); 
    });
    
}

function rand( end, start ) {
    if( typeof start == 'undefined' ) {
        start = 0;
    }
    
    return Math.floor( ( Math.random()*end ) + start);
}

function init() {
    
    $('#content').css({'top' : $('header').outerHeight()+'px'});
    
    
    
    var siteWidth = $('.site-wrapper').width();
    if( siteWidth <= 100 ) {
        // Convert % to px
        $('.site-wrapper').css({width: (siteWidth * ($(window).width()/100))+'px'});
    }
    
    
    // Number Only
    $(document).on('keyup', '.number', function(){
        var value = $(this).val()
        ,   pattern = /^(\d+)$/;

        if( $(this).hasClass('amount') ) {
            pattern = /^([0-9.,]|[0-9])+$/;
        }

        if( value != '' && !pattern.test( value ) ) {
                if( $(this).hasClass('amount') ) {
        // If this is the Amount field then, ignore ‚dot‘ and ‚comma‘ chars
                    value = value.replace( /[^0-9.,]/g, '' );
                }else{
                    value = value.replace( /\D+/g, '' );
                }    
                $(this).focus().val( value );
                alert( 'Only numbers are allowed.' );
                return false;
        }
    });

    
}

function windowWidth() {
    
}

function windowHeight(){
    var winHeight = $(window).innerHeight()-2;
       
    $('.win-height').each(function(){
        var maxHeight = $(this).attr('data-max-height');
        
        if( typeof maxHeight != 'undefined' ) {
            
            $(this).css({'height': (maxHeight*(winHeight/100))+'px', 'max-height': (maxHeight*(winHeight/100))+'px'});
        }else{
            if( $(this).hasClass('strict') ) {
                minHeight = winHeight;
            }else{
                var minHeight   = 1
                ,   offset      = $(this).offset();

                if( offset.top < winHeight ) {
                    minHeight = winHeight-(offset.top+($(this).outerHeight()-$(this).height()));
                }else{
                    minHeight = winHeight;
                }
            }
            
            $(this).css({'min-height': minHeight+'px'});
        }
                   
    })
            
}

function parallel($this) {
    
    if( typeof $this != 'undefined' ) {
        $parallel = $this.find('.parallel');
    }else{
        $parallel = $('.parallel');
    }
    
    $parallel.each(function(){
        var $parent     = $(this).closest('.parallels')
        ,   dataWidth   = $(this).attr( 'data-width' )
        ,   styles      = {};
        
        if( $parent.length == 0 ) {
            $parent = $(this).parent();
        }
        
        var childLen = $parent.find('.parallel').length
        ,   ignore = ($(this).outerWidth()-$(this).width())+(childLen*5);
        
        if( typeof dataWidth != 'undefined' ) {
            styles['width'] = ((dataWidth*($parent.width()/100))-ignore)+'px';
            
        }else{
            styles['width'] = (($parent.width()/childLen)-ignore)+'px';
            
            //console.log($(this).width()+'|'+$(this).outerWidth(true)+'|'+$(this).innerWidth());
            //console.log($parent.innerWidth()+' | '+childLen+'|'+$parent.attr('class'));
            //console.log($parent.width()+'|'+$parent.outerWidth(true)+'|'+$parent.innerWidth());
        }
        
        $(this).css(styles);
        
    });
}

function placeIcons() {
    
    $('.place-icon').each(function(){
        
        var $target = $($(this).attr('data-target'))
        ,   divider = 2;
        
        if( $(this).hasClass('icon') ) {
            divider = 4;
        }
        $(this).css({'margin-top': ($target.height()/divider)+'px'});
    });
}


$(document).on('ready', function(){
    
    init();
    windowHeight();
    parallel();
    sidePanel();
    placeIcons();
    tabs();
    ajaxCallback();
    
});

function ajaxCallback() {
    datePickers();
    
    /** Site Function after Ajax Call **/
    scriptAjaxCallback();
}

function tabs() {
    
    $( document ).on( 'click','.tab-header > div', function(e){
        var $this = $(this)
        ,   $tapId = $this.attr('data-target');
        
        $('.tab').fadeOut('slow');
        $('.tab-header > div').removeClass('active');
        $this.addClass('active');
        window.setTimeout(function(){
            $($tapId).fadeIn('slow');
            //$($tapId + ' input:first').focus();
        }, 500);
        
            
        if( !$this.hasClass('onpage-load') ) {    
            var top = Math.floor( $(window).height()/4 );
            if( $this.offset().top > top ) {
            
                //$('html, body').animate({'scrollTop': $('.tabs').offset().top}, 'slow', 'swing');
                $('html, body').animate({scrollTop: $this.offset().top-top}, 1000);
            }
            
        }else{
            $this.removeClass('onpage-load');
        }
        
        e.preventDefault();
    });
    
    $('.tab-header > div.active').addClass('onpage-load').trigger('click');
    
}

function datePickers( $datepicker ){
    if( typeof $datepicker == 'undefined' ) {
        $datepicker = $('.datepicker');
    }
    
    $datepicker.each(function(){
        var options = {
            'dateFormat'    : 'dd/mm/yy',
            'changeYear'    : true,
            'changeMonth'   : true
        }
        ,   dataFrom    = $(this).attr('data-from')
        ,   dataTo      = $(this).attr('data-to') 
        ,   past = today = future = false;
        
        
        if( $(this).hasClass('today') ) {
            today = true;
        }
        
        if( typeof dataFrom != 'undefined' ) {
            var dataSplit = dataFrom.split('-');
            options['minDate'] = new Date(dataSplit[0], dataSplit[1]-1, dataSplit[2]); //(2015, 11 - 1, 25);
        }else {
         
            if( $(this).hasClass('past') ) {
                past = true;
                options['maxDate'] = -1;
            }

            if( past && today ) {
                options['maxDate'] = 0;   
            }
        }
        
         
        if( typeof dataTo != 'undefined' ) {
            var dataSplit = dataTo.split('-');
            options['maxDate'] = new Date(dataSplit[0], dataSplit[1]-1, dataSplit[2]); //(2015, 11 - 1, 25);
            
        }else{
            
            if( $(this).hasClass('future') ) {
                future = true;
                options['minDate'] = 1;
            }

            if( future && today ){
                options['minDate'] = 0;
            }
        }
        
        /** Set Limit to TO DATE**/
        var dataTarget = $(this).attr( 'data-target' );
        if( typeof dataTarget != 'undefined' ) {
            options['onSelect'] = function( selectedDate ){
                //$('#by-to-date').datepicker( 'options', 'maxDate', selectedDate );
                var sp  = selectedDate.split('/') // 17/11/2015
                ,   dt  = new Date()
                ,   d   = dt.getDate()
                ,   m   = dt.getMonth()
                ,   y   = dt.getFullYear();
                
                $(dataTarget).removeClass('hasDatepicker').attr( 'data-from', sp[2]+'-'+sp[1]+'-'+sp[0] );
                if( past && today ) {
                    $(dataTarget).attr( 'data-to', y+'-'+(m+1)+'-'+d );
                }else if(past){
                    var prevDay = new Date( new Date().addDays(-1) );// [** From Selected Date **] new Date( new Date( sp[2], sp[1]-1, sp[0] ).addDays(-1) );
                    $(dataTarget).attr( 'data-to', prevDay.getFullYear()+'-'+(prevDay.getMonth()+1)+'-'+prevDay.getDate() );
                }
                
                datePickers( $(dataTarget) );
            }
        }
        
        $(this).datepicker(options);
    });
}


$(window).on('resize', function(){
    
    init();
    parallel();
    sidePanel();
    placeIcons();
});


function sidePanel() {
    
    var sidePanels = new Array('slide', 'push');
    sidePanelArr = new Array();
    
    for( var i = 0; i<sidePanels.length; i++ ) {
        sidePanelArr.push(sidePanels[i]+'-left');
        sidePanelArr.push(sidePanels[i]+'-right');
        sidePanelArr.push(sidePanels[i]+'-top');
        sidePanelArr.push(sidePanels[i]+'-bottom');
    }
    
    $('.side-panel-btn').each(function(){
        var dataAction = $(this).attr('data-action')
        ,   dataTarget = $(this).attr('data-target');
        
        //dataAction = sidePanelArr[rand(sidePanelArr.length-1)];
        
        if( typeof dataAction == 'undefined' ) {
            dataAction = 'push-right';
            $(this).attr('data-action', dataAction);
        }
        
        if( typeof dataTarget == 'undefined' ) {
            dataTarget = '#content';
            $(this).attr('data-action', dataTarget);
        }
        
        var maxHeight   = $(window).height()/2
        ,   maxWidth    = $(window).width()/2
        ,   targetHeight= $(dataTarget).height()
        ,   targetWidth = $(dataTarget).width()/2
        ,   actionSplit = dataAction.split('-')
        ,   side        = actionSplit[1]
        ,   styles      = {
            '-webkit-transition'    : '-webkit-transform 0.5s',
                'transition'        : 'transform 0.5s',
                //'display'           : 'block'
        };
        
        //$('.side-panel-push').css(styles);
        
        if( ( side == 'top' || side == 'bottom' ) && targetHeight > 60 ) {
            if( targetHeight > maxHeight ) {
                targetHeight = maxHeight;
                styles['overflow-x']  = 'scroll';
            }
            
            styles['height']            = targetHeight+'px';
            
            if( side == 'top' ) {
                targetHeight = '-'+targetHeight;
            }
            
            styles['-webkit-transform'] = 'translateY('+targetHeight+'px)';
            styles['-ms-transform']     = 'translateY('+targetHeight+'px)';
            styles['transform']         = 'translateY('+targetHeight+'px)';
            
        }else if( targetWidth > 215 ) {
            if( targetWidth > maxWidth ) {
                targetWidth = maxWidth;
            }
            
            styles['width']             = targetWidth+'px';
            styles['-webkit-transform'] = 'translateX('+targetWidth+'px)';
            styles['-ms-transform']     = 'translateX('+targetWidth+'px)';
            styles['transform']         = 'translateX('+targetWidth+'px)';
        }
        
        
        $(dataTarget).addClass(dataAction).delay(1000).css({'display': 'block'});
        $('.side-panel.'+dataAction).css(styles);
        
    });
    
    $('.side-panel-btn').on('click', function(e){
        
        var dataAction = $(this).attr('data-action')
        ,   dataTarget = $(this).attr('data-target')
        ,   dataDelay = $(this).attr('data-delay');
        
        if( typeof dataAction == 'undefined' ) {
            dataAction = 'push-right';
            $(this).attr('data-action', dataAction);
        }
        
        if( $(this).hasClass('spanel-active') ) {
            $('.side-panel-mask').trigger('click');
            return false;
        }
        
        $(this).addClass('spanel-active');
        $('.side-panel-btn').attr('disabled', 'disabled');
        
        if( typeof dataDelay != 'undefined' && dataDelay != '' ) {
            window.setTimeout(function(){
                $('.side-panel-btn.spanel-active').attr('data-close', 'true');
                $('.side-panel-mask').trigger('click');
                return false;
            }, dataDelay*1000);
        }
        
        $('body').addClass('has-active-menu');
        $('#content').addClass('has-'+dataAction);
        $(dataTarget).addClass('is-active '+dataAction);
        if( !$(this).hasClass('no-mask') ) {
            $('body').addClass('mask');
            $('#side-panel-mask').addClass('is-active');
        }
        
        e.preventDefault();
        
    });
    
    
    $('.side-panel-mask, .side-panel .close-btn').on('click', function(){
        var $activeSideBtn = $('.side-panel-btn.spanel-active')
        ,   dataClose = $activeSideBtn.attr('data-close')
        ,   dataAction = $activeSideBtn.attr('data-action')
        ,   dataTarget = $activeSideBtn.attr('data-target');
        
        if( dataClose == 'false' ) {
            return false;
        }
        
        $('body').removeClass('has-active-menu mask');
        $('#content').removeClass('has-'+dataAction);
        $(dataTarget+', #side-panel-mask').removeClass('is-active');
        
        $('.side-panel-btn').removeAttr('disabled', 'disabled').removeClass('spanel-active');
        
    });
    
}


