<?php
namespace JLTAUTHORBIO;

use JLTAUTHORBIO\Libs\Assets;
use JLTAUTHORBIO\Libs\Helper;
use JLTAUTHORBIO\Libs\Featured;
use JLTAUTHORBIO\Inc\Classes\Recommended_Plugins;
use JLTAUTHORBIO\Inc\Classes\Notifications\Notifications;
use JLTAUTHORBIO\Inc\Classes\Pro_Upgrade;
use JLTAUTHORBIO\Inc\Classes\Row_Links;
use JLTAUTHORBIO\Inc\Classes\Upgrade_Plugin;
use JLTAUTHORBIO\Inc\Admin\AdminSettings;
use JLTAUTHORBIO\Inc\Classes\Feedback;

/**
 * Main Class
 *
 * @awesome-wp-author-bio
 * Jewel Theme <support@jeweltheme.com>
 * @version     1.0.5
 */

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * JLT_Author_Bio Class
 */
if ( ! class_exists( '\JLTAUTHORBIO\JLT_Author_Bio' ) ) {

	/**
	 * Class: JLT_Author_Bio
	 */
	final class JLT_Author_Bio {

		const VERSION            = JLTAUTHORBIO_VER;
		private static $instance = null;

		/**
		 * what we collect construct method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			$this->includes();
			add_action( 'plugins_loaded', array( $this, 'jltauthorbio_plugins_loaded' ), 999 );
			// Body Class.
			add_filter( 'admin_body_class', array( $this, 'jltauthorbio_body_class' ) );
			// This should run earlier .
			// add_action( 'plugins_loaded', [ $this, 'jltauthorbio_maybe_run_upgrades' ], -100 ); .

			add_filter( 'the_content', array( $this, 'jltauthorbio_authorbio_display' ), 10, 3 );

		}



		/**
		* Front-End Author Bio Display 
		*/
		function jltauthorbio_authorbio_display( $content ) {

		    $jltauthorbio_show_bio = jltauthorbio_options( 'show-post-page', 'jeweltheme_wp_general' );

		    if ( (($jltauthorbio_show_bio == "post") and is_single()) or (($jltauthorbio_show_bio == "page") and is_page()) or (($jltauthorbio_show_bio=="both") and (is_single() or is_page()))  ) {  

		    ob_start();

		?>
		    <div class="jltauthorbio">

		        <div class="jltauthorbio-maindiv">

		            <div class="jeweltheme-wp-author-image-area">

		                <div class="jeweltheme-wp-author-image">

		                    <?php echo get_avatar( get_the_author_meta( 'ID' ), jltauthorbio_options( 'avatar-size', 'jeweltheme_wp_general' ) ); ?>
		                    
		                </div> <!-- /.jeweltheme-wp-author-image -->                

		                <div class="jeweltheme-wp-author-name">

		                     <?php the_author_posts_link( );?>   

		                </div>

		            </div><!-- .jeweltheme-wp-author-image-area -->


		            <div class="jeweltheme-wp-author-other">

		                 <div id="jeweltheme-wp-author-tab"> 

		                    <ul class="resp-tabs-list">

		                        <li>
		                            <i class="fa fa-user"></i>
		                            <?php _e( 'Description', 'jeweltheme' );?>
		                        </li>

		                        <li>
		                            <i class="fa fa-share"></i>
		                            <?php _e('Socials', 'jeweltheme');?>
		                        </li>

		                        <li>
		                                <i class="fa fa-list-ul"></i>
		                                <?php _e('Recent Post', 'jeweltheme');?>
		                        </li>

		                        <li>
		                                <i class="fa fa-comments-o"></i>
		                                <?php _e('Comments', 'jeweltheme');?>
		                        </li>
		                        
		                    </ul> 

		                    <div class="resp-tabs-container"> 

		                        <div>
		                            <p><?php echo get_the_author_meta('description' );?></p>
		                        </div>

		                        <div class="jeweltheme-wp-social-tab">

		                            <ul>

		                            <?php 
		                            
		                                $facebook = get_the_author_meta('facebook' );
		                                $twitter = get_the_author_meta('twitter' );
		                                $linkedin = get_the_author_meta('linkedin' );
		                                $googleplus = get_the_author_meta('googleplus' );
		                                $pinterest = get_the_author_meta('pinterest' );
		                                $thumbler = get_the_author_meta('thumbler' );
		                                $flickr = get_the_author_meta('flickr' );
		                                $instagram = get_the_author_meta('instagram' );
		                                $dribbble = get_the_author_meta('dribbble' );
		                                $youtube = get_the_author_meta('youtube' );

		                                if( $facebook ){ ?>
		                                    <li class="jeweltheme-wp-icon jeweltheme-wp-facebook"><a href="https://www.facebook.com/<?php echo $facebook;?>" target="_blank" ><i class="fa fa-facebook"></i></a></li>
		                                <?php } ?>

		                                <?php if ( $twitter ) { ?>
		                                    <li class="jeweltheme-wp-icon jeweltheme-wp-twitter"><a href="https://twitter.com/<?php echo $twitter;?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
		                                <?php } ?>

		                                <?php if ( $linkedin ) { ?>
		                                    <li class="jeweltheme-wp-icon jeweltheme-wp-linkedin"><a href="http://www.linkedin.com/in/<?php echo $linkedin;?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
		                                <?php } ?>

		                                <?php if( $googleplus ){ ?>
		                                    <li class="jeweltheme-wp-icon jeweltheme-wp-googleplus"><a href="https://plus.google.com/+<?php echo $googleplus;?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
		                                <?php } ?>

		                                <?php if( $dribbble ){ ?>
		                                    <li class="jeweltheme-wp-icon jeweltheme-wp-dribbble"><a href="http://dribbble.com/<?php echo $dribbble;?>" target="_blank"><i class="fa fa-dribbble"></i></a></li>
		                                <?php } ?>

		                                <?php if( $pinterest ){  ?>
		                                    <li class="jeweltheme-wp-icon jeweltheme-wp-pinterest"><a href="https://www.pinterest.com/<?php echo $pinterest;?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
		                                <?php } ?>

		                                <?php if( $youtube ){ ?>
		                                    <li class="jeweltheme-wp-icon jeweltheme-wp-youtube"><a href="https://www.youtube.com/user/<?php echo $youtube;?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
		                                <?php } ?>

		                                <?php if( $flickr ){ ?>
		                                    <li class="jeweltheme-wp-icon jeweltheme-wp-flickr"><a href="http://www.flickr.com/people/<?php echo $flickr;?>" target="_blank"><i class="fa fa-flickr"></i></a></li>
		                                <?php } ?>                               
		                                
		                            </ul>
		                                
		                        </div>

		                        <div>
		                            <ul>
		                              <?php 

		                                global $author_id;                  

		                                global $post_limit;                             
		                                
		                                $post_limit = jltauthorbio_options( 'post-limit', 'jeweltheme_wp_recent'); 
		                                
		                                $author_id = get_the_author_meta( 'ID' );
		                                
		                                $query =new \WP_Query(array('post_type' => 'post','author' => $author_id,'showposts' => $post_limit)); 

		                                if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post(); ?>

		                                <li>
		                                	<a href="<?php the_permalink(); ?>">
		                                     <?php
                                                    global $jeweltheme_wp_post_length;
                                                    
                                                    $jeweltheme_wp_post_length = jltauthorbio_options( 'post-title-length', 'jeweltheme_wp_recent', '10');

                                                    $title = get_the_title(); 

                                                    if (strlen($title) > 10)

                                                    $title = substr( $title, 0 , $jeweltheme_wp_post_length ) . "..."; 

                                                    echo "$title";
                                                ?>
		                                	&nbsp; &nbsp;
		                                <span>
		                                 
		                                 <?php
	                                        $jeweltheme_wp_show_comments = jltauthorbio_options( 'recent-show-comments', 'jeweltheme_wp_recent'); 

	                                        if( $jeweltheme_wp_show_comments =="yes" ) {

	                                        comments_number( '0 comment', '1 comment', '% Comments' ); } 
		                                ?>

		                                </span> &nbsp; &nbsp;
		                                </a>
		                            </li>

	                                 <?php 
	                                        
	                                        	wp_reset_postdata();
	                                        }

	                                    } else {	?>

	                                        <li> <p class="not_found">Sorry, no post is unavailable!</p> </li>
	                                    
	                                    <?php } ?>
		                            
		                            </ul>

		                        </div>

		                        <div>
		                            <ul>
		                                <?php 

		                                    $jeweltheme_wp_num_of_comments = jltauthorbio_options( 'comment-post-limit', 'jeweltheme_wp_comments'); 

		                                    $args = array('status' => 'approve','number' => $jeweltheme_wp_num_of_comments,'user_id' => get_the_author_meta( 'ID' ));
		                                    
		                                    $comments = get_comments($args);
		                                    
		                                    if( $comments ){

		                                    foreach($comments as $comment) { ?>

		                                <li>

		                                    <a href="<?php echo get_permalink( $comment->comment_post_ID ) ?>#comment-<?php echo $comment->comment_ID; ?>">
		                                       
		                                        <?php

		                                            $jeweltheme_wp_comment_title_length = jltauthorbio_options( 'comment-title-length', 'jeweltheme_wp_comments'); 
		                        
		                                            $contents = $comment->comment_content;

		                                            $trimmed_content = wp_trim_words( $contents, $jeweltheme_wp_comment_title_length);

		                                            echo $trimmed_content;

		                                        ?>

		                                        &nbsp; &nbsp; 


		                                    </a>

		                                </li>

		                                <?php } } else{ ?>

		                                    <li> <p class="not_found">Sorry, this author doesn't have any comments!</p> </li>

		                                <?php } ?>                                
		                                
		                            </ul>

		                        </div>
		                        
		                    </div><!-- /.resp-tabs-container -->
		                </div> <!-- /.jeweltheme-wp-author-tab -->

		            </div><!-- /.jeweltheme-wp-author-other -->
		        </div><!-- /.jltauthorbio-maindiv -->   
		    </div><!-- /.jltauthorbio -->


		    <?php

		    $jltauthorbio_contents = ob_get_clean();

		    ob_end_flush();

		    return $content . $jltauthorbio_contents;  

		    } else {  
		        return $content;  
		    }  
		}





		/**
		 * plugins_loaded method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltauthorbio_plugins_loaded() {
			$this->jltauthorbio_activate();
		}

		/**
		 * Version Key
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function plugin_version_key() {
			return Helper::jltauthorbio_slug_cleanup() . '_version';
		}

		/**
		 * Activation Hook
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function jltauthorbio_activate() {
			$current_jltauthorbio_version = get_option( self::plugin_version_key(), null );

			if ( get_option( 'jltauthorbio_activation_time' ) === false ) {
				update_option( 'jltauthorbio_activation_time', strtotime( 'now' ) );
			}

			if ( is_null( $current_jltauthorbio_version ) ) {
				update_option( self::plugin_version_key(), self::VERSION );
			}

			$allowed = get_option( Helper::jltauthorbio_slug_cleanup() . '_allow_tracking', 'no' );

			// if it wasn't allowed before, do nothing .
			if ( 'yes' !== $allowed ) {
				return;
			}
			// re-schedule and delete the last sent time so we could force send again .
			$hook_name = Helper::jltauthorbio_slug_cleanup() . '_tracker_send_event';
			if ( ! wp_next_scheduled( $hook_name ) ) {
				wp_schedule_event( time(), 'weekly', $hook_name );
			}
		}


		/**
		 * Add Body Class
		 *
		 * @param [type] $classes .
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltauthorbio_body_class( $classes ) {
			$classes .= ' awesome-wp-author-bio ';
			return $classes;
		}

		/**
		 * Run Upgrader Class
		 *
		 * @return void
		 */
		public function jltauthorbio_maybe_run_upgrades() {
			if ( ! is_admin() && ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Run Upgrader .
			$upgrade = new Upgrade_Plugin();

			// Need to work on Upgrade Class .
			if ( $upgrade->if_updates_available() ) {
				$upgrade->run_updates();
			}
		}

		/**
		 * Include methods
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function includes() {
			new AdminSettings();
			new Assets();
			new Recommended_Plugins();
			new Row_Links();
			new Pro_Upgrade();
			new Notifications();
			new Featured();
			new Feedback();
		}


		/**
		 * Initialization
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltauthorbio_init() {
			$this->jltauthorbio_load_textdomain();
		}


		/**
		 * Text Domain
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltauthorbio_load_textdomain() {
			$domain = 'awesome-wp-author-bio';
			$locale = apply_filters( 'jltauthorbio_plugin_locale', get_locale(), $domain );

			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, false, dirname( JLTAUTHORBIO_BASE ) . '/languages/' );
		}
		
		
		

		/**
		 * Returns the singleton instance of the class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof JLT_Author_Bio ) ) {
				self::$instance = new JLT_Author_Bio();
				self::$instance->jltauthorbio_init();
			}

			return self::$instance;
		}
	}

	// Get Instant of JLT_Author_Bio Class .
	JLT_Author_Bio::get_instance();
}