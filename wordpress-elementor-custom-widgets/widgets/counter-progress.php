<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

class circular_progress_counter_Elementor_Widgets extends \Elementor\Widget_Base {

    public function get_name() {
		return 'Circular Progress Bar';
	}

    public function get_title() {
		return esc_html__( 'Circular Progress Bar', 'Counter' );
	}

    public function get_icon() {
		return 'eicon-menu-card';
	}

    public function get_categories() {
		return [ 'basic' ];
	}

    public function get_keywords() {
		return [ 'Bar', 'Counter', 'Progress' ];
	}

    // Widget Controls
    protected function register_controls() {
    
    }

    // Widget Rendering for output
    protected function render() {

      ?>


<div class="wrapper circular_progress_bar" data-value="50">
        <div class="container">
          <div class="background-circle"></div>
          <div class="foreground-circle">
            <!-- svg's width (180px) = 
                foreground-circle's width (180px).
              cx, cy, and r values should be half of the svg's width. -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              version="1.1"
              width="180px"
              height="180px"
            >
              <circle
                class="bellow"
                cx="60"
                cy="60"
                r="60"
                stroke="#EBEBEB"
                stroke-width="10"
                fill="transparent"
                stroke-linecap="round"
              />
              <circle
                cx="60"
                cy="60"
                r="60"
                stroke="#50c878"
                stroke-width="10"
                fill="transparent"
                stroke-linecap="round"
              />
            </svg>
          </div>
          <div class="text-inside-circle">
            <p id="number-inside-circle">0</p>
          </div>
        </div>
      </div>


      <?php
      echo 'Circular Progress';
    }

}
