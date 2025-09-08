<?php
// FROM HASH: e2b7f2a82d558a0702ed90a0dc7df163
return array(
'macros' => array('genelSeklemler' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'genel' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if (($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metin') OR ($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metinikon')) {
		$__finalCompiled .= '
		';
		$__vars['konu-metin'] = $__templater->preEscaped('Konu');
		$__finalCompiled .= '
		';
		$__vars['forum-metin'] = $__templater->preEscaped('Forumu');
		$__finalCompiled .= '
		';
		$__vars['cevap-metin'] = $__templater->preEscaped('Cevap');
		$__finalCompiled .= '
		';
		$__vars['goruntuleme-metin'] = $__templater->preEscaped('Görüntüleme');
		$__finalCompiled .= '
		';
		$__vars['zaman-metin'] = $__templater->preEscaped('Gönderim');
		$__finalCompiled .= '
		';
		$__vars['sonyazan-metin'] = $__templater->preEscaped('Son yazan');
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
	';
	if (($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'ikon') OR ($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metinikon')) {
		$__finalCompiled .= '
		';
		$__vars['konu-ikon'] = $__templater->preEscaped('<i class="fal fa-comments"></i>');
		$__finalCompiled .= '
		';
		$__vars['forum-ikon'] = $__templater->preEscaped('<i class="fal fa-list-alt"></i>');
		$__finalCompiled .= '
		';
		$__vars['cevap-ikon'] = $__templater->preEscaped('<i class="fal fa-comment-dots"></i>');
		$__finalCompiled .= '
		';
		$__vars['goruntuleme-ikon'] = $__templater->preEscaped('<i class="fal fa-eye"></i>');
		$__finalCompiled .= '
		';
		$__vars['zaman-ikon'] = $__templater->preEscaped('<i class="fal fa-clock"></i>');
		$__finalCompiled .= '
		';
		$__vars['sonyazan-ikon'] = $__templater->preEscaped('<i class="fal fa-reply"></i>');
		$__finalCompiled .= '	
	';
	}
	$__finalCompiled .= '
	<div class="_xgtIstatistik-satir _xgtIstatistik_miniHeader">
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_sira_numarasi', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--sira"><i class="fal fa-sort-numeric-down"></i></div>
		';
	}
	$__finalCompiled .= '
		<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--avatar"></div>
		<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--konu">
			' . $__templater->filter($__vars['konu-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['konu-metin'], array(array('raw', array()),), true) . '
		</div>
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_icerik_forumu', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--forum">
				' . $__templater->filter($__vars['forum-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['forum-metin'], array(array('raw', array()),), true) . '
			</div>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_mesaj_sayisi', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--cevap">
				' . $__templater->filter($__vars['cevap-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['cevap-metin'], array(array('raw', array()),), true) . '
			</div>
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--goruntuleme">
				' . $__templater->filter($__vars['goruntuleme-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['goruntuleme-metin'], array(array('raw', array()),), true) . '
			</div>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_zaman_bilgisi', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--zaman">
				' . $__templater->filter($__vars['zaman-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['zaman-metin'], array(array('raw', array()),), true) . '
			</div>	
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_son_yazan', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--sonYazan">
				' . $__templater->filter($__vars['sonyazan-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['sonyazan-metin'], array(array('raw', array()),), true) . '
			</div>
		';
	}
	$__finalCompiled .= '		  
	</div>
