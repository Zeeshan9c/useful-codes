<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Repeater_Cards_Custom_Elementor_Widgets extends \Elementor\Widget_Base {
    
    public function get_name() {
		return 'repeater-cards';
	}

    public function get_title() {
		return esc_html__( 'Repeater Cards', 'elementor-list-widget' );
	}

    public function get_icon() {
		return 'eicon-menu-card';
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
				'label' => esc_html__( 'List Content', 'elementor-list-widget' ),
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
				'label' => esc_html__( 'Description', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Default Description', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your description here', 'textdomain' ),
			]
		);



        $repeated_items = new \Elementor\Repeater();

        $repeated_items->add_control(
            'widget_title',
            [
                'label' => esc_html__( 'Title', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Default title', 'textdomain' ),
                'placeholder' => esc_html__( 'Type your title here', 'textdomain' ),
            ]
        );

        $repeated_items->add_control(
            'widget_description',
            [
                'label' => esc_html__( 'Description', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Default Description', 'textdomain' ),
                'placeholder' => esc_html__( 'Type your description here', 'textdomain' ),
            ]
        );

        $this->add_control(
            'repeater_list',
            [
                'label' => esc_html__( 'List', 'elementor-list-widget' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeated_items->get_controls(),
                'default' => [
                    [
                        'widget_title' => esc_html__( 'Item 1', 'textdomain' ),
                        'widget_description' => esc_html__( 'Description for Item 1', 'textdomain' ),
                    ],
                    [
                        'widget_title' => esc_html__( 'Item 2', 'textdomain' ),
                        'widget_description' => esc_html__( 'Description for Item 1', 'textdomain' ),
                    ],
                    [
                        'widget_title' => esc_html__( 'Item 3', 'textdomain' ),
                        'widget_description' => esc_html__( 'Description for Item 1', 'textdomain' ),
                    ],
                ],
                'title_field' => '{{{ widget_title }}}',
            ]
        );

    
        $this->end_controls_section();

    }

    // Widget Rendering for output
    protected function render() {
        $settings = $this->get_settings_for_display();
        $repeater_list = $settings['repeater_list'];
    
        if (!empty($repeater_list)) {
            foreach ($repeater_list as $item) {
                $widget_title = $item['widget_title'];
                $widget_description = $item['widget_description'];
                ?>
                <div class="block">
                    <h2 class="card_title"><?php echo $widget_title; ?></h2>
                    <div class="card_description"><?php echo $widget_description; ?></div>
                </div>
                <?php
            }
        }
    }

}
