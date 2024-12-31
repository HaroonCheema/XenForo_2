<?php
// FROM HASH: 5bd7e104dbd3cf90c68e3747af64c25f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.badge-category-edit, .badge-edit {
	
	.image-icon-description {
		text-align: center;
		font-style: italic;
 	}
	
	.image-icon-description.yellow { color: GoldenRod;}
	.image-icon-description.blue   { color: @xf-borderColorFeature;}
	.image-icon-description.purple { color: indigo;}
	.image-icon-description.grey   { color: @xf-textColorMuted;}
	
	.image-icon-preview{
		margin-top: @xf-elementSpacer;
		padding: @xf-paddingLarge;
		max-height: 150px;
		max-width: 150px;
	}
	
	.image-icon-preview.yellow {
		border: 2px dashed GoldenRod;
		background: LightGoldenRodYellow;
	}
	
	.image-icon-preview.blue {
		border: 2px dashed @xf-borderColorFeature;
		background: @xf-contentHighlightBg;
	}
	
	.image-icon-preview.purple {
		border: 2px dashed indigo;
		background: lavender;
	}
	
	.image-icon-preview.grey {
		border: 2px dashed @xf-textColorMuted;
		background: LightGrey;
	}
	
}

.badge-list {
	.category, .badgeLi {
		.icon {			
			img {
				display: block;
				width: 22px;
				height: 22px;
				max-width: 22px;
			}
		}
	}
	
	.badgeLi {
		.has-userCriteria {
			float: right;
			color: @xf-textColorMuted;
			position: relative;
			top: 3px;
		}
	}
}

.badge-modal-message {
	text-align: center;
}';
	return $__finalCompiled;
}
);