<?php
// FROM HASH: 82574da96be4e39cff9a7ddce255e56b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['ftsliders'], 'empty', array()) AND $__templater->method($__vars['xf']['visitor'], 'hasPermission', array('FTSlider_permissions', 'FTSlider_view', ))) {
		$__finalCompiled .= '
	';
		$__templater->includeCss('FTSlider.less');
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'FTSlider/jquery.fts.1.0.js',
		));
		$__templater->includeJs(array(
			'src' => 'FTSlider/jquery.fts.wheel.js',
		));
		$__templater->includeJs(array(
			'src' => 'FTSlider/jquery.fts.min.js',
		));
		$__templater->inlineJs('
		' . '' . '
		' . '' . '
		' . $__templater->includeTemplate('FTSlider_js', $__vars) . '
	');
		$__finalCompiled .= '
	<div class="block ftslider">
		<div class="block-container">
			<h3 class="block-header">' . $__templater->escape($__vars['xf']['options']['FTSlider_title']) . '</h3>	

			<div class="block-body">	
				<div id="fs_auction_fullwidth_slider" class="everslider fullwidth-slider">
					<ul class="es-slides">
						';
		$__vars['key'] = 0;
		if ($__templater->isTraversable($__vars['ftsliders'])) {
			foreach ($__vars['ftsliders'] AS $__vars['value']) {
				$__vars['key']++;
				$__finalCompiled .= '
							<li>
								<a href="' . $__templater->func('link', array('auction/view-auction/', $__vars['value'], ), true) . '">
									<img src="' . ($__templater->func('count', array($__vars['value']['Thread']['FirstPost']['Attachments'], ), false) ? $__templater->func('link', array('full:attachments', $__templater->method($__vars['value']['Thread']['FirstPost']['Attachments'], 'first', array()), ), true) : $__templater->func('base_url', array('styles/FS/AuctionPlugin/no_image.png', true, ), true)) . '" 
										 alt="xyz' . $__templater->escape($__vars['key']) . '.jpeg"
										 loading="lazy"
										 title="' . $__templater->escape($__vars['value']['Thread']['title']) . '">	
								</a>
								<div class="fullwidth-title">
									<div class="ftslider_title_detail">
										' . $__templater->func('avatar', array($__vars['value']['Thread']['User'], 'xxs', false, array(
					'class' => 'FTSlider_Avatar ',
					'defaultname' => $__vars['fallbackName'],
					'itemprop' => 'image',
				))) . '	
										' . $__templater->escape($__vars['value']['Thread']['User']['username']) . '
										' . $__templater->func('date_dynamic', array($__vars['value']['Thread']['post_date'], array(
					'class' => 'ftslider-date',
					'data-full-old-date' => 'true',
				))) . '

										' . '
									</div>
									<div class="ftslider_content">
										<a href="' . $__templater->func('link', array('auction/view-auction/', $__vars['value'], ), true) . '" title="' . $__templater->escape($__vars['value']['Thread']['title']) . '">
											';
				if ($__vars['value']['Thread']['prefix_id']) {
					$__finalCompiled .= $__templater->func('prefix', array('thread', $__vars['value']['Thread'], 'html', '', ), true);
				}
				$__finalCompiled .= '
											' . $__templater->func('snippet', array($__vars['value']['Thread']['title'], 25, array('stripBbCode' => true, ), ), true) . '
										</a>	

										<div class="ftslider_excerpt"><a href="' . $__templater->func('link', array('auction/view-auction/', $__vars['value'], ), true) . '">' . $__templater->func('snippet', array($__vars['value']['Thread']['FirstPost']['message'], 100, array('stripBbCode' => true, ), ), true) . '</a></div>
									</div>	
								</div>
							</li>
						';
			}
		}
		$__finalCompiled .= '
					</ul>
				</div>
			</div>
		</div>
	</div>	
';
	}
	return $__finalCompiled;
}
);