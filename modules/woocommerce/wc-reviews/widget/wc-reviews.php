<?php

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

class stiles_wc_reviews extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'wc-reviews-style', plugin_dir_url( __FILE__ ) . '../css/wc-reviews.css');
    }
    
    public function get_name() 
    {
        return 'stiles-single-product-reviews';
    }

    public function get_title() {
        return __( 'Product Reviews', smw_slug );
    }

    public function get_icon() {
        return 'eicon-product-rating';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 'wc-reviews-style'];
    }
    
    protected function register_controls() 
    {
        $this->preview_review_section();
        
        $this->review_author_section();
        
        $this->add_review_section();
        
        $this->add_review_button();
    }
    
    protected function preview_review_section()
    {
        $this->start_controls_section(
            'section_content',
            array(
                'label' => __( 'Product Reviews', smw_slug ),
            )
        );

             $this->add_control(
            'show_reviews',
            array(
                'label'     => __( 'Preview Reviews', smw_slug ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_off' => __( 'Hide', smw_slug ),
                'label_on'  => __( 'Show', smw_slug ),
            )
        );

        $this->end_controls_section();
    }
    
    protected function review_author_section()
    {
        $this->start_controls_section(
            'review_author_content',
            array(
                'label' => __( 'Review Section', smw_slug ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );
        
            $this->add_control(
    			'review_title_heading',
    			array(
    				'label' => __( 'Review Title', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    			)
    		);
        
            $this->add_control(
				'review_title_color',
				array(
					'label'      => __( 'Colour', smw_slug ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'default'    => '',
					'selectors'  => array(
						'{{WRAPPER}} .woocommerce-Reviews-title' => 'color: {{VALUE}};',
					),
				)
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'       => 'review_title_text_typography',
					'selector'   => '{{WRAPPER}} .woocommerce-Reviews-title',
					'scheme'     => Typography::TYPOGRAPHY_4,
				)
			);
			
			$this->add_responsive_control(
				'review_title_align',
				array(
					'label'      => __( 'Alignment', smw_slug ),
					'type'       => Controls_Manager::CHOOSE,
					'options'    => array(
						'flex-start' => array(
							'title' => __( 'Left', smw_slug ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'     => array(
							'title' => __( 'Center', smw_slug ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'   => array(
							'title' => __( 'Right', smw_slug ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'separator'  => 'before',
					'default'    => 'flex-left',
					'selectors'  => array(
						'{{WRAPPER}} .woocommerce-Reviews-title' => 'justify-content: {{VALUE}};',
					),
				)
			);
			
			$this->add_control(
    			'author_title_heading',
    			array(
    				'label' => __( 'Review Author', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    			)
    		);
    		
    		$this->add_control(
				'author_title_color',
				array(
					'label'      => __( 'Colour', smw_slug ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'default'    => '',
					'selectors'  => array(
						'{{WRAPPER}} .woocommerce-review__author' => 'color: {{VALUE}};',
					),
				)
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'       => 'author_title_text_typography',
					'selector'   => '{{WRAPPER}} .woocommerce-review__author',
					'scheme'     => Typography::TYPOGRAPHY_4,
				)
			);
    		
    		$this->add_control(
    			'author_date_heading',
    			array(
    				'label' => __( 'Review Date', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    			)
    		);
    		
    		$this->add_control(
				'author_date_color',
				array(
					'label'      => __( 'Colour', smw_slug ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'default'    => '',
					'selectors'  => array(
						'{{WRAPPER}} .woocommerce-review__published-date' => 'color: {{VALUE}};',
					),
				)
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'       => 'author_date_text_typography',
					'selector'   => '{{WRAPPER}} .woocommerce-review__published-date',
					'scheme'     => Typography::TYPOGRAPHY_4,
				)
			);
    		
    		$this->add_control(
    			'review_text_heading',
    			array(
    				'label' => __( 'Review Text', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    			)
    		);
    		
    		$this->add_control(
				'review_text_color',
				array(
					'label'      => __( 'Colour', smw_slug ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'default'    => '',
					'selectors'  => array(
						'{{WRAPPER}} .description' => 'color: {{VALUE}};',
					),
				)
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'       => 'review_text_typography',
					'selector'   => '{{WRAPPER}} .description',
					'scheme'     => Typography::TYPOGRAPHY_1,
				)
			);
    		
    		$this->add_control(
    			'review_stars_heading',
    			array(
    				'label' => __( 'Review Stars', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    			)
    		);
    		
    		$this->add_control(
				'review_stars_color',
				array(
					'label'      => __( 'Colour', smw_slug ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'default'    => '',
					'selectors'  => array(
						'{{WRAPPER}} .star-rating' => 'color: {{VALUE}};',
					),
				)
			);
        
        $this->end_controls_section();
    }
    
    protected function add_review_section()
    {
        $this->start_controls_section(
            'add_review_section',
            array(
                'label' => __( 'Add Review', smw_slug ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );
        
            $this->add_control(
    			'add_review_heading',
    			array(
    				'label' => __( 'Add Review Text', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    			)
    		);
    		
    		$this->add_control(
				'add_review_color',
				array(
					'label'      => __( 'Colour', smw_slug ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'default'    => '',
					'selectors'  => array(
						'{{WRAPPER}} .comment-reply-title' => 'color: {{VALUE}};',
					),
				)
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'       => 'add_review_text_typography',
					'selector'   => '{{WRAPPER}} .comment-reply-title',
					'scheme'     => Typography::TYPOGRAPHY_4,
				)
			);
			
			$this->add_control(
    			'your_rating_heading',
    			array(
    				'label' => __( 'Your Rating Text', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    			)
    		);
    		
    		$this->add_control(
				'your_rating_color',
				array(
					'label'      => __( 'Colour', smw_slug ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'default'    => '',
					'selectors'  => array(
						'{{WRAPPER}} .comment-form-rating label' => 'color: {{VALUE}};',
					),
				)
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'       => 'your_rating_text_typography',
					'selector'   => '{{WRAPPER}} .comment-form-rating label',
					'scheme'     => Typography::TYPOGRAPHY_4,
				)
			);
			
			$this->add_responsive_control(
				'your_rating_bottom_spacing',
				array(
					'label'      => __( 'Your Rating Bottom Spacing', smw_slug ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => array(
						'px' => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} .comment-form-rating label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
				)
			);
			
			$this->add_control(
    			'add_review_stars_heading',
    			array(
    				'label' => __( 'Add Review Stars', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    			)
    		);
    		
    		$this->add_control(
				'add_review_stars_color',
				array(
					'label'      => __( 'Colour', smw_slug ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'default'    => '',
					'selectors'  => array(
						'{{WRAPPER}} .stars a' => 'color: {{VALUE}};',
					),
				)
			);
			
			$this->add_control(
    			'your_review_heading',
    			array(
    				'label' => __( 'Your Review Text', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    			)
    		);
    		
    		$this->add_control(
				'your_review_color',
				array(
					'label'      => __( 'Colour', smw_slug ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'default'    => '',
					'selectors'  => array(
						'{{WRAPPER}} .comment-form-comment label' => 'color: {{VALUE}};',
					),
				)
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'       => 'your_review_text_typography',
					'selector'   => '{{WRAPPER}} .comment-form-comment label',
					'scheme'     => Typography::TYPOGRAPHY_4,
				)
			);
			
			$this->add_responsive_control(
				'your_review_text_bottom_spacing',
				array(
					'label'      => __( 'Your Review Bottom Spacing', smw_slug ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => array(
						'px' => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} .comment-form-comment label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
				)
			);
			
			$this->add_control(
    			'your_review_textbox_heading',
    			array(
    				'label' => __( 'Your Review Text Box', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    			)
    		);
    		
    		$this->add_control(
				'your_review_textbox_color',
				array(
					'label'      => __( 'Colour', smw_slug ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'default'    => '',
					'selectors'  => array(
						'{{WRAPPER}} #comment' => 'color: {{VALUE}};',
					),
				)
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'       => 'your_review_text_textbox_typography',
					'selector'   => '{{WRAPPER}} #comment',
					'scheme'     => Typography::TYPOGRAPHY_4,
				)
			);
			
			$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'your_review_text_textbox_border',
				'label' => __( 'Border', smw_slug ),
				'selector' => '{{WRAPPER}} #comment',
			)
		);
			
			$this->add_responsive_control(
				'your_review_text_textbox_border_width',
				array(
					'label'      => __( 'Border Width', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} #comment' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'your_review_text_textbox_border_color',
				array(
					'label'     => __( 'Border Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .elementor-field, 
						{{WRAPPER}} #comment' => 'border-color: {{VALUE}};',
					),
				)
			);
			
			$this->add_responsive_control(
				'your_review_text_textbox_border_radius',
				array(
					'label'      => __( 'Border Radius', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} #comment' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
        
        $this->end_controls_section();
    }
    
    protected function add_review_button()
    {
        $this->start_controls_section(
            'add_review_button_section',
            array(
                'label' => __( 'Add Review Button', smw_slug ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );
        
        $this->start_controls_tabs('button_normal_style_tabs');
                
                // Button Normal tab
                $this->start_controls_tab(
                    'add_review_button_normal_style_tab',
                    array(
                        'label' => __( 'Normal', smw_slug ),
                    )
                );
                    
                    $this->add_control(
                        'add_review_button_colour',
                        array(
                            'label'     => __( 'Text Colour', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} #submit' => 'color: {{VALUE}} !important;',
                            ),
                        )
                    );
                    
                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'add_review_button_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  => '{{WRAPPER}} #submit',
                        )
                    );

                    $this->add_control(
                        'add_review_button_padding',
                        array(
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', 'em' ),
                            'selectors' => array(
                                '{{WRAPPER}} #submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ),
                        )
                    );

                    $this->add_control(
                        'add_review_button_margin',
                        array(
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', 'em' ),
                            'selectors' => array(
                                '.woocommerce {{WRAPPER}} #submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        array(
                            'name' => 'add_review_button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} #submit',
                        )
                    );

                    $this->add_control(
                        'button_border_radius',
                        array(
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => array(
                                '{{WRAPPER}} #submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ),
                        )
                    );

                    $this->add_control(
                        'add_review_button_background_colour',
                        array(
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} #submit' => 'background-color: {{VALUE}} !important',
                            ),
                        )
                    );

                $this->end_controls_tab();
                
                // Button Hover tab
                $this->start_controls_tab(
                    'add_review_button_hover_style_tab',
                    array(
                        'label' => __( 'Hover', smw_slug ),
                    )
                ); 
                    
                    $this->add_control(
                        'add_review_button_hover_colour',
                        array(
                            'label'     => __( 'Text Color', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} #submit:hover' => 'color: {{VALUE}} !important;',
                            ),
                        )
                    );

                    $this->add_control(
                        'add_review_button_hover_background_colour',
                        array(
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} #submit:hover' => 'background-color: {{VALUE}} !important',
                            ),
                        )
                    );

                    $this->add_control(
                        'add_review_button_hover_border_colour',
                        array(
                            'label' => __( 'Border Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} #submit:hover' => 'border-color: {{VALUE}} !important',
                            ),
                        )
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();
        
        $this->end_controls_section();
    }

    protected function render( $instance = [] ) 
    {

        $settings   = $this->get_settings_for_display();
        $is_editor = \Elementor\Plugin::instance()->editor->is_edit_mode();
        global $product;
        $product = wc_get_product();

        if( $is_editor )
        {
            if( $settings['show_reviews'] === 'yes' )
            {
                echo ' <div class="woocommerce-tabs-list"><div id="reviews" class="woocommerce-Reviews">
                    	<div id="comments">
                    		<h2 class="woocommerce-Reviews-title">
                    			1 review for' . '&nbsp;'. '<span>' . $product->get_title() . '</span>		</h2>
                    
                    					<ol class="commentlist">
                    				<li class="review byuser comment-author-stiles bypostauthor even thread-even depth-1" id="li-comment-6">
                    
                    	<div id="comment-6" class="comment_container">
                    
                    		<img alt="Avatar" data-src="https://secure.gravatar.com/avatar/e984bccc80acfb36d8e567bbb2eace3d?s=60&amp;d=mm&amp;r=g" class="avatar avatar-60wp-user-avatar wp-user-avatar-60 alignnone photo avatar-default lazyloaded" src="https://secure.gravatar.com/avatar/e984bccc80acfb36d8e567bbb2eace3d?s=60&amp;d=mm&amp;r=g" width="60" height="60"><noscript><img src="https://secure.gravatar.com/avatar/e984bccc80acfb36d8e567bbb2eace3d?s=60&#038;d=mm&#038;r=g" width="60" height="60" alt="Avatar" class="avatar avatar-60wp-user-avatar wp-user-avatar-60 alignnone photo avatar-default" /></noscript>
                    		<div class="comment-text">
                    
                    			<div class="star-rating" role="img" aria-label="Rated 5 out of 5"><span style="width:100%">Rated <strong class="rating">5</strong> out of 5</span></div>
                    	<p class="meta">
                    		<strong class="woocommerce-review__author">stiles </strong>
                    				<span class="woocommerce-review__dash">–</span> <time class="woocommerce-review__published-date" >'. date('d F Y') . '</time>
                    	</p>
                    
                    	<div class="description"><p>This is an awesome product!</p>
                    </div>
                    		</div>
                    	</div>
                    </li><!-- #comment-## -->
                    			</ol>
                    
                    						</div>
                    
                    			<div id="review_form_wrapper">
                    			<div id="review_form">
                    					<div id="respond" class="comment-respond">
                    		<span id="reply-title" class="comment-reply-title">Add a review <small><a rel="nofollow" id="cancel-comment-reply-link" href="/shop/grow-kits/farm-in-a-box/immune-boost/#respond" style="display:none;">Cancel reply</a></small></span><form action="https://www.teenygreeny.co.uk/wp-comments-post.php" method="post" id="commentform" class="comment-form" novalidate=""><div class="comment-form-rating"><label for="rating">Your rating</label><p class="stars">						<span>							<a class="star-1" href="#">1</a>							<a class="star-2" href="#">2</a>							<a class="star-3" href="#">3</a>							<a class="star-4" href="#">4</a>							<a class="star-5" href="#">5</a>						</span>					</p><select name="rating" id="rating" required="" style="display: none;">
                    						<option value="">Rate…</option>
                    						<option value="5">Perfect</option>
                    						<option value="4">Good</option>
                    						<option value="3">Average</option>
                    						<option value="2">Not that bad</option>
                    						<option value="1">Very poor</option>
                    					</select></div><p class="comment-form-comment"><label for="comment">Your review&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required=""></textarea></p><p class="form-submit"><input name="submit" type="submit" id="submit" class="submit" value="Submit"> <input type="hidden" name="comment_post_ID" value="751" id="comment_post_ID">
                    <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                    </p><input type="hidden" id="_wp_unfiltered_html_comment_disabled" name="_wp_unfiltered_html_comment" value="992f3c7554"><script>(function(){if(window===window.parent){document.getElementById("_wp_unfiltered_html_comment_disabled").name="_wp_unfiltered_html_comment";}})();</script>
                    </form>	</div><!-- #respond -->
                    				</div>
                    		</div>
                    	
                    	<div class="clear"></div>
                    </div>
                    </div>';
            }
        } else{
            if ( empty( $product ) ) 
            { 
                return; 
            }
            
            add_filter( 'comments_template', array( 'WC_Template_Loader', 'comments_template_loader' ) );
            echo '<div class="woocommerce-tabs-list">';
                comments_template();
            echo '</div>';
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_reviews() );