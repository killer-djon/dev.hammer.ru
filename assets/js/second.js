jQuery(document).ready(function() {
  
  //WOW js code
    new WOW().init();
    
    
    jQuery("#search-view").keyup(function(){
	
		jQuery("#category-list").find("[role=listitem]").hide();
		
		var data = this.value.split(" ");
		var jo = jQuery("#category-list").find("[role=listitem]");
		
	    jQuery.each(data, function(i, v){
	    	var reg = new RegExp(v, 'ig');
	    	jo = jo.filter(function(){
		    	return jQuery(this).text().match(reg);
	    	});
	    });
	    
	    jo.show();
    }).focus(function(){
		this.value="";
		jQuery(this).unbind('focus');
    });
    
    jQuery('#clear-search-input').click(function(){
	    jQuery("#search-view").val('');
	    jQuery("#search-view").trigger('keyup');
    });
	
    //this code is for the gmap
	 /*var map = new GMaps({
        el: '#map',
        lat: -12.043333,
        lng: -77.028333
      });*/


      //this code is for smooth scroll and nav selector
        jQuery(document).on("scroll", onScroll);
          
          //smoothscroll
          jQuery('a[href^="#"]:not(.no-anchor)').on('click', function (e) {
              e.preventDefault();
              jQuery(document).off("scroll");
              
              jQuery('a').each(function () {
                  jQuery(this).removeClass('active');
              })
              jQuery(this).addClass('active');
            
              var target = this.hash,
                  menu = target;
              jQuerytarget = jQuery(target);
              jQuery('html, body').animate({
                  'scrollTop': jQuerytarget.offset().top+2
              }, 600, 'swing', function () {
                  window.location.hash = target;
                  jQuery(document).on("scroll", onScroll);
              });
          });
          
          
          function onScroll(event){
              var scrollPos = jQuery(document).scrollTop();
              jQuery('.navbar-default .navbar-nav>li>a').each(function () {
                  var currLink = jQuery(this);
                  var refElement = jQuery(currLink.attr("href"));
                  if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                      jQuery('.navbar-default .navbar-nav>li>a').removeClass("active");
                      currLink.addClass("active");
                  }
                  else{
                      currLink.removeClass("active");
                  }
              });
          }
     
    jQuery(window).resize(function(){
	    
	    resizeModal();
    });
     
     jQuery("#menu-toggle").click(function(e) {
	        e.preventDefault();
	        jQuery("#wrapper").toggleClass("active");
	        jQuery("#top-header-second > .navbar").toggleClass("active");
	});
	
	jQuery(".header-toggle").click(function(e){
		e.preventDefault();
		jQuery(this).find('> .indicator').toggleClass('fa-caret-up');
		
		var rows = jQuery(this).closest('tr').nextUntil('.info');
		rows.toggleClass('collapsed');
	});
	
	jQuery(".cart-qty").click(function(){
		var inputText = jQuery(this).closest('.count-detail').find('.btn-number');
		var inputVal = parseInt(inputText.val());
		
		if( jQuery(this).hasClass('cart-minus') )
		{
			var newVal = ( inputVal == 0 ? 1 : inputVal-- );
			inputText.val(newVal);
		}
		
		if( jQuery(this).hasClass('cart-plus') )
		{
			var newVal = ( inputVal++ == 0 ? 1 : inputVal++ );
			inputText.val(newVal++);
		}
		
		if( jQuery(this).hasClass('cart-refresh') )
		{
			inputText.val(1)
		}
		
	});
	
	
	function resizeModal()
	{
		if( jQuery.browser.mobile || jQuery(window).width() <= 768 )
		{
			jQuery(".modal .modal-dialog").addClass('modal-sm');
			jQuery(".modal").addClass('col-xs-10 col-xs-offset-1');
		}else
		{
			jQuery(".modal .modal-dialog").removeClass('modal-sm');
			jQuery(".modal").removeClass('col-xs-10 col-xs-offset-1');
		}
	}
	
	resizeModal();
	
});