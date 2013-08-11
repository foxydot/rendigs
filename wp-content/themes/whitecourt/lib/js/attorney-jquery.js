jQuery(document).ready(function($) {
	$('h3.toggle').click(
			function() {
			    $('.attorney-additional-info').slideToggle(function(){
					$('#content-sidebar-wrap>div').equalHeightColumns('refresh');
			    });
			    $(this).find('span').toggle();
			  }
		);
});