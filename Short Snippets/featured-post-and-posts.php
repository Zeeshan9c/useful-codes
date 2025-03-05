<?php
/**
 * Short Code for get the Fetured Posts 
 * [featured_case_studies]
 * Get the posts from case-studies and limit is get latest 3 posts 
 */

 function mp_featured_case_studies() {
	ob_start();

	$args = array(
		'post_type'      => 'case-studies',
		'meta_query'     => array(
			array(
				'key'     => 'feature_case_study',
				'value'   => 'featured',
				'compare' => 'LIKE',
			),
		),
		'posts_per_page' => 3,
	);

	$featured_posts = new WP_Query( $args );

	if ( $featured_posts->have_posts() ) : ?>

		<div class="featured-case-studies-wrapper">

			<div class="featured-slider-wrapper swiper">
				<div class="swiper-wrapper">
				<?php while ( $featured_posts->have_posts() ) :
					$featured_posts->the_post();
					?>
					<div class="swiper-slide">
						<div class="featured-image-column">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
							<?php endif; ?>
						</div>
						<div class="featured-content-column">
							<h3 class="featured-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php
							$content = get_the_content();
							$excerpt = get_the_excerpt();
							if ( ! empty( $content ) || ! empty( $excerpt ) ) :
								?>
								<div class="featured-post-description">
									<p><?php echo wp_trim_words( $content ? $content : $excerpt, 30, '...' ); ?></p>
								</div>
							<?php endif; ?>
							<div class="button-wrapper text-link arrow-btn read-more">
								<a href="<?php the_permalink(); ?>" class="elementor-cta__button elementor-button elementor-size-">
									Read Case Study
								<span class="last"></span></a>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				</div>

				<div class="slider-controlls">
					<div class="swiper-button-prev featured-post-prev"></div>
					<div class="swiper-pagination featured-post-pagination"></div>
					<div class="swiper-button-next featured-post-next"></div>
				</div>

			</div>

		</div>

		<?php
		wp_reset_postdata();

	endif;

	return ob_get_clean();
}
add_shortcode( 'featured_case_studies', 'mp_featured_case_studies' );

/**
 * Now its the Facet code for get the posts from case-studies
 * Now this code get all the posts but exclude the latest posts
 */

 // Code for Display the posts for case-studies
 ?>
 <div class="mp-case-studies-wrapper">
  <div class="mp-case-studies-inner">
      <?php
      if ( have_posts() ) :
          while ( have_posts() ) : the_post();
        ?>
              <div class="mp-case-studies-card">
                  <div class="mp-case-studies-thumbnail">
                     <?php if ( has_post_thumbnail() ) : ?>
                          <img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>" alt="<?php echo get_the_title(); ?>">
                      <?php endif; ?>
                  </div>
                  <div class="mp-case-studies-content-wrapper">
                      <h3 class="mp-case-studies-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					  
					  
                     <?php 
    $content = get_the_content();
    $excerpt = get_the_excerpt();
    if ( !empty( $content ) || !empty( $excerpt ) ) : 
        $text = $content ? $content : $excerpt;
        $text = wp_strip_all_tags( $text ); // Remove HTML and tags
        $trimmed_text = mb_substr($text, 0, 125); // Trim after 125 characters
        if (mb_strlen($text) > 125) {
            $trimmed_text .= '...'; // Add ellipsis if trimmed
        }
        ?>
        <div class="description-wrapper">
            <p><?php echo $trimmed_text; ?></p>
        </div>
    <?php endif; ?>

                      <div class="button-wrapper text-link arrow-btn read-more">
                          <a class="elementor-cta__button elementor-button elementor-size-" href="<?php the_permalink(); ?>">
                              Read Case Study
                          <span class="last"></span></a>
                      </div>
                  </div>
              </div>
          <?php endwhile;
          wp_reset_postdata();
      else : ?>
           <div class="search-noresults">
              <h4><?php _e( "We're sorry but there are no case study found...", 'text-domain' ); ?></h4>
          </div>
      <?php endif; ?>
  </div>
</div>

<?php
// Here is the Query for get the posts from case-studies and exclude the latest three
<?php
// Ensure WordPress functions are available
if ( ! function_exists( 'get_posts' ) ) {
    return [];
}

// Get the IDs of the latest 3 featured case studies
$args_featured = [
    'post_type'      => 'case-studies',
    'post_status'    => 'publish',
    'meta_query'     => [
        [
            'key'     => 'feature_case_study',
            'value'   => 'featured',
            'compare' => 'LIKE',
        ],
    ],
    'posts_per_page' => 3,  // Get only the latest 3 featured posts
    'orderby'        => 'date',
    'order'          => 'DESC',
    'fields'         => 'ids', // Get only the post IDs
];

// Fetch posts
$latest_featured_posts = get_posts( $args_featured );
$excluded_ids = ! empty( $latest_featured_posts ) ? $latest_featured_posts : []; // Ensure it's an array

// Your main query to display case studies excluding the latest 3 featured
return [
    "post_type"      => "case-studies",
    "post_status"    => "publish",
    "posts_per_page" => 9,
    "post__not_in"   => $excluded_ids, // Only exclude the latest 3 featured posts
];
?>
