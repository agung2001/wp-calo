<?php

namespace Calo\Controller;

! defined( 'WPINC ' ) or die;

/**
* Initiate framework
*
* @package    Calo
* @subpackage Calo/Controller
*/

use Calo\View;
use Calo\WordPress\Hook\Action;
use Calo\WordPress\Page\SubmenuPage;

class BackendPage extends Controller {

	/**
	 * Admin constructor
	 *
	 * @return void
	 * @var    object   $plugin     Plugin configuration
	 * @pattern prototype
	 */
	public function __construct( $plugin ) {
		parent::__construct( $plugin );

		/** @backend - Add custom admin page under settings */
		$action = new Action();
		$action->setComponent( $this );
		$action->setHook( 'admin_menu' );
		$action->setCallback( 'page_setting' );
		$action->setMandatory( true );
		$this->hooks[] = $action;
	}

	/**
	 * Admin Menu Setting
	 *
	 * @backend @submenu setting
	 * @return  void
	 */
	public function page_setting() {
		/** Section */
		$sections = array();
		$sections['Backend.about'] = array( 'name' => 'About', 'active' => true);

		/** Set View */
		$view = new View( $this->Framework );
		$view->setTemplate( 'backend.default' );
		$view->setSections( $sections );
		$view->addData(
			array(
				'background'   => 'bg-alizarin'
			)
		);
		$view->setOptions( array( 'shortcode' => false ) );

        /**
         * Set Page.
         */
		/** Set Page */
		$page = new SubmenuPage();
		$page->setParentSlug( 'options-general.php' );
		$page->setPageTitle(CALO_NAME);
		$page->setMenuTitle(CALO_NAME);
		$page->setCapability( 'manage_options' );
        $page->setMenuSlug(strtolower(CALO_NAME).'-setting');
		$page->setFunction( array( $page, 'loadView' ) );
		$page->setView($view);
		$page->build();
	}

}
