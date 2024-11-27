<?php
// FROM HASH: a01fe491a4dd8f520c3835a9abf0aaa1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ((!$__vars['xf']['visitor']['user_id']) OR (!$__vars['xf']['visitor']['is_admin'])) {
		$__finalCompiled .= '
	<style>

		body {
			overflow: visible !important;
		}

		@media (min-width: 1200px) and (max-width: 1399.98px) {
			#zmmtg-root {
				height: 68% !important;
				margin-top: 151px !important;
			}

			.video-share-layout {
				height: 80% !important;
			}
		}

		@media (min-width: 1400px) {
			#zmmtg-root {
				height: 78% !important;
				margin-top: 151px !important;
			}

			.video-share-layout {
				height: 87% !important;
			}
		}


	</style>
	';
	} else {
		$__finalCompiled .= '
	<style>

		body {
			overflow: visible !important;
		}

		@media (min-width: 1200px) and (max-width: 1399.98px) {
			#zmmtg-root {
				height: 63% !important;
				margin-top: 185px !important;
			}

			.video-share-layout {
				height: 77% !important;
			}
		}

		@media (min-width: 1400px) {
			#zmmtg-root {
				height: 74% !important;
				margin-top: 185px !important;
			}

			.video-share-layout {
				height: 87% !important;
			}
		}


	</style>
';
	}
	$__finalCompiled .= '


' . '

<script src="https://source.zoom.us/3.9.0/lib/vendor/react.min.js"></script>
<script src="https://source.zoom.us/3.9.0/lib/vendor/react-dom.min.js"></script>
<script src="https://source.zoom.us/3.9.0/lib/vendor/redux.min.js"></script>
<script src="https://source.zoom.us/3.9.0/lib/vendor/redux-thunk.min.js"></script>
<script src="https://source.zoom.us/3.9.0/lib/vendor/lodash.min.js"></script>

<!-- Zoom SDK -->
<script src="https://source.zoom.us/zoom-meeting-3.9.0.min.js"></script>
<div id="zmmtg-root"></div>
<div id="meetingSDKElement"></div>
<script>
	// Set up Zoom Meeting configuration
	const sdkKey = "' . $__templater->escape($__vars['sdkKey']) . '";
	const meetingNumber = "' . $__templater->escape($__vars['meetingNumber']) . '";
	const role = "' . $__templater->escape($__vars['role']) . '";
	const userName = "' . $__templater->escape($__vars['username']) . '";
	const userEmail="' . $__templater->escape($__vars['email']) . '";
	const passWord = "' . $__templater->escape($__vars['passWord']) . '";
	const leaveUrl = "' . $__templater->escape($__vars['redirectUrl']) . '";
	const signature = "' . $__templater->escape($__vars['signature']) . '";
	const tk = "' . $__templater->escape($__vars['tk']) . '";

	// Initialize the SDK
	ZoomMtg.setZoomJSLib("https://source.zoom.us/3.9.0/lib", "/av");
	ZoomMtg.preLoadWasm();
	ZoomMtg.prepareWebSDK();

	function startMeeting() {
		ZoomMtg.init({
			leaveUrl: leaveUrl,
			disableCORP: !window.crossOriginIsolated,
			success: function () {
				ZoomMtg.join({
					sdkKey: sdkKey,
					signature: signature,
					meetingNumber: meetingNumber,
					userName: userName,
					passWord: passWord,
					tk:tk,
					success: function () {
						console.log("Joined Zoom meeting successfully");
					},
					error: function (error) {
						console.error("Error joining meeting:", error);
					}
				});
			},
			error: function (error) {
				console.error("Error initializing Zoom SDK:", error);
			}
		});
	}

	document.addEventListener("DOMContentLoaded", startMeeting);
</script>';
	return $__finalCompiled;
}
);