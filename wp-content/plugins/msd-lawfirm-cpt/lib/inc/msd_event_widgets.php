<?php
 /**
 * Archives widget class
 *
 * @since 2.8.0
 */
class MSDLAB_Widget_Event_Archives extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_archive event_archive', 'description' => __( 'A monthly archive of your events.') );
        parent::__construct('event_archives', __('Event Archives'), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $c = ! empty( $instance['count'] ) ? '1' : '0';
        $d = ! empty( $instance['dropdown'] ) ? '1' : '0';
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Event Archives') : $instance['title'], $instance, $this->id_base);

        echo $before_widget;
        if ( $title )
            echo $before_title . $title . $after_title;

        if ( $d ) {
?>
        <select name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'> <option value=""><?php echo esc_attr(__('Select Month')); ?></option> <?php wp_get_archives(apply_filters('widget_archives_dropdown_args', array('type' => 'monthly', 'format' => 'option', 'show_post_count' => $c))); ?> </select>
<?php
        } else {
?>
        <ul>
        <?php $this->msd_get_event_archives(apply_filters('widget_archives_args', array('type' => 'monthly', 'show_post_count' => $c))); ?>
        </ul>
<?php
        }

        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = $new_instance['count'] ? 1 : 0;
        $instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
        $title = strip_tags($instance['title']);
        $count = $instance['count'] ? 'checked="checked"' : '';
        $dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

<?php
    }
    
    function init() {
        if ( !is_blog_installed() )
            return;
            register_widget('MSDLAB_Widget_Event_Archives');
    }
    
    function add_css(){
        if(!is_admin()){
        }
    }
    function add_js(){
        if(!is_admin()){
        }
    }    
    
    function msd_get_event_archives($args = '') {
        global $wpdb, $wp_locale, $date_info;
        $today = current_time( 'timestamp' ) - 86400;
        $args = array(
            'post_type' => 'targeted_event',
            'meta_query' => array(
                array(
                    'key' => '_date_event_datestamp',
                    'value' => $today,
                    'compare' => '<'
                ),
             ),
             'order_by' => 'meta_value',
             'order' => 'ASC',
             'meta_key' => '_date_event_datestamp',
        );
        $posts = get_posts($args);
        $events = array();
        foreach ($posts as $key => $event) {
            $date_info->the_meta($event->ID);
            $datestamp = $date_info->get_the_value('event_datestamp');
            $events[date("Y",$datestamp)][date("m",$datestamp)] = $event;
        }
        krsort($events);
        foreach ($events AS $year => $months){
            krsort($months);
            foreach ($months AS $month => $event){
                $output .= '<li><a href="/event/'.$year.'/'.$month.'">'.date("F Y",strtotime($year.'-'.$month.'-01')).'</a></li>';
            }
        }
        echo $output;
    }
}