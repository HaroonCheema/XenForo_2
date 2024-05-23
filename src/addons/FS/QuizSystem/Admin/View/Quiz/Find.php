<?php

namespace FS\QuizSystem\Admin\View\Quiz;

use XF\Mvc\View;

class Find extends View
{
	public function renderJson()
	{
		$results = [];
		foreach ($this->params['questions'] AS $question)
		{

			$results[] = [
				'id' => $question->question_title,
				'text' => $question->question_title,
				'q' => $this->params['q']
			];
		}

		return [
			'results' => $results,
			'q' => $this->params['q']
		];
	}
}