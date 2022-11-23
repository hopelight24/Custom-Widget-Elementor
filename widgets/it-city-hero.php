<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * 	City Hero Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class City_Hero_Widget extends \Elementor\Widget_Base {

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
		return 'city-hero';
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
		return esc_html__( 'City Hero', 'custom-widget-elementor' );
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

		// City Name, info and image controls section
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'custom-widget-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        //  Post title
		$this->add_control(
			'hero_city_name',
			[
				'label' => __( 'Post Title', 'custom-widget-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'The title', 'custom-widget-elementor' ),
                'dynamic' => [
					'active' => true,
				],
                'label_block' => true,
				'placeholder' => __( 'Write Title Here', 'custom-widget-elementor' ),
			],
			
        );
		// Featured Image
		$this->add_control(
			'hero_city_featured',
			[
				'label' => esc_html__( 'Featured Image', 'custom-widget-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],

			]
		);
        // Short Info
		$this->add_control(
			'hero_city_info',
			[
				'label' => __( 'Content', 'custom-widget-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Short desciption will be here', 'custom-widget-elementor' ),
                'label_block' => true,
                'separator'=> 'before',
				'placeholder' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', 'inovate-elementor' ),
			]
        );
        $this->end_controls_section();


		// City Contact info Control Section
		$this->start_controls_section(
			'contact_link', 
			[
				'label' => __('Contact Link', 'custom-widget-elementor'),
			]
		);
				// Google Map URL
				$this->add_control(
					'city_map_link',
					[
						'label' => esc_html__( 'Google Maps', 'custom-widget-elementor' ),
						'type' => \Elementor\Controls_Manager::URL,
						'dynamic' => [
							'active' => true,
						],
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
        $hero_city_name = $settings['hero_city_name'];
        $hero_city_info = $settings['hero_city_info'];
        $hero_city_featured = $settings['hero_city_featured']['url'];
        $city_map_link = $settings['city_map_link']['url'];

		
    ?>
<div class="inovate-container">
    <div class="inovate-column">
        <div class="place-wrapper city-wrapper">
			<div class="heading-wrapper">
				<div class="inovate-heading place-mb">
					<h1><?php echo $hero_city_name; ?></h1>
				</div>
			</div>			
			<div class="city-sub">
			<div class="place-info">
                <div class="short-info-wrapper place-mb">
                    <div class="place-info">
                        <?php echo $hero_city_info; ?>
                    </div>
                </div>
            </div>
            <div class="place-contact-wrapper">
				<div class="city-map">
				<span>
                    <a href="<?php if( !empty($city_map_link) ) { echo $city_map_link; } ?>">Google Map</a>
                </span>
				</div>
            </div>
			</div>
        </div>
    </div>
    <div class="inovate-column">
        <div class="img-wrapper">
            <img class="inovate-img" src="<?php echo $hero_city_featured; ?>">
        </div>
    </div>
</div>
<?php
	}


}