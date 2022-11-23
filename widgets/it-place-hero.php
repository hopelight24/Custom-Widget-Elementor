<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * 	Place Hero Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Place_Hero_Widget extends \Elementor\Widget_Base {

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
		return 'place-hero';
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
		return esc_html__( 'Place Hero', 'custom-widget-elementor' );
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

		// Place Name, info and image controls section
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'custom-widget-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        //  Post title
		$this->add_control(
			'place_name',
			[
				'label' => __( 'Post Title', 'custom-widget-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Place Name', 'custom-widget-elementor' ),
                'dynamic' => [
					'active' => true,
				],
                'label_block' => true,
				'placeholder' => __( 'Write Place Title Here', 'custom-widget-elementor' ),
			],
			
        );
		// Featured Image
		$this->add_control(
			'place_featured',
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
			'place_info',
			[
				'label' => __( 'Content', 'custom-widget-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Short desciption will be here', 'custom-widget-elementor' ),
                'label_block' => true,
                'separator'=> 'before',
				'placeholder' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', 'custom-widget-elementor' ),
			]
        );
        $this->end_controls_section();


		// Place Contact info Control Section
		$this->start_controls_section(
			'contact_link', 
			[
				'label' => __('Contact Link', 'custom-widget-elementor'),
			]
		);
				// Google Map URL
				$this->add_control(
					'map_link',
					[
						'label' => esc_html__( 'Google Maps', 'custom-widget-elementor' ),
						'type' => \Elementor\Controls_Manager::URL,
						'dynamic' => [
							'active' => true,
						],
					]
				);
				// Phone Number
				$this->add_control(
					'phone_number',
					[
						'label' => esc_html__( 'Phone Number', 'custom-widget-elementor' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'label_block' => true,
						'dynamic' => [
							'active' => true,
						],
					]
				);
				// Website URL
				$this->add_control(
					'website_link',
					[
						'label' => esc_html__( 'Website Address', 'custom-widget-elementor' ),
						'type' => \Elementor\Controls_Manager::URL,
						'dynamic' => [
							'active' => true,
						],
					]
				);
				// No Contact 
				$this->add_control(
					'no_contact_link',
					[
						'label' => esc_html__( 'Popup', 'custom-widget-elementor' ),
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
        $place_name = $settings['place_name'];
        $place_info = $settings['place_info'];
        $place_featured = $settings['place_featured']['url'];
        $map_link = $settings['map_link']['url'];
        $phone_number = $settings['phone_number'];
        $website_link = $settings['website_link']['url'];
		$noContact_link = $settings['no_contact_link']['url'];


		
    ?>
<div class="inovate-container">
    <div class="inovate-column">
        <div class="place-wrapper">
			<div class="heading-wrapper">
				<div class="inovate-heading place-mb">
					<h1><?php echo $place_name; ?></h1>
				</div>
			</div>			
			<div class="place-sub">
			<div class="place-info">
                <div class="rating-wrapper place-mb">
                    <div class="it-review">
                        <span class="it-icon">
                            <?php 
					$starNumber = get_field('review', get_the_ID());
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
                        <span class="it-number"><?php the_field('review', get_the_ID()); ?></span>
                    </div>
                </div>
                <div class="short-info-wrapper place-mb">
                    <div class="place-info">
                        <?php echo $place_info; ?>
                    </div>
                </div>
            </div>
            <div class="place-contact-wrapper">
                <span>
                    <a href="<?php if( !empty($map_link) ) { echo $map_link; } else { echo $noContact_link; } ?>">
<img src="<?php echo plugin_dir_url( dirname(__FILE__) ) . 'assets/icons/maps-icon.png' ?>"></a>
                </span>
                <span>
					<?php if(empty($phone_number)) {
						?>
						<div class="it-popover">
						<span class="qs"><img src="<?php echo plugin_dir_url( dirname(__FILE__) ) . 'assets/icons/call-icon.png' ?>"><span class="popover above">Phone number not available</span>
						</span>
					</div>
					<?php
					}else {
					  ?>
					<a href="tel:+91<?php echo $phone_number; ?>">
					<img src="<?php echo plugin_dir_url( dirname(__FILE__) ) . 'assets/icons/call-icon.png' ?>">
					</a>
					<?php
					}
					
					?>
                </span>
                <span>
					<?php if(empty($website_link)) {
						?>
						<div class="it-popover">
						<span class="qs"><img src="<?php echo plugin_dir_url( dirname(__FILE__) ) . 'assets/icons/website-icon.png' ?>"><span class="popover above">Website not available</span>
						</span>
					</div>
					<?php
					}else {
					  ?>
					<a href="<?php echo $website_link; ?>">
					<img src="<?php echo plugin_dir_url( dirname(__FILE__) ) . 'assets/icons/website-icon.png' ?>">
					</a>
					<?php
					}
					
					?>
                </span>

            </div>
			</div>
        </div>
    </div>
    <div class="inovate-column">
        <div class="img-wrapper">
            <img class="inovate-img" src="<?php echo $place_featured; ?>">
        </div>
    </div>
</div>
<?php
	}
	/**
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
<# var getRating=function() { var ratingScale=parseInt( settings.rating_scale, 10 ), rating=settings.rating> ratingScale
    ? ratingScale : settings.rating;

    return [ rating, ratingScale ];
    },
    ratingData = getRating(),
    rating = ratingData[0],
    textualRating = ratingData[0] + '/' + ratingData[1],
    renderStars = function( icon ) {
    var starsHtml = '',
    flooredRating = Math.floor( rating );

    for ( var stars = 1; stars <= ratingData[1]; stars++ ) { if ( stars <=flooredRating ) { starsHtml
        +='<i class="elementor-star-full">' + icon + '</i>' ; } else if ( flooredRating + 1===stars && rating
        !==flooredRating ) { starsHtml +='<i class="elementor-star-' + ( rating - flooredRating ).toFixed( 1 ) * 10
        + '">' + icon + '</i>' ; } else { starsHtml +='<i class="elementor-star-empty">' + icon + '</i>' ; } } return
        starsHtml; }, icon='&#xE934;' ; if ( 'star_fontawesome'===settings.star_style ) { if
        ( 'outline'===settings.unmarked_star_style ) { icon='&#xE933;' ; } } else if
        ( 'star_unicode'===settings.star_style ) { icon='&#9733;' ; if ( 'outline'===settings.unmarked_star_style ) {
        icon='&#9734;' ; } } view.addRenderAttribute( 'iconWrapper' , 'class' , 'elementor-star-rating' );
        view.addRenderAttribute( 'iconWrapper' , 'itemtype' , 'http://schema.org/Rating' );
        view.addRenderAttribute( 'iconWrapper' , 'title' , textualRating ); view.addRenderAttribute( 'iconWrapper'
        , 'itemscope' , '' ); view.addRenderAttribute( 'iconWrapper' , 'itemprop' , 'reviewRating' ); var
        stars=renderStars( icon ); #>

        <div class="elementor-star-rating__wrapper">
            <# if ( ! _.isEmpty( settings.title ) ) { #>
                <div class="elementor-star-rating__title">{{ settings.title }}</div>
                <# } #>
                    <div {{{ view.getRenderAttributeString( 'iconWrapper' ) }}}>
                        {{{ stars }}}
                        <span itemprop="ratingValue" class="elementor-screen-only">{{ textualRating }}</span>
                    </div>
        </div>

        <?php
	}

}