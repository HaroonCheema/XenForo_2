<?php
// FROM HASH: c6579f1ef994a58c6cc34652542e03a9
return array(
'macros' => array('xgtStylesKategorikon' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
		'category' => '',
		'forum' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->formCheckBoxRow(array(
		'autosize' => 'true',
	), array(array(
		'name' => 'node[xgt_style_fa_ikon]',
		'selected' => $__vars['node']['xgt_style_fa_ikon'],
		'label' => 'Etkinleştir',
		'data-hide' => 'true',
		'_dependent' => array('
				' . $__templater->formTextBox(array(
		'name' => 'node[xgt_style_fa_ikon]',
		'value' => $__vars['node']['xgt_style_fa_ikon'],
	)) . '
				<span class="formRow-explain">' . ' <b> Kategori ikonu sadece FA ikon olmalıdır. Örnek: fad fa-list-alt</b>' . '</span>
			'),
		'_type' => 'option',
	)), array(
		'label' => 'Kategori ikonunuz',
		'explain' => 'Kategori vurguları için ikon ekleye bilirsiniz, bu fonksiyon sadece <b>XGT Temaları için geçerlidir</b>.',
	)) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);