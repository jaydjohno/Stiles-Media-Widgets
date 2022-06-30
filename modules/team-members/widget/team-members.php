<?php

/**
 * SMW Advanced Headings.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_team_members extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'team-members-css', plugin_dir_url( __FILE__ ) .  '../css/team-members.css');
    }
    
    public function get_name()
    {
        return 'stiles-team-members';
    }
    
    public function get_title()
    {
        return 'Team Members';
    }
    
    public function get_icon()
    {
        return 'eicon-person';
    }
    
    public function get_categories()
    {
        return [ 'stiles-media-category' ];
    }
    
    public function get_style_depends() 
    {
        return [ 'team-members-css' ];
    }
    
    protected function register_controls() 
	{
        $this->register_team_member_images();
        
        $this->register_team_member_content();
        
        $this->register_social_links();
        
        $this->register_team_members_general_styles();
        
        $this->register_team_member_image_controls();
        
        $this->register_team_members_typo();
        
        $this->register_social_links_style();
	}
	
	protected function register_team_member_images()
	{
	    $this->start_controls_section(
  			'smw_section_team_member_image',
  			[
  				'label' => esc_html__( 'Team Member Image', smw_slug)
  			]
  		);

		$this->add_control(
			'smw_team_member_image',
			[
				'label' => __( 'Team Member Avatar', smw_slug),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);


		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'condition' => [
					'smw_team_member_image[url]!' => '',
				],
			]
		);

		$this->end_controls_section();
	}
	
	protected function register_team_member_content()
	{
	    $this->start_controls_section(
  			'smw_section_team_member_content',
  			[
  				'label' => esc_html__( 'Team Member Content', smw_slug)
  			]
  		);

		$this->add_control(
			'smw_team_member_name',
			[
				'label' => esc_html__( 'Name', smw_slug),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'John Doe', smw_slug),
			]
		);
		
		$this->add_control(
			'smw_team_member_job_title',
			[
				'label' => esc_html__( 'Job Position', smw_slug),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Software Engineer', smw_slug),
			]
		);
		
		$this->add_control(
			'smw_team_member_description',
			[
				'label' => esc_html__( 'Description', smw_slug),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Add team member description here. Remove the text if not necessary.', smw_slug),
			]
		);

		$this->end_controls_section();
	}
	
	protected function register_social_links()
	{
	    $this->start_controls_section(
  			'smw_section_team_member_social_profiles',
  			[
  				'label' => esc_html__( 'Social Profiles', smw_slug)
  			]
  		);

		$this->add_control(
			'smw_team_member_enable_social_profiles',
			[
				'label' => esc_html__( 'Display Social Profiles?', smw_slug),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		
		$this->add_control(
			'smw_team_member_social_profile_links',
			[
				'type' => Controls_Manager::REPEATER,
				'condition' => [
					'smw_team_member_enable_social_profiles!' => '',
				],
				'default' => [
					[
						'social_new' => [
							'value' => 'fab fa-facebook',
							'library' => 'fa-brands'
						]
					],
					[
						'social_new' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands'
						]
					],
					[
						'social_new' => [
							'value' => 'fab fa-google-plus',
							'library' => 'fa-brands'
						]
					],
					[
						'social_new' => [
							'value' => 'fab fa-linkedin',
							'library' => 'fa-brands'
						]
					],
				],
				'fields' => [
					[
						'name' => 'social_new',
						'label' => esc_html__( 'Icon', smw_slug),
						'type' => Controls_Manager::ICONS,
						'fa4compatibility' => 'social',
						'default' => [
							'value' => 'fab fa-wordpress',
							'library' => 'fa-brands',
						],
					],
					[
						'name' => 'link',
						'label' => esc_html__( 'Link', smw_slug),
						'type' => Controls_Manager::URL,
						'label_block' => true,
						'default' => [
							'url' => '',
							'is_external' => 'true',
						],
						'placeholder' => esc_html__( 'Place URL here', smw_slug),
					],
				],
				'title_field' => '<i class="{{ social_new.value }}"></i>',
			]
		);

		$this->end_controls_section();
	}
	
	protected function register_team_members_general_styles()
	{
	    $this->start_controls_section(
			'smw_section_team_members_styles_general',
			[
				'label' => esc_html__( 'Team Member Styles', smw_slug),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$team_member_style_presets_options = apply_filters('smw_team_member_style_presets_options', [
			'smw-team-members-simple'        => esc_html__( 'Simple Style', 		smw_slug ),
			'smw-team-members-overlay'       => esc_html__( 'Overlay Style', 	smw_slug ),
			'smw-team-members-centered'      => esc_html__( 'Centered Style', 	smw_slug ),
			'smw-team-members-circle'        => esc_html__( 'Circle Style', 	smw_slug ),
		]);

		$this->add_control(
			'smw_team_members_preset',
			[
				'label'   => esc_html__( 'Style Preset', smw_slug),
				'type'    => Controls_Manager::SELECT,
				'default' => 'smw-team-members-simple',
				'options' => $team_member_style_presets_options
			]
		);

		$team_member_style_presets_condition = apply_filters('smw_team_member_style_presets_condition', [
			'smw-team-members-centered',
			'smw-team-members-circle',
			'smw-team-members-social-bottom'
		]);

		$this->add_control(
			'content_card_style',
			[
				'label' => __( 'Content Card', smw_slug),
				'type' => Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_control(
			'content_card_height',
			[
				'label' => esc_html__( 'Height', smw_slug),
				'type' => Controls_Manager::SLIDER,
				'size_units'	=> [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'em'	=> [
						'min'	=> 0,
						'max'	=> 200
					]
				],
				'default'	=> [
					'unit'	=> 'px',
					'size'	=> 'auto'
				],
				'selectors' => [
					'{{WRAPPER}} .smw-team-item .smw-team-content' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'smw_team_members_overlay_background',
			[
				'label' => esc_html__( 'Overlay Color', smw_slug),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.8)',
				'selectors' => [
					'{{WRAPPER}} .smw-team-members-overlay .smw-team-content' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'smw_team_members_preset' => 'smw-team-members-overlay',
				],
			]
		);

		$this->add_control(
			'smw_team_members_background',
			[
				'label' => esc_html__( 'Content Background Color', smw_slug),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .smw-team-item .smw-team-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'smw_team_members_alignment',
			[
				'label' => esc_html__( 'Set Alignment', smw_slug),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'default' => [
						'title' => __( 'Default', smw_slug),
						'icon' => 'fa fa-ban',
					],
					'left' => [
						'title' => esc_html__( 'Left', smw_slug),
						'icon' => 'fa fa-align-left',
					],
					'centered' => [
						'title' => esc_html__( 'Center', smw_slug),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', smw_slug),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'smw-team-align-default',
				'prefix_class' => 'smw-team-align-',
			]
		);

		$this->add_responsive_control(
			'smw_team_members_padding',
			[
				'label' => esc_html__( 'Content Padding', smw_slug),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .smw-team-item .smw-team-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'smw_team_members_border',
				'label' => esc_html__( 'Border', smw_slug),
				'selector' => '{{WRAPPER}} .smw-team-item',
			]
		);

		$this->add_control(
			'smw_team_members_border_radius',
			[
				'label' => esc_html__( 'Border Radius', smw_slug),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .smw-team-item' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function register_team_member_image_controls()
	{
	    	$this->start_controls_section(
			'smw_section_team_members_image_styles',
			[
				'label' => esc_html__( 'Team Member Image Style', smw_slug),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);		

		$this->add_responsive_control(
			'smw_team_members_image_width',
			[
				'label' => esc_html__( 'Image Width', smw_slug),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .smw-team-item figure img' => 'width:{{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'smw_team_members_preset!' => 'smw-team-members-circle'
				]
			]
		);

		do_action('smw/team_member_circle_controls', $this);

		$this->add_responsive_control(
			'smw_team_members_image_margin',
			[
				'label' => esc_html__( 'Margin', smw_slug),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .smw-team-item figure img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'smw_team_members_image_padding',
			[
				'label' => esc_html__( 'Padding', smw_slug),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .smw-team-item figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'smw_team_members_image_border',
				'label' => esc_html__( 'Border', smw_slug),
				'selector' => '{{WRAPPER}} .smw-team-item figure img',
			]
		);

		$this->add_control(
			'smw_team_members_image_rounded',
			[
				'label' => esc_html__( 'Rounded Avatar?', smw_slug),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'team-avatar-rounded',
				'default' => '',
			]
		);

		$this->add_control(
			'smw_team_members_image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', smw_slug),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .smw-team-item figure img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'condition' => [
					'smw_team_members_image_rounded!' => 'team-avatar-rounded',
				],
			]
		);

		$this->end_controls_section();
	}
	
	protected function register_team_members_typo()
	{
	    $this->start_controls_section(
			'smw_section_team_members_typography',
			[
				'label' => esc_html__( 'Color &amp; Typography', smw_slug),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'smw_team_members_name_heading',
			[
				'label' => __( 'Member Name', smw_slug),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'smw_team_members_name_color',
			[
				'label' => esc_html__( 'Member Name Color', smw_slug),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .smw-team-item .smw-team-member-name' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'smw_team_members_name_typography',
				'selector' => '{{WRAPPER}} .smw-team-item .smw-team-member-name',
			]
		);

		$this->add_control(
			'smw_team_members_position_heading',
			[
				'label' => __( 'Member Job Position', smw_slug),
				'type' => Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_control(
			'smw_team_members_position_color',
			[
				'label' => esc_html__( 'Job Position Color', smw_slug),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .smw-team-item .smw-team-member-position' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'smw_team_members_position_typography',
				'selector' => '{{WRAPPER}} .smw-team-item .smw-team-member-position',
			]
		);

		$this->add_control(
			'smw_team_members_description_heading',
			[
				'label' => __( 'Member Description', smw_slug),
				'type' => Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_control(
			'smw_team_members_description_color',
			[
				'label' => esc_html__( 'Description Color', smw_slug),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .smw-team-item .smw-team-content .smw-team-text' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'smw_team_members_description_typography',
				'selector' => '{{WRAPPER}} .smw-team-item .smw-team-content .smw-team-text',
			]
		);

		$this->end_controls_section();
	}
	
	protected function register_social_links_style()
	{
	    $this->start_controls_section(
			'smw_section_team_members_social_profiles_styles',
			[
				'label' => esc_html__( 'Social Profiles Style', smw_slug),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);		

		$this->add_control(
			'smw_team_members_social_icon_size',
			[
				'label' => esc_html__( 'Icon Size', smw_slug),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default'	=> [
					'size'	=> 35,
					'unit'	=> 'px'
				],
				'selectors' => [
					// '{{WRAPPER}} .smw-team-member-social-link > a' => 'width: {{SIZE}}px; height: {{SIZE}}px; line-height: {{SIZE}}px;',
					'{{WRAPPER}} .smw-team-member-social-link > a i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .smw-team-member-social-link > a img' => 'width: {{SIZE}}px; height: {{SIZE}}px; line-height: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'smw_team_members_social_profiles_padding',
			[
				'label' => esc_html__( 'Social Profiles Spacing', smw_slug),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .smw-team-content > .smw-team-member-social-profiles' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'smw_team_members_social_icons_spacing',
			[
				'label'      => esc_html__( 'Social Icon Spacing', smw_slug),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .smw-team-content > .smw-team-member-social-profiles li.smw-team-member-social-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'smw_team_members_social_icons_style_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', smw_slug) ] );

		$this->add_control(
			'smw_team_members_social_icon_color',
			[
				'label' => esc_html__( 'Icon Color', smw_slug),
				'type' => Controls_Manager::COLOR,
				'default' => '#f1ba63',
				'selectors' => [
					'{{WRAPPER}} .smw-team-member-social-link > a' => 'color: {{VALUE}};',
				],
			]
		);
		
		
		$this->add_control(
			'smw_team_members_social_icon_background',
			[
				'label' => esc_html__( 'Background Color', smw_slug),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .smw-team-member-social-link > a' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'smw_team_members_social_icon_border',
				'selector' => '{{WRAPPER}} .smw-team-member-social-link > a',
			]
		);
		
		$this->add_control(
			'smw_team_members_social_icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', smw_slug),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .smw-team-member-social-link > a' => 'border-radius: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'smw_team_members_social_icon_typography',
				'selector' => '{{WRAPPER}} .smw-team-member-social-link > a',
			]
		);

		
		$this->end_controls_tab();

		$this->start_controls_tab( 'smw_team_members_social_icon_hover', [ 'label' => esc_html__( 'Hover', smw_slug) ] );

		$this->add_control(
			'smw_team_members_social_icon_hover_color',
			[
				'label' => esc_html__( 'Icon Hover Color', smw_slug),
				'type' => Controls_Manager::COLOR,
				'default' => '#ad8647',
				'selectors' => [
					'{{WRAPPER}} .smw-team-member-social-link > a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'smw_team_members_social_icon_hover_background',
			[
				'label' => esc_html__( 'Hover Background Color', smw_slug),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .smw-team-member-social-link > a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'smw_team_members_social_icon_hover_border_color',
			[
				'label' => esc_html__( 'Hover Border Color', smw_slug),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .smw-team-member-social-link > a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		$this->end_controls_section();
	}


	protected function render( ) 
	{
        $settings = $this->get_settings();
        $team_member_image = $this->get_settings( 'smw_team_member_image' );
    	$team_member_image_url = Group_Control_Image_Size::get_attachment_image_src( $team_member_image['id'], 'thumbnail', $settings );	
    	if( empty( $team_member_image_url ) ) : $team_member_image_url = $team_member_image['url']; else: $team_member_image_url = $team_member_image_url; endif;
    	$team_member_classes = $this->get_settings('smw_team_members_preset') . " " . $this->get_settings('smw_team_members_image_rounded');
    	
    	?>
	
    	<div id="smw-team-member-<?php echo esc_attr($this->get_id()); ?>" class="smw-team-item <?php echo $team_member_classes; ?>">
    		<div class="smw-team-item-inner">
    			<div class="smw-team-image">
    				<figure>
    					<img src="<?php echo esc_url($team_member_image_url);?>" alt="<?php echo esc_attr( get_post_meta($team_member_image['id'], '_wp_attachment_image_alt', true) ); ?>">
    				</figure>
    			</div>
    
    			<div class="smw-team-content">
    				<h3 class="smw-team-member-name"><?php echo $settings['smw_team_member_name']; ?></h3>
    				<h4 class="smw-team-member-position"><?php echo $settings['smw_team_member_job_title']; ?></h4>
    
    				<?php if( 'smw-team-members-social-bottom' === $settings['smw_team_members_preset'] ) : ?>
    					<?php do_action('smw/team_member_social_botton_markup', $settings); ?>
    				<?php else: ?>
    					<?php if ( ! empty( $settings['smw_team_member_enable_social_profiles'] ) ): ?>
    					<ul class="smw-team-member-social-profiles">
    						<?php foreach ( $settings['smw_team_member_social_profile_links'] as $item ) : ?>
    							<?php $icon_migrated = isset($item['__fa4_migrated']['social_new']);
    							$icon_is_new = empty($item['social']); ?>
    							<?php if ( ! empty( $item['social'] ) || !empty($item['social_new'])) : ?>
    								<?php $target = $item['link']['is_external'] ? ' target="_blank"' : ''; ?>
    								<li class="smw-team-member-social-link">
    									<a href="<?php echo esc_attr( $item['link']['url'] ); ?>" <?php echo $target; ?>>
    										<?php if ($icon_is_new || $icon_migrated) { ?>
    											<?php if( isset( $item['social_new']['value']['url'] ) ) : ?>
    												<img src="<?php echo esc_attr($item['social_new']['value']['url'] ); ?>" alt="<?php echo esc_attr(get_post_meta($item['social_new']['value']['id'], '_wp_attachment_image_alt', true)); ?>" />
    											<?php else : ?>
    												<i class="<?php echo esc_attr($item['social_new']['value'] ); ?>"></i>
    											<?php endif; ?>
    										<?php } else { ?>
    											<i class="<?php echo esc_attr($item['social'] ); ?>"></i>
    										<?php } ?>
    									</a>
    								</li>
    							<?php endif; ?>
    						<?php endforeach; ?>
    					</ul>
    					<?php endif; ?>
    					<p class="smw-team-text"><?php echo $settings['smw_team_member_description']; ?></p>
    				<?php endif; ?>
    			</div>
    		</div>
    	</div>
	<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_team_members() );