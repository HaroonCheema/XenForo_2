<?php
// FROM HASH: a3cd14b974b4b8d28632e89d6dbb0be5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Insert math');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'CMTV/Math/insertMathDialog.js',
		'addon' => 'CMTV/Math',
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

			' . $__templater->formTextAreaRow(array(
		'name' => 'latex_input',
		'rows' => '2',
		'autosize' => 'true',
		'autofocus' => '1',
		'id' => 'latex_input',
	), array(
		'label' => 'LaTeX input',
		'explain' => '<a href="https://www.latex-tutorial.com/tutorials/amsmath/" target="_blank">How to write math using LaTeX?</a> • <a href="https://katex.org/docs/supported.html" target="_blank">List of supported functions</a>',
	)) . '

			<h2 class="block-formSectionHeader">
				<span class="block-formSectionHeader-aligner">
					<span class="preview-loading">' . $__templater->fontAwesome('fa-sync-alt fa-spin', array(
	)) . '</span>
					' . 'Preview' . '
				</span>
			</h2>

			<div class="preview-container showing">
				<div id="mathPreview"><formula id="preview">' . 'Preview' . '</formula></div>
				<div class="error" id="error">' . 'Incorrect latex input!' . '</div>
				<div class="empty" id="empty">' . 'Start typing math in "LaTeX input"...' . '</div>
			</div>
		</div>

		' . $__templater->formSubmitRow(array(
		'submit' => 'Continue',
		'id' => 'editor_math_submit',
	), array(
	)) . '
	</div>
</form>

<script>
	const formulaInput = document.getElementById("latex_input");
	const outputDiv = document.getElementById("preview");
	const emptyDiv = document.getElementById("empty");
	const previewDiv = document.getElementById("mathPreview");
	const errorDiv = document.getElementById("error");
	const loadingIcon = document.querySelector(".preview-loading");

	previewDiv.style.display = "none";
	errorDiv.style.display = "none";
	outputDiv.textContent = "";

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

			previewDiv.style.display = "block";
			emptyDiv.style.display = "none";
			errorDiv.style.display = "none";

			var mathPreviewDiv = document.getElementById("mathPreview");

			var formulaElement = document.createElement("formula");

			formulaElement.textContent = formula;

			mathPreviewDiv.innerHTML = "";
			mathPreviewDiv.appendChild(formulaElement);

			hideLoadingIcon();

			var preview = document.getElementsByClassName("mathJaxEqu");
			MathJax.typeset(preview);

		} else {
			if (formulaInput.value.trim() === "") {
				emptyDiv.style.display = "block";
				errorDiv.style.display = "none";
			} else {
				emptyDiv.style.display = "none";
				errorDiv.style.display = "block";
			}
			previewDiv.style.display = "none";

			hideLoadingIcon();
		}
	}

	formulaInput.addEventListener("input", convertFormula);
</script>';
	return $__finalCompiled;
}
);