jQuery(document).ready(function() {
  
  //WOW js code
    new WOW().init();

    //this code is for the gmap
	 /*var map = new GMaps({
        el: '#map',
        lat: -12.043333,
        lng: -77.028333
      });*/
	jQuery('[data-load="ajax"]').each(function(item){
	    var _href = jQuery(this).attr('data-href');
	    var _block = jQuery(this);
	    jQuery.ajax({
		    url: _href,
		    type: 'GET',
		    data: {
			    view: 'short_news'
		    },
		    success: function(result, success)
		    {
				if( success )    
				{
					_block.html(result);
				}
		    }
	    });
    });

      //this code is for smooth scroll and nav selector
            $(document).ready(function () {
              $(document).on("scroll", onScroll);
              
              //smoothscroll
              $('a[href^="#"]:not(.no-anchor)').on('click', function (e) {
                  e.preventDefault();
                  $(document).off("scroll");
                  
                  $('a').each(function () {
                      $(this).removeClass('active');
                  })
                  $(this).addClass('active');
                
                  var target = this.hash,
                      menu = target;
                  $target = $(target);
                  $('html, body').animate({
                      'scrollTop': $target.offset().top+2
                  }, 600, 'swing', function () {
                      window.location.hash = target;
                      $(document).on("scroll", onScroll);
                  });
              });
          });

          function onScroll(event){
              var scrollPos = $(document).scrollTop();
              $('.navbar-default .navbar-nav>li>a').each(function () {
                  var currLink = $(this);
                  var refElement = $(currLink.attr("href"));
                  if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                      $('.navbar-default .navbar-nav>li>a').removeClass("active");
                      currLink.addClass("active");
                  }
                  else{
                      currLink.removeClass("active");
                  }
              });
          }
     
     var windowScrollPosTop = jQuery(window).scrollTop();
     doScrollContent(windowScrollPosTop);
     //this code is for animation nav
     jQuery(window).scroll(function() {
	 	
        	doScrollContent(jQuery(window).scrollTop());
     });
     
     
     function doScrollContent(scrollTop)
     {
         console.log( scrollTop )
         
         if( scrollTop >= 525 )
         {
             jQuery("#header-btn-navigation").show();
         }else
         {
             jQuery("#header-btn-navigation").hide();
         }


	     if(scrollTop >= 50) {
	          jQuery(".top-header").css({"background": "#18171D",});
	          //jQuery(".top-header img.logo").css({"margin-top": "-30px", "margin-bottom": "15px"});
	          jQuery(".nav-bar").css({"margin-top": "6px",});
	        }
	        else{
	          jQuery(".top-header").css({"background": "transparent",});
	           //jQuery(".top-header img.logo").css({"margin-top": "-30px", "margin-bottom": "25px"});
	           jQuery(".nav-bar").css({"margin-top": "28px"});
	          
	        }
     }
	
});