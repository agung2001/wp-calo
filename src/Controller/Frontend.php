<?php

namespace Calo\Controller;

! defined( 'WPINC ' ) or die;

/**
 * Plugin hooks in a backend
 *
 * @package    Calo
 * @subpackage Calo/Controller
 */

use Calo\View;
use Calo\WordPress\Hook\Action;
use Calo\WordPress\Hook\Shortcode;

class Frontend extends Controller {

	/**
	 * Frontend constructor
	 *
	 * @return void
	 * @var    object   $plugin     Plugin configuration
	 * @pattern prototype
	 */
	public function __construct( $plugin ) {
		parent::__construct( $plugin );

		/** @frontend - Add Hook Action */
		$action = new Action();
		$action->setComponent( $this );
		$action->setHook( 'wp_enqueue_scripts' );
		$action->setCallback( 'frontend_enequeue' );
		$action->setAcceptedArgs( 0 );
		$action->setMandatory( true );
		$action->setDescription( __('Enqueue frontend framework assets','calo') );
		$this->hooks[] = $action;

		/** @frontend - Add Calo Admin Shortcode View */
		$shortcode = new Shortcode();
		$shortcode->setComponent($this);
		$shortcode->setHook('calo_admin');
		$shortcode->setCallback('calo_admin');
		$shortcode->setAcceptedArgs(1);
		$shortcode->setMandatory(true);
		$shortcode->setFeature($plugin->getFeatures()['core_frontend']);
		$this->hooks[] = $shortcode;
	}

	public function frontend_enequeue() {
		global $post;
		define( 'CALO_SCREEN', json_encode( $this->WP->getScreen() ) );
		$config  = $this->Framework->getConfig()->options;
		$screen  = $this->WP->getScreen();
		$slug    = sprintf( '%s-setting', $this->Framework->getSlug() );

		/** Load Vendors */
		/** Load Core Vendors */
		wp_enqueue_script('jquery');

		$this->WP->enqueue_assets( $config->calo_assets->backend );
		$this->WP->wp_enqueue_style( 'animatecss', 'vendor/animatecss/animate.min.css' );

		/** Load Plugin Assets */
		$this->WP->wp_enqueue_style( 'calo', 'build/css/backend.min.css' );
		$this->WP->wp_enqueue_script( 'calo', 'build/js/backend/backend.min.js', array(), '', true );
	}

	public function calo_admin( $atts ) {
		ob_start();
			$view = new View( $this->Framework );
			$view->setTemplate( 'frontend.blank' );
			$view->setSections( array(
				'Frontend.Admin' => array(
					'name' => 'Admin',
					'active' => true
				)
			) );
//			$view->setData();
			$view->setOptions( array( 'shortcode' => true ) );
			$view->build();
		return ob_get_clean();
	}

}
