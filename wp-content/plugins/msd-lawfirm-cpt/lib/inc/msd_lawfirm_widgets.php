<?php 
class MSDLawfirmAttorneyWidget extends WP_Widget {

    function __construct() {
        add_action('wp_print_styles', array($this,'add_css'));
        add_action('wp_print_scripts', array($this,'add_js'));
        $widget_ops = array('classname' => 'widget_lawfirm_atty', 'description' => __('Find an attorney by name or practice area'));
        $control_ops = array('width' => 400, 'height' => 350);
        parent::__construct('widget_lawfirm_atty', __('Attorney Finder'), $widget_ops, $control_ops);
    }

    function widget( $args, $instance ) {
        global $msd_lawfirm;
        extract($args);
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $text = apply_filters( 'widget_text', $instance['text'], $instance );
        $url = empty($instance['url']) ? FALSE : $instance['url'];
        $target = $instance['target'] ? ' target="_blank"':'';
        $linktext = apply_filters( 'widget_title', empty($instance['linktext']) ? 'Read More' : $instance['linktext'], $instance, $this->id_base);
        $attorneys = $msd_lawfirm->display_class->get_all_attorneys();
        $practice_areas = $msd_lawfirm->display_class->get_all_practice_areas();
        echo $before_widget; 
        ?>
        <div class="msd-widget-atty">
            <?php if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
            <form>
                <select id="attyname" name="attyname" class="control">
                    <option>Attorney Name</option>
                    <?php
                    foreach($attorneys AS $atty){
                        print '<option value="'.get_post_permalink($atty->ID).'">'.$atty->post_title.'</option>';
                    }
                    ?>
                </select>  
                <select id="pracarea" name="pracarea" class="control">
                    <option>Practice Area</option>
                    <?php
                    foreach($practice_areas AS $pa){
                        $mypage = get_page_by_path('/practice-areas/'.$pa->slug);
                        if($mypage){
                            print '<option value="/practice-areas/'.$pa->slug.'">'.$pa->name.'</option>';
                        }
                    }
                    ?>
                </select>
                <input type="submit" class="readmore" value="<?php print $linktext; ?>" />
            </form>
        </div>
        <?php
        echo $after_widget;
    }
        
        
    

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['linktext'] = strip_tags($new_instance['linktext']);
        
        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
        $title = strip_tags($instance['title']);
        $linktext = strip_tags($instance['linktext']);
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('linktext'); ?>"><?php _e('Link Text:'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('linktext'); ?>" name="<?php echo $this->get_field_name('linktext'); ?>" type="text" value="<?php echo esc_attr($linktext); ?>" /></p>
        
<?php
    }
    
    function init() {
        if ( !is_blog_installed() )
            return;
            register_widget('MSDLawfirmAttorneyWidget');
    }
    
    function add_css(){
        if(!is_admin()){
        }
    }
    function add_js(){
        global $msd_lawfirm;
        if(!is_admin()){
            wp_enqueue_script('msd-widget-atty',$msd_lawfirm->plugin_url.'/lib/js/msd-widget-atty.js','jquery','0.4',TRUE);
        }
    }    
}