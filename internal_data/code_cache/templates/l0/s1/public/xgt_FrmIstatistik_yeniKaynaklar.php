<?php
// FROM HASH: 321de5757e873628c5b7a743e8a07295
return array(
'extensions' => array('thread_type_resource' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '	
												<i class="fad fa-cog Konuikonu--konu" aria-hidden="true" title="' . $__templater->filter('Resource', array(array('for_attr', array()),), true) . '" data-xf-init="tooltip" title="' . $__templater->filter('Resource', array(array('for_attr', array()),), true) . '"></i>
												<span class="u-srOnly">' . 'Resource' . '</span>
											';
	return $__finalCompiled;
},
'statuses' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
											' . $__templater->renderExtension('thread_type_resource', $__vars, $__extensions) . '
										';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('xgt_FrmIstatistik_miniHeader_macros', 'Kaynaklar', array(
		'mesaj' => '!',
	), $__vars) . '
';
	if (!$__templater->test($__vars['resources'], 'empty', array())) {
		$__finalCompiled .= ' 
	<ul class="_xgtIstatistik-konuListe">
		  ';
		$__vars['i'] = 0;
		if ($__templater->isTraversable($__vars['resources'])) {
			foreach ($__vars['resources'] AS $__vars['resource']) {
				$__vars['i']++;
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
					if ($__vars['resource']['User'] AND $__templater->method($__vars['resource']['User'], 'isOnline', array())) {
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
					';
				if ($__vars['xf']['options']['xfrmAllowIcons']) {
					$__finalCompiled .= '
						' . $__templater->func('resource_icon', array($__vars['resource'], 's', $__templater->func('link', array('resources', $__vars['resource'], ), false), ), true) . '
						' . $__templater->func('avatar', array($__vars['resource']['User'], 'xxs', false, array(
						'href' => '',
						'class' => 'avatar--separated _istatistikHucre_avatar',
						'tabindex' => '0',
						'data-xf-init' => 'tooltip',
						'data-trigger' => 'auto',
					))) . '
					';
				} else {
					$__finalCompiled .= '
						' . $__templater->func('avatar', array($__vars['resource']['User'], 's', false, array(
						'defaultname' => $__vars['resource']['username'],
					))) . '
					';
				}
				$__finalCompiled .= '
				</div>
				<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--konu">
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
				if ($__vars['resource']['prefix_id']) {
					$__finalCompiled .= '
						';
					if ($__vars['category']) {
						$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('resources/categories', $__vars['category'], array('prefix_id' => $__vars['resource']['prefix_id'], ), ), true) . '" class="labelLink" rel="nofollow">' . $__templater->func('prefix', array('resource', $__vars['resource'], 'html', '', ), true) . '</a>
							';
					} else {
						$__finalCompiled .= '
							';
						if ($__vars['filterPrefix']) {
							$__finalCompiled .= '
								<a href="' . $__templater->func('link', array('resources', null, array('prefix_id' => $__vars['resource']['prefix_id'], ), ), true) . '" class="labelLink" rel="nofollow">' . $__templater->func('prefix', array('resource', $__vars['resource'], 'html', '', ), true) . '</a>
								';
						} else {
							$__finalCompiled .= '
								' . $__templater->func('prefix', array('resource', $__vars['resource'], 'html', '', ), true) . '
							';
						}
						$__finalCompiled .= '
						';
					}
					$__finalCompiled .= '
					';
				}
				$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('resources', $__vars['resource'], ), true) . '" class="" data-tp-primary="on">' . $__templater->escape($__vars['resource']['title']) . '</a>
					';
				if ($__templater->method($__vars['resource'], 'isVersioned', array())) {
					$__finalCompiled .= '
						<span class="u-muted">' . $__templater->escape($__vars['resource']['CurrentVersion']['version_string']) . '</span>
					';
				}
				$__finalCompiled .= '
					';
				if ($__templater->method($__vars['resource'], 'isExternalPurchasable', array())) {
					$__finalCompiled .= '
						<span class="label label--primary label--smallest">' . $__templater->filter($__vars['resource']['price'], array(array('currency', array($__vars['resource']['currency'], )),), true) . '</span>
					';
				}
				$__finalCompiled .= '			
				</div>
				';
				if ($__templater->func('property', array('xgt_Frmistatistik_icerik_forumu', ), false)) {
					$__finalCompiled .= '
					<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--forum" data-xf-init="tooltip" title="' . 'Kategorisi' . '">
						';
					if ($__templater->func('property', array('xgt_Frmistatistik_icerikBilgi_ikonlari', ), false)) {
						$__finalCompiled .= '
							';
						$__compilerTemp1 = '';
						$__compilerTemp1 .= '
										' . $__templater->renderExtension('statuses', $__vars, $__extensions) . '
									';
						if (strlen(trim($__compilerTemp1)) > 0) {
							$__finalCompiled .= '
								<div class="_icerikIkonu">
									' . $__compilerTemp1 . '
								</div>
							';
						}
						$__finalCompiled .= '	
						';
					}
					$__finalCompiled .= '
						';
					if ((!$__vars['category']) OR $__templater->method($__vars['category'], 'hasChildren', array())) {
						$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('resources/categories', $__vars['resource']['Category'], ), true) . '" title="$resource.Category.title}">' . $__templater->escape($__vars['resource']['Category']['title']) . '</a>
						';
					}
					$__finalCompiled .= '
					</div>
				';
				}
				$__finalCompiled .= '
				';
				if ($__templater->func('property', array('xgt_Frmistatistik_mesaj_sayisi', ), false)) {
					$__finalCompiled .= '
					<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--derece">
						' . $__templater->callMacro('rating_macros', 'stars', array(
						'rating' => $__vars['resource']['rating_avg'],
						'class' => 'Derecelendirme',
					), $__vars) . '
					</div>	
				';
				}
				$__finalCompiled .= '
				';
				if ($__templater->func('property', array('xgt_Frmistatistik_zaman_bilgisi', ), false)) {
					$__finalCompiled .= '
					<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--zaman">
						<a href="' . $__templater->func('link', array('resources', $__vars['resource'], ), true) . '" rel="nofollow">' . $__templater->func('date_dynamic', array($__vars['resource']['resource_date'], array(
					))) . '</a>
					</div>	
				';
				}
				$__finalCompiled .= '
				';
				if ($__templater->func('property', array('xgt_Frmistatistik_son_yazan', ), false)) {
					$__finalCompiled .= '
					<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--sonYazan">
						';
					if ($__templater->func('property', array('xgt_Frmistatistik_sonMesaj_avatar', ), false)) {
						$__finalCompiled .= '	
							' . $__templater->func('avatar', array($__vars['resource']['User'], 'xxs', false, array(
							'defaultname' => $__vars['resource']['username'],
						))) . '
						';
					}
					$__finalCompiled .= '
						' . $__templater->func('username_link', array($__vars['resource']['User'], false, array(
						'defaultname' => $__vars['resource']['username'],
					))) . '
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