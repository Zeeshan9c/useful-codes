<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

class Testimonial_Slider_Custom_Elementor_Widgets extends \Elementor\Widget_Base
{
  public function get_name()
  {
    return 'testimonial-slider';
  }

  public function get_title()
  {
    return esc_html__('Testimonial Slider', 'elementor-testimonial-slider-widget');
  }

  public function get_icon()
  {
    return 'eicon-slider-album';
  }

  public function get_categories()
  {
    return ['basic'];
  }

  public function get_keywords()
  {
    return ['Testimonial', 'Slider', 'Carasoul'];
  }


  protected function register_controls()
  {

    $this->start_controls_section(
      'content_section',
      [
        'label' => esc_html__('List Content', 'elementor-list-widget'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'testimonial_title',
      [
        'label' => esc_html__('Title', 'textdomain'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('Default title', 'textdomain'),
        'placeholder' => esc_html__('Type your title here', 'textdomain'),
      ]
    );

    $this->add_control(
      'testimonial_description',
      [
        'label' => esc_html__('Description', 'textdomain'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'default' => esc_html__('Default description', 'textdomain'),
        'placeholder' => esc_html__('Type your description here', 'textdomain'),
      ]
    );

    $repeated_items = new \Elementor\Repeater();

    $repeated_items->add_control(
      'widget_image',
      [
        'label' => esc_html__('Image', 'textdomain'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => '',
        ],
        'placeholder' => esc_html__('Select an image', 'textdomain'),
      ]
    );

    $repeated_items->add_control(
      'widget_title',
      [
        'label' => esc_html__('Title', 'textdomain'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('Default title', 'textdomain'),
        'placeholder' => esc_html__('Type your title here', 'textdomain'),
      ]
    );

    $repeated_items->add_control(
      'widget_description',
      [
        'label' => esc_html__('Description', 'textdomain'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'default' => esc_html__('Default Description', 'textdomain'),
        'placeholder' => esc_html__('Type your description here', 'textdomain'),
      ]
    );

    $this->add_control(
      'repeater_list',
      [
        'label' => esc_html__('List', 'elementor-list-widget'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeated_items->get_controls(),
        'default' => [
          [
            'widget_title' => esc_html__('Item 1', 'textdomain'),
            'widget_description' => esc_html__('Description for Item 1', 'textdomain'),
          ],
          [
            'widget_title' => esc_html__('Item 2', 'textdomain'),
            'widget_description' => esc_html__('Description for Item 2', 'textdomain'),
          ],
          [
            'widget_title' => esc_html__('Item 3', 'textdomain'),
            'widget_description' => esc_html__('Description for Item 3', 'textdomain'),
          ],
        ],
        'title_field' => '{{{ widget_title }}}',
      ]
    );

    $this->end_controls_section();
  }


  protected function render()
  {

    $settings = $this->get_settings_for_display();
    $testimonial_title = $settings['testimonial_title'];
    $testimonial_description = $settings['testimonial_description'];
    $repeater_list = $settings['repeater_list'];

?>

    <div class="testimonial_slider_section">

      <div class="testimonial_header" style="text-align: center;">
        <h2 class="testimonial_heading"> <?php echo $testimonial_title; ?> </h2>
        <div class="testimonial_description"> <?php echo $testimonial_description; ?> </div>
      </div>

      <div class="testimonial_slider_wrapper">
        <div class="swiper testimonial-slider">
          <div class="swiper-wrapper">

            <?php
            if (!empty($repeater_list)) {
              foreach ($repeater_list as $item) {
                $slide_title = $item['widget_title'];
                $slide_description = $item['widget_description'];
                $card_image = $item['widget_image']['url'];
                // Set a fallback image if the image is not set or empty
                $fallback_image_url = 'https://raw.githubusercontent.com/koehlersimon/fallback/master/Resources/Public/Images/placeholder.jpg';
                $card_image_url = !empty($card_image) ? $card_image : $fallback_image_url;
            ?>

                <div class="swiper-slide">
                  <div class="image_wrapper">
                    <img src="<?php echo $card_image_url; ?>" alt="Card Image">
                  </div>
                  <div class="content_wrapper">
                    <div class="testimonial_footer" style="text-align: center;">
                      <h2 class="footer_heading"> <?php echo $slide_title; ?> </h2>
                      <div class="footer_description"> <?php echo $slide_description; ?> </div>
                    </div>
                  </div>
                </div>

            <?php }
            }   ?>

          </div>
          <div class="testimonial-controllers">
            <div class="testimonial-arrow-left nav-btn"></div>
            <div class="swiper-pagination swiper-pagination-progressbar"></div>
            <div class="testimonial-arrow-right nav-btn"></div>
          </div>
        </div>
      </div>

    </div>
<?php
  }
}
