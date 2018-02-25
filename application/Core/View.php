<?php

namespace Mini\Core;

use Mini\Libs\Sesion;

class View
{
	public function render($filename, $data = null)
	{
		if($data){
			foreach ($data as $key => $value) {
				$this->{$key} = $value;
			}
		}

		require APP . 'view/_templates/header.php';
        require APP . 'view/' . $filename . '.php';
        require APP . 'view/_templates/footer.php';
	}

	public function renderFeedbackMessages()
	{
		require APP . 'view/_templates/feedback.php';
		Sesion::set('feedback_positive', null);
		Sesion::set('feedback_negative', null);
	}
}