';
	return $__finalCompiled;
}
),
'encoktepki' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'encoktepki' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if (($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metin') OR ($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metinikon')) {
		$__finalCompiled .= '
		';
		$__vars['konu-metin'] = $__templater->preEscaped('Konu');
		$__finalCompiled .= '
		';
		$__vars['forum-metin'] = $__templater->preEscaped('Forumu');
		$__finalCompiled .= '
		';
		$__vars['cevap-metin'] = $__templater->preEscaped('Beğenileri');
		$__finalCompiled .= '
		';
		$__vars['goruntuleme-metin'] = $__templater->preEscaped('Görüntüleme');
		$__finalCompiled .= '
		';
		$__vars['zaman-metin'] = $__templater->preEscaped('Gönderim');
		$__finalCompiled .= '
		';
		$__vars['sonyazan-metin'] = $__templater->preEscaped('Konu başlatan');
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
	';
	if (($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'ikon') OR ($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metinikon')) {
		$__finalCompiled .= '
		';
		$__vars['konu-ikon'] = $__templater->preEscaped('<i class="fal fa-comments"></i>');
		$__finalCompiled .= '
		';
		$__vars['forum-ikon'] = $__templater->preEscaped('<i class="fal fa-list-alt"></i>');
		$__finalCompiled .= '
		';
		$__vars['cevap-ikon'] = $__templater->preEscaped('<i class="fal fa-thumbs-up"></i>');
		$__finalCompiled .= '
		';
		$__vars['goruntuleme-ikon'] = $__templater->preEscaped('<i class="fal fa-eye"></i>');
		$__finalCompiled .= '
		';
		$__vars['zaman-ikon'] = $__templater->preEscaped('<i class="fal fa-clock"></i>');
		$__finalCompiled .= '
		';
		$__vars['sonyazan-ikon'] = $__templater->preEscaped('<i class="fal fa-user-crown"></i>');
		$__finalCompiled .= '	
	';
	}
	$__finalCompiled .= '		
	<div class="_xgtIstatistik-satir _xgtIstatistik_miniHeader">
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_sira_numarasi', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--sira"><i class="fal fa-sort-numeric-down"></i></div>
		';
	}
	$__finalCompiled .= '
		<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--avatar"></div>
		<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--konu">
			' . $__templater->filter($__vars['konu-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['konu-metin'], array(array('raw', array()),), true) . '
		</div>
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_icerik_forumu', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--forum">
				' . $__templater->filter($__vars['forum-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['forum-metin'], array(array('raw', array()),), true) . '
			</div>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_mesaj_sayisi', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--cevap">
				' . $__templater->filter($__vars['cevap-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['cevap-metin'], array(array('raw', array()),), true) . '
			</div>
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--goruntuleme">
				' . $__templater->filter($__vars['goruntuleme-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['goruntuleme-metin'], array(array('raw', array()),), true) . '
			</div>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_zaman_bilgisi', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--zaman">
				' . $__templater->filter($__vars['zaman-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['zaman-metin'], array(array('raw', array()),), true) . '
			</div>	
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_son_yazan', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--sonYazan">
				' . $__templater->filter($__vars['sonyazan-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['sonyazan-metin'], array(array('raw', array()),), true) . '
			</div>
		';
	}
	$__finalCompiled .= '		  
	</div>
';
	return $__finalCompiled;
}
),
'goruntuleme' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'goruntuleme' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if (($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metin') OR ($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metinikon')) {
		$__finalCompiled .= '
		';
		$__vars['konu-metin'] = $__templater->preEscaped('Konu');
		$__finalCompiled .= '
		';
		$__vars['forum-metin'] = $__templater->preEscaped('Forumu');
		$__finalCompiled .= '
		';
		$__vars['cevap-metin'] = $__templater->preEscaped('Cevap');
		$__finalCompiled .= '
		';
		$__vars['goruntuleme-metin'] = $__templater->preEscaped('Görüntüleme');
		$__finalCompiled .= '
		';
		$__vars['zaman-metin'] = $__templater->preEscaped('Gönderim');
		$__finalCompiled .= '
		';
		$__vars['sonyazan-metin'] = $__templater->preEscaped('Konu başlatan');
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
	';
	if (($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'ikon') OR ($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metinikon')) {
		$__finalCompiled .= '
		';
		$__vars['konu-ikon'] = $__templater->preEscaped('<i class="fal fa-comments"></i>');
		$__finalCompiled .= '
		';
		$__vars['forum-ikon'] = $__templater->preEscaped('<i class="fal fa-list-alt"></i>');
		$__finalCompiled .= '
		';
		$__vars['cevap-ikon'] = $__templater->preEscaped('<i class="fal fa-comment-dots"></i>');
		$__finalCompiled .= '
		';
		$__vars['goruntuleme-ikon'] = $__templater->preEscaped('<i class="fal fa-eye"></i>');
		$__finalCompiled .= '
		';
		$__vars['zaman-ikon'] = $__templater->preEscaped('<i class="fal fa-clock"></i>');
		$__finalCompiled .= '
		';
		$__vars['sonyazan-ikon'] = $__templater->preEscaped('<i class="fal fa-user-crown"></i>');
		$__finalCompiled .= '	
	';
	}
	$__finalCompiled .= '		
	<div class="_xgtIstatistik-satir _xgtIstatistik_miniHeader">
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_sira_numarasi', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--sira"><i class="fal fa-sort-numeric-down"></i></div>
		';
	}
	$__finalCompiled .= '
		<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--avatar"></div>
		<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--konu">
			' . $__templater->filter($__vars['konu-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['konu-metin'], array(array('raw', array()),), true) . '
		</div>
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_icerik_forumu', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--forum">
				' . $__templater->filter($__vars['forum-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['forum-metin'], array(array('raw', array()),), true) . '
			</div>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_mesaj_sayisi', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--cevap">
				' . $__templater->filter($__vars['cevap-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['cevap-metin'], array(array('raw', array()),), true) . '
			</div>
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--goruntuleme">
				' . $__templater->filter($__vars['goruntuleme-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['goruntuleme-metin'], array(array('raw', array()),), true) . '
			</div>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_zaman_bilgisi', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--zaman">
				' . $__templater->filter($__vars['zaman-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['zaman-metin'], array(array('raw', array()),), true) . '
			</div>	
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_son_yazan', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--sonYazan">
				' . $__templater->filter($__vars['sonyazan-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['sonyazan-metin'], array(array('raw', array()),), true) . '
			</div>
		';
	}
	$__finalCompiled .= '		  
	</div>
