<?php global $wpalchemy_media_access; ?>
<ul class="my_meta_control">
    <li>
    <?php $metabox->the_field('company_lineup'); ?>
    <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">Company Lineup</label>
    <div class="ginput_container"><textarea id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"><?php $metabox->the_value(); ?></textarea>
        <div><i class="smalltext">Comma separated list</i></div>
    </div>
    </li>
</ul>
<p id="warning" style="display: none;background:lightYellow;border:1px solid #E6DB55;padding:5px;">Order has changed. Please click Save or Update to preserve order.</p>     

<div class="event_meta_control my_file_grid">
    <label>Event Sponsors</label>
    <div class="table">
    <?php $i = 0; ?>
    <?php while($mb->have_fields_and_multi('otherfiles')): ?>
    <?php $mb->the_group_open(); ?>
    <?php if($i == 0){?>
    <div class="row">
        <div class="cell thumb">Thumb</div>
        <div class="cell">Logo File URL</div>
        <div class="cell">Sponsor Name</div>
        <div class="cell">Sponsor URL</div>
    </div>
    <?php } ?>
    <div class="row <?php print $i%2==0?'even':'odd'; ?>">
        <div class="cell thumb">
            <div class="thumbnail-preview" style="background-image:url(<?php print $mb->get_the_value(downloadurl); ?>);"></div>
        </div>
        <div class="cell file">
        <?php $mb->the_field('downloadurl'); ?>
        <?php $groupname = 'otherfiles_'. $mb->get_the_index(); ?>
        <?php $wpalchemy_media_access->setGroupName($groupname)->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
        
        <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
        <?php echo $wpalchemy_media_access->getButton(array('label' => '+')); ?>
        </div>
        <div class="cell">
        <?php $mb->the_field('title'); ?>
        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        </div>
        <div class="cell">
        <?php $mb->the_field('url'); ?>
        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        </div>
        <div class="cell">
            <a href="#" class="dodelete button">Remove Sponsor</a>
        </div>
    </div>
    <?php $i++; ?>
    <?php $mb->the_group_close(); ?>
    <?php endwhile; ?>
    </div>
    <div class="manage-files"><a href="#" class="docopy-otherfiles button">Add Sponsor</a>
    <a href="#" class="dodelete-otherfiles button">Remove All Sponsors</a></div>
</div>
<script>
jQuery(function($){
    $("#wpa_loop-otherfiles").sortable({
        change: function(){
            $("#warning").show();
        }
    });
    $(".thumbnail-preview").click(function(){
        var imgurl = $(this).parent(".thumb").next(".file").find('input').val();
        $(this).css('background-image','url('+imgurl+')');
    });
});
</script>