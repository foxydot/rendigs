<?php 
$fields = array(
	'experience' => 'Experience',
	'honors' => 'Honors/Distinctions',
	'admissions' => 'Admissions',
	'affiliations' => 'Professional Affiliations',
	'community' => 'Community Involvement',
	'presentations' => 'Presentations',
	'publications' => 'Publications',
	'education' => 'Education',
);
$i = 0; ?>
<ul class="attorney_meta_control customEditor gform_fields top_label description_below">
<?php
foreach($fields AS $k=>$v){
?>
	<?php $mb->the_field('_attorney_'.$k); ?>
	<li class="gfield even" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
		class="gfield_label"><?php print $v; ?></label>
	<div class="ginput_container last-child even">
			<?php wp_editor($mb->get_the_value(),$mb->get_the_name(),array()); ?>
		</div>
	</li>
<?php 
$i++;
} ?>
</ul>