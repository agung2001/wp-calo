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
