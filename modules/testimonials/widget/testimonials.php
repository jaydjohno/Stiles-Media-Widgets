<?php

/**
 * SMW Testimonials.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_testimonials extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'testimonials-css', plugin_dir_url( __FILE__ ) .  '../css/testimonials.css');
    }
    
    public function get_name()
    {
        return 'stiles-testimonials';
    }
    
    public function get_title()
    {
        return 'Testimonials';
    }
    
    public function get_icon()
    {
        return 'eicon-testimonial';
    }
    
    public function get_categories()
    {
        return [ 'stiles-media-category' ];
    }
    
    public function get_style_depends() 
    {
        return [ 'testimonials-css' ];
    }
    
    protected function register_controls() 
    {   
        
        $this->start_controls_section('testimonials_person_settings',
            [
                'label'             => __('Author', smw_slug),
            ]
        );
        
        $this->add_control('testimonials_person_image',
            [
                'label'             => __('Image',smw_slug),
                'type'              => Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
                'default'      => [
                    'url'   => Utils::get_placeholder_image_src()
                ],
                'description'       => __( 'Choose an image for the author', smw_slug ),
                'show_label'        => true,
            ]
        );

        $this->add_control('testimonials_person_image_shape',
            [
                'label'             => __('Image Style', smw_slug),
                'type'              => Controls_Manager::SELECT,
                'description'       => __( 'Choose image style', smw_slug ),
                'options'           => [
                    'square'  => __('Square',smw_slug),
                    'circle'  => __('Circle',smw_slug),
                    'rounded' => __('Rounded',smw_slug),
                ],
                'default'           => 'circle',
            ]
        );
        
        $this->add_control('testimonials_person_name',
            [
                'label'             => __('Name', smw_slug),
                'type'              => Controls_Manager::TEXT,
                'default'           => 'John Doe',
                'dynamic'           => [ 'active' => true ],
                'label_block'       => true
            ]
        );
        
        $this->add_control('testimonials_person_name_size',
            [
                'label'             => __('HTML Tag', smw_slug),
                'type'              => Controls_Manager::SELECT,
                'description'       => __( 'Select a heading tag for author name', smw_slug ),
                'options'       => [
                    'h1'    => 'H1',
                    'h2'    => 'H2',
                    'h3'    => 'H3',
                    'h4'    => 'H4',
                    'h5'    => 'H5',
                    'h6'    => 'H6',
                    'div'   => 'div',
                    'span'  => 'span',
                    'p'     => 'p',
                ],
                'default'           => 'h3',
                'label_block'       => true,
            ]
        );

        $this->add_control('separator_text',
            [
                'label'         => __('Separator', smw_slug),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '-',
                'separator'     => 'befpre'
            ]
        );

        $this->add_control('separator_align',
            [
                'label'             => __('Align', smw_slug),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'row'  => __('Inline',smw_slug),
                    'column'  => __('Block',smw_slug),
                ],
                'default'           => 'row',
                'prefix_class'      => 'testimonials-separator-',
                'selectors'         => [
                    '{{WRAPPER}} .testimonials-author-info'=> 'flex-direction: {{VALUE}}',
                ]
            ]
        );

        $this->add_control('separator_spacing',
            [
                'label'             => __('Spacing', smw_slug),
                'type'              => Controls_Manager::SLIDER,
                'size_units'        => ['px', 'em'],
                'default'           => [
                    'unit'  => 'px',
                    'size'  => 5,
                ],
                'selectors'         => [
                    '{{WRAPPER}}.testimonials-separator-row .testimonials-separator' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 ); margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    '{{WRAPPER}}.testimonials-separator-column .testimonials-separator' => 'margin-top: calc( {{SIZE}}{{UNIT}}/2 ); margin-bottom: calc( {{SIZE}}{{UNIT}}/2 );',
                ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section('testimonials_company_settings',
            [
                'label'             => __('Company', smw_slug)
            ]
        );
        
        $this->add_control('testimonials_company_name',
            [
                'label'             => __('Name', smw_slug),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'default'           => 'Leap13',
                'label_block'       => true,
            ]
        );
        
        $this->add_control('testimonials_company_name_size',
            [
                'label'             => __('HTML Tag', smw_slug),
                'type'              => Controls_Manager::SELECT,
                'description'       => __( 'Select a heading tag for company name', smw_slug ),
                'options'           => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div'   => 'div',
                    'span'  => 'span',
                    'p'     => 'p',
                ],
                'default'           => 'h4',
                'label_block'       => true,
            ]
        );
        
        $this->add_control('testimonials_company_link_switcher',
            [
                'label'         => __('Link', smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );

        $this->add_control('testimonials_company_link',
            [
                'label'             => __('Link', smw_slug),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [
                'active'            => true,
                'categories'        => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
                'description'       => __( 'Add company URL', smw_slug ),
                'label_block'       => true,
                'condition'         => [
                    'testimonials_company_link_switcher' => 'yes'
                ]
            ]
        );
        
        $this->add_control('testimonials_link_target',
            [
                'label'             => __('Link Target', smw_slug),
                'type'              => Controls_Manager::SELECT,
                'description'       => __( 'Select link target', smw_slug ),
                'options'           => [
                    'blank'  => __('Blank'),
                    'parent' => __('Parent'),
                    'self'   => __('Self'),
                    'top'    => __('Top'),
                ],
                'default'           => __('blank',smw_slug),
                'condition'         => [
                    'testimonials_company_link_switcher' => 'yes'
                ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section('testimonials_settings',
            [
                'label'                 => __('Content', smw_slug),
            ]
        );

        $this->add_control('testimonials_content',
            [    
                'label'             => __('Testimonial Content', smw_slug),
                'type'              => Controls_Manager::WYSIWYG,
                'dynamic'           => [ 'active' => true ],
                'default'           => __('Donec id elit non mi porta gravida at eget metus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Cras mattis consectetur purus sit amet fermentum. Nullam id dolor id nibh ultricies vehicula ut id elit. Donec id elit non mi porta gravida at eget metus.',smw_slug),
                'label_block'       => true,
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('testimonials_image_style',
            [
                'label'             => __('Image', smw_slug),
                'tab'               => Controls_Manager::TAB_STYLE, 
            ]
        );
        
        $this->add_control('testimonials_img_size',
            [
                'label'             => __('Size', smw_slug),
                'type'              => Controls_Manager::SLIDER,
                'size_units'        => ['px', 'em'],
                'default'           => [
                    'unit'  =>  'px',
                    'size'  =>  110,
                ],
                'range'             => [
                    'px'=> [
                        'min' => 10,
                        'max' => 150,
                    ]
                ],
                'selectors'         => [
                    '{{WRAPPER}} .testimonials-img-wrapper'=> 'width: {{SIZE}}{{UNIT}}; height:{{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control('testimonials_img_border_width',
            [
                'label'             => __('Border Width (PX)', smw_slug),
                'type'              => Controls_Manager::SLIDER,
                'default'           => [
                    'unit'  => 'px',
                    'size'  =>  2,
                ],
                'range'             => [
                    'px'=> [
                        'min' => 0,
                        'max' => 15,
                    ]
                ],
                'selectors'         => [
                    '{{WRAPPER}} .testimonials-img-wrapper' => 'border-width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
        
        $this->add_control('testimonials_image_border_color',
             [
                'label'                 => __('Border Colour', smw_slug),
                'type'                  => Controls_Manager::COLOR,
                'scheme'            => [
                        'type'  => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                 'selectors'            => [
                    '{{WRAPPER}} .testimonials-img-wrapper' => 'border-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('testimonialss_person_style', 
            [
                'label'                 => __('Author', smw_slug),
                'tab'                   => Controls_Manager::TAB_STYLE, 
            ]
        );
        
        $this->add_control('testimonials_person_name_color',
            [
                'label'             => __('Author Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .testimonials-person-name' => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'author_name_typography',
                'label'         => __('Name Typograhy', smw_slug),
                'scheme'        => Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .testimonials-person-name',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'author_name_shadow',
                'selector'      => '{{WRAPPER}} .testimonials-person-name'
            ]
        );
        
        $this->add_control('testimonials_separator_color',
            [
                'label'             => __('Separator Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'separator'         => 'before',
                'condition'         => [
                    'separator_text!'  => ''
                ],
                'selectors'         => [
                    '{{WRAPPER}} .testimonials-separator' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'separator_typography',
                'label'         => __('Separator Typograhy', smw_slug),
                'condition'     => [
                    'separator_text!'  => ''
                ],
                'selector'      => '{{WRAPPER}} .testimonials-separator',
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('testimonials_company_style',
            [
                'label'             => __('Company', smw_slug),
                'tab'               => Controls_Manager::TAB_STYLE, 
            ]
        );

        $this->add_control('testimonials_company_name_color',
            [
                'label'             => __('Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .testimonials-company-link' => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'company_name_typography',
                'scheme'        => Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .testimonials-company-link',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'company_name_shadow',
                'selector'      => '{{WRAPPER}} .testimonials-company-link'
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section('testimonials_content_style',
            [
                'label'             => __('Content', smw_slug),
                'tab'               => Controls_Manager::TAB_STYLE, 
            ]
        );

        $this->add_control('testimonials_content_color',
            [
                'label'             => __('Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_3,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .testimonials-text-wrapper' => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'content_typography',
                'scheme'        => Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .testimonials-text-wrapper',
            ]
        ); 
        
        $this->add_responsive_control('testimonials_margin',
            [
                'label'                 => __('Margin', smw_slug),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', 'em', '%'],
                'default'               =>[
                    'top'   =>  15,
                    'bottom'=>  15,
                    'left'  =>  0 ,
                    'right' =>  0 ,
                    'unit'  => 'px',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .testimonials-text-wrapper' => 'margin: {{top}}{{UNIT}} {{right}}{{UNIT}} {{bottom}}{{UNIT}} {{left}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section('testimonials_quotes',
            [
                'label'             => __('Quotation Icon', smw_slug),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('testimonials_quote_icon_color',
            [
                'label'              => __('Colour',smw_slug),
                'type'               => Controls_Manager::COLOR,
                'default'            => 'rgba(110,193,228,0.2)',
                'selectors'         =>  [
                    '{{WRAPPER}} .testimonials-upper-quote, {{WRAPPER}} .testimonials-lower-quote'   =>  'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control('testimonials_quotes_size',
            [
                'label'             => __('Size', smw_slug),
                'type'              => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em', '%'],
                'default'           => [
                    'unit'  => 'px',
                    'size'  => 120,
                ],
                'range'             => [
                    'px' => [
                        'min' => 5,
                        'max' => 250,
                    ]
                ],
                'selectors'         => [
                    '{{WRAPPER}} .testimonials-upper-quote, {{WRAPPER}} .testimonials-lower-quote' => 'font-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_responsive_control('testimonials_upper_quote_position',
            [
                'label'             => __('Top Icon Position', smw_slug),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', 'em', '%'],
                'default'           =>[
                    'top'   =>  70,
                    'left'  =>  12 ,
                    'unit'  =>  'px',
                    ],
                'selectors'         => [
                    '{{WRAPPER}} .testimonials-upper-quote' => 'top: {{TOP}}{{UNIT}}; left:{{LEFT}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_responsive_control('testimonials_lower_quote_position',
            [
                'label'             => __('Bottom Icon Position', smw_slug),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', 'em', '%'],
                'default'           =>[
                    'bottom'    =>  3,
                    'right'     =>  12,
                    'unit'      =>  'px',
                ],
                'selectors'         => [
                    '{{WRAPPER}} .testimonials-lower-quote' => 'right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section('testimonials_container_style',
            [
                'label'     => __('Container',smw_slug),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'testimonials_background',
                'types'             => [ 'classic' , 'gradient' ],
                'selector'          => '{{WRAPPER}} .testimonials-content-wrapper'
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'              => 'testimonials_container_border',
                'selector'          => '{{WRAPPER}} .testimonials-content-wrapper',
            ]
        );

        $this->add_control('testimonials_container_border_radius',
            [
                'label'         => __('Border Radius', smw_slug),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .testimonials-content-wrapper' => 'border-radius: {{SIZE}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'              => 'testimonials_container_box_shadow',
                'selector'          => '{{WRAPPER}} .testimonials-content-wrapper',
            ]
        );
        
        $this->add_responsive_control('testimonials_box_padding',
                [
                    'label'         => __('Padding', smw_slug),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .testimonials-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );

        $this->end_controls_section();
        
    }

    protected function render() 
    {
        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes('testimonials_person_name');
        $this->add_inline_editing_attributes('testimonials_company_name');
        $this->add_inline_editing_attributes('testimonials_content', 'advanced');
        $person_title_tag = $settings['testimonials_person_name_size'];
        
        $company_title_tag = $settings['testimonials_company_name_size'];
        
        $image_src = '';
        
        if( ! empty( $settings['testimonials_person_image']['url'] ) ) {
            $image_src = $settings['testimonials_person_image']['url'];
            $alt = esc_attr( Control_Media::get_image_alt( $settings['testimonials_person_image'] ) );
        }
        
        $this->add_render_attribute('testimonial', 'class', [
            'testimonials-box'
        ]);

        $this->add_render_attribute('img_wrap', 'class', [
            'testimonials-img-wrapper',
            $settings['testimonials_person_image_shape']
        ]);
        
    ?>
    
    <div <?php echo $this->get_render_attribute_string('testimonial'); ?>>
        <div class="testimonials-container">
            <i class="fas fa-quote-left testimonials-upper-quote"></i>
            <div class="testimonials-content-wrapper">
                <?php if ( ! empty( $image_src ) ) : ?>
                    <div <?php echo $this->get_render_attribute_string('img_wrap'); ?>>
                        <img src="<?php echo $image_src; ?>" alt="<?php echo $alt; ?>" class="testimonials-person-image">
                    </div>
                <?php endif; ?>

                <div class="testimonials-text-wrapper">
                    <div <?php echo $this->get_render_attribute_string('testimonials_content'); ?>>
                        <?php echo $settings['testimonials_content']; ?>
                    </div>
                </div>

                <div class="testimonials-author-info">
                    <<?php echo $person_title_tag; ?> class="testimonials-person-name">
                        <span <?php echo $this->get_render_attribute_string('testimonials_person_name'); ?>><?php echo $settings['testimonials_person_name']; ?></span>
                    </<?php echo $person_title_tag; ?>>
                    
                    <span class="testimonials-separator"><?php echo esc_html( $settings['separator_text'] ); ?></span>
                    
                    <<?php echo $company_title_tag; ?> class="testimonials-company-name">
                    <?php if( $settings['testimonials_company_link_switcher'] === 'yes') : ?>
                        <a class="testimonials-company-link" href="<?php echo $settings['testimonials_company_link']; ?>" target="_<?php echo $settings['testimonials_link_target']; ?>">
                            <span <?php echo $this->get_render_attribute_string('testimonials_company_name'); ?>><?php echo $settings['testimonials_company_name']; ?></span>
                        </a>
                    <?php else: ?>
                        <span class="testimonials-company-link" <?php echo $this->get_render_attribute_string('testimonials_company_name'); ?>>
                            <?php echo $settings['testimonials_company_name']; ?>
                        </span>
                    <?php endif; ?>
                    </<?php echo $company_title_tag; ?>>
                </div>
            </div>
            <i class="fas fa-quote-right testimonials-lower-quote"></i>
        </div>
    </div>
    <?php
    
    }
    
    protected function _content_template() 
    {
        ?>
        <#
        
            view.addInlineEditingAttributes('testimonials_person_name');
            view.addInlineEditingAttributes('testimonials_company_name');
            view.addInlineEditingAttributes('testimonials_content', 'advanced');
            view.addRenderAttribute('testimonials_company_name', 'class', 'testimonials-company-link');
            
            var personTag = settings.testimonials_person_name_size,
                companyTag = settings.testimonials_company_name_size,
                imageSrc = '',
                imageSrc,
                borderRadius;

            if( '' != settings.testimonials_person_image.url ) {
                imageSrc = settings.testimonials_person_image.url;
            }
        
            view.addRenderAttribute('testimonial', 'class', [
                'testimonials-box'
            ]);

            view.addRenderAttribute('img_wrap', 'class', [
                'testimonials-img-wrapper',
                settings.testimonials_person_image_shape
            ]);
            
        
        #>
        
            <div {{{ view.getRenderAttributeString('testimonial') }}}>
                <div class="testimonials-container">
                    <i class="fas fa-quote-left testimonials-upper-quote"></i>
                    <div class="testimonials-content-wrapper">
                        <# if ( '' != imageSrc ) { #>
                            <div {{{ view.getRenderAttributeString('img_wrap') }}}>
                                <img src="{{ imageSrc }}" alt="stiles-image" class="testimonials-person-image">
                            </div>
                        <# } #>
                        <div class="testimonials-text-wrapper">
                            <div {{{ view.getRenderAttributeString('testimonials_content') }}}>{{{ settings.testimonials_content }}}</div>
                        </div>
                        
                        <div class="testimonials-author-info">
                            <{{{personTag}}} class="testimonials-person-name">
                                <span {{{ view.getRenderAttributeString('testimonials_person_name') }}}>
                                {{{ settings.testimonials_person_name }}}
                                </span>
                            </{{{personTag}}}>
                            
                            <span class="testimonials-separator"> {{{ settings.separator_text }}} </span>
                            
                            <{{{companyTag}}} class="testimonials-company-name">
                                <a href="{{ settings.testimonials_company_link }}" {{{ view.getRenderAttributeString('testimonials_company_name') }}}>
                                    {{{ settings.testimonials_company_name }}}
                                </a>
                            </{{{companyTag}}}>
                        </div>
                        
                    </div>
                    
                    <i class="fas fa-quote-right testimonials-lower-quote"></i>
                    
                </div>
            </div>
        
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_testimonials() );