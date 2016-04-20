jQuery(document).ready(function() {
  
  //WOW js code
    new WOW().init();

    //this code is for the gmap
	 /*var map = new GMaps({
        el: '#map',
        lat: -12.043333,
        lng: -77.028333
      });*/


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
		var inputText = jQuery(this).closest('.count-detail').find('input[type=text]');
		var inputVal = parseInt(inputText.val());
		
		if( jQuery(this).hasClass('cart-minus') )
		{
			var newVal = ( inputVal-- == 0 ? 0 : inputVal-- );
			inputText.val(newVal);
		}
		
		if( jQuery(this).hasClass('cart-plus') )
		{
			var newVal = ( inputVal++ == 0 ? 1 : inputVal++);
			inputText.val(inputVal++);
		}
		
		if( jQuery(this).hasClass('cart-refresh') )
		{
			inputText.val(0)
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