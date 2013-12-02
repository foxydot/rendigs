<?php global $wpalchemy_media_access; ?>
<ul class="newsletter_meta_control gform_fields top_label description_below" id="gform_fields_4">
    <?php $mb->the_field('_newsletter_pdf'); ?>
    <li class="gfield even" id="field_newsletter_pdf"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Newsletter PDF File</label>
    <div class="ginput_container last-child even">
        <?php $wpalchemy_media_access->setGroupName('newsletter_pdf'. $mb->get_the_index())->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>     
        <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
        <?php echo $wpalchemy_media_access->getButton(array('label' => '+')); ?>
        </div>
    </li>
</ul>