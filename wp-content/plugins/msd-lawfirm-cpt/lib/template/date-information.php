<?php global $wpalchemy_media_access,$wpdb; ?>
<?php
$all_locations = $wpdb->get_col("SELECT meta_value
    FROM $wpdb->postmeta WHERE meta_key = '_date_event_location'" );
    $location_values = array_unique($all_locations);
    asort($location_values);
    ?>
<ul class="event_meta_control">
    <li>
    <?php $metabox->the_field('event_location'); ?>
    <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">Event Location (Title)</label>
    <input type="hidden" id="event_location_input" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>" />
    <div class="ui-widget ginput_container">
        <select class="combobox" id="combobox">
            <option></option>
        <?php 
        foreach($location_values AS $lv){
            $selected = $lv==$metabox->get_the_value()?' SELECTED':'';
            print '<option value="'.$lv.'"'.$selected.'>'.$lv.'</option>
            ';
        }
        ?>
        </select>
   <i>The common name for the area that the event is being held in. ie. "TriState", "Washington, D.C.", "Triangle", etc.</i>
    </div>
    
    </li>
    <li>
    <?php $metabox->the_field('event_datestamp'); ?>
    <input type="hidden" class="datestamp" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
    <?php $metabox->the_field('event_date'); ?>
    <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">Event Date</label>
    <div class="ginput_container"><input type="text" class="datepicker" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
    </li>
    <li>
    <?php $metabox->the_field('event_start_time'); ?>
    <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">Event Times</label>
    <div class="ginput_container"><input type="text" class="timepicker" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
        to 
    <?php $metabox->the_field('event_end_time'); ?>
    <input type="text" class="timepicker" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
    
    </div>
    </li>
    <li>
    
        <?php $metabox->the_field('event_timezone'); ?>
        <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">Timezone</label>
    <div class="ginput_container"><input type="text" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
    </div></li>
    
</ul>
<script>
jQuery(function($){
$.widget( "custom.combobox", {
_create: function() {
this.wrapper = $( "<span>" )
.addClass( "custom-combobox" )
.insertAfter( this.element );
this.element.hide();
this._createAutocomplete(); 
this._createShowAllButton();
},
_createAutocomplete: function() {
var selected = this.element.children( ":selected" ),
value = selected.val() ? selected.text() : "";
this.input = $( "<input>" )
.appendTo( this.wrapper )
.val( value )
.attr( "title", "" )
.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
.autocomplete({
delay: 0,
minLength: 0,
source: $.proxy( this, "_source" )
})
.tooltip({
tooltipClass: "ui-state-highlight"
});
this._on( this.input, {
autocompleteselect: function( event, ui ) {
ui.item.option.selected = true;
this._trigger( "select", event, {
item: ui.item.option
});
},
autocompletechange: "_postToTextField"
});
},

_createShowAllButton: function() {
var input = this.input,
wasOpen = false;
$( "<a>" )
.attr( "tabIndex", -1 )
.attr( "title", "Show All Items" )
.tooltip()
.appendTo( this.wrapper )
.button({
icons: {
primary: "ui-icon-triangle-1-s"
},
text: false
})
.removeClass( "ui-corner-all" )
.addClass( "custom-combobox-toggle ui-corner-right" )
.mousedown(function() {
wasOpen = input.autocomplete( "widget" ).is( ":visible" );
})
.click(function() {
input.focus();
// Close if already visible
if ( wasOpen ) {
return;
}
// Pass empty string as value to search for, displaying all results
input.autocomplete( "search", "" );
});
},
_source: function( request, response ) {
var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
response( this.element.children( "option" ).map(function() {
var text = $( this ).text();
if ( this.value && ( !request.term || matcher.test(text) ) )
return {
label: text,
value: text,
option: this
};
}) );
},
_postToTextField: function( event, ui ) {
    var value = this.input.val(),
    valueLowerCase = value.toLowerCase(),
    valid = false;
    this.element.children( "option" ).each(function() {
        if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            $('#event_location_input').val(value).trigger('change');
            return false;
        } else {
            $('#event_location_input').val(value).trigger('change');
        }
        });
},
_destroy: function() {
this.wrapper.remove();
this.element.show();
}
});

    $( ".combobox" ).combobox();
    $( ".datepicker" ).datepicker({
    onSelect : function(dateText, inst)
    {
        var epoch = $.datepicker.formatDate('@', $(this).datepicker('getDate')) / 1000;
        $('.datestamp').val(epoch);
        var new_title = $('#event_location_input').val() + ' - ' + $('.datepicker').val();
       // $('#title').val(new_title);
    }
    });
    $('.timepicker').timepicker({ 'scrollDefaultNow': true });
    $('#event_location_input').change(function(){
        var new_title = $('#event_location_input').val() + ' - ' + $('.datepicker').val();
       // $('#title').val(new_title);
    });
});

</script>