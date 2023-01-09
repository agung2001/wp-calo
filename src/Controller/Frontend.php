<?php

namespace Calo\Controller;

! defined( 'WPINC ' ) or die;

/**
 * Plugin hooks in a backend
 *
 * @package    Calo
 * @subpackage Calo/Controller
 */

use Calo\Metabox\CALOMetaboxSetting;

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
	}

}
