<?php

namespace FS\SpaHub\Api\Controller;

use XF\Mvc\ParameterBag;
use XF\Api\Controller\AbstractController;

class Spa extends AbstractController
{
    // ══════════════════════════════════════════════════════════════════
    //  GET /api/spa
    //  Returns full spa detail + similar items
    // ══════════════════════════════════════════════════════════════════
    public function actionGet(ParameterBag $params)
    {
        // ── Resolve & validate item (shared logic) ────────────────────
        $resolved = $this->resolveAndValidateItem();
        if ($resolved instanceof \XF\Mvc\Reply\AbstractReply) {
            return $resolved;   // early-out on error
        }

        [
            'item'                => $item,
            'itemCategory'        => $itemCategory,
            'parentCategoryState' => $parentCategoryState,
        ] = $resolved;

        // ── Cover image ───────────────────────────────────────────────
        $coverImageUrl = $this->buildCoverImageUrl($item);

        // ── Custom fields ─────────────────────────────────────────────
        $customFields = $this->buildCustomFields($item);

        // ── Rating summary ────────────────────────────────────────────
        $ratingSummary = $this->buildRatingSummary($item);

        // ── Similar items ─────────────────────────────────────────────
        $similarItems = $this->buildSimilarItems($item);

        // ── Build response ────────────────────────────────────────────
        $data = $this->buildItemData(
            $item,
            $itemCategory,
            $parentCategoryState,
            $coverImageUrl,
            $customFields,
            $ratingSummary,
            $similarItems
        );

        return $this->apiResult(['spa' => $data]);
    }


    // ══════════════════════════════════════════════════════════════════
    //  GET /api/spa/reviews
    //  Returns spa detail  +  paginated review threads
    // ══════════════════════════════════════════════════════════════════
    public function actionGetReviews(ParameterBag $params)
    {
        // ── Resolve & validate item (shared logic) ────────────────────
        $resolved = $this->resolveAndValidateItem();
        if ($resolved instanceof \XF\Mvc\Reply\AbstractReply) {
            return $resolved;
        }

        [
            'item'                => $item,
            'itemCategory'        => $itemCategory,
            'parentCategoryState' => $parentCategoryState,
        ] = $resolved;

        // ── Pagination params ─────────────────────────────────────────
        $page    = max(1, (int) $this->filter('page', 'uint'));
        $perPage = 100;

        // ── Review type filter (optional: 'positive','negative', etc.) ─
        $reviewType = '';

        // ── Thread / review finder ────────────────────────────────────
        $threadFinder = $this->finder('XF:Thread')
            ->where('discussion_state', 'visible')
            ->where('discussion_type', '<>', 'redirect')
            // ->where('spa_id', $item->item_id)
            ->order('last_post_date', 'DESC')
            ->indexHint('FORCE', 'last_post_date');

        // Only apply review_type filter when supplied
        if ($reviewType !== '') {
            $threadFinder->where('review_type', $reviewType);
        }

        $total   = $threadFinder->total();
        $threadFinder->limitByPage($page, $perPage);
        $threads = $threadFinder->fetch();

        // ── Serialise threads for API response ────────────────────────
        $reviews = [];
        foreach ($threads as $thread) {
            $reviews[] = [
                'thread_id'      => $thread->thread_id,
                'title'          => $thread->title,
                'reply_count' => $thread->reply_count,
                'view_count' => $thread->view_count,
                'last_post_date' => $thread->last_post_date,
                'post_date'      => $thread->post_date,
                'user_id'        => $thread->user_id,
                'username'       => $thread->username,
            ];
        }

        $totalPages = max(1, (int) ceil($total / $perPage));

        // ── Cover image + rating (handy for reviews page header) ──────
        $coverImageUrl = $this->buildCoverImageUrl($item);
        $ratingSummary = $this->buildRatingSummary($item);
        $customFields  = $this->buildCustomFields($item);
        $similarItems  = $this->buildSimilarItems($item);

        $spaData = $this->buildItemData(
            $item,
            $itemCategory,
            $parentCategoryState,
            $coverImageUrl,
            $customFields,
            $ratingSummary,
            $similarItems
        );

        return $this->apiResult([
            'spa'     => $spaData,
            'reviews' => [
                'data'        => $reviews,
                'pagination'  => [
                    'current_page' => $page,
                    'per_page'     => $perPage,
                    'total_items'  => $total,
                    'total_pages'  => $totalPages,
                    'has_prev'     => $page > 1,
                    'has_next'     => $page < $totalPages,
                ],
            ],
        ]);
    }

