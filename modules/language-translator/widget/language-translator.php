<?php

/**
 * SMW Language Translator.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_language_translator extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);
    }
    
    public function get_name()
    {
        return 'stiles-language-translator';
    }
    
    public function get_title()
    {
        return 'Website Translator';
    }
    
    public function get_icon()
    {
        return 'eicon-user-preferences';
    }
    
    public function get_categories()
    {
        return [ 'stiles-media-category' ];
    }
    
    public function get_style_depends() 
    {
        return [ 'stiles-website-translator' ];
    }
    
    public function get_script_depends() 
    {
        return [ 
            'stiles-website-translator',
            'googletranslate'
        ];
    }
    
    protected function get_languages()
    {
        return [
            'Afrikaans' => __( 'Afrikaans', smw_slug ),
            'Irish' => __( 'Irish', smw_slug ),
            'Albanian' => __( 'Albanian', smw_slug ),
            'Italian' => __( 'Italian', smw_slug ),
            'Arabic' => __( 'Arabic', smw_slug ),
            'Japanese' => __( 'Japanese', smw_slug ),
            'Azerbaijani' => __( 'Azerbaijani', smw_slug ),
            'Kannada' => __( 'Kannada', smw_slug ),
            'Basque' => __( 'Basque', smw_slug ),
            'Korean' => __( 'Korean', smw_slug ),
            'Bangla' => __( 'Bangla', smw_slug ),
            'Latin' => __( 'Latin', smw_slug ),
            'Belarusian' => __( 'Belarusian', smw_slug ),
            'Latvian' => __( 'Latvian', smw_slug ),
            'Bulgarian' => __( 'Bulgarian', smw_slug ),
            'Lithuanian' => __( 'Lithuanian', smw_slug ),
            'Catalan' => __( 'Catalan', smw_slug ),
            'Macedonian' => __( 'Macedonian', smw_slug ),
            'Chinese Simplified' => __( 'Chinese Simplified', smw_slug ),
            'Malay' => __( 'Malay', smw_slug ),
            'Chinese Traditional' => __( 'Chinese Traditional', smw_slug ),
            'Maltese' => __( 'Maltese', smw_slug ),
            'Croatian' => __( 'Croatian', smw_slug ),
            'Norwegian' => __( 'Norwegian', smw_slug ),
            'Czech' => __( 'Czech', smw_slug ),
            'Persian' => __( 'Persian', smw_slug ),
            'Danish' => __( 'Danish', smw_slug ),
            'Polish' => __( 'Polish', smw_slug ),
            'Dutch' => __( 'Dutch', smw_slug ),
            'Portuguese' => __( 'Portuguese', smw_slug ),
            'English' => __( 'English', smw_slug ),
            'Romanian' => __( 'Romanian', smw_slug ),
            'Esperanto' => __( 'Esperanto', smw_slug ),
            'Russian' => __( 'Russian', smw_slug ),
            'Estonian' => __( 'Estonian', smw_slug ),
            'Serbian' => __( 'Serbian', smw_slug ),
            'Filipino' => __( 'Filipino', smw_slug ),
            'Slovak' => __( 'Slovak', smw_slug ),
            'Finnish' => __( 'Finnish', smw_slug ),
            'Slovenian' => __( 'Slovenian', smw_slug ),
            'French' => __( 'French', smw_slug ),
            'Spanish' => __( 'Spanish', smw_slug ),
            'Galician' => __( 'Galician', smw_slug ),
            'Swahili' => __( 'Swahili', smw_slug ),
            'Georgian' => __( 'Georgian', smw_slug ),
            'Swedish' => __( 'Swedish', smw_slug ),
            'German' => __( 'German', smw_slug ),
            'Tamil' => __( 'Tamil', smw_slug ),
            'Greek' => __( 'Greek', smw_slug ),
            'Telugu' => __( 'Telugu', smw_slug ),
            'Gujarati' => __( 'Gujarati', smw_slug ),
            'Thai' => __( 'Thai', smw_slug ),
            'Haitian Creole' => __( 'Haitian Creole', smw_slug ),
            'Turkish' => __( 'Turkish', smw_slug ),
            'Hebrew' => __( 'Hebrew', smw_slug ),
            'Ukrainian' => __( 'Ukrainian', smw_slug ),
            'Hindi' => __( 'Hindi', smw_slug ),
            'Urdu' => __( 'Urdu', smw_slug ),
            'Hungarian' => __( 'Hungarian', smw_slug ),
            'Vietnamese' => __( 'Vietnamese', smw_slug ),
            'Icelandic' => __( 'Icelandic', smw_slug ),
            'Welsh' => __( 'Welsh', smw_slug ),
            'Indonesian' => __( 'Indonesian', smw_slug ),
            'Yiddish' => __( 'Yiddish', smw_slug )
        ];
    }
    
    protected function register_controls() 
    {
        $this-> icon_or_text();
        
        $this->language_section();
        
        $this->register_general_controls();
        
        $this->register_country_style_control();
    }
    
    protected function icon_or_text()
    {
        $this->start_controls_section(
			'translator_options',
			array(
				'label' => __( 'Translator Options', smw_slug ),
			)
		);
		
		$this->add_control(
			'translator_style',
			array(
				'label' => __( 'Choose Style', smw_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => array(
					'icon'  => __( 'Icon', smw_slug ),
					'text' => __( 'Text', smw_slug ),
					'both' => __( 'Icon + Text', smw_slug ),
				),
			)
		);
		
		$this->add_control(
			'icon_position',
			array(
				'label' => __( 'Icon Position', smw_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => __( 'Left', smw_slug ),
					'right' => __( 'Right', smw_slug ),
				),
				'condition' => array(
                    'translator_style' => 'both'
                ),
			)
		);
		
		$this->add_control(
			'translator_icon_heading',
			array(
				'label' => __( 'Translator Icon', smw_slug ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
                    'translator_style' => 'both'
                ),
			)
		);
		
		$this->add_control(
			'translator_icon',
			array(
				'label' => __( 'Icon', smw_slug ),
				'type' => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'fas fa-globe',
					'library' => 'solid',
				),
				'condition' => array(
                    'translator_style!' => 'text'
                ),
			)
		);
		
		$this->add_control(
			'translator_icon_color',
			array(
				'label' => __( 'Colour', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				),
				'default' => '#7A7A7A',
				'selectors' => array(
					'{{WRAPPER}} .ct-language i' => 'color: {{VALUE}}',
				),
				'condition' => array(
                    'translator_style!' => 'text'
                ),
			)
		);
		
		$this->add_responsive_control(
			'translator_icon_padding',
			array(
				'label'      => __( 'Padding', smw_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ct-language i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
                    'translator_style!' => 'text'
                ),
			)
		);
		
		$this->add_control(
			'translator_text_heading',
			array(
				'label' => __( 'Translator Text', smw_slug ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
                    'translator_style' => 'both'
                ),
			)
		);
		
		$this->add_control(
			'translator_text',
			array(
				'label' => __( 'Text', smw_slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Translate', smw_slug ),
				'placeholder' => __( 'Type your translator text here', smw_slug ),
				'condition' => array(
                    'translator_style!' => 'icon'
                ),
			)
		);
		
		$this->add_control(
			'translator_text_color',
			array(
				'label' => __( 'Colour', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				),
				'default' => '#7A7A7A',
				'selectors' => array(
					'{{WRAPPER}} .ct-language span' => 'color: {{VALUE}}',
				),
				'condition' => array(
                    'translator_style!' => 'icon'
                ),
			)
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'translator_text_typography',
				'label' => __( 'Typography', smw_slug ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ct-language span',
				'condition' => array(
                    'translator_style!' => 'icon'
                ),
			)
		);
		
		$this->add_responsive_control(
			'translator_text_padding',
			array(
				'label'      => __( 'Padding', smw_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ct-language span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
                    'translator_style!' => 'icon'
                ),
			)
		);
		
		$this->end_controls_section();
    }
    
    protected function language_section()
    {
        $this->start_controls_section(
			'section_countries',
			array(
				'label' => __( 'Countries', smw_slug ),
			)
		);
		
		    $repeater = new Repeater();
    
    		$repeater->add_control(
    			'choose_language',
    			array(
    			    'label' => __( 'Choose Language', smw_slug ),
    				'type' => Controls_Manager::SELECT2,
    				'options' => $this->get_languages(),
    				'default' => 'English',
    				'label_block' => true,
    			)
    		);
    		
    		$this->add_control(
    			'language_settings',
    			array(
    				'type'        => Controls_Manager::REPEATER,
    				'fields'      => array_values( $repeater->get_controls() ),
    				'default'     => array(
    					array(
    						'choose_language'  => __( 'English', smw_slug ),
    					),
    					array(
    						'choose_language'  => __( 'Spanish', smw_slug ),
    					),
    					array(
    						'choose_language'  => __( 'Russian', smw_slug ),
    					),
    				),
    				'title_field' => '{{{ choose_language }}}',
    			)
    		);

		$this->end_controls_section();
    }
    
    protected function register_general_controls()
    {
        $this->start_controls_section(
			'section_lt_general',
			array(
				'label' => __( 'General', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name' => 'background',
				'label' => __( 'Background', smw_slug ),
				'types' => [ 'classic', 'gradient', smw_slug ],
				'selector'  => '{{WRAPPER}} .ct-language',
			)
		);
		
		$this->add_control(
			'translator_text_color',
			array(
				'label' => __( 'Colour', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				),
				'default' => '#7A7A7A',
				'selectors' => array(
					'{{WRAPPER}} .ct-language span' => 'color: {{VALUE}}',
				),
			)
		);
		
		$this->add_responsive_control(
			'section_lt_list_padding',
			array(
				'label'      => __( 'Country Padding', smw_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ct-language__dropdown li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		
		$this->add_responsive_control(
			'section_lt_dropdown_position',
			array(
				'label'      => __( 'Dropdown Positioning', smw_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => '71%',
				'selectors'  => array(
					'{{WRAPPER}} .ct-language__dropdown' => 'top: {{TOP}}{{UNIT}};',
					'{{WRAPPER}} .ct-language__dropdown' => 'right: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .ct-language__dropdown' => 'bottom: {{BOTTOM}}{{UNIT}};',
					'{{WRAPPER}} .ct-language__dropdown' => 'left: {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
    }
    
    protected function register_country_style_control()
    {
        $this->start_controls_section(
			'section_country_style',
			array(
				'label' => __( 'Countries', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_control(
			'country_background',
			array(
				'label' => __( 'Background Colour', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				),
				'default' => '#ededed',
				'selectors' => array(
					'{{WRAPPER}} .ct-language__dropdown::before' => 'border-bottom-color: {{VALUE}}',
					'{{WRAPPER}} .ct-language__dropdown li' => 'background: {{VALUE}}',
				),
			)
		);
		
		$this->add_control(
			'country_text_heading',
			array(
				'label' => __( 'Country Text', smw_slug ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		
		$this->start_controls_tabs(
			'style_tabs'
		);

		$this->start_controls_tab(
			'style_normal_tab',
			array(
				'label' => __( 'Normal', 'plugin-name' ),
			)
		);
		
		$this->add_control(
			'country_normal_color',
			array(
				'label' => __( 'Colour', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} .ct-language__dropdown a' => 'color: {{VALUE}}',
				),
			)
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'hyperlink_normal_typography',
				'label' => __( 'Typography', smw_slug ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ct-language__dropdown a',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_hover_tab',
			array(
				'label' => __( 'Hover', 'plugin-name' ),
			)
		);
		
		$this->add_control(
			'country_hover_color',
			array(
				'label' => __( 'Colour', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} .ct-language__dropdown a:hover' => 'color: {{VALUE}}',
				),
			)
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'hyperlink_hover_typography',
				'label' => __( 'Typography', smw_slug ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ct-language__dropdown a:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
    }
    
    protected function render() 
    {
        $settings = $this->get_settings_for_display();
		$node_id  = $this->get_id();
		
        $languagecodes = array (
            'af' => 'Afrikaans',
            'ga' => 'Irish',
            'sq' => 'Albanian',
            'it' => 'Italian',
            'ar' => 'Arabic',
            'ja' => 'Japanese',
            'az' => 'Azerbaijani',
            'kn' => 'Kannada',
            'eu' => 'Basque',
            'ko' => 'Korean',
            'bn' => 'Bangla',
            'la' => 'Latin',
            'be' => 'Belarusian',
            'lv' => 'Latvian',
            'bg' => 'Bulgarian',
            'lt' => 'Lithuanian',
            'ca' => 'Catalan',
            'mk' => 'Macedonian',
            'zh-CN' => 'Chinese Simplified',
            'ms' => 'Malay',
            'zh-TW' => 'Chinese Traditional',
            'mt' => 'Maltese',
            'hr' => 'Croatian',
            'no' => 'Norwegian',
            'cs' => 'Czech',
            'fa' => 'Persian',
            'da' => 'Danish',
            'pl' => 'Polish',
            'nl' => 'Dutch',
            'pt' => 'Portuguese',
            'en' => 'English',
            'ro' => 'Romanian',
            'eo' => 'Esperanto',
            'ru' => 'Russian',
            'et' => 'Estonian',
            'sr' => 'Serbian',
            'tl' => 'Filipino',
            'sk' => 'Slovak',
            'fi' => 'Finnish',
            'sl' => 'Slovenian',
            'fr' => 'French',
            'es' => 'Spanish',
            'gl' => 'Galician',
            'sw' => 'Swahili',
            'ka' => 'Georgian',
            'sv' => 'Swedish',
            'de' => 'German',
            'ta' => 'Tamil',
            'el' => 'Greek',
            'te' => 'Telugu',
            'gu' => 'Gujarati',
            'th' => 'Thai',
            'ht' => 'Haitian Creole',
            'tr' => 'Turkish',
            'iw' => 'Hebrew',
            'uk' => 'Ukrainian',
            'hi' => 'Hindi',
            'ur' => 'Urdu',
            'hu' => 'Hungarian',
            'vi' => 'Vietnamese',
            'is' => 'Icelandic',
            'cy' => 'Welsh',
            'id' => 'Indonesian',
            'yi' => 'Yiddish'
        );
        
        $languagename = array (
            'Afrikaans' => 'Afrikaans',
            'Gaeilge' => 'Irish',
            'Shqiptar' => 'Albanian',
            'Italiano' => 'Italian',
            'Eurbaa' => 'Arabic',
            '日本人' => 'Japanese',
            'Azərbaycan' => 'Azerbaijani',
            'ಕನ್ನಡ' => 'Kannada',
            'Euskal' => 'Basque',
            '한국어' => 'Korean',
            'বাংলা' => 'Bengali',
            'Latine' => 'Latin',
            'Беларус' => 'Belarusian',
            'Latvijas' => 'Latvian',
            'български' => 'Bulgarian',
            'Lietuvis' => 'Lithuanian',
            'Català' => 'Catalan',
            'Македонски' => 'Macedonian',
            '简体中文' => 'Chinese Simplified',
            'Bahasa Melayu' => 'Malay',
            '中國傳統的' => 'Chinese Traditional',
            'Malti' => 'Maltese',
            'Hrvatski' => 'Croatian',
            'Norsk' => 'Norwegian',
            'Čeština' => 'Czech',
            'فارسی' => 'Persian',
            'Dansk' => 'Danish',
            'Polskie' => 'Polish',
            'Nederlands' => 'Dutch',
            'Português' => 'Portuguese',
            'English' => 'English',
            'Română' => 'Romanian',
            'Esperanto' => 'Esperanto',
            'Pусский' => 'Russian',
            'Eesti Keel' => 'Estonian',
            'Српски' => 'Serbian',
            'Filipino' => 'Filipino',
            'Slovenský' => 'Slovak',
            'Suomalainen' => 'Finnish',
            'Slovenščina' => 'Slovenian',
            'Français' => 'French',
            'Español' => 'Spanish',
            'Galego' => 'Galician',
            'Kiswahili' => 'Swahili',
            'ქართული' => 'Georgian',
            'Svenska' => 'Swedish',
            'Deutsche' => 'German',
            'தமிழ்' => 'Tamil',
            'Ελληνικά' => 'Greek',
            'తెలుగు' => 'Telugu',
            'ગુજરાતી' => 'Gujarati',
            'ไทย' => 'Thai',
            'Kreyòl Ayisyen' => 'Haitian Creole',
            'Türk' => 'Turkish',
            'עִברִית' => 'Hebrew',
            'Українська' => 'Ukrainian',
            'हिन्दी' => 'Hindi',
            'اردو' => 'Urdu',
            'Magyar' => 'Hungarian',
            'Tiếng Việt' => 'Vietnamese',
            'Íslensku' => 'Icelandic',
            'Cymraeg' => 'Welsh',
            'Bahasa Indonesia' => 'Indonesian',
            'יידיש' => 'Yiddish'
        );
        
        $selected = array();
        ?>
        <div class="ct-topbar">
            <div class="container">
                <ul class="list-unstyled list-inline ct-topbar__list">
                    <?php if( $settings['icon_position'] === 'right' )
                    {
                        ?>
                        <li class="ct-language"><span><?php echo $settings[ 'translator_text' ]; ?></span> <?php \Elementor\Icons_Manager::render_icon( $settings['translator_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php
                    }
                    else
                    {
                        ?>
                        <li class="ct-language"><?php \Elementor\Icons_Manager::render_icon( $settings['translator_icon'], [ 'aria-hidden' => 'true' ] ); ?><span> <?php echo $settings[ 'translator_text' ]; ?> </span>
                        <?php
                    }
                        ?>
                        <ul class="list-unstyled ct-language__dropdown">
                            <?php
                            if ( count( $settings[ 'language_settings' ] ) ) 
                            {
                                $count = 0;
                                
                        		foreach ( $settings[ 'language_settings' ] as $item ) 
                        		{
                        		    if( ! in_array( $item["choose_language"] , $selected ) )
                        		    {
                        		        //add our item to array so it cant be used again
                                        array_push($selected , $item["choose_language"] );
                                        
                        		        $repeater_setting__country = $this->get_repeater_setting_key( 'choose_language', 'language_settings', $count );
                                        $this->add_inline_editing_attributes( $repeater_setting__country );
                                            
                                        $code = $item["choose_language"];
                                        $name = array_search( $code , $languagename);
                                        $code = array_search( $code , $languagecodes);
                                        
                                        //make our list items as the item is not a duplicate
                                        ?>
                                        <li>
                                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); ?> href="#googtrans(en|<?php echo $code; ?>)" class="lang-es lang-select" data-lang="<?php echo $code; ?>"><img src="<?php echo plugin_dir_url( __DIR__ ) . 'flags/'; ?><?php echo wp_kses_post( $item["choose_language"] ); ?>.svg" alt="<?php echo $name; ?>"><?php echo $name; ?></a>
                                        </li>
                                        <?php
                        		    }
                        		}
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_language_translator() );