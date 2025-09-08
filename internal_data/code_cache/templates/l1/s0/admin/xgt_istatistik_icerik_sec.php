<?php
// FROM HASH: 1d42622a89e97b5912b5174a60dda98d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Sekme içerik türünü seçiniz');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formSelectRow(array(
		'name' => 'type',
		'data-xf-init' => 'show-hide-select',
		'value' => $__vars['forumIstatistikIcerik']['icerik_id'],
	), array(array(
		'type' => 'threads',
		'value' => 'yeni_mesajlar',
		'label' => 'Yeni mesajlar',
		'_type' => 'option',
	),
	array(
		'type' => 'threads',
		'value' => 'yeni_konular',
		'label' => 'Yeni konular',
		'_type' => 'option',
	),
	array(
		'type' => 'threads',
		'value' => 'encok_tepki',
		'label' => 'En çok tepki',
		'_type' => 'option',
	),
	array(
		'type' => 'threads',
		'value' => 'encok_mesaj',
		'label' => 'En çok mesaj',
		'_type' => 'option',
	),
	array(
		'type' => 'threads',
		'value' => 'encok_goruntulenen',
		'label' => 'En çok görüntülenen',
		'_type' => 'option',
	),
	array(
		'type' => 'resources',
		'value' => 'yeni_kaynaklar',
		'label' => 'Yeni kaynaklar',
		'_type' => 'option',
	)), array(
		'label' => 'İçerik türü',
		'explain' => 'İstatistiklere sisteminde göstermek istediğiniz veri türünü seçiniz.',
	)) . '				
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'içeriği ekle',
		'icon' => 'add',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('forum-istatistik/ekle', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);