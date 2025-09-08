<?php
// FROM HASH: eaa70ecc407a21d8f89aeb54d7f8c188
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('xgt_FrmIstatistik_miniHeader_macros', 'genelSeklemler', array(
		'genel' => '!',
	), $__vars) . '
';
	if (!$__templater->test($__vars['threads'], 'empty', array())) {
		$__finalCompiled .= '
	<ul class="_xgtIstatistik-konuListe">
		';
		if ($__templater->isTraversable($__vars['threads'])) {
			foreach ($__vars['threads'] AS $__vars['thread']) {
				$__finalCompiled .= '
			<li class="_xgtIstatistik-satir">
				';
				if ($__templater->func('property', array('xgt_Frmistatistik_sira_numarasi', ), false)) {
					$__finalCompiled .= '
					<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--sira _sayisal"></div>
				';
				}
				$__finalCompiled .= '
				<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--avatar">
					';
				if ($__templater->func('property', array('xgt_Frmistatistik_online_durumu', ), false)) {
					$__finalCompiled .= '
						';
					if ($__vars['thread']['User'] AND $__templater->method($__vars['thread']['User'], 'isOnline', array())) {
						$__finalCompiled .= '
							<span class="_xgtIstatistik-satir--avatar-online" tabindex="0" data-xf-init="tooltip" data-trigger="auto" title="' . 'Şu an çevrim içi' . '"></span>
						';
					} else {
						$__finalCompiled .= '
							<span class="_xgtIstatistik-satir--avatar-offlline" tabindex="0" data-xf-init="tooltip" data-trigger="auto" title="' . 'Şu an çevrim dışı' . '"></span>
						';
					}
					$__finalCompiled .= '
					';
				}
				$__finalCompiled .= '					
					' . $__templater->func('avatar', array($__vars['thread']['User'], 's', false, array(
					'defaultname' => $__vars['thread']['username'],
				))) . '
					';
				if ($__templater->method($__vars['thread'], 'getUserPostCount', array())) {
					$__finalCompiled .= '
						' . $__templater->func('avatar', array($__vars['xf']['visitor'], 'xxs', false, array(
						'href' => '',
						'class' => 'avatar--separated _istatistikHucre_avatar',
						'tabindex' => '0',
						'data-xf-init' => 'tooltip',
						'data-trigger' => 'auto',
						'title' => 'You have posted ' . $__templater->method($__vars['thread'], 'getUserPostCount', array()) . ' message(s) in this thread',
					))) . '
					';
				}
				$__finalCompiled .= '		
				</div>
				<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--konu structItem--thread' . ($__vars['thread']['prefix_id'] ? (' is-prefix' . $__templater->escape($__vars['thread']['prefix_id'])) : '') . ' ' . ($__templater->method($__vars['thread'], 'isIgnored', array()) ? ' is-ignored' : '') . ' ' . (($__templater->method($__vars['thread'], 'isUnread', array()) AND (!$__vars['forceRead'])) ? ' _yeniIcerik' : '') . ' ' . (($__vars['thread']['discussion_state'] == 'moderated') ? ' is-moderated' : '') . ' ' . (($__vars['thread']['discussion_state'] == 'deleted') ? ' is-deleted' : '') . ' js-inlineModContainer js-threadListItem-' . $__templater->escape($__vars['thread']['thread_id']) . '" 
				 	data-author="' . ($__templater->escape($__vars['thread']['User']['username']) ?: $__templater->escape($__vars['thread']['username'])) . '">
					';
				if ($__templater->func('property', array('xgt_Frmistatistik_google_buton', ), false)) {
					$__finalCompiled .= '
						<a href="http://www.google.com/search?hl=tr&amp;q=' . $__templater->escape($__vars['thread']['title']) . '" title="' . $__templater->escape($__vars['thread']['title']) . '" target="_blank">
							<div class="_googleButon">
								<i class="fab fa-google" title="' . 'Google arama yap' . '"></i>
							</div>
						</a>
					';
				}
				$__finalCompiled .= '
					';
				$__vars['canPreview'] = $__templater->method($__vars['thread'], 'canPreview', array());
				$__finalCompiled .= '
					';
				if ($__vars['thread']['prefix_id']) {
					$__finalCompiled .= '
						';
					if ($__vars['forum']) {
						$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('forums', $__vars['forum'], array('prefix_id' => $__vars['thread']['prefix_id'], ), ), true) . '" class="labelLink" rel="nofollow">' . $__templater->func('prefix', array('thread', $__vars['thread'], 'html', '', ), true) . '</a>
						';
					} else {
						$__finalCompiled .= '
							' . $__templater->func('prefix', array('thread', $__vars['thread'], 'html', '', ), true) . '
						';
					}
					$__finalCompiled .= '
					';
				}
				$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('threads' . (($__templater->method($__vars['thread'], 'isUnread', array()) AND (!$__vars['forceRead'])) ? '/unread' : ''), $__vars['thread'], ), true) . '" class="" data-tp-primary="on" data-xf-init="' . ($__vars['canPreview'] ? 'preview-tooltip' : '') . '" data-preview-url="' . ($__vars['canPreview'] ? $__templater->func('link', array('threads/preview', $__vars['thread'], ), true) : '') . '">' . $__templater->escape($__vars['thread']['title']) . '</a>
				</div>
				';
				if ($__templater->func('property', array('xgt_Frmistatistik_icerik_forumu', ), false)) {
					$__finalCompiled .= '
					<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--forum">
						';
					if ($__templater->func('property', array('xgt_Frmistatistik_icerikBilgi_ikonlari', ), false)) {
						$__finalCompiled .= '
							' . $__templater->includeTemplate('xgt_FrmIstatistik_icerikIkonlari', $__vars) . '
						';
					}
					$__finalCompiled .= '
						<a href="' . $__templater->func('link', array('forums', $__vars['thread']['Forum'], ), true) . '" title="' . $__templater->escape($__vars['thread']['Forum']['title']) . '">' . $__templater->escape($__vars['thread']['Forum']['title']) . '</a>
					</div>
				';
				}
				$__finalCompiled .= '
				';
				if ($__templater->func('property', array('xgt_Frmistatistik_mesaj_sayisi', ), false)) {
					$__finalCompiled .= '
					<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--cevap" data-xf-init="tooltip" title="' . 'Cevap' . '">
						' . (($__vars['thread']['discussion_type'] == 'redirect') ? '&ndash;' : $__templater->filter($__vars['thread']['reply_count'], array(array('number', array()),), true)) . '
					</div>	
					<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--goruntuleme" data-xf-init="tooltip" title="' . 'Görüntüleme' . '">
						' . (($__vars['thread']['discussion_type'] == 'redirect') ? '&ndash;' : (($__vars['thread']['view_count'] > $__vars['thread']['reply_count']) ? $__templater->filter($__vars['thread']['view_count'], array(array('number_short', array(1, )),), true) : $__templater->func('number', array($__templater->filter($__vars['thread']['reply_count'], array(array('number_short', array(1, )),), false), ), true))) . '
					</div>	
				';
				}
				$__finalCompiled .= '
		
				';
				if ($__templater->func('property', array('xgt_Frmistatistik_zaman_bilgisi', ), false)) {
					$__finalCompiled .= '
					<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--zaman">
						';
					if ($__vars['thread']['discussion_type'] == 'redirect') {
						$__finalCompiled .= '
							' . 'N/A' . '
						';
					} else {
						$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('threads/latest', $__vars['thread'], ), true) . '" rel="nofollow">' . $__templater->func('date_dynamic', array($__vars['thread']['last_post_date'], array(
							'class' => 'structItem-latestDate',
						))) . '</a>
						';
					}
					$__finalCompiled .= '
					</div>	
				';
				}
				$__finalCompiled .= '
				';
				if ($__templater->func('property', array('xgt_Frmistatistik_son_yazan', ), false)) {
					$__finalCompiled .= '
					<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--sonYazan">
						';
					if ($__vars['thread']['discussion_type'] == 'redirect') {
						$__finalCompiled .= '
							';
						if ($__templater->func('property', array('xgt_Frmistatistik_sonMesaj_avatar', ), false)) {
							$__finalCompiled .= '
								' . $__templater->func('avatar', array(null, 'xs', false, array(
							))) . '
							';
						}
						$__finalCompiled .= '
							' . 'N/A' . '
						';
					} else {
						$__finalCompiled .= '
							';
						if ($__templater->method($__vars['xf']['visitor'], 'isIgnoring', array($__vars['thread']['last_post_user_id'], ))) {
							$__finalCompiled .= '
								' . 'Ignored member' . '
							';
						} else {
							$__finalCompiled .= '
								';
							if ($__templater->func('property', array('xgt_Frmistatistik_sonMesaj_avatar', ), false)) {
								$__finalCompiled .= '
									' . $__templater->func('avatar', array($__vars['thread']['User'], 'xxs', false, array(
									'defaultname' => $__vars['thread']['User'],
								))) . '
								';
							}
							$__finalCompiled .= '					
								' . $__templater->func('username_link', array($__vars['thread']['User'], false, array(
								'defaultname' => $__vars['thread']['username'],
							))) . '
							';
						}
						$__finalCompiled .= '
						';
					}
					$__finalCompiled .= '
					</div>
				';
				}
				$__finalCompiled .= '
			</li>
		';
			}
		}
		$__finalCompiled .= '
	</ul>
';
	} else {
		$__finalCompiled .= '
	 <div class="block-row">
		  ' . 'No results found.' . '
	 </div>
';
	}
	return $__finalCompiled;
}
);