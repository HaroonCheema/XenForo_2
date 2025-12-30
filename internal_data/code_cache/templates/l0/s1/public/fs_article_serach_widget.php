<?php
// FROM HASH: aa8b9dcb89dc933fff40d7b600b1945d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block"' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
	<div class="block-container">
		<h3 class="block-minorHeader">
			<a href="' . $__templater->func('link', array('#', ), true) . '" rel="nofollow">' . ($__templater->escape($__vars['title']) ?: 'Article Search') . '</a>
		</h3>
		<ul class="block-body">
			<form action="' . $__templater->func('link', array('search/article-search', ), true) . '" method="post"
				  class="menu-content"
				  data-xf-init="quick-search">

				' . '
				<div class="menu-row">
					';
	if ($__vars['searchConstraints']) {
		$__finalCompiled .= '
						<div class="inputGroup inputGroup--joined">
							' . $__templater->formTextBox(array(
			'name' => 'keywords',
			'placeholder' => 'Search' . $__vars['xf']['language']['ellipsis'],
			'aria-label' => 'Search',
			'data-menu-autofocus' => 'true',
		)) . '
							';
		$__compilerTemp1 = array(array(
			'value' => '',
			'label' => 'Everywhere',
			'_type' => 'option',
		));
		if ($__templater->isTraversable($__vars['searchConstraints'])) {
			foreach ($__vars['searchConstraints'] AS $__vars['constraintName'] => $__vars['constraint']) {
				$__compilerTemp1[] = array(
					'value' => $__templater->filter($__vars['constraint'], array(array('json', array()),), false),
					'label' => $__templater->escape($__vars['constraintName']),
					'_type' => 'option',
				);
			}
		}
		$__finalCompiled .= $__templater->formSelect(array(
			'name' => 'constraints',
			'class' => 'js-quickSearch-constraint',
			'aria-label' => 'Search within',
		), $__compilerTemp1) . '
						</div>
						';
	} else {
		$__finalCompiled .= '
						' . $__templater->formTextBox(array(
			'name' => 'keywords',
			'placeholder' => 'Search' . $__vars['xf']['language']['ellipsis'],
			'aria-label' => 'Search',
			'data-menu-autofocus' => 'true',
		)) . '
					';
	}
	$__finalCompiled .= '
				</div>

				' . '
				<div class="menu-row">
					';
	$__compilerTemp2 = '';
	if ($__vars['xf']['options']['enableTagging']) {
		$__compilerTemp2 .= '
									<span tabindex="0" role="button"
										  data-xf-init="tooltip" data-trigger="hover focus click" title="' . 'Tags will also be searched' . '">

										' . $__templater->fontAwesome('far fa-question-circle', array(
			'class' => 'u-muted u-smaller',
		)) . '
									</span>
								';
	}
	$__finalCompiled .= $__templater->formCheckBox(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'c[title_only]',
		'label' => '
								' . 'Search titles only' . '

								' . $__compilerTemp2 . '
							',
		'_type' => 'option',
	))) . '
				</div>
				' . '
				<div class="menu-row">
					<div class="inputGroup">
						<span class="inputGroup-text" id="ctrl_search_menu_by_member">' . 'By' . $__vars['xf']['language']['label_separator'] . '</span>
						<input type="text" class="input" name="c[users]" data-xf-init="auto-complete" placeholder="' . $__templater->filter('Member', array(array('for_attr', array()),), true) . '" aria-labelledby="ctrl_search_menu_by_member" />
					</div>
				</div>

				' . $__templater->formHiddenVal('c[nodes][]', $__vars['node_id'], array(
	)) . '
				' . $__templater->formHiddenVal('c[child_nodes]', '1', array(
	)) . '
				' . $__templater->formHiddenVal('search_type', 'post', array(
	)) . '
				' . $__templater->formHiddenVal('order', 'date', array(
	)) . '

				<div class="menu-footer">
					<span class="menu-footer-controls">
						' . $__templater->button('', array(
		'type' => 'submit',
		'class' => 'button--primary',
		'icon' => 'search',
	), '', array(
	)) . '
					</span>
				</div>

				' . $__templater->func('csrf_input') . '
			</form>
		</ul>
	</div>
</div>';
	return $__finalCompiled;
}
);