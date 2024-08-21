<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Static cards Slider.
 *
 * @since 1.0.0
 */
class TeachingChannel_Courses_Cards extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'teaching-channel-courses-cards';
    }

    /**
     * Get widget title.
     *
     * Retrieve widget title.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Courses Cards', 'teachingchannel' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve widget icon.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    /**
     * Get widget categories.
     *
     * Register the widget in our own custom category.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'teaching_channel_widgets' ];
    }

    /**
     * Register widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            array(
                'label' => __( 'Content', 'teachingchannel' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'course_title',
            array(
                'label'       => __( 'Title', 'teachingchannel' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Course Title' , 'teachingchannel' ),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'course_type',
            array(
                'label'      => __( 'Course Type', 'teachingchannel' ),
                'type'       => \Elementor\Controls_Manager::TEXT,
                'show_label' => true,
            )
        );

        $repeater->add_control(
            'course_credits',
            array(
                'label'      => __( 'Course Credits', 'teachingchannel' ),
                'type'       => \Elementor\Controls_Manager::TEXT,
                'show_label' => true,
            )
        );

        $repeater->add_control(
            'course_link_text',
            array(
                'label'       => __( 'Course Link Text', 'teachingchannel' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Card Button Text' , 'teachingchannel' ),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'course_link',
            array(
                'label'         => __( 'Course Link', 'teachingchannel' ),
                'type'          => \Elementor\Controls_Manager::URL,
                'placeholder'   => __( 'https://your-link.com', 'teachingchannel' ),
                'show_external' => true,
                'default'       => array(
                    'url'         => '#',
                    'is_external' => false,
                    'nofollow'    => false,
                ),
            )
        );

        $this->add_control(
            'list',
            array(
                'label'   => __( 'Course List', 'teachingchannel' ),
                'type'    => \Elementor\Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => array(
                    array(
                        'course_title'       => __( 'Course Title #1', 'teachingchannel' ),
                        'course_type'        => __( 'K-12', 'teachingchannel' ),
                        'course_credits'     => __( '3 Credits', 'teachingchannel' ),
                        'course_link_text'   => __( 'Register', 'teachingchannel' ),
                        'course_link'        => __( '#', 'teachingchannel' ),
                    ),
                    array(
                        'course_title'       => __( 'Course Title #2', 'teachingchannel' ),
                        'course_type'        => __( 'K-12', 'teachingchannel' ),
                        'course_credits'     => __( '3 Credits', 'teachingchannel' ),
                        'course_link_text'   => __( 'Register', 'teachingchannel' ),
                        'course_link'        => __( '#', 'teachingchannel' ),
                    ),
                    array(
                        'course_title'       => __( 'Course Title #3', 'teachingchannel' ),
                        'course_type'        => __( 'K-12', 'teachingchannel' ),
                        'course_credits'     => __( '3 Credits', 'teachingchannel' ),
                        'course_link_text'   => __( 'Register', 'teachingchannel' ),
                        'course_link'        => __( '#', 'teachingchannel' ),
                    ),
                ),
                'title_field' => '{{{ course_title }}}',
            )
        );

        $this->add_control(
            'see_all',
            array(
                'label'        => __( 'Show see All box', 'teachingchannel' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'teachingchannel' ),
                'label_off'    => __( 'No', 'teachingchannel' ),
                'return_value' => 'yes',
                'default'      => 'no',
            )
        );

        $this->add_control(
            'see_all_title',
            array(
                'label'       => __( 'See All Title', 'teachingchannel' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'See All Title' , 'teachingchannel' ),
                'label_block' => true,
                'condition'   => array(
                    'see_all' => 'yes',
                ),
            )
        );

        $this->add_control(
            'see_all_link_text',
            array(
                'label'       => __( 'See All Link Text', 'teachingchannel' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'See All Link Text' , 'teachingchannel' ),
                'label_block' => true,
                'condition'   => array(
                    'see_all' => 'yes',
                ),
            )
        );

        $this->add_control(
            'see_all_link',
            array(
                'label'         => __( 'See All Link', 'teachingchannel' ),
                'type'          => \Elementor\Controls_Manager::URL,
                'placeholder'   => __( 'https://your-link.com', 'teachingchannel' ),
                'show_external' => true,
                'default'       => array(
                    'url'         => '#',
                    'is_external' => false,
                    'nofollow'    => false,
                ),
                'condition'     => array(
                    'see_all' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

    }

    /**
     * Render cards slider widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {

        $settings  = $this->get_settings_for_display();
        $list      = $settings['list'] ? $settings['list'] : array();

        if ( ! empty( $list ) ) { ?>
			<div class="courses-container swiper-container courses-slider">
				<div class="courses-wrapper swiper-wrapper">
					<?php foreach ( $list as $item ) : ?>
						<?php $this->remove_render_attribute( 'course_link' );
						if ( ! empty( $item['course_link'] ) ) {
							$this->add_link_attributes( 'course_link', $item['course_link'] );
						}
						?>
						<div class="course-box swiper-slide">
                            <?php if ( $item['course_title'] ) : ?>
                                <h4 class="course-title">
                                    <?php if ( $item['course_link']['url'] ) : ?>
                                        <a <?php echo $this->get_render_attribute_string( 'course_link' ); ?>><?php echo esc_html( $item['course_title'] ); ?></a>
                                    <?php else : ?>
                                        <?php echo esc_html( $item['course_title'] ); ?>
                                    <?php endif; ?>
                                </h4>
                            <?php endif; ?>
                            <?php if ( $item['course_type'] || $item['course_credits'] ) : ?>
                                <div class="course-info">
                                    <?php if ( $item['course_type'] ) : ?>
                                        <p><?php echo esc_html( $item['course_type'] ); ?></p>
                                    <?php endif; ?>
                                    <?php if ( $item['course_credits'] ) : ?>
                                        <p><?php echo esc_html( $item['course_credits'] ); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ( $item['course_link_text'] && $item['course_link']['url'] ) : ?>
                                <div class="course-buttons">
                                    <a <?php echo $this->get_render_attribute_string( 'course_link' ); ?> ><?php echo esc_html( $item['course_link_text'] ); ?></a>
                                </div>
                            <?php endif; ?>
						</div>
					<?php endforeach; ?>
					<?php if ( $settings['see_all'] == 'yes' ) : ?>
						<div class="course-box view-all curved-button">
							<?php if ( $settings['see_all_title'] ) : ?>
								<h3><?php echo esc_html( $settings['see_all_title'] ); ?></h3>
							<?php endif; ?>
							<?php 
								if ( ! empty( $settings['see_all_link']['url'] ) ) {
									$this->add_link_attributes( 'see_all_link', $settings['see_all_link'] );
								}
							?>
							<?php if ( $settings['see_all_link_text'] && $settings['see_all_link']['url'] ) : ?>
								<a <?php echo $this->get_render_attribute_string( 'see_all_link' ); ?> class="elementor-button"><?php echo esc_html( $settings['see_all_link_text'] ); ?></a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="topics-pagination"></div>
			</div>
         <?php }
    }
}

