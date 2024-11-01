<?php
namespace JLTAUTHORBIO\Inc\Admin;

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @version 1.0.5
 * @package awesome-wp-author-bio
 */
if ( ! class_exists( 'AdminSettings' ) ) {
	/**
	 * Admin Settings Class
	 */
	class AdminSettings {


		private static $settings_api = null;

		/**
		 * Adminsettings Construct method
		 */
		public function __construct() {
			add_action( 'admin_init', array( $this, 'settings_fields' ) );
			add_action( 'admin_menu', array( $this, 'settings_menu' ) );
		}

		/**
		 * Register Main Menu.
		 *
		 * @return void
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function settings_menu() {
			add_menu_page(
				__( 'WP Author Bio Settings', 'awesome-wp-author-bio' ),
				__( 'Author Bio', 'awesome-wp-author-bio' ),
				'manage_options',
				'wp-author-bio' . '-settings',
				array( $this, 'settings_page' ),
				'dashicons-admin-generic',
				40
			);

			add_submenu_page(
				'wp-author-bio-settings',
				__( 'Author Bio Settings', 'awesome-wp-author-bio' ),
				__( 'Settings', 'awesome-wp-author-bio' ),
				'manage_options',
				'wp-author-bio-settings',
				array( $this, 'settings_page' ),
				10
			);
		}

		/**
		 * Returns all the settings fields
		 *
		 * @return void
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function settings_fields() {
	        $sections = array(
	            array(
	                'id' => 'jeweltheme_wp_general',
	                'title' => __( 'General', 'awesome-wp-author-bio' )
	            ),

	            array(
	                'id' => 'jeweltheme_wp_style',
	                'title' => __( 'Style', 'awesome-wp-author-bio' )
	            ),            
	            array(
	                'id' => 'jeweltheme_wp_recent',
	                'title' => __( 'Recent Posts', 'awesome-wp-author-bio' )
	            ),

	            array(
	                'id' => 'jeweltheme_wp_comments',
	                'title' => __( 'Comments', 'awesome-wp-author-bio' )
	            )
	        );	
	        

			$settings_fields = array(
            	'jeweltheme_wp_general' => array(
	                array(
	                    'name' => 'show-post-page',
	                    'label' => __( 'Author Bio Shows in', 'awesome-wp-author-bio' ),
	                    'desc' => __( 'Choose where to show Post/Page or Both?', 'awesome-wp-author-bio' ),
	                    'type' => 'select',
	                    'default' => 'post',
	                    'options' => array(
	                        'post' => 'Post',
	                        'page' => 'Page',
	                        'both' => 'Both'
	                    )
	                ),

	                array(
	                    'name' => 'avatar-size',
	                    'label' => __( 'Avatar Size', 'awesome-wp-author-bio' ),
	                    'desc' => __( 'px', 'awesome-wp-author-bio' ),
	                    'type' => 'text',
	                    'default' => '100',
	                    'sanitize_callback' => 'intval'
	                ),
	            ),


	            /* Styles */
	            'jeweltheme_wp_style' => array(
	                array(
	                    'name' => 'background-color',
	                    'label' => __( 'Background Color', 'awesome-wp-author-bio' ),
	                    'desc' => __( 'Select Background Color. Default: #DDDDDD', 'awesome-wp-author-bio' ),
	                    'default' => '#DDDDDD',
	                    'type' => 'color'
	                ),  

	                array(
	                    'name' => 'tabbed-color',
	                    'label' => __( 'Tabs Background Color', 'awesome-wp-author-bio' ),
	                    'desc' => __( 'Select Tabs Background Color. Default: #56AAA6', 'awesome-wp-author-bio' ),
	                    'default' => '#56AAA6',
	                    'type' => 'color'
	                )
	            ),


	            /* Author's Recent Post*/
	            'jeweltheme_wp_recent' => array(

	                array(
	                    'name' => 'post-title-length',
	                    'label' => __( 'Post Title Length', 'awesome-wp-author-bio' ),
	                    'desc' => __( 'Characters', 'awesome-wp-author-bio' ),
	                    'type' => 'text',
	                    'default' => '35',
	                    'sanitize_callback' => 'intval'
	                ),
	                
	                array(
	                    'name' => 'post-limit',
	                    'label' => __( 'Show Posts', 'awesome-wp-author-bio' ),
	                    'desc' => __( 'Posts shows in Author Recent Post tab.', 'awesome-wp-author-bio' ),
	                    'type' => 'select',
	                    'default' => 3,
	                    'options' => array(
	                        '1' => '1',
	                        '2' => '2',
	                        '3' => '3',
	                        '4' => '4',
	                        '5' => '5',
	                        '6' => '6',
	                        '7' => '7',
	                        '8' => '8',
	                        '9' => '9',
	                        '10' => '10'
	                    )
	                ),

	                array(
	                    'name' => 'recent-show-comments',
	                    'label' => __( 'Show Comments', 'awesome-wp-author-bio' ),
	                    'desc' => __( 'Show Comments in Author Recent Section.', 'awesome-wp-author-bio' ),
	                    'type' => 'select',
	                    'default' => 'yes',
	                    'options' => array(
	                        'yes' => 'Yes',
	                        'no' => 'No'
	                    )
	                ),

	            ),


	            /* Author's Recent Comments Tab */
	            'jeweltheme_wp_comments' => array(
	               
	                array(
	                    'name' => 'comment-title-length',
	                    'label' => __( 'Comment Title Length', 'awesome-wp-author-bio' ),
	                    'desc' => __( 'Characters', 'awesome-wp-author-bio' ),
	                    'type' => 'text',
	                    'default' => '20',
	                    'sanitize_callback' => 'intval'
	                ),
	                
	                array(
	                    'name' => 'comment-post-limit',
	                    'label' => __( 'Number of Comments', 'awesome-wp-author-bio' ),
	                    'desc' => __( 'Comment Shows in Author Comment Post tab.', 'awesome-wp-author-bio' ),
	                    'type' => 'select',
	                    'default' => '3',
	                    'options' => array(
	                        '1' => '1',
	                        '2' => '2',
	                        '3' => '3',
	                        '4' => '4',
	                        '5' => '5',
	                        '6' => '6',
	                        '7' => '7',
	                        '8' => '8',
	                        '9' => '9',
	                        '10' => '10'
	                    )
	                ),
	            )

			);

			self::$settings_api = new Settings_API();

			/*
			 * set the settings.
			 */
			self::$settings_api->set_sections( $sections );
			self::$settings_api->set_fields( $settings_fields );

			/*
			 * initialize settings
			 */
			self::$settings_api->admin_init();
		}

		/**
		 * Settings page
		 *
		 * @return void
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function settings_page() {                            ?>

			<div class="wrap jltauthorbio-settings-page">
				<h2 style="display: flex;"><?php esc_html_e( 'Author Bio Settings', 'awesome-wp-author-bio' ); ?>
					<span id="changelog_badge"></span>
				</h2>
				<?php self::$settings_api->show_settings(); ?>
			</div>
			<?php
		}

		/**
		 * Get all the pages
		 *
		 * @return array page names with key value pairs
		 */
		public function get_pages() {
			$pages         = get_pages();
			$pages_options = array();

			if ( $pages ) {
				foreach ( $pages as $page ) {
					$pages_options[ $page->ID ] = $page->post_title;
				}
			}

			return $pages_options;
		}
	}
}