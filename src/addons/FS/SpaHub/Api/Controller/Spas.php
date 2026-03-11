<?php

namespace FS\SpaHub\Api\Controller;

use XF\Mvc\Entity\Entity;
use XF\Mvc\ParameterBag;
use XF\Api\Controller\AbstractController;

class Spas extends AbstractController
{
    public function actionGet(ParameterBag $params)
    {
        $db = \XF::db();

        $StateswithCities = $db->fetchAll("
        SELECT category_id, title,parent_category_id,short_url
        FROM xf_xa_sc_category
        ORDER BY display_order ASC
    ");

        // ─────────────────────────────────────────────────────
        //  Popular Spa Cities in the USA
        // ─────────────────────────────────────────────────────
        $popularCities = [];

        $popularCities = $db->fetchAll("
SELECT 
    c.category_id, 
    c.title, 
    c.short_url,
    p.short_url AS parent_short_url
FROM xf_xa_sc_category c
LEFT JOIN xf_xa_sc_category p 
    ON c.parent_category_id = p.category_id
WHERE c.parent_category_id != 0
ORDER BY c.item_count DESC
LIMIT 4
");

        // ─────────────────────────────────────────────────────
        //  Browse Spas by U.S. State
        // ─────────────────────────────────────────────────────
        $browseStates = $db->fetchAll("
    SELECT category_id, title, short_url
    FROM   xf_xa_sc_category
    WHERE  parent_category_id = 0
    ORDER  BY item_count DESC
    LIMIT 7
");

    // ─────────────────────────────────────────────────────
    //  Top Rated Spas in the United States
    // ─────────────────────────────────────────────────────

        /** @var \XF\Mvc\Entity\Finder $finder */
        $finder = $this->finder('XenAddons\Showcase:Item');

        $finder
            ->with('CoverImage')
            ->with('CoverImage.Data')
            ->setDefaultOrder('rating_count', 'DESC');

        $finder->limitByPage(1, 5);

        /** @var \XenAddons\Showcase\Entity\Item[] $itemEntities */
        $itemEntities = $finder->fetch();

        $ratedItems = [];

        foreach ($itemEntities as $item) {

            /* Cover image thumbnail URL — null-safe */
            $coverImageUrl = null;

            if ($item->CoverImage && $item->CoverImage->Data) {
                $coverImageUrl = $item->CoverImage->getThumbnailUrl();
            }

            $ratedItems[] = [
                'item_id' => $item->item_id,
                'title' => $item->title,
                'category_title' => $item->Category->title,
                'category_id' => $item->category_id,
                'rating_avg' => round((float) $item->rating_avg, 2),
                'review_count' => (int) $item->review_count,
                'rating_weighted' => round((float) $item->rating_weighted, 2),
                'cover_image' => $coverImageUrl,   // thumbnail URL or null
                'state_short_url' => $item->Category->ParentCategory->short_url ?? '',
                'city_short_url' => $item->Category->short_url ?? '',
            ];
        }

        return $this->apiResult([
            'stateCities' => $StateswithCities,
            'browseStates' => $browseStates,
            'ratedItems' => $ratedItems,
            'popularCities' => $popularCities,
        ]);
    }

    public function actionGetStateUrl(ParameterBag $params)
    {
        $shortStateUrl = $this->filter('short_state_url', 'str');
        $shortStateCityUrl = $this->filter('short_state_city_url', 'str');
        $page = $this->filterPage();   // reads ?page=N, defaults to 1
        $perPage = 8;

        $db = \XF::db();

        // ─────────────────────────────────────────────────────
        // 1️⃣  Selected state by short URL  (raw DB — category only)
        // ─────────────────────────────────────────────────────
        $selectedState = $db->fetchRow("
    SELECT category_id, title, short_url
    FROM   xf_xa_sc_category
    WHERE  parent_category_id = 0
        AND  short_url = ?
    LIMIT  1
", $shortStateUrl);

        if (!$selectedState) {
            return $this->apiResult(['error' => 'State not found']);
        }

        // ─────────────────────────────────────────────────────
        // 2️⃣  All states  (left sidebar)
        // ─────────────────────────────────────────────────────
        $states = $db->fetchAll("
    SELECT category_id, title, short_url
    FROM   xf_xa_sc_category
    WHERE  parent_category_id = 0
    ORDER  BY display_order ASC
");

        // ─────────────────────────────────────────────────────
        // 3️⃣  City resolution
        // ─────────────────────────────────────────────────────
        $selectedCity = null;
        $cities = [];

        if (!empty($shortStateCityUrl)) {

            $selectedCity = $db->fetchRow("
        SELECT category_id, title, short_url, item_count
        FROM   xf_xa_sc_category
        WHERE  short_url = ?
        LIMIT  1
    ", $shortStateCityUrl);

            if ($selectedCity) {
                $cities[] = $selectedCity;
            }
        } else {

            $cities = $db->fetchAll("
        SELECT category_id, title, short_url, item_count
        FROM   xf_xa_sc_category
        WHERE  parent_category_id = ?
        ORDER  BY title ASC
    ", $selectedState['category_id']);
        }

        // ─────────────────────────────────────────────────────
        // 4️⃣  Category IDs for item query
        // ─────────────────────────────────────────────────────
        if (!empty($shortStateCityUrl) && $selectedCity) {
            $categoryIds = [$selectedCity['category_id']];
        } else {
            $categoryIds = [$selectedState['category_id']];
            foreach ($cities as $city) {
                $categoryIds[] = $city['category_id'];
            }
        }

    // ─────────────────────────────────────────────────────
    // 5️⃣  Finder — items with CoverImage relation
    //
    //  withAlias() eagerly loads the CoverImage relation
    //  (defined on the Item entity as TO_ONE → XF:Attachment
    //   with conditions content_type = 'sc_item', content_id,
    //   attachment_id = cover_image_id, with 'Data')
    // ─────────────────────────────────────────────────────
        /** @var \XF\Mvc\Entity\Finder $finder */
        $finder = $this->finder('XenAddons\Showcase:Item');

        $finder
            ->where('category_id', $categoryIds)
            ->with('CoverImage')          // eager-load the CoverImage + Data
            ->with('CoverImage.Data')     // also load attachment Data for URL
            ->setDefaultOrder('create_date', 'DESC');

        // Total count before pagination
        $totalItems = $finder->total();

        $totalPages = max(1, (int) ceil($totalItems / $perPage));
        $page = max(1, min($page, $totalPages));   // clamp
        $offset = ($page - 1) * $perPage;

        // Apply pagination — XF's limitByPage handles LIMIT + OFFSET
        $finder->limitByPage($page, $perPage);

        /** @var \XenAddons\Showcase\Entity\Item[] $itemEntities */
        $itemEntities = $finder->fetch();

        // ─────────────────────────────────────────────────────
        // 6️⃣  Build items array for API response
        // ─────────────────────────────────────────────────────
        $items = [];

        foreach ($itemEntities as $item) {

            /* Cover image thumbnail URL — null-safe */
            $coverImageUrl = null;

            if ($item->CoverImage && $item->CoverImage->Data) {
                $coverImageUrl = $item->CoverImage->getThumbnailUrl();
            }

            $items[] = [
                'item_id' => $item->item_id,
                'title' => $item->title,
                'creator' => $item->User->username,
                'create_date' => $item->create_date,
                'category_title' => $item->Category->title,
                'category_id' => $item->category_id,
                'description' => $item->description,
                'rating_avg' => round((float) $item->rating_avg, 2),
                'review_count' => (int) $item->review_count,
                'rating_weighted' => round((float) $item->rating_weighted, 2),
                'view_count' => (int) $item->view_count,
                'watch_count' => (int) $item->watch_count,
                'cover_image' => $coverImageUrl,   // thumbnail URL or null
                'state_short_url' => $selectedState ? $selectedState['short_url'] : '',
                'city_short_url' => $item->Category->short_url ? $item->Category->short_url : '',
            ];
        }

        // ─────────────────────────────────────────────────────
        // 7️⃣  Return everything + pagination meta
        // ─────────────────────────────────────────────────────
        return $this->apiResult([
            'states' => $states,
            'selectedState' => $selectedState,
            'selectedCity' => $selectedCity,
            'cities' => $cities,
            'items' => $items,

            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total_items' => $totalItems,
                'total_pages' => $totalPages,
                'from' => $totalItems > 0 ? $offset + 1 : 0,
                'to' => min($offset + $perPage, $totalItems),
                'has_prev' => $page > 1,
                'has_next' => $page < $totalPages,
            ],
        ]);
    }
    public function actionGetSearchFilter()
    {
        $input = $this->filter([
            'title'       => 'str',
            'scfCity'     => 'str',
            'scfLocation' => 'str',
            'scfPhone'    => 'str',
        ]);

        $db    = \XF::db();
        $items = [];   // keyed by item_id to avoid duplicates

        // ── PHONE SEARCH ──────────────────────────────────────
        if (!empty($input['scfPhone'])) {
            $normalizedInput = preg_replace('/\D/', '', $input['scfPhone']);

            $phoneValues = $this->finder('XenAddons\Showcase:ItemFieldValue')
                ->with('Item')
                ->where('field_id', 'scfPhone')
                ->fetch();

            foreach ($phoneValues as $fv) {
                if ($fv->Item) {
                    $stored = preg_replace('/\D/', '', $fv->field_value);
                    if (strpos($stored, $normalizedInput) !== false) {
                        $items[$fv->item_id] = $fv->Item;
                    }
                }
            }
        }

        // ── CITY / LOCATION SEARCH ────────────────────────────
        $orConditions = [];
        $fieldIds     = [];

        if (!empty($input['scfCity'])) {
            $orConditions[] = ['field_value', 'LIKE', '%' . $input['scfCity'] . '%'];
            $fieldIds[]     = 'scfCity';
        }
        if (!empty($input['scfLocation'])) {
            $orConditions[] = ['field_value', 'LIKE', '%' . $input['scfLocation'] . '%'];
            $fieldIds[]     = 'scfLocation';
        }

        if (!empty($orConditions)) {
            $fieldValues = $this->finder('XenAddons\Showcase:ItemFieldValue')
                ->with('Item')
                ->where('field_id', $fieldIds)
                ->whereOr($orConditions)
                ->fetch();

            foreach ($fieldValues as $fv) {
                if ($fv->Item) {
                    $items[$fv->item_id] = $fv->Item;
                }
            }
        }

        // ── TITLE SEARCH ──────────────────────────────────────
        if (!empty($input['title'])) {
            $titleItems = $this->finder('XenAddons\Showcase:Item')
                ->where('title', 'LIKE', '%' . $input['title'] . '%')
                ->fetch();

            foreach ($titleItems as $item) {
                $items[$item->item_id] = $item;
            }
        }

        // ── BUILD RESPONSE ────────────────────────────────────
        $result = [];

        foreach ($items as $item) {

            $cityShortUrl  = '';
            $stateShortUrl = '';

            if ($item->Category) {
                $cityShortUrl = $item->Category->short_url ?? '';

                // State = parent category of city
                if ($item->Category->parent_category_id) {
                    $stateRow = $db->fetchRow(
                        "SELECT short_url FROM xf_xa_sc_category WHERE category_id = ? LIMIT 1",
                        $item->Category->parent_category_id
                    );
                    $stateShortUrl = $stateRow ? $stateRow['short_url'] : '';
                }
            }

            // SEO title slug: "Blue Dream Spa" → "blue-dream-spa"
            $titleSlug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $item->title), '-'));

            $result[] = [
                'item_id'         => $item->item_id,
                'title'           => $item->title,
                'title_slug'      => $titleSlug,
                'city_short_url'  => $cityShortUrl,
                'state_short_url' => $stateShortUrl,
            ];
        }

        return $this->apiResult(['items' => $result]);
    }
}
