jQuery(document).ready(function($) {
    $('.widget_lawfirm_atty select').change(function(){
        var url = $(this).val();
        window.location = url;
    });
});