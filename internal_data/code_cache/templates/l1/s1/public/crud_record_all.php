<?php
// FROM HASH: 3def260b7a542eff75b5e136d34fb109
return array(
'macros' => array('search_menu' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'conditions' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block-filterBar">
		<div class="filterBar">
			<a
			   class="filterBar-menuTrigger"
			   data-xf-click="menu"
			   role="button"
			   tabindex="0"
			   aria-expanded="false"
			   aria-haspopup="true"
			   >' . 'Filters' . '</a
				>
			<div
				 class="menu menu--wide"
				 data-menu="menu"
				 aria-hidden="true"
				 data-href="' . $__templater->func('link', array('crud/refine-search', null, $__vars['conditions'], ), true) . '"
				 data-load-target=".js-filterMenuBody"
				 >
				<div class="menu-content">
					<h4 class="menu-header">' . 'Show only' . $__vars['xf']['language']['label_separator'] . '</h4>
					<div class="js-filterMenuBody">
						<div class="menu-row">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
					</div>
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'record_table_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'data' => $__vars['data'],
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'_type' => 'cell',
		'html' => ' Name ',
	),
	array(
		'_type' => 'cell',
		'html' => ' Class ',
	),
	array(
		'_type' => 'cell',
		'html' => ' Roll No ',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => ' Action ',
	))) . '
	';
	if ($__templater->isTraversable($__vars['data'])) {
		foreach ($__vars['data'] AS $__vars['val']) {
			$__finalCompiled .= '
		' . $__templater->dataRow(array(
			), array(array(
				'href' => $__templater->func('link', array('crud/edit', $__vars['val'], ), false),
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['name']) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['class']) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['rollNo']) . ' ',
			),
			array(
				'href' => $__templater->func('link', array('crud/delete-record', $__vars['val'], ), false),
				'overlay' => 'true',
				'_type' => 'delete',
				'html' => '',
			))) . '
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('CRUD');
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped('CRUD'), '#', array(
	));
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add Record', array(
		'href' => $__templater->func('link', array('crud/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
	' . $__templater->func('csrf_input') . '
');
	$__finalCompiled .= '

<div class="block">
	<div class="block-outer">
		' . $__templater->callMacro('filter_macro', 'quick_filter', array(
		'key' => 'crud',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>
	<div class="block-container">
		<!-- filter macro -->

		' . $__templater->callMacro(null, 'search_menu', array(
		'conditions' => $__vars['conditions'],
	), $__vars) . '

		<!-- filter macro -->
		<div class="block-body">


			<div>
				
				';
	$__templater->includeCss('fs_bunny_disp_video_thumb.less');
	$__finalCompiled .= $__templater->formRow('
					' . '' . '
					
					<div class="attachmentUploads is-active">
					
					<ul class="attachUploadList">
						<li class="file">
							<a class="file-preview" href="data/CrudTesting/video.mp4" target="_blank">
								<video>
									<source src="data/CrudTesting/video.mp4" />
								</video>
							</a>
							<div class="file-content">
								<div class="file-insert">
									<a class="file-insertLink" data-action="full" data-type="video" role="button" tabindex="0">
										' . 'Insert' . '
									</a>
								</div>
								<a class="file-info"
								   href="data/CrudTesting/video.mp4"
								   target="_blank">
									<span class="file-name">file name here</span>
									<div class="file-meta">
										2.6 MB
									</div>
								</a>
							</div>
						</li>
					</ul>
					</div>
					
					<span class="custom-file-upload">
					<label for="bunny_video" class="button button--link"><i class="fa fa-upload" aria-hidden="true" style="padding-right: 8px;"></i>' . 'Upload Video' . '</label>
					<input type="file" id="bunny_video" name="bunny_video" onchange="uploadFile()" accept=".mp4, .avi, .mov" style="display: none;" />
				</span>
					
				', array(
		'rowtype' => 'fullWidth noLabel mergePrev noTopPadding',
	)) . '
				
				
				
			</div>
			
			
			<!--       < Records >  -->

			';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['data'], 'empty', array())) {
		$__compilerTemp1 .= '
					<!-- list macro -->

					' . $__templater->callMacro(null, 'record_table_list', array(
			'data' => $__vars['data'],
		), $__vars) . '

					<!-- list macro -->
					';
	} else {
		$__compilerTemp1 .= '
					<div class="blockMessage">
						' . 'No items have been created yet.' . '
					</div>
				';
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp1 . '
			', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
			' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'crud',
		'wrapperclass' => 'block',
		'perPage' => $__vars['perPage'],
	))) . '
			<!--       </ Records > -->
		</div>

		<!-- <div class="block-footer">
  <span class="block-footer-counter">footer</span>
   </div> -->
	</div>
</div>

<!-- All macros is here define in below -->

<!-- Filter Bar Macro Start -->

' . '

<!-- Filter Bar Macro End -->

<!-- Record Table List Start -->

' . '

<!-- Record Table List End -->';
	return $__finalCompiled;
}
);