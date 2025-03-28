<?php
namespace JLTAUTHORBIO\Libs;

use JLTAUTHORBIO\JLT_Author_Bio;

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Upgrader' ) ) {
	/**
	 * Plugin Upgrader Class
	 *
	 * Jewel Theme <support@jeweltheme.com>
	 */
	class Upgrader {

		/**
		 * Plugin version option key
		 *
		 * @var string
		 */
		protected $option_name = ''; // this should be bundled plugins installed time version .

		/**
		 * Lists of upgrades
		 *
		 * @var string[]
		 */
		protected $upgrades = array();

		/**
		 * Constructor
		 */
		public function __construct() {
			$this->option_name = JLT_Author_Bio::plugin_version_key();
		}

		/**
		 * Get plugin installed version
		 *
		 * @return string
		 */
		protected function get_installed_version() {
			return get_option( $this->option_name, JLTAUTHORBIO_VER );
		}

		/**
		 * Check if plugin's update is available
		 *
		 * @return bool
		 */
		public function if_updates_available() {
			if ( version_compare( $this->get_installed_version(), JLTAUTHORBIO_VER, '<' ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Run plugin updates
		 *
		 * @return void
		 */
		public function run_updates() {
			$installed_version = $this->get_installed_version();
			$path              = trailingslashit( JLTAUTHORBIO_DIR );

			foreach ( $this->upgrades as $version => $file ) {
				if ( version_compare( $installed_version, $version, '<' ) ) {
					include $path . $file;
				}
			}
		}
	}
}