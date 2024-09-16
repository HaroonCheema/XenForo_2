<?php
// FROM HASH: 299dd3a97691de2ba4e619fb59589dee
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@_input-textColor: xf-default(@xf-input--color, @xf-textColor);

.select2-search--dropdown .select2-search__field,
.structItemContainer .select2-search__field,
{
	font-size: @xf-fontSizeNormal;
}

.structItemContainer
{
	.input.prefix--title
	{
		.select2-selection__choice
		{
			padding-bottom: 4px !important;
		}
	}
}

.js-filterMenuBody
{
	.select2 .select2-selection ul > li.select2-selection__choice
	{
		font-size: inherit;
		margin-top: 3px;
	}

	.select2 .select2-selection ul
	{
		margin-bottom: 3px;
	}

	.select2-results__option .label
	{
		font-size:inherit;
	}
}

.select2 .select2-selection__choice .label
{
	position: relative;
	top: -2px;
}

.input.prefix--title
{
	.select2-selection__choice
	{
		padding-top: 2px !important;
	}

	.select2-search__field
	{
		.m-placeholder({color: fade(@_input-textColor, 40%); });
		margin-bottom: -4px;

		&:focus,
		&.is-focused
		{
			outline: 0;
			.xf-inputFocus();
			.m-placeholder({color: fade(@_input-textColor, 50%); });
		}
	}
}

select[id^=js-SVMultiPrefixUniqueId]
{
	+.select2 // this is the actual container
	{
		.select2-selection--single
		{
			padding: 5px;

			.select2-selection__rendered
			{
				margin: 0;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
			}
		}
	}
}

ul[id^=select2-js-SVMultiPrefixUniqueId][id$=-results]
{
	overflow-x: auto;
	max-height: 31.250em;

	@media (max-width: @xf-responsiveMedium)
	{
		max-height: 25.000em;
	}

	@media (max-width: @xf-responsiveNarrow)
	{
		max-height: 15.625em;
	}

	.select2-results__options
	{
		overflow: visible;
		max-height: none;
		-webkit-overflow-scrolling: auto;
	}

	ul.select2-results__options--nested
	{
		max-width: 100% !important;
		box-shadow: none !important;
		li.select2-results__option > span
		{
			padding:0;
		}
	}

	li.select2-results__option
	{
		&[aria-selected="true"]
		{
			.label
			{
				.xf-chip();
			}
		}
	}
}

.select2-dropdown--forceHide
{
	> .select2-search
	{
		display: none;
	}
}

.prefixContainer + .inputGroup
{
	margin-top: 1em;
}';
	return $__finalCompiled;
}
);