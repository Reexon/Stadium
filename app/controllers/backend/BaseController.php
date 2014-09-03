<?php

namespace Backend\Controller;

use View;

class BaseController extends \Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
    protected $viewFolder = 'backend.';

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