     public function actionGetAlerts(ParameterBag $params)
    {
        // ── Resolve & validate item (shared logic) ────────────────────
        $resolved = $this->resolveAndValidateItem();
        if ($resolved instanceof \XF\Mvc\Reply\AbstractReply) {
            return $resolved;
        }

        [
            'item'                => $item,
            'itemCategory'        => $itemCategory,
            'parentCategoryState' => $parentCategoryState,
        ] = $resolved;

        // ── Pagination params ─────────────────────────────────────────
        $page    = max(1, (int) $this->filter('page', 'uint'));
        $perPage = 100;

        // ── Review type filter (optional: 'positive','negative', etc.) ─
        $reviewType = '';

        // ── Thread / review finder ────────────────────────────────────
        $threadFinder = $this->finder('XF:Thread')
            ->where('discussion_state', 'visible')
            ->where('discussion_type', '<>', 'redirect')
            // ->where('spa_id', $item->item_id)
            ->order('last_post_date', 'DESC')
            ->indexHint('FORCE', 'last_post_date');

        // Only apply review_type filter when supplied
        if ($reviewType !== '') {
            $threadFinder->where('review_type', $reviewType);
        }

        $total   = $threadFinder->total();
        $threadFinder->limitByPage($page, $perPage);
        $threads = $threadFinder->fetch();

        // ── Serialise threads for API response ────────────────────────
        $reviews = [];
        foreach ($threads as $thread) {
            $reviews[] = [
                'thread_id'      => $thread->thread_id,
                'title'          => $thread->title,
                'reply_count' => $thread->reply_count,
                'view_count' => $thread->view_count,
                'last_post_date' => $thread->last_post_date,
                'post_date'      => $thread->post_date,
                'user_id'        => $thread->user_id,
                'username'       => $thread->username,
            ];
        }

        $totalPages = max(1, (int) ceil($total / $perPage));

        // ── Cover image + rating (handy for reviews page header) ──────
        $coverImageUrl = $this->buildCoverImageUrl($item);
        $ratingSummary = $this->buildRatingSummary($item);
        $customFields  = $this->buildCustomFields($item);
        $similarItems  = $this->buildSimilarItems($item);

        $spaData = $this->buildItemData(
            $item,
            $itemCategory,
            $parentCategoryState,
            $coverImageUrl,
            $customFields,
            $ratingSummary,
            $similarItems
        );

        return $this->apiResult([
            'spa'     => $spaData,
            'alerts' => [
                'data'        => $reviews,
                'pagination'  => [
                    'current_page' => $page,
                    'per_page'     => $perPage,
                    'total_items'  => $total,
                    'total_pages'  => $totalPages,
                    'has_prev'     => $page > 1,
                    'has_next'     => $page < $totalPages,
                ],
            ],
        ]);
    }

    // ══════════════════════════════════════════════════════════════════
    //  PRIVATE HELPERS
    //  Shared across actionGet and actionGetReviews
    // ══════════════════════════════════════════════════════════════════

