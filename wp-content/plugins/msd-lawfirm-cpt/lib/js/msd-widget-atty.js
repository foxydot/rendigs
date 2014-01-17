jQuery(document).ready(function($) {
    $('.widget_lawfirm_atty select').change(function(){
        var url = $(this).val();
        $(this).parents('form').attr('action',url);
        window.location = url;
    });
});