<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * 	Place_Accordion_Widget
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Author_Box_Widget extends \Elementor\Widget_Base {

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
		return 'Author Box';
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
		return __( 'Author Box', 'custom-widget-elementor' );
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
			'content_section',
			[
				'label' => __( 'Content', 'custom-widget-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        // Author name
		$this->add_control(
			'it_author_name',
			[
				'label' => __( 'Author Name', 'custom-widget-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Author Name', 'custom-widget-elementor' ),
                'dynamic' => [
					'active' => true,
				],
                'label_block' => true,
				'placeholder' => __( 'Write Author Name', 'custom-widget-elementor' ),
			],
			
        );
        // Author designation
		$this->add_control(
			'it_author_designation',
			[
				'label' => __( 'Author Designation', 'custom-widget-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Author', 'custom-widget-elementor' ),
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Write Author Designation', 'custom-widget-elementor' ),
			]
        );
		
		// Author image
		$this->add_control(
			'it_author_img',
			[
				'label' => esc_html__( 'Author Image', 'custom-widget-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],

			]
		);
        $this->end_controls_section();

		$this->start_controls_section(
			'social_section',
			[
				'label' => __( 'Social Link', 'custom-widget-elementor' ),
			]
		);
		// Facebook Link
		$this->add_control(
			'facebook_link',
			[
				'label' => esc_html__( 'Facebook Link', 'custom-widget-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		// Instagram Link
		$this->add_control(
			'instagram_link',
			[
				'label' => esc_html__( 'Instagram Link', 'custom-widget-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		// Linkedin Link
		$this->add_control(
			'linkedin_link',
			[
				'label' => esc_html__( 'Linkedin Link', 'custom-widget-elementor' ),
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
        $it_author_name = $settings['it_author_name'];
        $it_author_designation = $settings['it_author_designation'];
        $it_author_img = $settings['it_author_img']['url'];
        $it_author_facebook = $settings['facebook_link']['url'];
        $it_author_instagram = $settings['instagram_link']['url'];
        $it_author_linkedin = $settings['linkedin_link']['url'];


    ?>

<?php 

	$teamID = get_field( 'by_author' );
	

?>
<div class="place-author-card">
    <div class="place-author-img">
        <img src="
		<?php 
			if(get_field('by_author') && empty($it_author_img)){
				the_field('team_profile', $teamID);
			}else {
				echo $it_author_img;
			}
		?>
		">
    </div>
    <div class="place-author-content">
        <div>
            <h3 class="author-name">
                <?php 

					if(get_field('by_author') && empty($it_author_name)){
						the_field('team_name', $teamID);
					}else {
						echo $it_author_name;
					}
				?>
            </h3>
            <p class="place-mb">
                <?php 
					if(get_field('by_author') && empty($it_author_designation)){
						the_field('team_designation', $teamID);
					}else {
						echo $it_author_designation;
					}
				?>
            </p>
        </div>
        <ul class="place-author-social">
            <li>
                <a href="
				<?php 
					if(get_field('by_author') && empty($it_author_facebook)){
						the_field('team_facebook', $teamID);
					}else {
						echo $it_author_facebook;
					}
				?>
				">
                    <img src="<?php echo plugin_dir_url( dirname(__FILE__) ) . 'assets/icons/facebook.png' ?>">
                </a>
            </li>
            <li>
                <a href="
				<?php 
					if(get_field('by_author') && empty($it_author_instagram)){
						the_field('team_instagram', $teamID);
					}else {
						echo $it_author_instagram;
					}
				?>
				">
                    <img src="<?php echo plugin_dir_url( dirname(__FILE__) ) . 'assets/icons/instagram.png' ?>">
                </a>
            </li>
            <li>
                <a href="
				<?php 
					if(get_field('by_author') && empty($it_author_linkedin)){
						the_field('team_linkedin', $teamID);
					}else {
						echo $it_author_linkedin;
					}
				?>
				">
                    <img src="<?php echo plugin_dir_url( dirname(__FILE__) ) . 'assets/icons/linkedin.png' ?>">
                </a>
            </li>
        </ul>
    </div>
</div>
<?php
	}

}