<?php
// FROM HASH: 3dd58cc1cd4d947feeefbd1ee6d3af4e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// ── Slider wrapper ──────────────────────────────────────────
.attractive-states-slider-wrapper {
	display: flex;
	align-items: center;
	gap: 4px;
	position: relative;
}

.attractive-states-track-outer {
	padding-bottom: 5px;
	overflow: hidden;
	flex: 1;
}

// ── Arrow buttons ───────────────────────────────────────────
.slider-arrow {
	flex-shrink: 0;
	width: 30px;
	height: 30px;
	border-radius: 50%;
	border: 1px solid #1d9f1d;
	background: #ececec;
	color: #1d9f1d;
	font-size: 20px;
	line-height: 1;
	cursor: pointer;
	display: flex;
	align-items: center;
	justify-content: center;
	box-shadow: 0 2px 6px rgba(0,0,0,0.1);
	transition: background 0.2s, transform 0.2s;
	&:hover {
		background: #d4f4d4;
		transform: scale(1.1);
	}
}

// ── Slider list ─────────────────────────────────────────────
.attractive-states {
	display: flex;
	flex-wrap: nowrap;          // KEY: single row
	gap: 8px;
	padding: 4px 2px;
	list-style: none;
	margin: 0;
	overflow-x: auto;           // scrollable
	scroll-snap-type: x mandatory;
	-webkit-overflow-scrolling: touch;
	scrollbar-width: none;      // hide scrollbar Firefox
	&::-webkit-scrollbar { display: none; } // hide scrollbar Chrome

	li {
		flex: 0 0 auto;         // don\'t shrink
		width: auto;          
		min-width: 80px;     
		max-width: 250px;
		scroll-snap-align: start;
		opacity: 0;
		transform: translateY(8px);
		animation: statesFadeUp 0.4s ease forwards;
		&:nth-child(1)    { animation-delay: 0.03s; }
		&:nth-child(2)    { animation-delay: 0.06s; }
		&:nth-child(3)    { animation-delay: 0.09s; }
		&:nth-child(4)    { animation-delay: 0.12s; }
		&:nth-child(5)    { animation-delay: 0.15s; }
		&:nth-child(6)    { animation-delay: 0.18s; }
		&:nth-child(7)    { animation-delay: 0.21s; }
		&:nth-child(8)    { animation-delay: 0.24s; }
		&:nth-child(9)    { animation-delay: 0.27s; }
		&:nth-child(10)   { animation-delay: 0.30s; }
		&:nth-child(11)   { animation-delay: 0.33s; }
		&:nth-child(12)   { animation-delay: 0.36s; }
		&:nth-child(n+13) { animation-delay: 0.39s; }
	}

	.attractive-state {
		display: block;
		text-decoration: none !important;
	}

	.state-title {
		display: flex;
		flex-direction: column;    // ← stack vertically
		align-items: center;
		justify-content: center;
		gap: 4px;                  // ← space between icon and text
		position: relative;
		width: 100%;
		padding: 10px 8px 8px;     // ← a bit more top padding for breathing room
		text-align: center;
		font-size: 13px;
		font-weight: 600;
		letter-spacing: 0.06em;
		color: #141414;
		text-decoration: none;
		cursor: pointer;
		overflow: hidden;
		border-radius: 18px;
		background: #ececec;
		border: 1px solid #1d9f1d;
		box-shadow:
			inset 0 1px 0 rgba(255,255,255,0.75),
			inset 0 -1px 0 rgba(0,0,0,0.06),
			0 2px 6px rgba(0,0,0,0.1);
		transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
		white-space: normal;
		word-break: break-word;
		line-height: 1.3;

		&::before {
			content: \'\';
			position: absolute;
			inset: 0;
			background: linear-gradient(
				110deg,
				transparent 30%,
				rgba(255,255,255,0.55) 50%,
				transparent 70%
			);
			transform: translateX(-100%);
			transition: transform 0.45s ease;
			border-radius: inherit;
		}
		&::after {
			content: \'\';
			position: absolute;
			left: 7px;
			top: 50%;
			transform: translateY(-50%) scale(0);
			width: 4px;
			height: 4px;
			border-radius: 50%;
			background: #1d9f1d;
			box-shadow: 0 0 6px rgba(29,159,29,0.7);
			transition: transform 0.2s ease 0.05s;
		}
	}

	.state-icon {
		display: block;            // ← ensure it\'s on its own line
		object-fit: contain;
		flex-shrink: 0;
		filter: grayscale(20%);
		transition: transform 0.25s ease, filter 0.25s ease;
	}

	.attractive-state:hover .state-icon {
		transform: scale(1.15);
		filter: none;
	}

	.attractive-state:hover {
		text-decoration: none !important;
		.state-title {
			color: #111111;
			background: #e0e0e0;
			border-color: #158015;
			transform: translateY(-2px) scale(1.04);
			&::before { transform: translateX(100%); }
			&::after  { transform: translateY(-50%) scale(1); }
		}
	}

	@media (max-width: 600px) {
		li { width: 80px; min-width: 65px; }
		.state-title { font-size: 12px; padding: 8px 6px 6px; }
	}
}

@keyframes statesFadeUp {
	to { opacity: 1; transform: translateY(0); }
}';
	return $__finalCompiled;
}
);