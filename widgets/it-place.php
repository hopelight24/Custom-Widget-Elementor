<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * 	It_City_Widget
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class IT_Place_Widget extends \Elementor\Widget_Base {

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
		return 'it-place';
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
		return __( 'IT Place', 'custom-widget-elementor' );
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
		return 'eicon-post-list';
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
			'it_place_query',
			[
				'label' => __( 'Place Query', 'custom-widget-elementor' ),
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
			'it_tag_name',
			[
				'label' => __( 'Tag Name', 'custom-widget-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'tag name1, tag name2',
			],
			
		);
        $this->add_control(
            'it_dynamic_tag',
            [
                'label' => esc_html__( 'Dynamic Tag', 'custom-widget-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'custom-widget-elementor' ),
                'label_off' => esc_html__( 'No', 'custom-widget-elementor' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );		
		// Posts Per Page
		$this->add_control(
			'it_place_count',
			[
				'label' => __( 'Total Place Show', 'custom-widget-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 4,
			],

		);

        $this->add_control(
            'it_near_place',
            [
                'label' => esc_html__( 'Near Places', 'custom-widget-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'custom-widget-elementor' ),
                'label_off' => esc_html__( 'No', 'custom-widget-elementor' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        $this->add_control(
            'it_more_place',
            [
                'label' => esc_html__( 'More Places', 'custom-widget-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'custom-widget-elementor' ),
                'label_off' => esc_html__( 'No', 'custom-widget-elementor' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        $this->add_control(
            'it_pagination',
            [
                'label' => esc_html__( 'Pagination', 'custom-widget-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'custom-widget-elementor' ),
                'label_off' => esc_html__( 'No', 'custom-widget-elementor' ),
                'return_value' => 'yes',
                'default' => 'no',
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
        $it_place_count = $settings['it_place_count'];
		$it_place_tag = $settings['it_tag_name'];
		
		

       // $operator_valu = 'NOTIN';


    ?>
<div class="it-post-card">
	<?php 
		global $post;
		if( has_term('', 'city_name') ){
		 $city_name_terms = get_the_terms($post->ID, 'city_name');
		}
   
        if ( !empty($city_name_terms) ) {
            foreach ($city_name_terms as $city_name_term) {
                $city_terms_value = $city_name_term->name;
            }
        }
		
	 // Tax Query
    $tax_query = array( 'relation' => 'OR' );
    if ( 'yes' === $settings['it_near_place'] ) {
        $tax_query[] = array(
            'taxonomy' => 'city_name',
            'field' => 'slug',
            'terms' => [$city_terms_value],
            'operator' => 'IN',
        );
    }
    if ( 'yes' === $settings['it_more_place'] ) {
        $tax_query[] = array(
            'taxonomy' => 'city_name',
            'field' => 'slug',
            'terms' => [$city_terms_value],
            'operator' => 'NOT IN',
        );
    }	
		
    // Post Query
    	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		if ( 'yes' === $settings['it_dynamic_tag'] ) {
			if ( empty($it_place_tag) ) {
				if ( is_tag() ) {
					$tag = get_queried_object();
					$it_place_tag = $tag->slug;
				}
		}
		}

        $args = array(
            'post_type' => 'place',
            'posts_per_page' => $it_place_count,
            'post_status' => 'publish',
            'post__not_in' => array(get_the_ID()),
			'tag' => $it_place_tag,
			'tax_query' => $tax_query,
			'paged' => $paged
			
        );
		
		$place_query = new WP_Query( $args );
		
		if( $place_query->have_posts() ) :
			while( $place_query->have_posts() ) : $place_query->the_post(); ?>
	
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

             <span class="it-city state-tag"> 
				 <?php
					$city_names = get_the_terms($post->ID, 'city_name');
					if ($city_names) {
						foreach ($city_names as $city_name) {
							echo $city_name->name;
						}
					}
				 ?>
			</span>
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
			endwhile;
		
			else : _e( 'Sorry, no city matched your criteria.', 'custom-widget-elementor' );
			endif; 
		wp_reset_postdata();
	?>
</div>
<?php 
// Pagination
	if ( 'yes' === $settings['it_pagination']) { ?>
		<div class="pagination">
			<div class="paginate-links">
    <?php 
        echo paginate_links( array(
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'total'        => $place_query->max_num_pages,
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'format'       => '?paged=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 2,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => sprintf( '<i></i> %1$s', __( 'Prev', 'inovate-elementor' ) ),
            'next_text'    => sprintf( '%1$s <i></i>', __( 'Next', 'inovate-elementor' ) ),
            'add_args'     => false,
            'add_fragment' => '',
        ) );
    ?>
			</div>			
</div>

	<?php };
?>


<?php
	}

}