<?php
// FROM HASH: e150386ead2730e800f560a0f472973b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->includeTemplate('real_time_chat_setup.less', $__vars) . '

.invite-background {
	height: 100%;

	.invite-center {
		display: flex;
		height: 100%;
		width: 100%;
		justify-content: center;
		align-items: center;
	}

	.room-card {
		background: @xf-contentBg;
		box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
		border-radius: 8px;
		min-width: 300px;
		max-width: 450px;
		font-size: 15px;
		
		.section {
			padding: 10px;
			display: flex;
			
			&.section--header {
				align-items: center;
				padding-bottom: 0;
			}
			
			&.section--description {
				padding: 10px 15px;
			}
			
			&.section--join {
				justify-content: end;
				padding-top: 0;
				
				.button {
					.m-chatButton();
					background: var(--primary-color);
					color: #fff;
				}
			}
		}
		
		.room-avatar {
			margin-right: 10px;
		}
		
		.room-name {
			font-size: 18px;
		}
	}
	
	@media (max-width: 450px) {
		.room-card {
			width: 100%;
			border-radius: 0;
		}
	}
}';
	return $__finalCompiled;
}
);