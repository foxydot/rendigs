jQuery(document).ready(function($) {
	$('.headshot').load(function(){
		$('#content-sidebar-wrap>div').equalHeightColumns('refresh');
	});
	$('h3.toggle').click(
			function() {
			    $('.attorney-additional-info').slideToggle(function(){
					$('#content-sidebar-wrap>div').equalHeightColumns('refresh');
			    });
			    $(this).find('span').toggle();
			  }
		);
});