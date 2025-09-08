<?php
// FROM HASH: cf5c7137c8559b44c8bf09a868abdc3f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('[XGT] Forum istatistik içerikleri');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Sekme ekle', array(
		'href' => $__templater->func('link', array('forum-istatistik/liste/ekle', $__vars['forumIstatistik'], ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '
';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['forumIstatistikPozisyonlar'])) {
		foreach ($__vars['forumIstatistikPozisyonlar'] AS $__vars['pozinyon'] => $__vars['forumIstatistikPozinyon']) {
			$__compilerTemp1 .= '
				';
			if ($__templater->isTraversable($__vars['forumIstatistikPozinyon'])) {
				foreach ($__vars['forumIstatistikPozinyon'] AS $__vars['forumIstatistik']) {
					$__compilerTemp1 .= '  
					';
					$__compilerTemp2 = '';
					if ($__vars['forumIstatistik']['veri_ikonu']) {
						$__compilerTemp2 .= '
								<i style="color: #47a7eb; font-size: 20px;" class="' . $__templater->escape($__vars['forumIstatistik']['veri_ikonu']) . '"></i>
							';
					}
					$__compilerTemp1 .= $__templater->dataRow(array(
					), array(array(
						'href' => $__templater->func('link', array('forum-istatistik/liste/duzenle', $__vars['forumIstatistik'], ), false),
						'class' => 'dataList-cell--main',
						'_type' => 'cell',
						'html' => '
							<div class="dataList-mainRow">
								' . $__templater->escape($__vars['forumIstatistik']['title']) . '
							</div>
						',
					),
					array(
						'class' => 'dataList-cell--min dataList-cell--hint',
						'title' => 'Sekme ikonu',
						'_type' => 'cell',
						'html' => '
							' . $__compilerTemp2 . '
						',
					),
					array(
						'class' => 'dataList-cell--min dataList-cell--hint',
						'title' => 'Sekme sırası',
						'_type' => 'cell',
						'html' => 'Sekme sırası' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['forumIstatistik']['display_order']),
					),
					array(
						'name' => 'aktif[' . $__vars['forumIstatistik']['veri_id'] . ']',
						'selected' => $__vars['forumIstatistik']['active'],
						'class' => 'dataList-cell--separated',
						'submit' => 'true',
						'tooltip' => 'Enable / disable \'' . $__vars['forumIstatistik']['title'] . '\'',
						'_type' => 'toggle',
						'html' => '',
					),
					array(
						'href' => $__templater->func('link', array('forum-istatistik/liste/sil', $__vars['forumIstatistik'], ), false),
						'tooltip' => 'Delete',
						'_type' => 'delete',
						'html' => '',
					))) . '
				';
				}
			}
			$__compilerTemp1 .= '
			';
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		' . $__templater->dataList('
			' . $__compilerTemp1 . '
		', array(
	)) . '
		<div class="block-footer">
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['forumIstatistikPozisyonlar'], $__vars['total'], ), true) . '</span>
		</div>	
	</div>		
', array(
		'action' => $__templater->func('link', array('forum-istatistik/liste/toggle', ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '

<div class="blockMessage blockMessage--success" style="border-radius:4px;padding: 10px;font-size: 20px;font-weight: 400;">
	' . '[XGT] Forum istatistik - Örnek görünüş' . '
</div>

';
	if ($__templater->isTraversable($__vars['forumIstatistikPozisyonlar'])) {
		foreach ($__vars['forumIstatistikPozisyonlar'] AS $__vars['pozinyon'] => $__vars['forumIstatistikPozinyon']) {
			$__finalCompiled .= '
	<div class="block">	
		<h2 class="block-tabHeader tabs hScroller" data-xf-init="tabs h-scroller" data-state="replace" role="tablist" style="border-top-left-radius: 4px;border-top-right-radius: 4px;border-bottom: none;">
			<span class="hScroller-scroll">
				';
			if ($__templater->isTraversable($__vars['forumIstatistikPozinyon'])) {
				foreach ($__vars['forumIstatistikPozinyon'] AS $__vars['forumIstatistik']) {
					$__finalCompiled .= ' 
					';
					if ($__vars['forumIstatistik']['active']) {
						$__finalCompiled .= '
						<a href="' . $__templater->func('link', array('forum-istatistik/liste/duzenle', $__vars['forumIstatistik'], ), true) . '" class="tabs-tab ' . (($__vars['counter'] == 1) ? 'is-active' : '') . '" role="tab" tabindex="0" aria-controls="istatistikveri-' . $__templater->escape($__vars['veri_id']) . '">
							';
						if ($__templater->func('property', array('xgt_Frmistatistik_sekme_ikonlari', ), false) AND $__vars['forumIstatistik']['veri_ikonu']) {
							$__finalCompiled .= '
								<i class="' . $__templater->escape($__vars['forumIstatistik']['veri_ikonu']) . '"></i> 
							';
						}
						$__finalCompiled .= '
							' . $__templater->escape($__vars['forumIstatistik']['title']) . '
						</a>
					';
					}
					$__finalCompiled .= '
				';
				}
			}
			$__finalCompiled .= '
			</span>
		</h2>
		<div class="block-body">
			<div class="block-container" style="border-radius: 0px 0px 4px 4px;padding: 10px; border-width: 0;">
				' . 'Geçerli sekme içeriği...' . '
			</div>	
		</div>
	</div>			
';
		}
	}
	return $__finalCompiled;
}
);