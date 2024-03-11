<?php
<<<<<<< HEAD
// FROM HASH: 90d4164f00951f46999e60281d5d6819
=======
// FROM HASH: e6033cdc76d0864b6f1b64908a366d46
>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Insert math');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
<<<<<<< HEAD
		'src' => 'CMTV/Math/insert-math-dialog.js',
		'min' => '1',
		'addon' => 'CMTV/Math',
=======
		'src' => 'CMTV/Math/insertMathDialog.js',
>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
	));
	$__finalCompiled .= '

<form class="block" id="editor_math_form" data-xf-init="insert-math-form">
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRadioRow(array(
		'name' => 'math_type',
	), array(array(
		'value' => 'block',
		'checked' => 'checked',
		'label' => 'Block',
		'_type' => 'option',
	),
	array(
		'value' => 'inline',
		'label' => 'Inline',
		'_type' => 'option',
	)), array(
		'label' => 'Type',
		'explain' => 'Inline math is smaller and should be used inside the plain text. Block math is bigger and should be used for big equations and formulas. It also creates line breaks before and after.',
	)) . '
<<<<<<< HEAD
			
=======

>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
			' . $__templater->formTextAreaRow(array(
		'name' => 'latex_input',
		'rows' => '2',
		'autosize' => 'true',
		'autofocus' => '1',
<<<<<<< HEAD
=======
		'id' => 'latex_input',
>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
	), array(
		'label' => 'LaTeX input',
		'explain' => '<a href="https://www.latex-tutorial.com/tutorials/amsmath/" target="_blank">How to write math using LaTeX?</a> • <a href="https://katex.org/docs/supported.html" target="_blank">List of supported functions</a>',
	)) . '
<<<<<<< HEAD
		
=======

>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
			<h2 class="block-formSectionHeader">
				<span class="block-formSectionHeader-aligner">
					<span class="preview-loading">' . $__templater->fontAwesome('fa-sync-alt fa-spin', array(
	)) . '</span>
					' . 'Preview' . '
				</span>
			</h2>
<<<<<<< HEAD
			
			<div class="preview-container showing">
				<div class="preview">' . 'Preview' . '</div>
				<div class="error">' . 'Incorrect latex input!' . '</div>
				<div class="empty">' . 'Start typing math in "LaTeX input"...' . '</div>
			</div>
		</div>
		
=======

			<div class="preview-container showing">
				<div class="preview" id="preview">' . 'Preview' . '</div>
				<div class="error" id="error">' . 'Incorrect latex input!' . '</div>
				<div class="empty" id="empty">' . 'Start typing math in "LaTeX input"...' . '</div>
			</div>
		</div>

>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
		' . $__templater->formSubmitRow(array(
		'submit' => 'Continue',
		'id' => 'editor_math_submit',
	), array(
	)) . '
	</div>
<<<<<<< HEAD
</form>';
=======
</form>
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script
		id="MathJax-script"
		async
		src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"
		></script>
<script>
	const formulaInput = document.getElementById("latex_input");
	const outputDiv = document.getElementById("preview");
	const emptyDiv = document.getElementById("empty");
	const previewDiv = document.getElementById("preview");
	const errorDiv = document.getElementById("error");
	const loadingIcon = document.querySelector(".preview-loading");

	previewDiv.style.display = "none";
	errorDiv.style.display = "none";

	function showLoadingIcon() {
		loadingIcon.classList.add("showing");
	}

	function hideLoadingIcon() {
		loadingIcon.classList.remove("showing");
	}

	function convertFormula() {
		const formula = formulaInput.value;
		outputDiv.textContent = "";
		showLoadingIcon();

		// Regular expression to match LaTeX delimiters or commands
		const mathJaxPattern = /\\\\\\[|\\\\\\]|\\\\\\(|\\\\\\)|\\\\(?:[^a-zA-Z]|[a-zA-Z]+ ?)/;
		if (mathJaxPattern.test(formula)) {
			MathJax.tex2chtmlPromise(formula)
				.then((node) => {
				outputDiv.appendChild(node);
				return MathJax.startup.promise;
			})
				.then(() => {

				if (formulaInput.value.trim() === "") {
					emptyDiv.style.display = "block";
				} else {
					emptyDiv.style.display = "none";
				}

				errorDiv.style.display = "none";
				previewDiv.style.display = "block";
				MathJax.typesetPromise();
			}).finally(() => {
				hideLoadingIcon();
			}).catch((error) => {
				errorDiv.style.display = "block";
				hideLoadingIcon();
			});

		} else {
			// Show the empty div if the formula does not match MathJax patterns
			if (formulaInput.value.trim() === "") {
				emptyDiv.style.display = "block";
				errorDiv.style.display = "none";
			} else {
				emptyDiv.style.display = "none";
				errorDiv.style.display = "block";
			}
			outputDiv.style.display = "none";
			hideLoadingIcon();
		}
	}

	formulaInput.addEventListener("input", convertFormula);
</script>';
>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
	return $__finalCompiled;
}
);