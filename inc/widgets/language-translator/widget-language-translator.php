<?php
/**
*  Class Language Translator Widgets
*/
class Stiles_Language_Translator_Widget extends WP_Widget
{
    /**
    * Default Constructor
    */
    public function __construct() 
    {
        $widget_options = array(
            'description' => esc_html__('Stiles Language Translator Widget', smw_slug)
        );
        
        parent::__construct( 'stiles_widget_lt', __('Stiles: Language Translator', smw_slug), $widget_options );
    }

    /**
    * Output
    */
    public function widget( $args, $instance ) 
    {
        $title = apply_filters( 'widget_title', $instance[ 'title' ] );
        
        echo $args['before_widget'];
        
        if( ! empty( $instance['title'] ) )
        { 
            echo $args['before_title'] . $title . $args['after_title']; 
        }
        
        echo do_shortcode( '[stilestranslate]' );
        
        echo $args['after_widget'];
    }
    
    /**
    * Form
    */
    public function form( $instance ) 
    {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo esc_html__( 'Title:', smw_slug ) ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) 
    {
        $instance = $old_instance;
        
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        
        return $instance;
    }
}