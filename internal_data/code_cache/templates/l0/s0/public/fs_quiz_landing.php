<?php
// FROM HASH: 2ca8500a9328d40ab54f8d1f31f26927
return array(
'macros' => array('search_menu' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'conditions' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
  <div class="block-filterBar">
    <div class="filterBar">
      <a
        class="filterBar-menuTrigger"
        data-xf-click="menu"
        role="button"
        tabindex="0"
        aria-expanded="false"
        aria-haspopup="true"
        >' . 'Filters' . '</a
      >
      <div
        class="menu menu--wide"
        data-menu="menu"
        aria-hidden="true"
        data-href="' . $__templater->func('link', array('auction/refine-search', null, $__vars['conditions'], ), true) . '"
        data-load-target=".js-filterMenuBody"
      >
        <div class="menu-content">
          <h4 class="menu-header">' . 'Show only' . $__vars['xf']['language']['label_separator'] . '</h4>
          <div class="js-filterMenuBody">
            <div class="menu-row">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
          </div>
        </div>
      </div>
    </div>
  </div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Quiz');
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '
<script>
  // For All Auctions
  function DateTimeConverter(unixdatetime) {
    var wStart_time = new Date(unixdatetime * 1000).toLocaleString("en-US", {
      hour12: false,
      //  timeZone: \'America/New_York\',
      // timeZone:\'Europe/London\',
      timeStyle: "long",
    });
    var tempHumanDate = new Date(unixdatetime * 1000).toLocaleDateString(
      "en-US",
      {
        timeZone: "America/New_York",
        year: "numeric",
        month: "numeric",
        day: "numeric",
      }
    );

    var humanDate = new Date(tempHumanDate);
    var year = humanDate.getFullYear();
    var month = (humanDate.getMonth() + 1).toString().padStart(2, "0");
    var date = humanDate.getDate();

    var fulldate = year + "-" + month + "-" + date + " " + wStart_time + ":00";

    // FormatingDateEspecialyForIOS
    var tempCountTimmer = fulldate.split(/[- :]/);
    // Apply each element to the Date function
    var tempDateObject = new Date(
      tempCountTimmer[0],
      tempCountTimmer[1] - 1,
      tempCountTimmer[2],
      tempCountTimmer[3],
      tempCountTimmer[4],
      tempCountTimmer[5]
    );
    var CountDownDateTime = new Date(tempDateObject).getTime();

    return CountDownDateTime;
  }

  function timmerCounter(auction_id, start_datetime) {
    let auc_id = auction_id;

    let humanDateTime = DateTimeConverter(start_datetime);

    var countDownDate = new Date(humanDateTime).getTime();
    var counter = setInterval(function () {
      // Get today\'s date and time
      var now = new Date().getTime();
      // Find the distance between now and the count down date
      var timeDistance = countDownDate - now;
      document.getElementById("days-auction-" + auc_id).innerHTML =
        Math.floor(timeDistance / (1000 * 60 * 60 * 24)) + " D";
      document.getElementById("hours-auction-" + auc_id).innerHTML =
        Math.floor((timeDistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)) +
        " H";
      document.getElementById("minutes-auction-" + auc_id).innerHTML =
        Math.floor((timeDistance % (1000 * 60 * 60)) / (1000 * 60)) + " M";
      document.getElementById("seconds-auction-" + auc_id).innerHTML =
        Math.floor((timeDistance % (1000 * 60)) / 1000) + " S";

      // If the count down is over, write some text
      if (timeDistance < 0) {
        clearInterval(counter);
        document.getElementById("auction-counter-" + auc_id).style.display =
          "none";
      }
    }, 1000);
  }
</script>

';
	$__templater->setPageParam('searchConstraints', array('Auctions' => array('search_type' => 'fs_auction_auctions', ), ));
	$__finalCompiled .= '

';
	if ($__vars['canInlineMod']) {
		$__finalCompiled .= '
  ';
		$__templater->includeJs(array(
			'src' => 'xf/inline_mod.js',
			'min' => '1',
		));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

<div
  class="block"
  data-xf-init="' . ($__vars['canInlineMod'] ? 'inline-mod' : '') . '"
  data-type="fs_auction_auctions"
  data-href="' . $__templater->func('link', array('inline-mod', ), true) . '"
>
  <div class="block-outer">
    ' . trim('
      ' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'auction',
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '

    ') . '
  </div>
  <div class="block-container">
    ' . $__templater->callMacro(null, 'search_menu', array(
		'conditions' => $__vars['conditions'],
	), $__vars) . '

    <!--Listing View--->
    <div class="block-body">
      ';
	if ($__vars['xf']['visitor']['layout_type'] == '0') {
		$__finalCompiled .= '
        ';
		if (!$__templater->test($__vars['listings'], 'empty', array())) {
			$__finalCompiled .= '
          <div class="structItemContainer">
            ';
			if ($__templater->isTraversable($__vars['listings'])) {
				foreach ($__vars['listings'] AS $__vars['listing']) {
					$__finalCompiled .= '
              ' . $__templater->callMacro('fs_auction_listing_list_macros', 'listing', array(
						'listing' => $__vars['listing'],
					), $__vars) . '
            ';
				}
			}
			$__finalCompiled .= '
          </div>
          ';
		} else if ($__vars['filters']) {
			$__finalCompiled .= '
          <div class="block-row">
            ' . 'There are currently no auctions that match your filters.' . '
          </div>
          ';
		} else {
			$__finalCompiled .= '
          <div class="block-row">
            ' . 'No auctions have been created yet.' . '
          </div>
        ';
		}
		$__finalCompiled .= '
        ';
	} else if ($__vars['xf']['visitor']['layout_type'] == '1') {
		$__finalCompiled .= '
        ';
		if (!$__templater->test($__vars['featuredListings'], 'empty', array())) {
			$__finalCompiled .= '
          <div class="structItemContainer">
            ';
			if ($__templater->isTraversable($__vars['featuredListings'])) {
				foreach ($__vars['featuredListings'] AS $__vars['listing']) {
					$__finalCompiled .= '
              ' . $__templater->callMacro('fs_auction_listing_list_macros', 'listing_grid', array(
						'listing' => $__vars['listing'],
					), $__vars) . '
            ';
				}
			}
			$__finalCompiled .= '
          </div>
        ';
		}
		$__finalCompiled .= '

        <!--Grid View-->
        ';
		if (!$__templater->test($__vars['listings'], 'empty', array()) AND false) {
			$__finalCompiled .= '
          <div class="structItemContainer">
            ';
			if ($__templater->isTraversable($__vars['listings'])) {
				foreach ($__vars['listings'] AS $__vars['listing']) {
					$__finalCompiled .= '
              ' . $__templater->callMacro('fs_auction_listing_list_macros', 'listing_grid', array(
						'listing' => $__vars['listing'],
					), $__vars) . '
            ';
				}
			}
			$__finalCompiled .= '
          </div>
          ';
		} else if ($__vars['filters']) {
			$__finalCompiled .= '
          <div class="block-row">
            ' . 'There are currently no auctions that match your filters.' . '
          </div>
          ';
		} else {
			$__finalCompiled .= '
          <div class="block-row">
            ' . 'No auctions have been created yet.' . '
          </div>
        ';
		}
		$__finalCompiled .= '
      ';
	}
	$__finalCompiled .= '
      <div class="block-footer">
        <span class="block-footer-counter"
          >' . $__templater->func('display_totals', array($__vars['totalReturn'], $__vars['total'], ), true) . '</span
        >
      </div>
    </div>
  </div>

  <div class="block-outer block-outer--after">
    ' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'auction',
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '
    ' . $__templater->func('show_ignored', array(array(
		'wrapperclass' => 'block-outer-opposite',
	))) . '
  </div>
</div>

';
	$__templater->setPageParam('sideNavTitle', 'Categories');
	$__finalCompiled .= '

';
	$__templater->modifySideNavHtml(null, '
  ' . $__templater->callMacro('fs_quiz_category_list_macros', 'simple_list_block', array(
		'categoryTree' => $__vars['categoryTree'],
	), $__vars) . '
', 'replace');
	$__finalCompiled .= '

<!-- Filter Bar Macro Start -->

';
	return $__finalCompiled;
}
);