<?php
// FROM HASH: c25355acdd5e50ded44f9dd3af6d6e9b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block"' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
		<div class="block-container">
				<h3 class="block-minorHeader">
					 ' . 'Highest Rated in This Category' . '
				</h3>
				<ul class="block-body">
					';
	if (!$__templater->test($__vars['highestRatedItems'], 'empty', array())) {
		$__finalCompiled .= '
						<div class="brandHub">		
							<ul class="highestRated_grid-list">
								';
		if ($__templater->isTraversable($__vars['highestRatedItems'])) {
			foreach ($__vars['highestRatedItems'] AS $__vars['highestRatedItem']) {
				$__finalCompiled .= '
									
									';
				$__vars['itemThumbnailUrl'] = $__templater->method($__vars['highestRatedItem'], 'getthumbnailurl', array());
				$__finalCompiled .= '
								
								<li class="bh_item">

									<div class="contentRow-main contentRow-main--close">
										
										<a href="' . $__templater->func('link', array($__vars['xf']['options']['bh_main_route'] . '/item', $__vars['highestRatedItem'], ), true) . '" class="bh_a" >
											';
				if ($__vars['itemThumbnailUrl']) {
					$__finalCompiled .= '
												<img src="' . $__templater->escape($__vars['itemThumbnailUrl']) . '" alt="Item-image" />
											';
				} else {
					$__finalCompiled .= '
												<i class="fas fa-image fa-4x" ></i>
											';
				}
				$__finalCompiled .= '

											<div class="contentRow-lesser">
												' . $__templater->escape($__vars['highestRatedItem']['item_title']) . '
												' . $__templater->callMacro('rating_macros', 'stars', array(
					'rating' => $__vars['highestRatedItem']['rating_avg'],
					'class' => 'ratingStars--smaller',
				), $__vars) . ' (' . $__templater->escape($__vars['highestRatedItem']['rating_count']) . ') 
											</div>
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
				</ul>
		</div>
	</div>';
	return $__finalCompiled;
}
);