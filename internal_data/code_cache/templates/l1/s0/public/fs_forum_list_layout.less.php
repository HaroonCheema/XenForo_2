<?php
// FROM HASH: 8bf803a95a9a64d7f1cb23cc3e67a290
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.fs-grid-list {
 	display: grid !important;
    grid-template-columns: repeat(3, 1fr);
}

@media (max-width:650px)
{
	.fs-grid-list 
	{
		grid-template-columns: repeat(2, 1fr);
	}
}

[data-template="forum_list"]
{
	.node-stats,
	.node-extra,
	.node-statsMeta
	{
		display:none !important;
	}
}';
	return $__finalCompiled;
}
);