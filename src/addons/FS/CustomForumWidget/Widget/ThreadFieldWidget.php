<?php

namespace FS\CustomForumWidget\Widget;

use XF\Widget\AbstractWidget;

/**
 * Class ThreadFieldWidget
 *
 * @package FS\CustomForumWidget\Widget
 */

class ThreadFieldWidget extends AbstractWidget
{
    /** @var array */
    protected $defaultOptions = [
        'limit' => 5,
        'dateLimit' => 90,
        'order' => 'newest',
        'node_ids' => [],
    ];

    protected function getDefaultTemplateParams($context)
    {
        $params = parent::getDefaultTemplateParams($context);
        if ($context == 'options') {

            $applicableForumIds = \XF::options()->fs_custom_select_forums;

            $nodeList = $this->finder('XF:Node')->where("node_id", $applicableForumIds)->order('lft');

            $nodeRepo = $this->app->repository('XF:Node');
            // $params['nodeTree'] = $nodeRepo->createNodeTree($nodeRepo->getFullNodeList());
            $params['nodeTree'] = $nodeRepo->createNodeTree($nodeList->fetch());

            $thread = $this->em()->create('XF:Thread');

            $params['thread'] = $thread;

            $onlyInclude = [];

            $customFieldIdOptions = \XF::options()->fsCustomThreadFieldIds;

            if (!empty($customFieldIdOptions)) {

                $customFieldIds = array_unique(array_map('trim', explode(',', $customFieldIdOptions)));

                if (count($customFieldIds)) {
                    foreach ($customFieldIds as $Id) {
                        $onlyInclude[$Id] = $Id;
                    }
                }
            }

            $params['onlyInclude'] = $onlyInclude;
        }
        return $params;
    }

    public function render()
    {
        $options = $this->options;

        $finder = $this->finder('XF:Thread');

        if (isset($options['node_ids']) && !in_array(0, $options['node_ids'])) {
            $finder->where('node_id', $options['node_ids']);
        }

        $days = $options['dateLimit'];

        if ($days) {
            $currentTime = time();

            $prevTime = $currentTime - ($days * 24 * 60 * 60);

            $finder->where('post_date', '<=', $prevTime);
        }

        $cusCount = 0;

        $customFieldIdOptions = \XF::options()->fsCustomThreadFieldIds;

        if (!empty($customFieldIdOptions)) {

            $customFieldIds = array_unique(array_map('trim', explode(',', $customFieldIdOptions)));

            if (count($customFieldIds)) {

                foreach ($customFieldIds as $Id) {

                    $cusValue = $options[$Id];

                    if (!empty($cusValue)) {
                        if (is_array($cusValue)) {

                            if (count($cusValue) == 1) {
                                $inStr = implode('","', $cusValue);
                                $val = '"' . $Id . '":["' . $cusValue[0] . '"]';
                            } else {
                                $inStr = implode('","', $cusValue);
                                $val = '"' . $Id . '":[' . $inStr . ']';
                            }
                        } else {
                            $val = '"' . $Id . '":"' . $cusValue . '"';
                        }

                        $cusCount += 1;
                        $finder->where('custom_fields', 'LIKE', $finder->escapeLike($val, '%?%'));
                    }

                    $onlyInclude[$Id] = $Id;
                }
            }
        }

        if (!$cusCount) {
            $finder->where('custom_fields', '!=', "[]");
        }

        if ($options['order'] == 'newest') {
            $finder->order('thread_id', 'DESC');
        } else {
            $finder->order($finder->expression('RAND()'));
        }

        $page = 1;
        $limit = $options['limit'];

        $finder->limitByPage($page, $limit);

        $viewParams = [
            'threads' => $finder->fetch(),
        ];

        return $this->renderer('widget_custom_forum_widget', $viewParams);
    }

    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {
        $options = $request->filter([
            'limit' => 'uint',
            'dateLimit' => 'uint',
            'node_ids' => 'array-uint',
            'order' => 'str',
        ]);

        $customFieldIdOptions = \XF::options()->fsCustomThreadFieldIds;

        if (!empty($customFieldIdOptions)) {

            $customFieldIds = array_unique(array_map('trim', explode(',', $customFieldIdOptions)));

            if (count($customFieldIds)) {
                foreach ($customFieldIds as $Id) {

                    $field = \xf::app()->em()->find('XF:ThreadField', $Id);

                    if (isset($field)) {

                        if ($field['field_type'] == 'textbox') {
                            if ($field['match_type'] == 'number') {
                                $options[$field['field_id']] = $request->filter($field['field_id'], 'uint');
                            } else {
                                $options[$field['field_id']] = $request->filter($field['field_id'], 'str');
                            }
                        } elseif ($field['field_type'] == 'multiselect' || $field['field_type'] == 'checkbox') {
                            $options[$field['field_id']] = $request->filter($field['field_id'], 'array-uint');
                        } elseif ($field['field_type'] == 'select' || $field['field_type'] == 'radio' || $field['field_type'] == 'textarea') {
                            $options[$field['field_id']] = $request->filter($field['field_id'], 'str');
                        }
                    }
                }
            }
        }

        if (in_array(0, $options['node_ids'])) {
            $options['node_ids'] = [0];
        }
        if ($options['limit'] < 1) {
            $options['limit'] = 1;
        }

        return true;
    }
}
