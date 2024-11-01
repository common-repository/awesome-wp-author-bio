<?php
namespace JLTAUTHORBIO\Libs;

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Assets' ) ) {

	/**
	 * Assets Class
	 *
	 * Jewel Theme <support@jeweltheme.com>
	 * @version     1.0.5
	 */
	class Assets {

		/**
		 * Constructor method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'jltauthorbio_enqueue_scripts' ), 100 );
			add_action( 'admin_enqueue_scripts', array( $this, 'jltauthorbio_admin_enqueue_scripts' ), 100 );
			add_action( 'wp_head', array( $this, 'jltauthorbio_custom_style' ) );
		}


		
		public function jltauthorbio_custom_style() { ?>
			<style type="text/css">	
				.resp-tabs-list li, h2.resp-accordion{
					background: <?php echo jltauthorbio_options( 'tabbed-color', 'jeweltheme_wp_style', '#56AAA6');?>;
				}

				h2.resp-accordion{
					
					background: <?php echo jltauthorbio_options( 'tabbed-color', 'jeweltheme_wp_style', '#56AAA6');?> !important;
				}

				.jeweltheme-wp-author-name a {
					color:<?php echo jltauthorbio_options( 'name-color', 'jeweltheme_wp_style', '#fff' );?>;
				}
				
				.jltauthorbio{
					background:<?php echo jltauthorbio_options( 'background-color', 'jeweltheme_wp_style', '#DDDDDD' );?>;
				}
			</style>
		<?php
		}


		/**
		 * Get environment mode
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function get_mode() {
			return defined( 'WP_DEBUG' ) && WP_DEBUG ? 'development' : 'production';
		}

		/**
		 * Enqueue Scripts
		 *
		 * @method wp_enqueue_scripts()
		 */
		public function jltauthorbio_enqueue_scripts() {

			// CSS Files .
			wp_enqueue_style( 'awesome-wp-author-bio-frontend', JLTAUTHORBIO_ASSETS . 'css/awesome-wp-author-bio-frontend.css', JLTAUTHORBIO_VER, 'all' );
			wp_enqueue_style( 'font-awesome', JLTAUTHORBIO_ASSETS . 'css/font-awesome.min.css', JLTAUTHORBIO_VER, 'all' );


			// JS Files .
			wp_enqueue_script( 'awesome-wp-author-responsive-tabs', JLTAUTHORBIO_ASSETS . 'js/responsive-tabs.js', false, JLTAUTHORBIO_VER, true );
			wp_enqueue_script( 'awesome-wp-author-bio-frontend', JLTAUTHORBIO_ASSETS . 'js/awesome-wp-author-bio-frontend.js', array( 'jquery' ), JLTAUTHORBIO_VER, true );


		    if( is_admin() ){ ?>
		        <style type="text/css">
		        .postbox {
		            padding-left: 20px;
		        }
		        </style>
		    <?php }

		}


		/**
		 * Enqueue Scripts
		 *
		 * @method admin_enqueue_scripts()
		 */
		public function jltauthorbio_admin_enqueue_scripts() {
			// CSS Files .
			wp_enqueue_style( 'awesome-wp-author-bio-admin', JLTAUTHORBIO_ASSETS . 'css/awesome-wp-author-bio-admin.css', array( 'dashicons' ), JLTAUTHORBIO_VER, 'all' );

			// JS Files .
	        wp_enqueue_style( 'wp-color-picker' );
	        wp_enqueue_script( 'wp-color-picker' );
	        wp_enqueue_script( 'media-upload' );
	        wp_enqueue_script( 'thickbox' );			
			wp_enqueue_script( 'awesome-wp-author-bio-admin', JLTAUTHORBIO_ASSETS . 'js/awesome-wp-author-bio-admin.js', array( 'jquery' ), JLTAUTHORBIO_VER, true );
			wp_localize_script(
				'awesome-wp-author-bio-admin',
				'JLTAUTHORBIOCORE',
				array(
					'admin_ajax'        => admin_url( 'admin-ajax.php' ),
					'recommended_nonce' => wp_create_nonce( 'jltauthorbio_recommended_nonce' ),
				)
			);

			$custom_css = ".metabox-holder .postbox{
	            padding: 10px !important;
	        }";
			wp_add_inline_style( 'custom-style', $custom_css );
		}
	}
}