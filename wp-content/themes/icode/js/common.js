$(document).ready(function(e) {
    $('header ul li ul li').parent().addClass("subMenu");
	$('.subMenu').siblings('a').addClass("subLink");
	$('.subMenu').parent().addClass("subList");
	$('.subList').append('<span class="rite-arrow"></span>');
	$('.subMenu').prepend('<li class="backTo"><a href="#">Back to menu</a></li>');
	
	$('.mobileTrigger').click(function(){ 
	if(!$(this).hasClass('active')){
	$(this).addClass('active');
	$('header, body').animate({left:'240px'});
	$('.mobSlide').animate({left:0});
	} else {
	$(this).removeClass('active');
	$('header, body').animate({left:0});
	$('.mobSlide, .subMenu').animate({left:'-240px'});
	}
	});
	
	$('.rite-arrow').click(function(){
		$(this).siblings('.subMenu').animate({left:0});
		return false;
	});
	
	$('.backTo').click(function(){
		$(this).parents('.subMenu').animate({left:'-240px'});
		return false;
	});
	
	$('.searchTrigger a').click(function(e) {
		$('.searchOverflow').css('z-index','2');
        $('.searchBox').animate({right: 0}, 600);
		return false;
    });
	
	$('.searchBox > i').click(function(e) {
        $('.searchBox').animate({right: '-100%'}, 600, function() { $('.searchOverflow').css('z-index','-1'); })
		return false;
    });
	
	$('.articleDesc > a').hover(function(e){
	$(this).siblings('.bottomFeature').find('> div').addClass('showPostedon');	
	}, function(e){ 
	$(this).siblings('.bottomFeature').find('> div').removeClass('showPostedon');
	
	});
	
	$('pre').each(function(){
		var lang = $(this).attr('data-lang');
		$(this).prepend('<h5>'+lang+'</h5>');
	});
	
  /* var lastScrollTop = 0;
   $(window).scroll(function(event){
   var st = $(this).scrollTop();
   if (st > lastScrollTop){
	   // downscroll code
	   if(($('.subMenu').is(':hidden')) && ($('.downProfile').is(':hidden')))
	   {
		$('header').addClass('slideUpHide');
	   }
   } else {
      // upscroll code
	  $('header').removeClass('slideUpHide');
   }
   lastScrollTop = st;
});*/

/*$('#dropProfile > a').click(function(e) {
    $('.downProfile').slideToggle();
	return false;
});*/

$('.subMenu li:nth-child(2)').hover(function(e){
	$('.subMenu').addClass('subMenuHover');
}, function(e){
	$('.subMenu').removeClass('subMenuHover');
});

	$('.showComments > div > span i.fa-reply').click(function(){
		if(!$(this).hasClass('active'))
		{
		$('.showComments > div > span i.fa-reply').removeClass('active');
		$('.replyBox').slideUp();
		$(this).addClass('active');
		$(this).parent().siblings('.replyBox').slideToggle();
		}
		else
		{
		$(this).removeClass('active');
		$(this).parent().siblings('.replyBox').slideUp();	
		}
		return false;
	});
	
	$('.selectMenu').selectmenu({
	width: 200
	});
	
	$('.replyLink').click(function(){
		return false;
	});
	
	/*$('.showComments > div').hover(function(){
		$(this).find('.replyLink strong').html('Reply');
	}, function(){
		var CommentDate=$(this).find('.replyLink').attr('data-date');
		$(this).find('.replyLink strong').html(CommentDate);
	});*/
	
	$('.titleList span').click(function(){
		if(!$(this).hasClass('active'))
		{
			$('.titleList span').removeClass('active');
			$('.detailView').slideUp();
			$(this).addClass('active');
			$(this).parent().siblings('.detailView').slideDown();
		}
		else {
			$('.titleList span').removeClass('active');
			$('.detailView').slideUp();
		}
	});
	
	if(Modernizr.touch){
		$('.subLink').click(function(){
			$(this).siblings('.subMenu').slideToggle();
		});
		
	}
	
});

$(window).load(function(e) {
	$('.blogPost').each(function(index, element) {
		$(this).find('.articleDesc a h2').matchHeight();
		$(this).find('.articleDesc a p').matchHeight();
    });
	$('#featureTab').owlCarousel({
		singleItem: true,
        slideSpeed: 1000,
		autoPlay: false,
		mouseDrag: false,
		rewindNav:false,
        navigation: false,
        pagination: true,
		paginationNumbers: false
		});
});

$(window).resize(function(e) {
    $('.blogPost').each(function(index, element) {
		$(this).find('.articleDesc a h2').matchHeight();
		$(this).find('.articleDesc a p').matchHeight();
    });
});