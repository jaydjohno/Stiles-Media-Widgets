<?php

/**
 * Stiles Media Widgets Product Categories.
 *
 * @package SMW
 */
 
namespace StilesMediaWidgets;

if ( ! defined( 'ABSPATH' ) ) 
{
	exit;   // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Base;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;

class stiles_wc_product_categories extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'product-categories-style', plugin_dir_url( __FILE__ ) . '../css/categories.css');
    }
    
    public function get_name() 
    {
        return 'stiles-product-categories';
    }
    
    public function get_title() 
    {
        return __( 'Product: Category List', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-categories';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 'product-categories-style' ];
    }
    
    protected function register_controls() 
    {
        $this->category_list_control();
        
        $this->extra_option_controls();
        
        $this->area_style_control();
        
        $this->title_style_control();
        
        $this->counter_style_control();
        
        $this->description_style();
        
        $this->description_icon_style_control();
    }
    
    protected function category_list_control()
    {
        $this->start_controls_section(
            'section_content',
            array(
                'label' => esc_html__( 'Category List', smw_slug ),
            )
        );

            $this->add_control(
                'layout',
                [
                    'label' => esc_html__( 'Select Layout', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'horizontal',
                    'options' => [
                        'vertical' => esc_html__('Vertical',smw_slug),
                        'horizontal' => esc_html__('Horizontal',smw_slug),
                    ],
                    'label_block' => true,
                ]
            );

            $this->add_responsive_control(
                'category_grid_column',
                [
                    'label' => esc_html__( 'Columns', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '8',
                    'options' => [
                        '1' => esc_html__( 'One', smw_slug ),
                        '2' => esc_html__( 'Two', smw_slug ),
                        '3' => esc_html__( 'Three', smw_slug ),
                        '4' => esc_html__( 'Four', smw_slug ),
                        '5' => esc_html__( 'Five', smw_slug ),
                        '6' => esc_html__( 'Six', smw_slug ),
                        '7' => esc_html__( 'Seven', smw_slug ),
                        '8' => esc_html__( 'Eight', smw_slug ),
                        '9' => esc_html__( 'Nine', smw_slug ),
                        '10'=> esc_html__( 'Ten', smw_slug ),
                    ],
                    'condition'=>[
                        'layout'=>'horizontal',
                    ],
                    'label_block' => true,
                    'prefix_class' => 'sm-columns%s-',
                ]
            );

            $this->add_control(
                'category_display_type',
                [
                    'label' => esc_html__( 'Category Display Type', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'all_cat',
                    'options' => [
                        'single_cat' => esc_html__('Single Category',smw_slug),
                        'multiple_cat'=> esc_html__('Multiple Categories',smw_slug),
                        'all_cat'=> esc_html__('All Categories',smw_slug),
                    ],
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'product_categories',
                [
                    'label' => esc_html__( 'Select categories', smw_slug ),
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => smw_taxonomy_list(),
                    'condition' => [
                        'category_display_type' => 'single_cat',
                    ]
                ]
            );

            $this->add_control(
                'multi_categories',
                [
                    'label' => esc_html__( 'Select categories', smw_slug ),
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'options' => smw_taxonomy_list(),
                    'condition' => [
                        'category_display_type' => 'multiple_cat',
                    ]
                ]
            );

            $this->add_control(
                'catorder',
                [
                    'label' => esc_html__( 'Order', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'ASC',
                    'options' => [
                        'ASC'   => esc_html__('Ascending',smw_slug),
                        'DESC'  => esc_html__('Descending',smw_slug),
                    ],
                    'condition' => [
                        'category_display_type!' => 'single_cat',
                    ]
                ]
            );

            $this->add_control(
                'limitcount',
                [
                    'label' => esc_html__( 'Show items', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'default' => 5,
                    'condition' => [
                        'category_display_type' => 'all_cat',
                    ]
                ]
            );

            $this->add_control(
                'custom_title',
                [
                    'label' => esc_html__( 'Custom Title', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    'condition' => [
                        'category_display_type' => 'single_cat',
                    ]
                ]
            );

            $this->add_control(
                'catcustitle',
                [
                    'label' => __( 'Title', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'rows' => 10,
                    'placeholder' => __( 'Type your title here', smw_slug ),
                    'condition' => [
                        'custom_title' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'custom_image',
                [
                    'label' => esc_html__( 'Custom Image', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    'condition' => [
                        'category_display_type' => 'single_cat',
                    ]
                ]
            );

            $this->add_control(
                'catcusimage',
                [
                    'label' => __( 'Image', smw_slug ),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'custom_image' => 'yes',
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'thumbnailsize',
                    'default' => 'thumbnail',
                    'separator' => 'none',
                ]
            );

        $this->end_controls_section();
    }
    
    protected function extra_option_controls()
    {
        // Extra Option
        $this->start_controls_section(
            'section_extra_option',
            array(
                'label' => esc_html__( 'Extra Option', smw_slug ),
            )
        );
            
            $this->add_control(
                'show_image',
                [
                    'label' => __( 'Show Image / Icon', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Yes', smw_slug ),
                    'label_off' => esc_html__( 'No', smw_slug ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'show_product_counter',
                [
                    'label' => esc_html__( 'Show Product Counter', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-category .sm-category-content h4 sup' => 'display: block !important;',
                        '{{WRAPPER}} .sm-single-category .sm-category-content h4' => 'padding-right: 25px;',
                    ],
                ]
            );

            $this->add_control(
                'show_description',
                [
                    'label' => esc_html__( 'Show Category Description', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-category .sm-category-content p' => 'display: block !important;',
                    ],
                ]
            );

            $this->add_control(
                'length',
                [
                    'label' => esc_html__( 'Description length', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10000,
                    'step' => 1,
                    'default' => 15,
                    'condition'=>[
                        'show_description'=>'yes',
                    ],
                ]
            );

            $this->add_control(
                'show_custom_icon',
                [
                    'label' => esc_html__( 'Custom Icon', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Yes', smw_slug ),
                    'label_off' => esc_html__( 'No', smw_slug ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'select_category',
                [
                    'label' => esc_html__( 'Select Category', smw_slug ),
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => smw_taxonomy_list(),
                ]
            );

            $repeater->add_control(
                'icon',
                [
                    'label' => esc_html__( 'Icon', smw_slug ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fas fa-star',
                        'library' => 'solid',
                    ],
                ]
            );

            $this->add_control(
                'category_icon_options',
                [
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => array_values( $repeater->get_controls() ),
                    'default' => [
                        [
                            'select_category' => esc_html__( 'Select Category', smw_slug ),
                            'icon' => 'fas fa-star',
                        ]
                    ],
                    'title_field' => '{{{ select_category }}}',
                    'condition' => [
                        'show_custom_icon' => 'yes',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function area_style_control()
    {
        // Area Style Section
        $this->start_controls_section(
            'category_style_section',
            [
                'label' => esc_html__( 'Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'no_gutters',
                [
                    'label' => esc_html__( 'No Gutters', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Yes', smw_slug ),
                    'label_off' => esc_html__( 'No', smw_slug ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_responsive_control(
                'item_space',
                [
                    'label' => esc_html__( 'Space', smw_slug ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 10,
                    ],
                    'condition'=>[
                        'no_gutters!'=>'yes',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-row > [class*="col-"]' => 'padding: 0  {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'item_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'item_border',
                    'label' => esc_html__( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .sm-single-category',
                ]
            );

            $this->add_responsive_control(
                'contentalign',
                [
                    'label'   => __( 'Alignment', smw_slug ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left'    => [
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'fa fa-align-right',
                        ],
                    ],
                    'condition'=>[
                        'layout'=>'horizontal',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-category'   => 'text-align: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function title_style_control()
    {
        // Title Style Section
        $this->start_controls_section(
            'category_title_style',
            [
                'label' => esc_html__( 'Title', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'title_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default'=>'#878787',
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-category .sm-category-content h4' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'title_hover_color',
                [
                    'label' => __( 'Hover Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default'=>'#878787',
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-category .sm-category-content h4 a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .sm-single-category .sm-category-content h4',
                ]
            );

            $this->add_responsive_control(
                'title_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-category .sm-category-content h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

        $this->end_controls_section();
    }
    
    protected function counter_style_control()
    {
        // Counter Style Section
        $this->start_controls_section(
            'category_counter_style',
            [
                'label' => esc_html__( 'Counter', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_product_counter'=>'yes',
                ]
            ]
        );
            
            $this->add_control(
                'counter_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default'=>'#878787',
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-category .sm-category-content h4 sup' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'counter_hover_color',
                [
                    'label' => __( 'Hover Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default'=>'#878787',
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-category .sm-category-content h4:hover sup' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'counter_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .sm-single-category .sm-category-content h4 sup',
                ]
            );

        $this->end_controls_section();
    }
    
    protected function description_style()
    {
        // Description Style Section
        $this->start_controls_section(
            'category_description_style',
            [
                'label' => esc_html__( 'Description', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_description'=>'yes',
                ]
            ]
        );
            
            $this->add_control(
                'description_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default'=>'#878787',
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-category .sm-category-content p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'description_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .sm-single-category .sm-category-content p',
                ]
            );

        $this->end_controls_section();
    }
    
    protected function description_icon_style_control()
    {
        // Description Style Section
        $this->start_controls_section(
            'category_custom_icon_style',
            [
                'label' => esc_html__( 'Icon', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_custom_icon'=>'yes',
                ]
            ]
        );
            
            $this->add_control(
                'icon_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default'=>'#878787',
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-category .sm-single-category-img a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'icon_hover_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default'=>'#878787',
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-category .sm-single-category-img a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'icon_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .sm-single-category .sm-single-category-img a',
                ]
            );

        $this->end_controls_section();
    }
    
    protected function render( $instance = [] ) 
    {
        $settings   = $this->get_settings_for_display();

        $display_type = $this->get_settings_for_display('category_display_type');
        $order = ! empty( $settings['catorder'] ) ? $settings['catorder'] : '';

        $custom_title   = $this->get_settings_for_display('custom_title');
        $custom_image   = $this->get_settings_for_display('custom_image');
        $catcustitle    = $this->get_settings_for_display('catcustitle');
        $column         = $this->get_settings_for_display('category_grid_column');
        $layout         = $this->get_settings_for_display('layout');

        $collumval = 'sm-col-8';
        if( $column !='' )
        {
            $collumval = 'sm-col-'.$column;
        }

        $catargs = array(
            'orderby'    => 'name',
            'order'      => $order,
            'hide_empty' => true,
        );

        if( $display_type == 'single_cat' )
        {
            $product_categories = $settings['product_categories'];
            $product_cats = str_replace( ' ', '', $product_categories );
            $catargs['slug'] = $product_cats;
        }
        elseif( $display_type == 'multiple_cat' )
        {
            $product_categories = $settings['multi_categories'];
            $product_cats = str_replace(' ', '', $product_categories);
            $catargs['slug'] = $product_cats;
        }else
        {
            $catargs['slug'] = '';
        }
        
        $prod_categories = get_terms( 'product_cat', $catargs );

        if( $display_type == 'all_cat' )
        {
            $limitcount = $settings['limitcount'];
        }else
        {
            $limitcount = -1;
        }

        $size = $settings['thumbnailsize_size'];
        $image_size = Null;
        if( $size === 'custom' )
        {
            $image_size = [
                $settings['thumbnailsize_custom_dimension']['width'],
                $settings['thumbnailsize_custom_dimension']['height']
            ];
        }else
        {
            $image_size = $size;
        }

        $counter = 0;
        $thumbnails = '';

        $icon_opt = $settings['category_icon_options'];

        echo '<div class="sm-row '.( $settings['no_gutters'] === 'yes' ? 'sm-no-gutters' : '' ).' sm-layout-'.$settings['layout'].'">';
        foreach ( $prod_categories as $key => $prod_cat ):
            $counter++;

            $cat_thumb_id = get_term_meta( $prod_cat->term_id, 'thumbnail_id', true );

            $cat_thumb = wp_get_attachment_image( $cat_thumb_id, $image_size );

            // Multiple Custom Icon
            if( is_array( $icon_opt ) && $settings['show_custom_icon'] == 'yes' )
            {
                foreach ( $icon_opt as $icon ) 
                {
                    if( $prod_cat->slug === $icon['select_category'] )
                    {
                        $cat_thumb = SMW_Icon_manager::render_icon( $icon['icon'], [ 'aria-hidden' => 'true' ] );
                        break;
                    }
                }
            }

            $term_link = get_term_link( $prod_cat, 'product_cat' );

            if( ( $custom_title == 'yes' ) && ( !empty($catcustitle) ) )
            {
                $prod_cat->name = $catcustitle;
            }

            if( ( $custom_image == 'yes' ) && (!empty($settings['catcusimage']['url'])) )
            {
                $thumbnails = '<img src="'.esc_url( $settings['catcusimage']['url'] ).'" alt="'.esc_attr__( $prod_cat->name, 'woolentor-pro' ).'">';
            }else
            {
                $thumbnails = $cat_thumb;
            }

        ?>
        <div class="<?php echo esc_attr( esc_attr( $collumval ) ); ?>">
            <div class="sm-single-category">
                <?php if( !empty($thumbnails) && $settings['show_image'] === 'yes' ):?>
                    <div class="sm-single-category-img">
                        <a href="<?php echo esc_url( $term_link ); ?>">
                            <?php echo $thumbnails; ?>
                        </a>
                    </div>
                <?php endif; ?>
                <div class="sm-category-content">
                    <h4><a href="<?php echo esc_url( $term_link ); ?>"><?php echo esc_html__( $prod_cat->name, 'woolentor-pro' ); ?></a><sup>(<?php echo esc_html__( $prod_cat->count, 'woolentor-pro' ); ?>)</sup></h4>
                    <p><?php echo wp_trim_words( $prod_cat->description, $settings['length'] ); ?></p>
                </div>
            </div>
        </div>
        <?php
        if( $counter == $limitcount ) { break; }
        endforeach;
        echo '</div>';
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_product_categories() );