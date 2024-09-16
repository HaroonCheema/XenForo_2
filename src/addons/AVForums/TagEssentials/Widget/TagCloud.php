<?php

namespace AVForums\TagEssentials\Widget;

use XF\Widget\AbstractWidget;

/**
 * Class TagCloud
 *
 * @package AVForums\TagEssentials\Widget
 */
class TagCloud extends AbstractWidget
{
    protected $defaultOptions = [
        'category_ids' => [],
        'limit' => 50
    ];

    /**
     * @param $context
     *
     * @return array
     */
    protected function getDefaultTemplateParams($context)
    {
        $params = parent::getDefaultTemplateParams($context);

        if ($context === 'options' && is_array($params))
        {
            /** @var \AVForums\TagEssentials\Repository\TagCategory $tagCategoryRepo */
            $tagCategoryRepo = $this->repository('AVForums\TagEssentials:TagCategory');
            $tagCategories = $tagCategoryRepo->getCategoryTitlePairs();

            $params['tagCategories'] = $tagCategories;
        }

        return $params;
    }

    /**
     * @return \XF\Widget\WidgetRenderer
     */
    public function render()
    {
        /** @var \AVForums\TagEssentials\XF\Repository\Tag $tagRepo */
        $tagRepo = $this->repository('XF:Tag');

        $contextParams = $this->contextParams;
        $forum = null;

        if (isset($contextParams['forum']))
        {
            $forum = $contextParams['forum'];
            if (!$forum instanceof \XF\Entity\Forum)
            {
                throw new \LogicException('Forum context expected to be instance of XF:Forum entity');
            }
        }

        $cloudEntries = $tagRepo->getTagsForCloudWidget(
            $this->options['limit'], $this->options['category_ids'], $forum ? $forum->node_id : null
        );
        $tagCloud = $tagRepo->getTagCloud($cloudEntries);

        $viewParams = [
            'tagCloud' => $tagCloud,
            'forum' => $forum
        ];
        return $this->renderer('avForumsTagEss_tag_cloud', $viewParams);
    }

    /**
     * @param \XF\Http\Request $request
     * @param array            $options
     * @param null             $error
     *
     * @return bool
     */
    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {
        $options = $request->filter([
            'limit' => 'uint',
            'category_ids' => 'array-str',
        ]);

        if ($options['limit'] < 1)
        {
            $options['limit'] = 1;
        }

        return true;
    }
}