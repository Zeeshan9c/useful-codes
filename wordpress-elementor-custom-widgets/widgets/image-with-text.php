<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_With_Text_Custom_Elementor_Widgets extends \Elementor\Widget_Base {

    public function get_name() {
		return 'Image with text';
	}

    public function get_title() {
		return esc_html__( 'Image with text', 'elementor-custom-widgets' );
	}

    public function get_icon() {
		return 'eicon-thumbnails-half';
	}

    public function get_categories() {
		return [ 'basic' ];
	}

    protected function register_controls() {
        $this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'image_position',
            [
                'label' => esc_html__( 'Image Position', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Right', 'textdomain' ),
                'label_off' => esc_html__( 'Left', 'textdomain' ),
                'return_value' => 'right',
                'default' => 'left',
            ]
        );

        $this->add_control(
            'widget_image',
            [
                'label' => esc_html__( 'Image', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'placeholder' => esc_html__( 'Select an image', 'textdomain' ),
            ]
        );

        $this->add_control(
			'section_title',
			[
				'label' => esc_html__( 'Title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Default title', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your title here', 'textdomain' ),
			]
		);

        $this->add_control(
            'section_description',
            [
                'label' => esc_html__( 'Description', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Default description', 'textdomain' ),
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

        $card_title = $settings['section_title'];
        $card_description = $settings['section_description'];
        $card_image = $settings['widget_image']['url'];
        // Set a fallback image if the image is not set or empty
        $fallback_image_url = 'https://raw.githubusercontent.com/koehlersimon/fallback/master/Resources/Public/Images/placeholder.jpg';
        $card_image_url = ! empty($card_image) ? $card_image : $fallback_image_url;

        ?>

        <div class="card_wrapper">
            <h2 class="card_title"><?php echo $card_title; ?></h2>
            <div class="card_description"><?php echo $card_description; ?></div>
            <img src="<?php echo $card_image_url; ?>" alt="Card Image">
        </div>

        <?php

    }

}