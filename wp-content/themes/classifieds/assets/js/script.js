/* 
 * script.js
 */

/** Functions **/

function getSamplePosts(){
    
    setTimeout(function(){
        var $activeTab  = $('#sample-posts .tab-header > div.active')
        ,   data = {
            'action': 'sample-posts',
            'data'  : {
                'type'  : $activeTab.attr('data-type')    
            }
        };
        
        $($activeTab.attr('data-target')).html('<div class="no-results">Please wait ...</div>');

        if( typeof data.data.type !=  'undefined' ) {
            $.post( siteUrl + 'ajax/common.php', data, function( results ){
                    $($activeTab.attr('data-target')).html( results );

                    /** Call neccesary functions **/
                    ajaxCallback();
            });

        }
    }, 1000);
    
}


function scriptAjaxCallback() {
    // Search button
    if( $('#advanced-search').length > 0 ) {
        if( $('#main-content #adv-search-btn').length == 0 ) {
            $('#main-content .quick-search-box').after( '<button id="adv-search-btn" class="btn"><i class="fa fa-search"></i> Show Advanced</button>' );
        }

        if( $('.quick-search-box').val() == '' ) {
            $('#adv-search-btn').fadeOut('slow');
        }else{
            $('#adv-search-btn').fadeIn('slow');
            
            if( $('#adv-search-btn').hasClass('active') ) {
                // Open Search fields.
                $('#advanced-search').show();
            }
        }
    }
}


/** jQuery DOM Ready **/

