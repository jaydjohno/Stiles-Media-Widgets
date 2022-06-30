<?php

/**
 * SMW MC4WP Form
 *
 * @package SMW
 */
 
namespace StilesMediaWidgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Widget_Button;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}
 
class stiles_newsletter extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'newsletter-css', plugin_dir_url( __FILE__ ) . '../css/newsletter.css');
    }
    
    public function get_name()
    {
        return 'stiles-newsletter';
    }
    
    public function get_title()
    {
        return 'MC4WP: Subscribtion Form';
    }
    
    public function get_icon()
    {
        return 'eicon-mail';
    }
    
    public function get_categories()
    {
        return ['stiles-media-forms'];
    }
    
    public function get_style_depends() 
    {
        return [ 'newsletter-css' ];
    }
    
    public static function get_button_sizes() 
    {
		return Widget_Button::get_button_sizes();
	}
    
    protected function register_controls() 
    {
        $this->register_form_fields_controls();
        
        $this->register_button_form_controls();
      
        $this->register_form_style_controls();
            
        $this->register_input_style_controls();
      
        $this->register_submit_style_controls();
            
        $this->register_label_style_controls();
    }
    
    protected function register_form_fields_controls()
    {
        $this->start_controls_section(
            'newsletter_content',
            array(
                'label' => __( 'Form Fields', smw_slug ),
            )
        );
        
            $this->add_control(
                'mail_chimp_form_id',
                array(
                    'label'       => __( 'Mailchimp Form ID', smw_slug ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => __( '290', smw_slug ),
                    'description' => __( 'To get your mailchimp ID, <a href="admin.php?page=mailchimp-for-wp-forms" target="_blank"> Click here </a>', smw_slug ),
                    'label_block' => true,
                    'separator'   => 'before',
                )
            );
            
            $this->add_control(
            'show_labels',
            array(
                'label'   => __( 'Field Label', smw_slug ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'default' => __( 'Show', smw_slug ),
                    'custom'  => __( 'Custom Labels', smw_slug ),
                    'none'    => __( 'None', smw_slug ),
                ),
                'default' => 'default',
            )
        );

        $this->add_control(
            'email_label',
            array(
                'label'       => __( 'Email Label', smw_slug ),
                'default'     => __( 'Email Address:', smw_slug ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => array(
                    'active' => true,
                ),
                'label_block' => true,
                'condition'   => array(
                    'show_labels' => 'custom',
                ),
            )
        );
        
        $this->add_control(
            'email_placeholder',
            array(
                'label'       => __( 'Email Placeholder', smw_slug ),
                'default'     => __( 'Your e-mail address', smw_slug ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => array(
                    'active' => true,
                ),
                'label_block' => true,
                'condition'   => array(
                    'show_labels' => 'custom',
                ),
            )
        );

        $this->end_controls_section();
    }
    
    protected function register_button_form_controls()
    {
        $this->start_controls_section(
            'newsletter_button',
            array(
                'label' => __( 'Button Text', smw_slug ),
            )
        );
        
            $this->add_control(
				'button_text',
				array(
					'label'       => __( 'Text', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Sign Up', smw_slug ),
					'placeholder' => __( 'Sign Up', smw_slug ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);
		
		$this->end_controls_section();
    }
    
    protected function register_form_style_controls()
    {
        $this->start_controls_section(
            'newsletter_section_style',
            array(
                'label' => __( 'Newsletter Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
        
        $this->add_responsive_control(
            'newsletter_section_padding',
            array(
                'label' => __( 'Padding', smw_slug ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors' => array(
                    '{{WRAPPER}} .newsletter-input-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' =>'before',
            )
        );
        
        $this->add_responsive_control(
            'newsletter_section_margin',
            array(
                'label' => __( 'Margin', smw_slug ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors' => array(
                    '{{WRAPPER}} .newsletter-input-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' =>'before',
            )
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'newsletter_section_background',
                'label' => __( 'Background', smw_slug ),
                'types' => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .newsletter-input-box',
            )
        );
        
        
        $this->add_responsive_control(
            'newsletter_section_align',
            array(
                'label' => __( 'Alignment', smw_slug ),
                'type' => Controls_Manager::CHOOSE,
                'options' => array(
                    'left' => array(
                        'title' => __( 'Left', smw_slug ),
                        'icon' => 'fa fa-align-left',
                    ),
                    'center' => array(
                        'title' => __( 'Center', smw_slug ),
                        'icon' => 'fa fa-align-center',
                    ),
                    'right' => array(
                        'title' => __( 'Right', smw_slug ),
                        'icon' => 'fa fa-align-right',
                    ),
                    'justify' => array(
                        'title' => __( 'Justified', smw_slug ),
                        'icon' => 'fa fa-align-justify',
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .newsletter-input-box' => 'text-align: {{VALUE}};',
                ),
                'default' => 'left',
                'separator' =>'before',
            )
        );

        $this->end_controls_section();
    }
    
    protected function register_input_style_controls()
    {
        $this->start_controls_section(
            'newsletter_input_style',
            array(
                'label'     => __( 'Input Box', smw_slug ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );
        
            $this->add_control(
                'newsletter_input_box_height',
                array(
                    'label' => __( 'Height', smw_slug ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => array(
                        'px' => array(
                            'max' => 150,
                        ),
                    ),
                    'default' => array(
                        'size' => 50,
                    ),
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]'  => 'height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'height: {{SIZE}}{{UNIT}};',
                    ),
                )
            );
            
            $this->add_control(
                'newsletter_input_box_width',
                array(
                    'label' => __( 'Width', smw_slug ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => array(
                        '%' => array(
                            'max' => 100,
                        ),
                    ),
                    'default' => array(
                        'size' => 100,
                    ),
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form-fields p.email'  => 'width: {{SIZE}}%;',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name' => 'newsletter_input_box_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .mc4wp-form input[type*="email"]',
                )
            );

            $this->add_control(
                'newsletter_input_box_background',
                array(
                    'label'     => __( 'Background Color', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]'         => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]'        => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form select[name*="_mc4wp_lists"]' => 'background-color: {{VALUE}};',
                    ),
                )
            );

            $this->add_control(
                'newsletter_input_box_text_color',
                array(
                    'label'     => __( 'Text Color', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'color: {{VALUE}};',
                    ),
                )
            );

            $this->add_control(
                'newsletter_input_box_placeholder_color',
                array(
                    'label'     => __( 'Placeholder Color', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]::-moz-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]::-moz-placeholder' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]:-ms-input-placeholder' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form select[name*="_mc4wp_lists"]'      => 'color: {{VALUE}};',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                array(
                    'name' => 'newsletter_input_box_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .mc4wp-form input[type*="email"]',
                )
            );

            $this->add_responsive_control(
                'newsletter_input_box_border_radius',
                array(
                    'label' => esc_html__( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ),
                    'separator' =>'before',
                )
            );

            $this->add_responsive_control(
                'newsletter_input_box_padding',
                array(
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%', 'em' ),
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                    'separator' =>'before',
                )
            );

            $this->add_responsive_control(
                'newsletter_input_box_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%', 'em' ),
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                    'separator' =>'before',
                )
            );
           
        $this->end_controls_section();
    }
    
    protected function register_submit_style_controls()
    {
        $this->start_controls_section(
            'newsletter_inputsubmit_style',
            array(
                'label'     => __( 'Button', smw_slug ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );
        
        $this->add_responsive_control(
				'button_top_spacing',
				array(
					'label'     => __( 'Button Top Spacing', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'margin-top: {{SIZE}}{{UNIT}};',
					),
				)
			);
			
			$this->add_responsive_control(
				'button_bottom_spacing',
				array(
					'label'     => __( 'Button Bottom Spacing', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
				)
			);
			
			$this->add_control(
                'newsletter_button_column_width',
                array(
                    'label' => __( 'Width', smw_slug ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => array(
                        '%' => array(
                            'max' => 100,
                        ),
                    ),
                    'default' => array(
                        'size' => 100,
                    ),
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form-fields p.submit'  => 'width: {{SIZE}}%;',
                    ),
                )
            );
            
            $this->add_control(
                'newsletter_input_submit_height',
                array(
                    'label' => __( 'Height', smw_slug ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => array(
                        'px' => array(
                            'max' => 150,
                        ),
                    ),
                    'default' => array(
                        'size' => 40,
                    ),
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'height: {{SIZE}}{{UNIT}};',
                    ),
                )
            );
        
        $this->start_controls_tabs('newsletter_submit_style_tabs');

            $this->start_controls_tab(
                'newsletter_submit_style_normal_tab',
                array(
                    'label' => __( 'Normal', smw_slug ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name' => 'newsletter_input_submit_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .mc4wp-form input[type*="submit"]',
                )
            );

            $this->add_control(
                'newsletter_input_submit_text_color',
                array(
                    'label'     => __( 'Text Color', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form input[type*="submit"]'  => 'color: {{VALUE}};',
                    ),
                )
            );

            $this->add_control(
                'newsletter_input_submit_background_color',
                array(
                    'label'     => __( 'Background Color', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form input[type*="submit"]'  => 'background-color: {{VALUE}};',
                    ),
                )
            );

            $this->add_responsive_control(
                'newsletter_input_submit_padding',
                array(
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%', 'em' ),
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                    'separator' =>'before',
                )
            );

            $this->add_responsive_control(
                'newsletter_input_submit_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%', 'em' ),
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                    'separator' =>'before',
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                array(
                    'name' => 'newsletter_input_submit_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .mc4wp-form input[type*="submit"]',
                )
            );

            $this->add_responsive_control(
                'newsletter_input_submit_border_radius',
                array(
                    'label' => esc_html__( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ),
                    'separator' =>'before',
                )
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                array(
                    'name' => 'newsletter_input_submit_box_shadow',
                    'label' => __( 'Box Shadow', smw_slug ),
                    'selector' => '{{WRAPPER}} .mc4wp-form input[type*="submit"]',
                )
            );

            $this->end_controls_tab();
            $this->end_controls_tabs();
            
            $this->start_controls_tabs('newsletter_submit_style_tabs');

                // Button Normal tab start
                $this->start_controls_tab(
                    'newsletter_submit_style_normal_tab',
                    array(
                        'label' => __( 'Normal', smw_slug ),
                    )
                );
                
                $this->end_controls_tab();

                $this->start_controls_tab(
                    'newsletter_submit_style_hover_tab',
                    array(
                        'label' => __( 'Hover', smw_slug ),
                    )
                );

                    $this->add_control(
                        'newsletter_input_submithover_text_color',
                        array(
                            'label'     => __( 'Text Color', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .mc4wp-form input[type*="submit"]:hover'  => 'color: {{VALUE}};',
                            ),
                        )
                    );

                    $this->add_control(
                        'newsletter_input_submithover_background_color',
                        array(
                            'label'     => __( 'Background Color', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .mc4wp-form input[type*="submit"]:hover'  => 'background-color: {{VALUE}};',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        array(
                            'name' => 'newsletter_input_submithover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .mc4wp-form input[type*="submit"]:hover',
                        )
                    );

                $this->end_controls_tab(); // Button Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section();     
    }
    
    protected function register_label_style_controls()
    {
    
        $this->start_controls_section(
            'newsletter_label_style',
            array(
                'label'     => __( 'Label', smw_slug ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_control(
                'newsletter_label_text_color',
                array(
                    'label'     => __( 'Color', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .mc4wp-form label'  => 'color: {{VALUE}};',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name' => 'newsletter_label_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .mc4wp-form label',
                )
            );
            
            $this->add_responsive_control(
				'label_spacing',
				array(
					'label'     => __( 'Label Bottom Spacing', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'margin-top: {{SIZE}}{{UNIT}};',
					),
				)
			);

        $this->end_controls_section();
    }

  /**
   * Render working hours
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.0.0
   * @access protected
   */

    /**
   * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function render() 
    {
        $settings   = $this->get_settings_for_display();
        $id         = $this->get_id();
      
        $this->add_render_attribute( 'newsletter_attr', 'class', 'mc4wp-form-wrapper' );
      
        $this->add_render_attribute( 'shortcode', 'id', $settings['mail_chimp_form_id'] );
        $shortcode = sprintf( '[mc4wp_form %s]', $this->get_render_attribute_string( 'shortcode' ) );
      
        if( function_exists( 'mc4wp_show_form' ) ) 
        {
            ?>
            <div <?php echo $this->get_render_attribute_string('newsletter_attr'); ?> >
                <div class="newsletter-input-box">
                    <?php
                        if( !empty( $settings['mail_chimp_form_id'] ) ){
                            echo do_shortcode( $shortcode ); 
                        }else{
                            echo '<div class="smw-newsletter-message-error">' .__('Please Enter the Mail chimp form id.',smw_slug). '</div>';
                        }
                    ?>
                </div>
            </div>
            
            <script type="text/javascript">
    			jQuery(document).ready(function($) 
    			{
    			    $('.mc4wp-form-fields p:first').addClass('email');
    			    $('.mc4wp-form-fields p:nth-child(2)').addClass('submit');
    			    
    			    var button = "<?php echo $settings['button_text']; ?>"
    			    var submittext = '<input value="' + button + '" type="submit">';
    			    $('.mc4wp-form-fields p:nth-child(2)').text('');
    			    $('.mc4wp-form-fields p:nth-child(2)').append(submittext);
    			});
    		</script>
    		<script type="text/javascript">
    			jQuery(document).ready(function($) 
    			{
    			    var label = '';
    			    var placeholder = '';
    			    <?php
    			    if( 'none' === $settings['show_labels'] )
    			    {
    			        ?>
    			        $('.mc4wp-form-fields p:first').text('');
    			        $('.mc4wp-form-fields p:first').append('<input type="email" name="EMAIL" placeholder="" required="">');
    			        <?php
    			    }
    			    elseif( 'custom' === $settings['show_labels'] )
    			    {
    			        ?>
    			        placeholder = "<?php echo $settings['email_placeholder']; ?>";
    			        label = "<?php echo $settings['email_label']; ?>"
    			        $('.mc4wp-form-fields p:first').text('');
    			        var inputtext = '<label>' + label + '<input type="email" name="EMAIL" placeholder="' + placeholder + '" required=""></label>';
    			        $('.mc4wp-form-fields p:first').append(inputtext);
    			        <?php
    			    }
    			    ?>
    			});
    		</script>
            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_newsletter() );