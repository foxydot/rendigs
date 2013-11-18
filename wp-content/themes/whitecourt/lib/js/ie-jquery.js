jQuery(document).ready(function($) {	
	$('.no-csscolumns .footer-widgets-1 .menu').columnize({ columns: 3 });
  if ($.browser.version == 8) {
    $('body').addClass('ie8');
  }  
  if ($.browser.version < 8) {
    $('body').addClass('ie7');
  }
});