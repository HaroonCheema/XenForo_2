<?php
// FROM HASH: 1f19e1e72438011caef29ee51885a929
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.gallery {
	display: flex;
	flex-wrap: wrap;
	justify-content: space-around; /* Adjust alignment as needed */
}

.image-wrapper {
	flex: 0 0 calc(4% - 1px); /* Adjust width and margin as needed */
	margin: 10px 20px;
}

.image-wrapper img {
	width: 100%;
	height: auto;
}

@media (max-width: 768px) {
	.image-wrapper {
		flex: 0 0 calc(5% - 1px); /* Adjust width and margin for small screens */
		margin: 10px 20px;

	}
}

@media (max-width: 359px)
{

}

@media (max-width: 376px)
{
	.image-wrapper {
		flex: 0 0 calc(20% - 1px); /* Adjust width and margin for small screens */
		padding: 0px 15px;
		margin: 10px 0px;

	}
}

@media (max-width: 415px)
{
	
}

@media (max-width: 768px)
{

}


@media (max-width: 800px)
{

}


@media (max-width: 900px)
{

}';
	return $__finalCompiled;
}
);