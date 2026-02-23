<?php
// FROM HASH: 9add65c72d8ca11524213fc9df0c11d6
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('show_all_states.less');
	$__finalCompiled .= '
';
	if (!$__templater->test($__vars['nodes'], 'empty', array())) {
		$__finalCompiled .= '
    <div class="block"' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
        <div class="block-container">
            <h3 class="block-minorHeader">' . $__templater->escape($__vars['title']) . '</h3>
            <div class="block-body">
                <div class="attractive-states-slider-wrapper">
                    <button class="slider-arrow slider-arrow--prev" aria-label="Previous" style="margin: 0 3px;">&#8249;</button>
                    <div class="attractive-states-track-outer">
                        <ul class="listHeap attractive-states">
                            ';
		if ($__templater->isTraversable($__vars['nodes'])) {
			foreach ($__vars['nodes'] AS $__vars['node']) {
				$__finalCompiled .= '
                                <li>
                                    <a class="attractive-state" href="' . $__templater->func('link', array('categories', $__vars['node'], ), true) . '">
                                        <span class="state-title">
                                            ';
				if ($__templater->method($__vars['node'], 'getStateIcon', array())) {
					$__finalCompiled .= '
                                                <img
                                                    class="state-icon"
                                                    src="' . $__templater->func('base_url', array($__templater->method($__vars['node'], 'getStateIcon', array()), ), true) . '"
                                                    alt="' . $__templater->escape($__vars['node']['title']) . '"
                                                    style="width: ' . $__templater->escape($__vars['xf']['options']['fs_state_icon_dimenstions']['width']) . 'px; height: ' . $__templater->escape($__vars['xf']['options']['fs_state_icon_dimenstions']['height']) . 'px;"
                                                    loading="lazy"
                                                />
                                            ';
				}
				$__finalCompiled .= ' ' . $__templater->escape($__vars['node']['title']) . '
                                        </span>
                                    </a>
                                </li>
                            ';
			}
		}
		$__finalCompiled .= '
                        </ul>
                    </div>
                    <button class="slider-arrow slider-arrow--next" aria-label="Next" style="margin: 0 3px;">&#8250;</button>
                </div>
            </div>
        </div>
    </div>
';
	}
	$__finalCompiled .= '

<script>
(function() {
    document.addEventListener(\'DOMContentLoaded\', function() {
        document.querySelectorAll(\'.attractive-states-slider-wrapper\').forEach(function(wrapper) {
            const track = wrapper.querySelector(\'.attractive-states\');
            const prev  = wrapper.querySelector(\'.slider-arrow--prev\');
            const next  = wrapper.querySelector(\'.slider-arrow--next\');
            const scrollAmount = 220;

            next.addEventListener(\'click\', function() {
                track.scrollBy({ left: scrollAmount, behavior: \'smooth\' });
            });
            prev.addEventListener(\'click\', function() {
                track.scrollBy({ left: -scrollAmount, behavior: \'smooth\' });
            });

            function updateArrows() {
                prev.style.opacity = track.scrollLeft <= 0 ? \'0.3\' : \'1\';
                prev.style.pointerEvents = track.scrollLeft <= 0 ? \'none\' : \'auto\';
                const atEnd = track.scrollLeft + track.clientWidth >= track.scrollWidth - 2;
                next.style.opacity = atEnd ? \'0.3\' : \'1\';
                next.style.pointerEvents = atEnd ? \'none\' : \'auto\';
            }

            track.addEventListener(\'scroll\', updateArrows);
            updateArrows();
        });
    });
})();
</script>';
	return $__finalCompiled;
}
);