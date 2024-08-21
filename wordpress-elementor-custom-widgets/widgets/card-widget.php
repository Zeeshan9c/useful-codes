<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Cards_Custom_Elementor_Widgets extends \Elementor\Widget_Base {

    public function get_name() {
		return 'card';
	}

    public function get_title() {
		return esc_html__( 'Simple Cards', 'elementor-custom-widgets' );
	}

    public function get_icon() {
		return 'eicon-code';
	}

    public function get_categories() {
		return [ 'basic' ];
	}

    public function get_keywords() {
		return [ 'Basic', 'Cards', 'Simple' ];
	}


    // Widget Controls
    protected function register_controls() {

        $this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'widget_title',
			[
				'label' => esc_html__( 'Title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Default title', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your title here', 'textdomain' ),
			]
		);

        $this->add_control(
			'widget_description',
			[
				'label' => esc_html__( 'Title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Default title', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your description here', 'textdomain' ),
			]
		);

        $this->end_controls_section();

		// Style Controls
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color',
			[
				'label' => esc_html__( 'Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#f00',
				'selectors' => [
					'{{WRAPPER}} .card_title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

    }

    // Widget Rendering for output
    protected function render() {
        $settings = $this->get_settings_for_display();

        $card_title = $settings['widget_title'];
		$card_subtitle = $settings['widget_subtitle'];
        $card_description = $settings['widget_description'];

        ?>

        <div class="card_wrapper">
            <h2 class="card_title"><?php echo $card_title; ?></h2>
            <div class="card_description"><?php echo $card_description; ?></div>
        </div>

        <?php

    }
    
}