';
	return $__finalCompiled;
}
),
'Kaynaklar' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'mesaj' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if (($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metin') OR ($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metinikon')) {
		$__finalCompiled .= '
		';
		$__vars['kaynak-metin'] = $__templater->preEscaped('Kaynak');
		$__finalCompiled .= '
		';
		$__vars['kategori-metin'] = $__templater->preEscaped('Kategorisi');
		$__finalCompiled .= '
		';
		$__vars['derece-metin'] = $__templater->preEscaped('Derece');
		$__finalCompiled .= '
		';
		$__vars['zaman-metin'] = $__templater->preEscaped('Gönderim');
		$__finalCompiled .= '
		';
		$__vars['sonyazan-metin'] = $__templater->preEscaped('Oluşturan');
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
	';
	if (($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'ikon') OR ($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'metinikon')) {
		$__finalCompiled .= '
		';
		$__vars['kaynak-ikon'] = $__templater->preEscaped('<i class="fal fa-download" aria-hidden="true"></i>');
		$__finalCompiled .= '
		';
		$__vars['kategori-ikon'] = $__templater->preEscaped('<i class="fal fa-list-alt"></i>');
		$__finalCompiled .= '
		';
		$__vars['derece-ikon'] = $__templater->preEscaped('<i class="fal fa-stars"></i>');
		$__finalCompiled .= '
		';
		$__vars['zaman-ikon'] = $__templater->preEscaped('<i class="fal fa-clock"></i>');
		$__finalCompiled .= '
		';
		$__vars['sonyazan-ikon'] = $__templater->preEscaped('<i class="fal fa-user-crown"></i>');
		$__finalCompiled .= '	
	';
	}
	$__finalCompiled .= '	
	<div class="_xgtIstatistik-satir _xgtIstatistik_miniHeader">
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_sira_numarasi', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--sira"><i class="fal fa-sort-numeric-down"></i></div>
		';
	}
	$__finalCompiled .= '
		<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--avatar"></div>
		<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--konu">
			' . $__templater->filter($__vars['kaynak-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['kaynak-metin'], array(array('raw', array()),), true) . '
		</div>
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_icerik_forumu', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--forum">
				' . $__templater->filter($__vars['kategori-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['kategori-metin'], array(array('raw', array()),), true) . '
			</div>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_mesaj_sayisi', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--derece">
				' . $__templater->filter($__vars['derece-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['derece-metin'], array(array('raw', array()),), true) . '
			</div>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_zaman_bilgisi', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--zaman">
				' . $__templater->filter($__vars['zaman-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['zaman-metin'], array(array('raw', array()),), true) . '
			</div>	
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_son_yazan', ), false)) {
		$__finalCompiled .= '
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--sonYazan">
				' . $__templater->filter($__vars['sonyazan-ikon'], array(array('raw', array()),), true) . $__templater->filter($__vars['sonyazan-metin'], array(array('raw', array()),), true) . '
			</div>
		';
	}
	$__finalCompiled .= '		  
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
' . '
' . '
';
	return $__finalCompiled;
}
);