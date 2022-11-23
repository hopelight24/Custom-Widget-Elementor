<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * 	It_Post_Widget
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class IT_Posts_Widget_Two extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve About widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'it-posts2';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve About widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'IT Posts Two', 'custom-widget-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve About widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-adjust';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the About widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'custom-widget-category' ];
	}

	/**
	 * Register About widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'it_post_query',
			[
				'label' => __( 'Post Query', 'custom-widget-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        /**
         *  ======================
         *      POST QUERY CONTROLS
         * ======================
         */

         // Post type
        $this->add_control(
			'it_post_type',
			[
				'label' => esc_html__( 'Post Type', 'custom-widget-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'Post',
				'options' => [
					'Post'  => esc_html__( 'Posts', 'custom-widget-elementor' ),
					'Place'  => esc_html__( 'Places', 'custom-widget-elementor' ),
                    'City'  => esc_html__( 'Cities', 'custom-widget-elementor' ),
                    'State'  => esc_html__( 'States', 'custom-widget-elementor' ),
				],
			]
		);
		
		// Posts Per Page
		$this->add_control(
			'it_posts_count',
			[
				'label' => __( 'Posts Per Page', 'custom-widget-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 4,
			],

		);
		$this->add_control(
			'it_postsby_tags',
			[
				'label' => esc_html__( 'Tags Name', 'custom-widget-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Tag-one, Tag-two, Tag-three', 'custom-widget-elementor' ),
			]
		);		

        $this->end_controls_section();


	}

	/**
	 * Render About widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

        $settings = $this->get_settings_for_display();
        $it_post_type = $settings['it_post_type'];
        $it_posts_count = $settings['it_posts_count'];
		$it_postsby_tags = $settings['it_postsby_tags'];

    ?>
<div class="it-post-card">
    <?php
		global $post;
		//$page_slug = get_post_field( 'post_name', get_the_ID() );
		
        $city_name_terms = get_the_terms($post->ID, 'city_name');
        if ($city_name_terms) {
            foreach ($city_name_terms as $city_name_term) {
                $city_terms_value = $city_name_term->name;
            }
        }

    // Post Query
        $args = array(
            'post_type' => $it_post_type,
            'posts_per_page' => $it_posts_count,
            'post_status' => 'publish',
            'post__not_in' => array(get_the_ID()),
			'tag' => $it_postsby_tags,

        );

        // Variable to call WP_Query.
        $the_query = new WP_Query( $args );

        if ( $the_query->have_posts() ) :
            // Start the Loop
            while ( $the_query->have_posts() ) : $the_query->the_post();
            ?>
    <div class="it-card-item">
        <div class="it-card-img">
            <a href="<?php the_permalink(); ?>">
                <?php if ( has_post_thumbnail() ) { the_post_thumbnail();}
					else { echo '<img src="https://source.unsplash.com/300x200" />';} 
				?>
            </a>
        </div>
        <div class="it-card-content">
            <a href="<?php the_permalink(); ?>">
                <h3><?php the_title(); ?></h3>
            </a>

            <?php if(!empty($city_terms_value)) : ?>
                <span class="it-city">
                    <?php
                    $city_names = get_the_terms($post->ID, 'city_name');
                    if ($city_names) {
                        foreach ($city_names as $city_name) {
                            echo $city_name->name;
                        }
                    }
                    ?>
                </span>
            <?php endif; ?>
            <?php
                if ( get_field( 'review', $post->ID)) {
                    ?>
                    <div class="it-review">
                <span class="it-icon">
                    <?php
                    $starNumber = get_field('review', $post->ID);
                    for( $x = 0; $x < 5; $x++ )
                    {
                        if( floor( $starNumber )-$x >= 1 )
                        { echo '<li><i class="fa fa-star star-icon"></i></li>'; }
                        elseif( $starNumber-$x > 0 )
                        { echo '<li><i class="fa fa-star-half-alt star-icon"></i></li>'; }
                        else
                        { echo '<li><i class="fa fa-star-o"></i></li>'; }
                    }
                    ?>
                </span>
                        <span class="it-number"><?php the_field('review', $post->ID); ?></span>
                    </div>

                    <?php
                }
            ?>


        </div>
    </div> <!-- single item  -->
    <?php
            // End the Loop
            endwhile;
	
        else:
        // If no posts match this query, output this text.
            _e( 'Sorry, no posts matched your criteria.', 'custom-widget-elementor' );
		

        endif;

        wp_reset_postdata();
        ?>
</div>


<?php
	}

}