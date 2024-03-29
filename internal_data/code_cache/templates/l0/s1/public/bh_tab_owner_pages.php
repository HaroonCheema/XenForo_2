<?php
// FROM HASH: 4df3ee4537a64ca82d94690819b02a88
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']));
	$__finalCompiled .= '
';
	$__templater->includeCss('bh_brandHub_list.less');
	$__finalCompiled .= '
<div class="block">
	<div class="block-container">
		<div class="block-header">
			<h3 class="block-minorHeader">' . '' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Owner Pages' . '</h3>
			<div class="p-description">' . 'View owner pages to see photos, customization and comments  about member-owner ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . 's' . '</div>
		</div>
		<div class="block-body block-row block-row--separated">
			<div class="block-body">

			<div class="block-body">
				';
	if (!$__templater->test($__vars['ownerPages'], 'empty', array())) {
		$__finalCompiled .= '
						<div class="brandHub">		
							<ul class="grid-list">
								';
		if ($__templater->isTraversable($__vars['ownerPages'])) {
			foreach ($__vars['ownerPages'] AS $__vars['ownerPage']) {
				$__finalCompiled .= '
								<li class="bh_item">
									<div class="borderpage">

										';
				$__vars['pageThumbnailUrl'] = $__templater->method($__vars['ownerPage'], 'getthumbnailurl', array());
				$__finalCompiled .= '

												<a href="' . $__templater->func('link', array('owners', $__vars['ownerPage'], ), true) . '" class="bh_a" >
													';
				if ($__vars['pageThumbnailUrl']) {
					$__finalCompiled .= '
														<img src="' . $__templater->escape($__vars['pageThumbnailUrl']) . '"  />	
													';
				} else {
					$__finalCompiled .= '
														<i class="fas fa-image fa-6x" ></i>
													';
				}
				$__finalCompiled .= '	

													' . '
													
													<strong>' . ($__templater->escape($__vars['ownerPage']['title']) ?: '' . $__templater->escape($__vars['ownerPage']['User']['username']) . '\'s ' . $__templater->escape($__vars['ownerPage']['Item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['ownerPage']['Item']['item_title']) . ' ') . '</strong></a>
												</a>
									</div>

									</li>
								';
			}
		}
		$__finalCompiled .= '
							</ul>	
						</div>
				';
	} else {
		$__finalCompiled .= '
					<div class="blockMessage">' . 'No results found.' . '</div>
				';
	}
	$__finalCompiled .= '
		

				</div>
			</div>
		</div>
	</div>
</div>



';
	return $__finalCompiled;
}
);