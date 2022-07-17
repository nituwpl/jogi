jQuery(document).ready(function(){
    /* Home banner text rotation */
	var items = (Math.floor(Math.random() * (jQuery('#testimonials li').length)));
	jQuery('#testimonials li').hide().eq(items).show();
	
  function next(){
		jQuery('#testimonials li:visible').delay(4000).fadeOut('slow',function(){
			jQuery(this).appendTo('#testimonials ul');
			jQuery('#testimonials li:first').fadeIn('slow',next);
    });
   }
  next();
  /* Home banner end*/
});