<?php
// FROM HASH: 637c880255d3886335b41ff48a336166
return array(
'macros' => array('listing' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'listing' => '!',
		'category' => null,
		'showWatched' => true,
		'allowInlineMod' => true,
		'chooseName' => '',
		'extraInfo' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '
	';
	$__templater->includeCss('fs_quiz_list_view.less');
	$__finalCompiled .= '

	<div class="structItem structItem--listing js-inlineModContainer " id="quiz-' . $__templater->escape($__vars['listing']['quiz_id']) . '" data-author="">

		<img src ="' . $__templater->func('base_url', array('styles/FS/AuctionPlugin/no_image.png', true, ), true) . '" style="display: none;" onload="timmerCounter(' . $__templater->escape($__vars['listing']['quiz_id']) . ',' . $__templater->escape($__vars['listing']['quiz_end_date']) . ')">

		<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy">

			<div class="structItem-title">

				<a href="' . $__templater->func('link', array('quiz/view-quiz', $__vars['listing'], ), true) . '" class="" data-tp-primary="on">' . $__templater->escape($__vars['listing']['quiz_name']) . '</a>

			</div>
			<div class="structItem-minor">

				<ul class="structItem-parts">
					<li class="structItem-startDate">
						' . $__templater->func('date_dynamic', array($__vars['listing']['created_at'], array(
	))) . ' 

					</li>

					<li>' . $__templater->func('snippet', array($__vars['listing']['Category']['title'], 50, array('stripBbCode' => true, ), ), true) . '</li>

				</ul>
			</div>



			<div class="auction-category">' . $__templater->func('snippet', array($__vars['listing']['quiz_des'], 100, array('stripBbCode' => true, ), ), true) . '</div>


		</div>
		
		<div class="structItem-cell structItem-cell--listingMeta">

			<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--questionCount">
				<dt>' . 'Questions' . '</dt>
				<dd>
					' . $__templater->func('count', array($__vars['listing']['quiz_questions'], ), true) . '
				</dd>
			</dl>
			
			<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--questionDuration">
				<dt >' . 'Time Per Question' . '</dt>
				<dd>
					' . $__templater->escape($__vars['listing']['time_per_question']) . ' ' . 'Seconds' . '
				</dd>
			</dl>

			<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--questionDuration">
				<dt >' . 'Quiz Duration' . '</dt>
				<dd>
					' . $__templater->escape($__templater->method($__vars['listing'], 'getQuizDuration', array())) . '
					' . '

				</dd>
			</dl>
			
		</div>
		
		<div class="structItem-cell structItem-cell--listingMeta">

			<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--starting">
				<dt>' . 'Start Date' . '</dt>
				<dd>
					' . $__templater->func('date_dynamic', array($__vars['listing']['quiz_start_date'], array(
	))) . '
				</dd>
			</dl>

			<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--expiration">
				<dt >' . 'End Date' . '</dt>
				<dd>
					' . $__templater->func('date_dynamic', array($__vars['listing']['quiz_end_date'], array(
	))) . '
					' . '

				</dd>
			</dl>
			<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--type">
				<dt id="counter-before">

				</dt>
				<dd>	';
	if ($__vars['listing']['quiz_end_date'] < $__vars['xf']['time']) {
		$__finalCompiled .= '
					<li>
						<span class="label label--red label--smallest">' . 'Expired' . '</span>
					</li>
					';
	} else {
		$__finalCompiled .= '
					<li>
						<div id="quiz-counter-' . $__templater->escape($__vars['listing']['quiz_id']) . '">

							<span class="label  label--blue label--counter" id="days-quiz-' . $__templater->escape($__vars['listing']['quiz_id']) . '">
								' . '00 D' . '
							</span>
							<span class="label  label--blue label--counter" id="hours-quiz-' . $__templater->escape($__vars['listing']['quiz_id']) . '">
								' . '00 H' . '
							</span>
							<span class="label  label--blue label--counter" id="minutes-quiz-' . $__templater->escape($__vars['listing']['quiz_id']) . '">
								' . '00 M' . '
							</span>
							<span class="label  label--blue label--counter" id="seconds-quiz-' . $__templater->escape($__vars['listing']['quiz_id']) . '">
								' . '00 S' . '
							</span>
						</div>

					</li>
					';
	}
	$__finalCompiled .= ' </dd>
			</dl>


		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);