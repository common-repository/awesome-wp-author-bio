<?php
namespace JLTAUTHORBIO\Inc\Classes\Notifications;

use JLTAUTHORBIO\Inc\Classes\Notifications\Base\Date;
use JLTAUTHORBIO\Libs\Helper;

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Notification Class
 *
 * Jewel Theme <support@jeweltheme.com>
 */
class Notifications {

	use Date;

	public $manager;

	public $conflict_days = 5;

	public $slug;

	/**
	 * Construction method
	 */
	public function __construct() {
		$this->manager = new Manager();

		$this->slug = Helper::jltauthorbio_slug_cleanup();

		add_action( 'admin_notices', array( $this, 'setup_notifications' ) );

		add_action( 'jltauthorbio_display_notice', array( $this, 'display_notice' ), 10, 2 );
		add_action( 'jltauthorbio_display_popup', array( $this, 'display_popup' ), 10, 2 );

		add_action( 'wp_ajax_jltauthorbio_notification_action', array( $this, 'notification_action' ) );
	}

	/**
	 * Notification Action
	 *
	 * @author Jewel Theme <support@jeweltheme.com>
	 */
	public function notification_action() {
		check_ajax_referer( 'jltauthorbio_notification_nonce' );

		$action_type       = ! empty( $_REQUEST['action_type'] ) ? sanitize_key( $_REQUEST['action_type'] ) : '';
		$notification_type = ! empty( $_REQUEST['notification_type'] ) ? sanitize_key( $_REQUEST['notification_type'] ) : '';
		$trigger_time      = ! empty( $_REQUEST['trigger_time'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['trigger_time'] ) ) : '';

		$exec_notifications = $this->manager->get_exec_notifications( $trigger_time, $notification_type );

		// No Executable Notifications found .
		if ( empty( $exec_notifications ) ) {
			die( 0 );
		}

		$count = 0;

		foreach ( $exec_notifications as $index => $notification ) {
			if ( 0 === $index ) {
				if ( 'disable' === $action_type ) {
					$notification->is_active = false;
				}
				$notification->fire( $trigger_time, $notification_type )->save();
			} else {
				$count++;
				$notification->maybe_delay( $this->date_increment( $trigger_time, $this->conflict_days * $count ) )->save();
			}
		}

		die( 0 );
	}


	/**
	 * Notification Setup
	 *
	 * @param [type] $type .
	 *
	 * @author Jewel Theme <support@jeweltheme.com>
	 */
	public function setup_notifications_by_type( $type ) {
		// $trigger_time should be today .
		$trigger_time = $this->current_time();

		// Block if necessary .
		$notification_last_fired = get_option( "jltauthorbio_{$type}_last_interact" );

		if ( $notification_last_fired ) {
			$notification_enable_date = $this->date_increment( $notification_last_fired, $this->conflict_days );

			if ( $this->date_is_prev( $trigger_time, $notification_enable_date ) ) {
				return;
			}
		}

		// Get Executable Notifications .
		$exec_notifications = $this->manager->get_exec_notifications( $trigger_time, $type );

		// No Executable Notifications found .
		if ( empty( $exec_notifications ) ) {
			return;
		}

		$notification = $exec_notifications[0];

		do_action( "jltauthorbio_display_{$type}", $notification, $trigger_time );
	}

	/**
	 * Notification setup
	 *
	 * @author Jewel Theme <support@jeweltheme.com>
	 */
	public function setup_notifications() {
		$this->setup_notifications_by_type( 'notice' );
		$this->setup_notifications_by_type( 'popup' );
	}



	/**
	 * Display notice
	 *
	 * @param [type] $notice .
	 * @param [type] $trigger_time .
	 *
	 * @return void
	 * @author Jewel Theme <support@jeweltheme.com>
	 */
	public function display_notice( $notice, $trigger_time ) {
		$notice->notice_header();
		$notice->notice_content();
		$notice->notice_footer();

		$notice->core_script( $trigger_time );
	}

	/**
	 * Display Popup
	 *
	 * @param [type] $popup .
	 * @param [type] $trigger_time .
	 *
	 * @return void
	 * @author Jewel Theme <support@jeweltheme.com>
	 */
	public function display_popup( $popup, $trigger_time ) {
		$image_url = $popup->get_content( 'image_url' );

		?>

		<div class="jltauthorbio-popup" id="jltauthorbio-popup" data-plugin="<?php echo esc_attr( $this->slug ); ?>" tabindex="1">

			<div class="jltauthorbio-popup-overlay"></div>

			<div class="jltauthorbio-popup-modal" style="background-image: url('<?php echo esc_url( $image_url ); ?>'); --jltauthorbio-popup-color: <?php echo esc_attr( $popup->get_content( 'btn_color' ) ); ?>;">

				<!-- close  -->
				<div class="jltauthorbio-popup-modal-close popup-dismiss">×</div>

				<!-- content section  -->
				<div class="jltauthorbio-popup-modal-footer">

					<!-- countdown  -->
					<div class="jltauthorbio-popup-countdown" style="display: none;">
						<span class="jltauthorbio-popup-countdown-text"><?php echo esc_html__( 'Deal Ends In', 'awesome-wp-author-bio' ); ?></span>
						<div class="jltauthorbio-popup-countdown-time">
							<div>
								<span data-counter="days">00</span>
								<span><?php echo esc_html__( 'Days', 'awesome-wp-author-bio' ); ?></span>
							</div>
							<span>:</span>
							<div>
								<span data-counter="hours">00</span>
								<span><?php echo esc_html__( 'Hours', 'awesome-wp-author-bio' ); ?></span>
							</div>
							<span>:</span>
							<div>
								<span data-counter="minutes">00</span>
								<span><?php echo esc_html__( 'Minutes', 'awesome-wp-author-bio' ); ?></span>
							</div>
							<span>:</span>
							<div>
								<span data-counter="seconds">00</span>
								<span><?php echo esc_html__( 'Seconds', 'awesome-wp-author-bio' ); ?></span>
							</div>
						</div>
					</div>

					<!-- button  -->
					<a class="jltauthorbio-popup-button" target="_blank" href="<?php echo esc_url( $popup->get_content( 'button_url' ) ); ?>"><?php echo esc_html( $popup->get_content( 'button_text' ) ); ?></a>
				</div>
			</div>
		</div>

		<script>
			function jltauthorbio_popup_action(evt, $this, $action_type) {

				evt.preventDefault();

				$this.closest('.jltauthorbio-popup').fadeOut(200);

				jQuery.post('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
					action: 'jltauthorbio_notification_action',
					_wpnonce: '<?php echo esc_js( wp_create_nonce( 'jltauthorbio_notification_nonce' ) ); ?>',
					action_type: $action_type,
					notification_type: 'popup',
					trigger_time: '<?php echo esc_attr( $trigger_time ); ?>'
				});
			}

			// Notice Dismiss
			jQuery('body').on('click', '.jltauthorbio-popup .popup-dismiss', function(evt) {
				jltauthorbio_popup_action(evt, jQuery(this), 'dismiss');
			});

			// Notice Disable
			jQuery('body').on('click', '.jltauthorbio-popup .popup-disable', function(evt) {
				jltauthorbio_popup_action(evt, jQuery(this), 'disable');
			});
		</script>

		<?php
	}
}