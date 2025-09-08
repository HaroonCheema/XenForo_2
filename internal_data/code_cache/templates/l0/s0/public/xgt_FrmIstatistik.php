<?php
// FROM HASH: 05708ef054318bae49455edb8ba7e41b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['xf']['visitor'], 'canIstatistikleriGor', array())) {
		$__finalCompiled .= '
	<div class="xgtForumIstatistik">
		<div class="xgtForumIstatistik-row">	
			';
		if ($__templater->method($__vars['xf']['visitor'], 'canKullaniciIstatistikGor', array())) {
			$__finalCompiled .= '
				';
			if (($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metin') OR ($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metinikon')) {
				$__finalCompiled .= '
					';
				$__vars['kullanici-metin'] = $__templater->preEscaped('Kullanıcı');
				$__finalCompiled .= '
					';
				$__vars['mesaj-metin'] = $__templater->preEscaped('Mesajı');
				$__finalCompiled .= '
				';
			}
			$__finalCompiled .= '
				';
			if (($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'ikon') OR ($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metinikon')) {
				$__finalCompiled .= '
					';
				$__vars['kullanici-ikon'] = $__templater->preEscaped('<i class="fal fa-user"></i>');
				$__finalCompiled .= '
					';
				$__vars['mesaj-ikon'] = $__templater->preEscaped('<i class="fal fa-comment-dots"></i>');
				$__finalCompiled .= '
				';
			}
			$__finalCompiled .= '
				';
			if (($__templater->func('property', array('xgt_Frmistatistik_kullanici_verisi', ), false) AND ($__templater->func('property', array('xgt_Frmistatistik_kullanici_veri_konum', ), false) == 'solda'))) {
				$__finalCompiled .= '
					<div class="xgtForumIstatistik-row--sol-s">
						<h2 class="xgtForumIstatistik-tabHeader block-tabHeader">
							<div class="tabs-tab _userTabs">
								';
				if ($__templater->func('property', array('xgt_Frmistatistik_sekme_ikonlari', ), false)) {
					$__finalCompiled .= '
									<i class="fad fa-user-friends"></i>
								';
				}
				$__finalCompiled .= '
								' . 'En çok mesaj' . '
							</div>
						</h2>
						<div class="_xgtIstatistik--blok">
							<div class="_xgtIstatistik-satir _xgtIstatistik_miniHeader">
								<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--konu">
									' . $__templater->filter($__vars['kullanici-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['kullanici-metin'], array(array('raw', array()),), true) . '
								</div>
								<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--cevap">
									' . $__templater->filter($__vars['mesaj-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['mesaj-metin'], array(array('raw', array()),), true) . '
								</div>
							</div>
							' . $__templater->renderWidget('xgtForumIstatistik_encok_mesaj_kullanici', array(), array()) . '
						</div>
					</div>
				';
			}
			$__finalCompiled .= '	
			';
		}
		$__finalCompiled .= '
			<div class="' . (($__templater->method($__vars['xf']['visitor'], 'canKullaniciIstatistikGor', array()) AND $__templater->func('property', array('xgt_Frmistatistik_kullanici_verisi', ), false)) ? 'xgtForumIstatistik-row--l' : '') . (((!$__templater->method($__vars['xf']['visitor'], 'canKullaniciIstatistikGor', array())) OR (!$__templater->func('property', array('xgt_Frmistatistik_kullanici_verisi', ), false))) ? 'xgtForumIstatistik-row--xl' : '') . '">
				';
		if ($__vars['forumIstatistikleri']['pozisyonlar']['anaveri']) {
			$__finalCompiled .= '
					';
			$__vars['baslangic'] = $__vars['forumIstatistikleri']['baslangic']['anaveri'];
			$__finalCompiled .= '     
					';
			$__vars['counter'] = '1';
			$__finalCompiled .= '
					<h2 class="xgtForumIstatistik-tabHeader block-tabHeader tabs hScroller" data-xf-init="tabs h-scroller" data-state="replace" role="tablist">
							<span class="hScroller-scroll">
								';
			if ($__templater->isTraversable($__vars['forumIstatistikleri']['pozisyonlar']['anaveri'])) {
				foreach ($__vars['forumIstatistikleri']['pozisyonlar']['anaveri'] AS $__vars['veri_id'] => $__vars['forumIstatistik']) {
					$__finalCompiled .= '
									<a class="tabs-tab ' . (($__vars['counter'] == 1) ? 'is-active' : '') . '" role="tab" tabindex="0" aria-controls="istatistikveri-' . $__templater->escape($__vars['veri_id']) . '">
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
					$__vars['counter'] = ($__vars['counter'] + 1);
					$__finalCompiled .= '
								';
				}
			}
			$__finalCompiled .= '
							</span>
						';
			if ($__templater->func('property', array('xgt_Frmistatistik_collapse', ), false)) {
				$__finalCompiled .= '
							';
				if (((($__templater->method($__vars['xf']['visitor'], 'canKullaniciIstatistikGor', array()) AND ($__templater->func('property', array('xgt_Frmistatistik_kullanici_verisi', ), false) AND ($__templater->func('property', array('xgt_Frmistatistik_kullanici_veri_konum', ), false) == 'solda'))) OR (!$__templater->method($__vars['xf']['visitor'], 'canKullaniciIstatistikGor', array()))) OR (!$__templater->func('property', array('xgt_Frmistatistik_kullanici_verisi', ), false)))) {
					$__finalCompiled .= '
								<div class="_collapseButton">
									<span class="collapseTrigger is-active" data-xf-click="toggle" data-xf-init="toggle-storage tooltip" 
										  data-target="._xgtIstatistik--blok" data-storage-key="xgtForumIstatistik"
										  title="' . 'İstatistikleri kapat/aç' . '"></span>
								</div>
							';
				}
				$__finalCompiled .= '
						';
			}
			$__finalCompiled .= '
					</h2>
					';
			$__vars['counter'] = '1';
			$__finalCompiled .= '
					<ul class="tabPanes _xgtIstatistik--blok">
						';
			if ($__templater->isTraversable($__vars['forumIstatistikleri']['pozisyonlar']['anaveri'])) {
				foreach ($__vars['forumIstatistikleri']['pozisyonlar']['anaveri'] AS $__vars['veri_id'] => $__vars['forumIstatistik']) {
					$__finalCompiled .= '
							';
					if ($__vars['counter'] == 1) {
						$__finalCompiled .= '
								<li class="is-active" role="tabpanel" id="istatistikveri-' . $__templater->escape($__vars['veri_id']) . '" data-href-initial="' . $__templater->func('link', array('forum-istatistik/sonuclar', $__vars['forumIstatistik'], ), true) . '">
									';
						$__compilerTemp1 = $__vars;
						$__compilerTemp1['forumIstatistik'] = $__vars['baslangic'];
						$__finalCompiled .= $__templater->includeTemplate('xgt_FrmIstatistik_icerikSonuc', $__compilerTemp1) . '
								</li>
							';
					} else {
						$__finalCompiled .= '
								<li class="" role="tabpanel" id="istatistikveri-' . $__templater->escape($__vars['veri_id']) . '" data-href="' . $__templater->func('link', array('forum-istatistik/sonuclar', $__vars['forumIstatistik'], ), true) . '" data-href-initial="' . $__templater->func('link', array('forum-istatistik/sonuclar', $__vars['forumIstatistik'], ), true) . '">
									<div class="_istatistikYukleniyor">
										<i class="fas fa-spinner fa-pulse"></i>
									</div>
								</li>
							';
					}
					$__finalCompiled .= '
							';
					$__vars['counter'] = ($__vars['counter'] + 1);
					$__finalCompiled .= '
						';
				}
			}
			$__finalCompiled .= '
					</ul>
				';
		}
		$__finalCompiled .= '
			</div>	
			';
		if ($__templater->method($__vars['xf']['visitor'], 'canKullaniciIstatistikGor', array())) {
			$__finalCompiled .= '
				';
			if (($__templater->func('property', array('xgt_Frmistatistik_kullanici_verisi', ), false) AND ($__templater->func('property', array('xgt_Frmistatistik_kullanici_veri_konum', ), false) == 'sagda'))) {
				$__finalCompiled .= '
					<div class="xgtForumIstatistik-row--sag-s _sutun-bosluk">
						<h2 class="xgtForumIstatistik-tabHeader block-tabHeader">
							<div class="tabs-tab _userTabs">
								';
				if ($__templater->func('property', array('xgt_Frmistatistik_sekme_ikonlari', ), false)) {
					$__finalCompiled .= '
									<i class="fad fa-user-friends"></i>
								';
				}
				$__finalCompiled .= '
								' . 'En çok mesaj' . '
							</div>
							';
				if ($__templater->func('property', array('xgt_Frmistatistik_collapse', ), false)) {
					$__finalCompiled .= '
								<div class="_collapseButton">
									<span class="collapseTrigger is-active" data-xf-click="toggle" data-xf-init="toggle-storage tooltip" 
										  data-target="._xgtIstatistik--blok"  data-storage-key="xgtForumIstatistik" title="' . 'İstatistikleri kapat/aç' . '"></span>
								</div>
							';
				}
				$__finalCompiled .= '
						</h2>
						<div class="_xgtIstatistik--blok">
							<div class="_xgtIstatistik-satir _xgtIstatistik_miniHeader">
								<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--konu">
									' . $__templater->filter($__vars['kullanici-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['kullanici-metin'], array(array('raw', array()),), true) . '
								</div>
								<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--cevap">
									' . $__templater->filter($__vars['mesaj-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['mesaj-metin'], array(array('raw', array()),), true) . '
								</div>
							</div>
							' . $__templater->renderWidget('xgtForumIstatistik_encok_mesaj_kullanici', array(), array()) . '
						</div>
					</div>
				';
			}
			$__finalCompiled .= '
			';
		}
		$__finalCompiled .= '
		</div>
		';
		if ($__vars['xf']['options']['xgtIstatistikOtoyenileme']['otoyenileme']) {
			$__finalCompiled .= '
			' . $__templater->callMacro('xgt_FrmIstatistik.js', 'otoyenile', array(
				'kullanici' => $__vars['kullanici'],
			), $__vars) . '
		';
		}
		$__finalCompiled .= '
		';
		$__templater->includeCss('xgt_FrmIstatistik.less');
		$__finalCompiled .= '
	</div>
';
	}
	return $__finalCompiled;
}
);