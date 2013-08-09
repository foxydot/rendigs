<?php global $wpalchemy_media_access; ?>
<ul class="attorney_meta_control gform_fields top_label description_below" id="gform_fields_4">
	<?php $mb->the_field('_attorney_last_name'); ?>
	<li class="gfield gfield_contains_required even"
		id="field_attorney_last_name"><label for="<?php $mb->the_name(); ?>" class="gfield_label">Last Name (for alphabetizing)
	</label>
	<div class="ginput_container last-child even">
			<input type="text" tabindex="24" class="medium" value="<?php $mb->the_value(); ?>"
				id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>">
		</div>
	</li>
	<?php $mb->the_field('_attorney_phone'); ?>
	<li class="gfield gfield_contains_required even"
		id="field_attorney_phone"><label for="<?php $mb->the_name(); ?>" class="gfield_label">Phone
	</label>
	<div class="ginput_container last-child even">
			<input type="text" tabindex="28" class="medium" value="<?php $mb->the_value(); ?>"
				id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>">
		</div>
	</li>
	<?php $mb->the_field('_attorney_mobile'); ?>
	<li class="gfield gfield_contains_required even"
		id="field_attorney_mobile"><label for="<?php $mb->the_name(); ?>" class="gfield_label">Mobile
	</label>
	<div class="ginput_container last-child even">
			<input type="text" tabindex="29" class="medium" value="<?php $mb->the_value(); ?>"
				id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>">
		</div>
	</li>
	<?php $mb->the_field('_attorney_fax'); ?>
	<li class="gfield even" id="field_attorney_fax"><label for="<?php $mb->the_name(); ?>"
		class="gfield_label">Fax</label>
	<div class="ginput_container last-child even">
			<input type="text" tabindex="30" class="medium" value="<?php $mb->the_value(); ?>"
				id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>">
		</div>
	</li>
	<?php $mb->the_field('_attorney_linked_in'); ?>
	<li class="gfield even" id="field_attorney_linked_in"><label for="<?php $mb->the_name(); ?>"
		class="gfield_label">Linked In URL</label>
	<div class="ginput_container last-child even">
			<input type="text" tabindex="32" class="medium" value="http://"
				id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>">
		</div>
	</li>
	
	
	<?php $mb->the_field('_attorney_vcard'); ?>
	<li class="gfield even" id="field_attorney_vcard"><label for="<?php $mb->the_name(); ?>"
		class="gfield_label">vCard File</label>
	<div class="ginput_container last-child even">
        <?php $wpalchemy_media_access->setGroupName('attorney_vcard'. $mb->get_the_index())->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
		
		<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
        <?php echo $wpalchemy_media_access->getButton(array('label' => '+')); ?>
		</div>
	</li>
	
	<?php $mb->the_field('_attorney_email'); ?>
	<li class="gfield last-child odd" id="field_attorney_email"><label
		for="<?php $mb->the_name(); ?>" class="gfield_label">Email</label>
	<div class="ginput_container last-child even">
			<input type="text" tabindex="34" class="medium" value="<?php $mb->the_value(); ?>"
				id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>">
		</div>
	</li>
</ul>