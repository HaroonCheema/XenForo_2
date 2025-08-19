<?php
// FROM HASH: e05c783b92237821a5cc9922a518d30d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<script>
	XF.samViewCountMethod = "' . $__templater->escape($__vars['xf']['options']['siropuAdsManagerViewCountMethod']) . '";
	XF.samServerTime = ' . $__templater->escape($__vars['xf']['time']) . ';
	XF.samItem = ".' . $__templater->escape($__vars['xf']['options']['siropuAdsManagerSamItemCssClass']) . '";
	XF.samCodeUnit = ".' . $__templater->escape($__vars['xf']['options']['siropuAdsManagerSamCodeUnitCssClass']) . '";
	XF.samBannerUnit = ".' . $__templater->escape($__vars['xf']['options']['siropuAdsManagerSamBannerUnitCssClass']) . '";
</script>
';
	if ($__vars['xf']['samLoadJsCarousel']) {
		$__finalCompiled .= '
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/js/swiper.min.js"></script>
	<script>
	$(function() {
		var options = {
			slidesPerColumnFill: \'row\',
			pagination: {
				el: \'.swiper-pagination\',
				clickable: true
			},
			navigation: {
				nextEl: \'.swiper-button-next\',
				prevEl: \'.swiper-button-prev\'
			},
			autoplay: {
				delay: 3000,
				disableOnInteraction: false
			},
			on: {
				init: function() {
					var unit = this.$wrapperEl;
					unit.find(XF.samItem + \' img[data-src]\').trigger(\'loadImage\');
					unit.find(\'.swiper-slide-active\').trigger(\'adViewCarousel\');
				},
				slideChangeTransitionEnd: function() {
					this.$wrapperEl.find(\'.swiper-slide-active\').trigger(\'adViewCarousel\');
				}
			}
		}
		$(\'.sam-swiper-container\').each(function() {
			jQuery.extend(options, $(this).data(\'options\'));
			var id = $(this).data(\'id\');
			var swiper = [];
			swiper[id] = new Swiper(\'.sam-swiper-container[data-id="\' + id + \'"]\', options);
			$(this).on(\'mouseover\', function() {
				swiper[id].autoplay.stop();
			});
			$(this).on(\'mouseout\', function() {
				swiper[id].autoplay.start();
			});
		});
	});
	</script>
';
	}
	$__finalCompiled .= '
';
	if (($__vars['xf']['options']['siropuAdsManagerAdBlock'] != 'disabled') AND ((!$__templater->method($__vars['xf']['visitor'], 'isMemberOf', array($__vars['xf']['options']['siropuAdsManagerAdBlockExcludeUserGroup'], ))) AND ((!$__templater->func('in_array', array($__vars['xf']['reply']['template'], $__vars['xf']['options']['siropuAdsManagerAdBlockExcludePages'], ), false)) AND ($__vars['xf']['samAds'] AND $__vars['xf']['options']['siropuAdsManagerAdBlockDevices'][$__templater->method($__vars['xf']['samAds'], 'getUserDevice', array())])))) {
		$__finalCompiled .= '
	<script>
		$(function() {
			var adBlockAction = "' . $__templater->escape($__vars['xf']['options']['siropuAdsManagerAdBlock']) . '";
			var supportUsTitle = "' . $__templater->filter('Please support us', array(array('escape', array('js', )),), true) . '";
			var supportUsMessage = "' . $__templater->filter('Please support us by disabling AdBlocker on our website.', array(array('escape', array('js', )),), true) . '";
			var supportRedirectUrl = "' . $__templater->escape($__vars['xf']['options']['siropuAdsManagerAdBlockRedirectUrl']) . '";
			var adBlockNotice = {
				element: \'.p-body-content\',
				method: \'prepend\',
				content: "' . $__templater->filter($__vars['xf']['options']['siropuAdsManagerAdBlockMessage'], array(array('escape', array('js', )),), true) . '",
				interval: ' . $__templater->escape($__vars['xf']['options']['siropuAdsManagerAdBlockDisplayInterval']) . ',
				views: ' . $__templater->escape($__vars['xf']['options']['siropuAdsManagerAdBlockDisplayAfterXPageViews']) . '
			};
			function hasContentHeight(ad) {
				if (ad.find(\'[data-xf-init="sam-lazy"]\').length) {
					return true;
				}
				var adminActions = ad.find(\'.samAdminActions\');
				var ignoreContent = ad.find(\'.samIgnoreContent\');
				var adsenseUnit = ad.find(\'ins.adsbygoogle\');
				var googleTagUnit = ad.find(\'[id^="div-gpt-ad"]\');
				var ignoredHeight = 0;
				if (adminActions.length) {
					ignoredHeight += adminActions.height();
				}
				if (ignoreContent.length) {
					ignoredHeight += ignoreContent.height();
				}
				if (adsenseUnit.length) {
					if (adsenseUnit[0].attributes[\'data-adsbygoogle-status\'] === undefined) {
						return false;
					} else if (adsenseUnit.is(\':hidden\')) {
						return true;
					}
				} else if (googleTagUnit.length) {
					if (googleTagUnit.css(\'min-height\') == \'1px\') {
						return false;
					}
				}
				return (ad.height() - ignoredHeight) > 0;
			}
			function initDetection() {
				 $(\'<div class="banner_728x90 ad-banner" />\').appendTo(\'body\');
				 var adUnits = $(XF.samCodeUnit + \' \' + XF.samItem + \':not(.samLazyLoading)\' + \',\' + XF.samBannerUnit + \' \' + XF.samItem + \':not(.samLazyLoading)\');
				 if (adUnits.length && ($(\'.banner_728x90.ad-banner\').is(\':hidden\') || XF.samCoreLoaded === undefined)) {
					  if (adBlockAction == \'backup\' || adBlockAction == \'message\') {
						   adUnits.each(function() {
								if (!hasContentHeight($(this)) && $(this).find(\'> a img[data-src]\').length == 0) {
									 if (adBlockAction == \'backup\') {
										  var backup = $(this).find(\'.samBackup\');
										  if (backup.length) {
											   backup.find(\'img\').each(function() {
													$(this).attr(\'src\', $(this).data(\'src\'));
											   });
											   backup.fadeIn();
										  }
									 } else {
										  $(\'<div class="samSupportUs" />\').html(supportUsMessage).prependTo($(this));
									 }
								}
						   });
					  } else {
						   var adsBlocked = 0;
						   adUnits.each(function() {
								if (!hasContentHeight($(this))) {
									 adsBlocked += 1;
								};
						   });
						   var canDisplayNotice = true;
						  	var pageViewCount = ' . ($__templater->escape($__templater->method($__vars['xf']['session'], 'get', array('samPageViewCount', ))) ?: 0) . ';
						  	if (adBlockNotice.views && adBlockNotice.views > pageViewCount) {
								canDisplayNotice = false;
							}
						   if (adsBlocked && canDisplayNotice) {
							   if (adBlockAction == \'notice\') {
								   var dismissCookieTime = adBlockNotice.interval ? XF.Cookie.get(\'sam_notice_dismiss\') : false;
								   if (dismissCookieTime && (Math.floor(Date.now() / 1000) - dismissCookieTime <= (adBlockNotice.interval * 60)))
								   {
										return;
								   }
								   var content = supportUsMessage;
								   if (adBlockNotice.content) {
									   content = adBlockNotice.content;
								   }
								   var notice = $(\'<div id="samNotice" />\');
								   notice.prepend(\'<a role="button" id="samDismiss">×</a>\');
								   notice.append(\'<span>\' + content + \'</span>\');
								   if (adBlockNotice.method == \'prepend\') {
									   notice.prependTo(adBlockNotice.element);
								   } else {
									   notice.appendTo(adBlockNotice.element);
								   }
								   notice.fadeIn(\'slow\');
								   XF.activate(notice);
								   $(\'body\').addClass(\'samAdBlockDetected\');
							   } else {
								   var pUrl = window.location.href;
								   var rUrl = supportRedirectUrl;
								   if (rUrl && pUrl.indexOf(rUrl) === -1) {
									   window.location.href = rUrl;
									   return;
								   }
								   var $overlay = XF.getOverlayHtml({
									   title: supportUsTitle,
									   dismissible: false,
									   html: \'<div class="blockMessage">\' + supportUsMessage + \'</div>\'
								   });
								   var overlay = new XF.Overlay($overlay, {
									   backdropClose: false,
									   keyboard: false,
									   escapeClose: false,
									   className: \'samSupportUsOverlay\'
								   });
								   overlay.show();
								   $(\'head\').append(\'<style>::-webkit-scrollbar{display: none;}</style>\');
								   $(\'.samSupportUsOverlay\').css(\'background-color\', \'black\').fadeTo(\'slow\', 0.95);
							   }
						   }
					  }
				 }
			}
			$(document).on(\'click\', \'#samDismiss\', function() {
				$(this).parent(\'#samNotice\').fadeOut();
				$(\'body\').removeClass(\'samAdBlockDetected\');
				XF.Cookie.set(\'sam_notice_dismiss\', Math.floor(Date.now() / 1000));
			});
			$(document).on(\'samInitDetection\', function() {
				initDetection();
			});
			$(document).trigger(\'samInitDetection\');
		});
	</script>
';
	}
	$__finalCompiled .= '
<script>
	$(function() {
		var bkp = $(\'div[data-ba]\');
		if (bkp.length) {
			bkp.each(function() {
				var ad = $(this);
				if (ad.find(\'ins.adsbygoogle\').is(\':hidden\')) {
					 XF.ajax(\'GET\', XF.canonicalizeUrl(\'index.php?sam-item/\' + ad.data(\'ba\') + \'/get-backup\'), {}, function(data) {
						 if (data.backup) {
							 ad.html(data.backup);
						 }
					 }, { skipDefault: true, global: false});
				}
			});
		}
		$(\'.samAdvertiseHereLink\').each(function() {
			var unit = $(this).parent();
			if (unit.hasClass(\'samCustomSize\')) {
				unit.css(\'margin-bottom\', 20);
			}
		});
		$(\'div[data-position="footer_fixed"] > div[data-cv="true"]\').each(function() {
			$(this).trigger(\'adView\');
		});
	});
</script>';
	return $__finalCompiled;
}
);