    /**
     * Read + validate input, fetch item, verify state/city ownership.
     *
     * @return array{item, itemCategory, parentCategoryState}
     *         OR \XF\Mvc\Reply\AbstractReply on error
     */
    private function resolveAndValidateItem()
    {
        $db = $this->app()->db();

        // ── Input ─────────────────────────────────────────────────────
        $itemId            = $this->filter('item_id',              'int');
        $shortStateUrl     = $this->filter('short_state_url',      'str');
        $shortStateCityUrl = $this->filter('short_state_city_url', 'str');

        if (!$itemId) {
            return $this->apiShowError('item_id is required.', 'item_id_required', 400);
        }
        if (!$shortStateUrl) {
            return $this->apiShowError('short_state_url is required.', 'state_required', 400);
        }

        // ── Validate state ────────────────────────────────────────────
        $parentCategoryState = $db->fetchRow("
            SELECT category_id, title, short_url
            FROM   xf_xa_sc_category
            WHERE  parent_category_id = 0
              AND  short_url = ?
            LIMIT  1
        ", $shortStateUrl);

        if (!$parentCategoryState) {
            return $this->apiShowError(
                'Invalid state: no category found for the given short_state_url.',
                'invalid_state', 404
            );
        }

        // ── Fetch item ────────────────────────────────────────────────
        /** @var \XenAddons\Showcase\Entity\Item|null $item */
        $item = $this->finder('XenAddons\Showcase:Item')
            ->where('item_id', $itemId)
            ->where('item_state', 'visible')
            ->with(['User', 'Category', 'CoverImage', 'CoverImage.Data'])
            ->fetchOne();

        if (!$item) {
            return $this->apiShowError(
                'Spa item not found or is not publicly visible.',
                'item_not_found', 404
            );
        }

        // ── Verify item belongs to state ──────────────────────────────
        $itemCategory = $item->Category;

        if (!$itemCategory) {
            return $this->apiShowError(
                'Item category could not be resolved.',
                'category_error', 500
            );
        }

        $stateId = (int) $parentCategoryState['category_id'];

        $itemBelongsToState =
            ((int) $item->category_id === $stateId) ||
            ((int) $itemCategory->parent_category_id === $stateId);

        if (!$itemBelongsToState) {
            return $this->apiShowError(
                'Item does not belong to the specified state.',
                'state_mismatch', 403
            );
        }

        // ── Optional: validate city ───────────────────────────────────
        if ($shortStateCityUrl !== '') {
            $cityCategory = $db->fetchRow("
                SELECT category_id, title, short_url
                FROM   xf_xa_sc_category
                WHERE  parent_category_id = ?
                  AND  short_url = ?
                LIMIT  1
            ", [$stateId, $shortStateCityUrl]);

            if (!$cityCategory) {
                return $this->apiShowError(
                    'Invalid city: no category found for the given short_state_city_url under this state.',
                    'invalid_city', 404
                );
            }

            if ((int) $item->category_id !== (int) $cityCategory['category_id']) {
                return $this->apiShowError(
                    'Item does not belong to the specified city.',
                    'city_mismatch', 403
                );
            }
        }

        return [
            'item'                => $item,
            'itemCategory'        => $itemCategory,
            'parentCategoryState' => $parentCategoryState,
        ];
    }

    // ─────────────────────────────────────────────────────────────────
    private function buildCoverImageUrl(\XenAddons\Showcase\Entity\Item $item): ?string
    {
        if ($item->cover_image_id && $item->CoverImage) {
            return $this->app()->router('public')
                ->buildLink('canonical:attachments', $item->CoverImage);
        }
        return null;
    }

    // ─────────────────────────────────────────────────────────────────
    private function buildCustomFields(\XenAddons\Showcase\Entity\Item $item): array
    {
        $rawCustomFields = $item->custom_fields->getFieldValues() ?? [];
        $knownKeys = ['scfCity', 'scfLocation', 'scfPhone'];

        $customFields = [
            'city'     => $rawCustomFields['scfCity']     ?? null,
            'location' => $rawCustomFields['scfLocation'] ?? null,
            'phone'    => $rawCustomFields['scfPhone']    ?? null,
        ];

        $extraCustomFields = array_diff_key($rawCustomFields, array_flip($knownKeys));
        if (!empty($extraCustomFields)) {
            $customFields['extra'] = $extraCustomFields;
        }

        return $customFields;
    }

    // ─────────────────────────────────────────────────────────────────
    private function buildRatingSummary(\XenAddons\Showcase\Entity\Item $item): array
    {
        $ratingAvg = round((float) $item->rating_avg, 2);
        $ratingPct = $ratingAvg > 0 ? round(($ratingAvg / 5) * 100, 1) : 0;

        return [
            'avg'           => $ratingAvg,
            'out_of'        => 5,
            'percentage'    => $ratingPct,
            'weighted'      => round((float) $item->rating_weighted, 2),
            'total_reviews' => (int) $item->review_count,
            'total_ratings' => (int) $item->rating_count,
            'rating_sum'    => (int) $item->rating_sum,
            'author_rating' => round((float) $item->author_rating, 2),
        ];
    }

    // ─────────────────────────────────────────────────────────────────
    private function buildSimilarItems(\XenAddons\Showcase\Entity\Item $item): array
    {
        $similarItems = [];

        if (!$item->category_id) {
            return $similarItems;
        }

        $similarResults = $this->finder('XenAddons\Showcase:Item')
            ->where('category_id', $item->category_id)
            ->where('item_state', 'visible')
            ->where('item_id', '<>', $item->item_id)
            ->with('CoverImage')
            ->limit(6)
            ->order('rating_weighted', 'DESC')
            ->fetch();

        foreach ($similarResults as $similar) {
            $simCover = null;
            if ($similar->cover_image_id && $similar->CoverImage) {
                $simCover = $this->app()->router('public')
                    ->buildLink('canonical:attachments', $similar->CoverImage);
            }
            $similarItems[] = [
                'item_id'     => $similar->item_id,
                'title'       => $similar->title,
                'cover_image' => $simCover,
            ];
        }

        return $similarItems;
    }

    // ─────────────────────────────────────────────────────────────────
    private function buildItemData(
        \XenAddons\Showcase\Entity\Item $item,
        $itemCategory,
        array $parentCategoryState,
        ?string $coverImageUrl,
        array $customFields,
        array $ratingSummary,
        array $similarItems
    ): array {
        return [
            // ── Core identity ──────────────────────────────────────────
            'item_id'     => $item->item_id,
            'title'       => $item->title,
            'description' => $item->description,
            'is_feature'  => $item->Featured ? 1 : 0,

            // ── Creator ────────────────────────────────────────────────
            'creator' => [
                'user_id'  => $item->user_id,
                'username' => $item->User ? $item->User->username : $item->username,
            ],

            // ── State & Category ───────────────────────────────────────
            'state' => [
                'category_id' => $parentCategoryState['category_id'],
                'title'       => $parentCategoryState['title'],
                'short_url'   => $parentCategoryState['short_url'],
            ],
            'category' => [
                'category_id'    => $item->category_id,
                'title'          => $itemCategory->title,
                'city_short_url' => $itemCategory->short_url,
            ],

            // ── Media ──────────────────────────────────────────────────
            'cover_image' => $coverImageUrl,

            // ── Custom fields ──────────────────────────────────────────
            'custom_fields' => $customFields,

            // ── Location ───────────────────────────────────────────────
            'location'      => $item->location,
            'location_data' => $item->location_data ?? [],

            // ── Business hours ─────────────────────────────────────────
            'business_hours' => $item->business_hours ?? [],

            // ── Dates (Unix timestamps) ────────────────────────────────
            'dates' => [
                'created'     => $item->create_date,
                'last_update' => $item->last_update,
                'last_review' => $item->last_review_date,
                'edit_date'   => $item->edit_date,
            ],

            // ── Counts ─────────────────────────────────────────────────
            'counts' => [
                'views'       => (int) $item->view_count,
                'watches'     => (int) $item->watch_count,
                'comments'    => (int) $item->comment_count,
                'updates'     => (int) $item->update_count,
                'attachments' => (int) $item->attach_count,
            ],

            // ── Ratings ────────────────────────────────────────────────
            'rating' => $ratingSummary,

            // ── Flags ──────────────────────────────────────────────────
            'flags' => [
                'sticky'        => (bool) $item->sticky,
                'comments_open' => (bool) $item->comments_open,
                'ratings_open'  => (bool) $item->ratings_open,
                'has_poll'      => (bool) $item->has_poll,
            ],

            // ── Similar items ──────────────────────────────────────────
            'similar_items' => $similarItems,
        ];
    }

    // ─────────────────────────────────────────────────────────────────
    //  Standardised error response
    // ─────────────────────────────────────────────────────────────────
    public function apiShowError(string $message, string $code, int $httpCode = 400)
    {
        return $this->apiResult([
            'error'   => true,
            'code'    => $code,
            'message' => $message,
        ]);
    }
}