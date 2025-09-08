<?php
// FROM HASH: fe0797304b2622e5739e1a4e87594b8e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['forumIstatistik'], 'isInsert', array())) {
		$__finalCompiled .= '
    ';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('İstatistik sekmesi ekle');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
    ';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Düzenlenen sekme' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['forumIstatistik']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['forumIstatistik'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
    ' . $__templater->button('', array(
			'href' => $__templater->func('link', array('forum-istatistik/liste/sil', $__vars['forumIstatistik'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['forumIstatistik']['veri_ikonu']) {
		$__compilerTemp1 .= '
						<div style="color: #47a7eb; width: 100px; text-align: center;background: #f7fbfe;border: solid 1px #cbcbcb; border-radius: 4px; line-height: 2; font-size: 30px;"><i class="' . $__templater->escape($__vars['forumIstatistik']['veri_ikonu']) . '"></i></div>
					';
	}
	$__compilerTemp2 = array(array(
		'value' => 'anaveri',
		'label' => 'Konum seç',
		'_type' => 'option',
	));
	$__compilerTemp2 = $__templater->mergeChoiceOptions($__compilerTemp2, $__vars['forumIstatistik']['pozisyonlar']);
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
	 	<div class="block-body">
		  	' . $__templater->formRow('
					' . $__templater->escape($__vars['forumIstatistikIcerik']['title']) . '
					' . $__templater->formHiddenVal('icerik_id', $__vars['forumIstatistikIcerik']['icerik_id'], array(
	)) . '
		  	', array(
		'label' => 'İçerik türü',
	)) . '
		  	' . $__templater->formTextBoxRow(array(
		'name' => 'custom_title',
		'value' => $__vars['forumIstatistik']['custom_title'],
		'maxlength' => $__templater->func('max_length', array($__vars['forumIstatistik'], 'custom_title', ), false),
	), array(
		'label' => 'Title',
		'explain' => 'Dilerseniz istatistik sekmesi için bir başlık berlileyebilirsiniz. Eğer başlık eklenmez ise sekme verisi başlığı kullanılacaktır. İlgili sekmenin içeriği' . $__vars['xf']['language']['label_separator'] . ' <b>' . $__templater->escape($__vars['forumIstatistikIcerik']['title']) . '</b>',
	)) . '
			
			' . $__templater->formRow('
				<div class="inputGroup">
					' . $__templater->formTextBox(array(
		'name' => 'veri_ikonu',
		'value' => $__vars['forumIstatistik']['veri_ikonu'],
		'maxlength' => $__templater->func('max_length', array($__vars['forumIstatistik'], 'veri_ikonu', ), false),
	)) . '
					<span class="inputGroup-splitter"></span>
					' . $__compilerTemp1 . '	
				</div>
			', array(
		'label' => 'Sekme ikonu',
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => 'Bu sekmeye bir Font Awesome ikonu ekleyebilirsiniz. İkonun HTML class ismini ekmeniz yeterli.<br>
<b>Örnek :</b> fad fa-alarm-exclamation',
		'html' => $__templater->escape($__vars['listedHtml']),
	)) . '
		  	<div name="pozinyon" value="anaveri" label="' . 'Konum seç' . '" source="' . $__templater->escape($__vars['forumIstatistik']['pozisyonlar']) . '" style="display:none;">
		  		' . $__templater->formSelectRow(array(
		'name' => 'pozinyon',
		'value' => 'anaveri',
		'style' => 'display:none;',
	), $__compilerTemp2, array(
		'label' => 'Konum seç',
	)) . '
		  	</div>
		  	' . $__templater->formNumberBoxRow(array(
		'name' => 'display_order',
		'value' => ($__vars['forumIstatistik']['display_order'] ?: 5),
		'min' => '0',
		'required' => 'required',
	), array(
		'label' => 'Display order',
	)) . '
			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'active',
		'selected' => $__vars['forumIstatistik']['active'],
		'label' => 'Yes',
		'_type' => 'option',
	)), array(
		'label' => 'Aktif',
	)) . '
		  	' . $__templater->filter($__templater->method($__vars['forumIstatistik'], 'renderOptions', array()), array(array('raw', array()),), true) . '
	 	</div>
	 	' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('forum-istatistik/liste/save', $__vars['forumIstatistik'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);