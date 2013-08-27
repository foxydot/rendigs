jQuery(document).ready(function($) {
    $('select').change(function(){
        var url = $(this).val();
        window.location = url;
    });
});