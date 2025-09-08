<?php
// FROM HASH: c433ee5b62c07a243245d542034082af
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('	
	<dfn class="formRow-explain">' . 'İstatistik sisteminin gösterileceği konumlardan birini seçiniz. <b>Eğer özel bir konum belirlemek</b> istiyorsanız yukarıdaki seçeneklerden <b>"Kendi konumum"</b> seçin ve aşağıdaki kodu ilgili şablona ekleyiniz:' . '<br><br>		
		<textarea style="color: #c84448;border: solid 1px #c84448;border-left: solid 3px #c84448;background: #fde9e9;" class="input input--fitHeight" rows="1" readonly="readonly" data-xf-init="textarea-handler">&lt;xf:macro template="xgt_FrmIstatistik_konumlar_macros" name="xgt_istatistik_konum" arg-template="" arg-location="kendikonumum" arg-position="!" /&gt;</textarea>
	</dfn>
', array(
		'label' => $__templater->escape($__vars['titleHtml']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['property']['description']),
	));
	return $__finalCompiled;
}
);