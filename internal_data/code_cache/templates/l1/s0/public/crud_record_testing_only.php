<?php
// FROM HASH: c9d95fb3db2070ae98734c32a54af1c7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<style>
	
	
	.stats-p-body-section{
			margin-bottom:0 !important;
		}

		/* Container to hold the two boxes */
		.statsContainer {
			display: flex; /* Use flexbox */
			justify-content: space-between; /* Add space between the two boxes */
			flex-wrap: wrap; /* Allow wrapping to the next line on smaller screens */
		}

		/* Styles for the individual boxes */
		.statsBox {
			display: block;
			box-sizing: border-box; /* Include padding and border in the box\'s total width */
			margin-bottom: 5px; /* Add some space between the boxes */
		}
	
	.myContainer {
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
		margin: 0 auto;
		width: 100%;
	}

	.myBox {
		background-color: #eee;
		border: 1px solid #ddd; /* Added border definition */
		border-radius: 4px;
		width: 24%;
		margin-bottom: 10px;
	}

	.myBox-heading {
		font-size: 18px;
		font-weight: bold;
		margin-bottom: 10px;
		text-align: center;
		border-bottom: 1px solid #ddd;
		padding-bottom: 10px;
	}

	.myBox-body{
		text-align: center;
	}

	@media screen and (max-width: 768px) {
		.myBox {
			width: 45%;
		}
	}

	@media screen and (max-width: 480px) {
		.myBox {
			width: 100%;
		}
	}

	.myContainer1 {
		display: flex;
		flex-wrap: wrap;
		justify-content: space-around;
		margin: 0 auto;
		width: 100%;
	}

</style>


	<div class="stats-p-body-section">
		<div class="p-body-section-header">
			<div class="statsContainer">
				<div class="statsBox">
					<h2>Stats</h2>
				</div>

				';
	if (true) {
		$__finalCompiled .= '

					<div class="statsBox">
						<h2><i class="fas fa-chevron-right"></i></h2>
					</div>

				';
	}
	$__finalCompiled .= '
			</div>
		</div>
	</div>

<div class="myContainer">
	<div class="myBox">
		<h1 class="myBox-heading"><i class="fa fa-tv"></i> TV time</h1>
		<div class="myContainer1">
			<div class="myBox-body">
				<h2>
					1
				</h2>
				<h5>
					MONTH
				</h5>
			</div>
			<div class="myBox-body">
				<h2>
					0
				</h2>
				<h5>
					DAYS
				</h5>
			</div>

			<div class="myBox-body">
				<h2>
					22
				</h2>
				<h5>
					HOURS
				</h5>
			</div>
		</div>
	</div>
	<div class="myBox">
		<h1 class="myBox-heading"><i class="fa fa-tv"></i> Episode watched</h1>
		<div class="myBox-body">
			<h1>
				1,974
			</h1>
		</div>
	</div>
	<div class="myBox">
		<h1 class="myBox-heading"><i class="fa fa-film"></i> Movie time</h1>
		<div class="myContainer1">
			<div class="myBox-body">
				<h2>
					0
				</h2>
				<h5>
					MONTH
				</h5>
			</div>
			<div class="myBox-body">
				<h2>
					2
				</h2>
				<h5>
					DAYS
				</h5>
			</div>

			<div class="myBox-body">
				<h2>
					21
				</h2>
				<h5>
					HOURS
				</h5>
			</div>
		</div>
	</div>
	<div class="myBox">
		<h1 class="myBox-heading"><i class="fa fa-film"></i> Movie watched</h1>
		<div class="myBox-body">
			<h1>
				38
			</h1>
		</div>
	</div>
</div>






' . '

' . '

		' . '

		';
	return $__finalCompiled;
}
);