$(document).on('ready', function(){
    var page  = 'home';
    
    $(document).on('change', '.state', function(){

        var stateId = $(this).val()
        ,   _city = $(this).attr('data-trigger')
        ,   data  = {
            'action' : 'list-cities',
            data   : {
                'stateId'   : stateId 
            } 
        };  

        if( typeof _city != 'undefined' ) {
            // Get Cities
            
            $.post( siteUrl + 'ajax/common.php', data, function( results ){
                    results = JSON.parse(results);
                    $(_city).html( results );

                    /** Call neccesary functions **/
                    ajaxCallback();
            });
            
        }
        
    });
    
    /*for(var p=0; p<pages.length; p++) {
        var url = window.location.href
        ,   regExp = new RegExp('^(.*)\/views\/'+ pages[p] +'(.*)$');
        
        if( url.match( regExp ) !== null ) {
            page = pages[p];
            break;
        }
        
    }
    
    console.log( 'Current Page: '+page );
    $('body').attr('id', page); */
    
    var $sideSrchBox = $('#side-menu .quick-search-box')
    ,   placehoder  = 'Quick Search ...';
    
    if( $('#main-content .quick-search-box').length > 0 ) {
        placehoder = $('#main-content .quick-search-box:first').attr('placeholder');
        
        $sideSrchBox.attr( 'placeholder', placehoder );
    }else{
        // Remove Sidebar Search input
        $sideSrchBox.remove();
        $('#quick-search .fa-search').remove();
    }
    
    //$sideSrchBox.attr( 'placeholder', placehoder );
    
    $(document).on('scroll', function(){
        if( ($(window).scrollTop() + $(window).height()) > ($(document).height() - $('footer').outerHeight() ) )  {
            $('footer').fadeOut('slow');
        }else{
            $('footer').fadeIn('slow');
        }
    });
  
    
    
    /** Home **/
    /*$(document).on('click', '#home #main-cat-sec .block', function(){
        var mainCat = $(this).attr( 'data-id' )     
        ,   data    = {};
            
        if( typeof mainCat == 'undefined' || mainCat == '' ) {
            return false;
        }
        
        data['main_cat'] = mainCat;
        $.post( siteUrl + 'ajax/category.shtml', { data : data }, function( results ){
            $('#browse-box').fadeOut('slow', function(){
                $(this).fadeIn('slow').html( results );  
            });
        });
        
        
    });*/
    
    
    /** Publish **/
    $(document).on('click', '#publish .control-icon', function(){
            var fileNo = $(this).attr('data-no');
            if( typeof fileNo == 'undefined' ) {
                fileNo = 1;
            }
            
            if( $(this).attr('id') == 'add-file-icon' ) {
                fileNo++;
                var  html = '<div id="file-'+ fileNo +'" style="margin-top: 5px;"><input type="file" name="file[]" ><i data-no="'+ fileNo +'" class="fa fa-minus-circle control-icon"></i></div>';
                $(this).parent('div').after( html );
                $(this).attr( 'data-no', fileNo );
            }else{
                // Remove
                $('#file-'+fileNo+' input[type="file"]').val('');
                $('#file-'+fileNo).slideUp('slow');
            }    
    });
    
    
    /** Posts **/
    $(document).on('click', '.show-contacts-btn', function(){
        var $details = $(this).next('.show-contacts-details');
        $(this).fadeOut('slow');
        $details.delay(600).slideDown('slow');
    })
    
    $(document).on( 'click', '.results .info-opener', function( e ){
        //alert( 'cliked' );
            if( $(this).hasClass('active') ) {
                // slideUp
                $(this).parents('.block').find( '.info' ).slideUp('slow');
                $(this).addClass( 'fa-chevron-down' ).removeClass('fa-chevron-up');
                
            }else{
                $(this).parents('.block').find( '.info' ).slideDown('slow');
                $(this).addClass( 'fa-chevron-up' ).removeClass('fa-chevron-down');
                
            }
            $(this).toggleClass('active');
            e.preventDefault();
    });
    
    /** Login **/
    $('#login-content input[type="submit"]').on('click', function(){
            var type    = $(this).attr('name')
            ,   title   = 'Login';
            
            $('input[type="submit"].active').removeClass('active');
            if( type == 'reg' ) {
                // Show Reg. Form
                $('#login-form').slideUp('slow');
                $('#reg-form').slideDown('slow');
                title = 'Register';    
            }else{
                
                // Show Login. Form
                $('#reg-form').slideUp('slow');
                $('#login-form').slideDown('slow');
                
            }
            
            //alert(this);
            $(this).toggleClass('active');
            $('.page-title h1').html( title );
            
            return false;
        
    });
    
    /** Search **/
    var searchInter = '';
    
    $(document).on( 'click', 'input[name="discount-type"]', function(){
        if( $(this).attr('id') == 'discount-type-per' ) {
            // Percent
            $('input.discount').fadeOut('slow', function(){
                $('select.discount').fadeIn();
            })
            
        }else{
            // Cash
            $('select.discount').fadeOut('slow', function(){
                $('input.discount').fadeIn().focus();
            });
        }
        
    });
    
    $(document).on( 'click', '#adv-search-btn', function(){
        if( $(this).hasClass('active') ) {
            $('#advanced-search').slideUp('slow', function(){
                $(this).find('*').filter(':input').not('.btn').each(function(){
                    $(this).val('');
                })
            });
            $(this).html( '<i class="fa fa-search"></i> Show Advanced' ).removeClass('active');
        }else{
            $('#advanced-search').slideDown('slow');
            $(this).html( '<i class="fa fa-search"></i> Hide Advanced' ).addClass('active');
        }
        
    });
    
    $(document).on( 'keyup', '.quick-search-box', function(){
        var $this   = $(this)
        ,   value   = $this.val();
        window.clearInterval( searchInter );
        
        searchInter = window.setInterval(function(){
                window.clearInterval( searchInter );
                
                if( value == '' ) {
                    $('#adv-search-btn').fadeOut( 'slow' );
                }
                
                /*
                 * Only sidebar "Quick serach is there.."
                 */
                /*if( $('.quick-search-box').length == 1 ) {
                    // Get Home page content
                    //$.post( siteUrl + 'views/home.shtml', {}, function( results ){
                        $('body').attr('id', 'home');
                        var html = '<div id=>';
                        
                        $('#content .site-wrapper').html( results );
                        $('.quick-search-box').trigger('keyup');
                    //});
                    
                    //return false;
                }*/
                
                $('.quick-search-box').val( value );
                
                if( $('#content #main-cat-sec' ).length > 0 ) {
                    // Home Page
                    
                    var $results = $('#browse-box .results');
                    if( $results.length == 0 ) {
                        $('#browse-box').append( '<div class="results"></div>' );
                        $results = $('#browse-box .results');
                    }
                    
                    if( value == '' ) {
                        $results.fadeOut( 'slow', function(){
                            $('#main-cat-sec').fadeIn( 'slow' );
                        });
                
                        
                    }else{
                        $('#main-cat-sec').fadeOut( 'slow', function(){
                            $results.fadeIn( 'slow' );
                        });
                        
                        var data = {
                            value : value
                        };

                        $.post( siteUrl + 'ajax/search.php', { data: data }, function( results ){
                                $('#browse-box .results').html( results );
                                
                                /** Call neccesary functions **/
                                ajaxCallback();
                        })
                        
                    }   
                    
                }else if( $('#content #sub-cat' ).length > 0 ) {
                    // Category Page
                    
                    if( value == '' ) {
                        $( '#sub-cat .block' ).fadeIn( 'slow' );
                    }else{
                        $( '#sub-cat .block' ).each(function(){
                            var content = $(this).find( 'h4' ).text()+' '+$(this).find( '.info' ).text()
                            ,   regExp = new RegExp(  value, 'ig' );
                            
                            if( content.match( regExp ) ) {
                                $(this).fadeIn( 'slow' );
                            }else{
                                $(this).fadeOut( 'slow' );
                            }
                        })
                    
                    }
                    
                    
                }else if( $('#content #posts-content' ).length > 0 ) {
                    // Posts Page
                    
                    var $h1 = $( '#posts-content .page-title h1')
                    ,   $div = $( '#posts-content .page-title div');
                    if( value == '' ) {
                        $('#search-title').remove();
                        $h1.fadeIn('slow');
                        $div.text( $div.attr( 'actual-content' ) ).attr( 'actual-content', '');
                        //$( '#posts-content .block' ).fadeIn( 'slow' );*/
                        
                        $('#posts-content .results').fadeOut( function(){ $(this).html(''); $('#posts-content #posts').fadeIn('slow'); })
                    }else{
                        
                        
                        var data = {
                            page    : 'posts',
                            value : value,
                        };

                        $('#posts-content #posts').fadeOut();
                        
                        $.post( siteUrl + 'ajax/search.php', { data: data }, function( results ){
                                if( $('#posts-content .results').length == 0 ) {
                                    $('#posts-content #posts').after( '<div class="results"></div>' );
                                }
                                $('#posts-content .results').html( results ).fadeIn('slow');
                                
                                if( $('#search-title').length == 0 ) {
                                    $h1.after( '<h1 id="search-title"></h1>');
                                }
                                var $hidden = $('#posts-content .results #hidden-search')
                                ,   hiddenVal = JSON.parse( $hidden.val() )
                                ,   matches   = hiddenVal.total;     
                                
                         
                                
                                /*$( '#posts-content .block' ).each(function(){
                                    var content = $(this).find( 'h4' ).text()+' '+$(this).find( '.content p' ).text()
                                    ,   regExp = new RegExp(  value, 'ig' );

                                    if( content.match( regExp ) ) {
                                        matches++;
                                        $(this).fadeIn( 'slow' );
                                    }else{
                                        $(this).fadeOut( 'slow' );
                                    }
                                })*/

                                if( $div.attr( 'actual-content') == '' || typeof $div.attr( 'actual-content') == 'undefined' ) {
                                    $div.attr( 'actual-content', $div.text() );
                                }

                                if( matches == 0 ) {
                                    html = 'No results';
                                    $div.text( '' );
                                }else{
                                    html = 'Results';
                                    $div.text( matches );
                                }

                                html +=  ' for "'+ value+'"';
                                $h1.fadeOut( function(){
                                    $('#search-title').html( html ).fadeIn('slow');
                                });
                                
                                /** Call neccesary functions **/
                                ajaxCallback();
                            
                        }) // ajax
                        
                        
                    
                    }
                    
                    
                    
                }
                
                
                
        }, 700);
    })
    
       
    
    /** Single **/
    
    $(document).on( 'click', '#single-content #comments .info-opener', function(){
        console.log( 'Clicked' );
        var $parent = $(this).parents('ul')
        ,   $target = $parent.find('li > ul');
        if( $(this).hasClass('active') ) {
            $target.fadeOut( 'slow' );
            $parent.removeClass( 'break-line' );
            $(this).addClass( 'fa-chevron-down' ).removeClass('fa-chevron-up');
        }else {
            $target.fadeIn( 'slow' );
            $parent.addClass( 'break-line' );
            $(this).addClass( 'fa-chevron-up' ).removeClass('fa-chevron-down');
        } 
        
        $(this).toggleClass('active');
                
        
        
    });
    
    if( $('#sample-posts').length > 0 ) {
        getSamplePosts();
        
        $('#sample-posts .tab-header > div').on('click', function(){
            getSamplePosts();
        });
    }
    
    var sliderLen = $('.slider').length
    ,   leastHeight  = 200
    ,   maxHeight = 450
    ,   slidersArr = {};
    
    if( sliderLen > 0 ){
        
        function getSlideOptions( $this ) {
            var sliderId = $this.attr( 'id' )
            ,   dataDelay = $this.attr( 'data-delay' )
            ,   imgLen  = $this.find('img').length
            ,   slideNo = $this.attr( 'slide-no' )
            ,   options = {
                'imgLen'  : imgLen,
                'slideNo' : slideNo   
            };
            
            if( typeof sliderId == 'undefined' ) {
                sliderId = 'slider-'+options.slideNo;
                $this.attr( 'id', sliderId );
            }
            options['sliderId'] = sliderId; 
            
            if( typeof dataDelay == 'undefined' ) {
                dataDelay = 5000;
            }
            options['dataDelay'] = dataDelay;
            
            var animateDur = Math.floor( dataDelay/4 );
            options['animateDur'] = animateDur;
            
            return options;
        }
        
        function slide( $this ) {
            
            var options = getSlideOptions( $this )
            ,   sliderId = options.sliderId;
            
            objToArr( options );
            
            var timer = window.setInterval(function(){
                var dataId = $('#'+sliderId+' > img.active').attr('data-id');
                
                // Hide Current Img
                $('#'+sliderId+' > .img-'+dataId).fadeOut( options.animateDur );
                window.setTimeout( function(){
                    
                    setSlide( $this, 1 );
                }, (options.animateDur-options.imgLen));

            }, options.dataDelay );

            slidersArr[$(this)] = timer;
            $('#'+sliderId+' .controls i.fa-play ').removeClass( 'fa-play' ).addClass( 'fa-pause' );
        }
        
        function setSlide( $this, seek ) {
            var options = getSlideOptions( $this )
            ,   sliderId = options.sliderId
            ,   dataId      = parseInt( $this.find(' > img.active').attr('data-id') );
            
            if( typeof seek != 'undefined' ) {
                dataId += seek; 
            }

            if( dataId >= options.imgLen || seek == 'first' ) {
                // Reached Max Slide
                dataId = 0;
            }else if( dataId < 0 || seek == 'last' ) {
                dataId = options.imgLen-1;
            }
            
            $('#'+sliderId+' > img.active').fadeOut(function(){
                $(this).removeClass('active');
                $('#'+sliderId+' > .img-'+dataId).fadeIn( options.animateDur ).addClass('active');
                $('#'+sliderId+' .controls .count').html( '<span>'+(dataId+1) + '</span>/'+options.imgLen );
            });
            
        }
        
        $('.slider').each(function(i, key){
            $(this).attr( 'slide-no', i );
            
            var options = getSlideOptions( $(this) )
            ,   sliderId = options.sliderId
            ,   minHeight   = 1;
            
            $('#'+sliderId+' > img').each(function(k){
                $(this).attr('data-id', k).attr('class', 'img-'+k);
                
                if( $(this).height() > minHeight ) {
                    minHeight = $(this).height();
                }
            })
            
            if( minHeight > maxHeight ) {
                minHeight = maxHeight;
            }
            
            if( minHeight < leastHeight ) {
                minHeight = leastHeight;
            }
            
            $('#'+sliderId).css({'height': minHeight+'px', 'min-height': minHeight+'px', 'min-width': minHeight+'px'});
            $('#'+sliderId+' > img').css({ 'max-height': minHeight+'px' });
            $('#'+sliderId+' > .controls').css({ 'top': (minHeight+145)+'px', 'width' : $('#'+sliderId).width()+'px' });
            
            $('#'+sliderId+' > img:first').addClass('active');
            
            if( options.imgLen > 1 ) {
                $('#'+sliderId+' .controls').slideDown('slow');
                
                slide( $(this) );
            
            }
            
            $(this).find('.controls i').on( 'click', function(){
                var $slider = $(this).parents( '.slider' );
                
                window.clearInterval( slidersArr[$slider] );
                if( $(this).hasClass( 'fa-pause' ) ) {
                    // Pause
                    $(this).removeClass( 'fa-pause' ).addClass( 'fa-play' );
                }else if( $(this).hasClass( 'fa-play' ) ) {
                    // Play
                    slide( $slider );
                }else if( $(this).hasClass( 'fa-chevron-right' ) ) {
                    // Next Slide
                    setSlide( $slider, 1 );
                    slide( $slider );
                }else if( $(this).hasClass( 'fa-chevron-left' ) ) {
                    // Prev Slide
                    setSlide( $slider, -1 );
                    slide( $slider );
                }else if( $(this).hasClass( 'fa-fast-forward' ) ) {
                    // Last Slide
                    setSlide( $slider, 'last' );
                    slide( $slider );
                }else if( $(this).hasClass( 'fa-fast-backward' ) ) {
                    // Last Slide
                    setSlide( $slider, 'first' );
                    slide( $slider );
                }
                
                
            });
            
        }); // each
        
        
    }
    
    
})


