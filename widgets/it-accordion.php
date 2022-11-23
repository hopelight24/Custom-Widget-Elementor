<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * 	it_Accordion_Widget
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class IT_Accordion_Widget extends \Elementor\Widget_Base {

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
		return 'it-accordion';
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
		return __( 'IT Accordion', 'custom-widget-elementor' );
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

        // Place Accordion Title
		$this->add_control(
			'it_accordion_title',
			[
				'label' => __( 'Accordion Title', 'custom-widget-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Write the heading', 'custom-widget-elementor' ),
                'dynamic' => [
					'active' => true,
				],
                'label_block' => true,
				'placeholder' => __( 'Heading', 'custom-widget-elementor' ),
			],
			
        );

        
        // Place Accordion Description
		$this->add_control(
			'it_accordion_desc',
			[
				'label' => __( 'Description', 'custom-widget-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Write the description', 'custom-widget-elementor' ),
                'label_block' => true,
                'separator'=> 'before',
				'placeholder' => __( 'Description', 'custom-widget-elementor' ),
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
        $it_accordion_title = $settings['it_accordion_title'];
        $it_accordion_desc = $settings['it_accordion_desc'];

    ?>
<div class="accordion-item">
    <h2 class="acc-heading"><?php echo $it_accordion_title; ?></h2>
    <div class="panel">
        <?php echo $it_accordion_desc;  ?>
    </div>
</div>
<?php
	}

}