<?php

namespace AddonFlare\ForumStats\ForumStat;

class ForumStatConfig
{
    public $statId;
    public $definitionId;
    public $position;
    public $displayOrder;
    public $options;
    public $active;

    public function __construct($statId, $definitionId, $position, $displayOrder, array $options, $active)
    {
        $this->statId = $statId;
        $this->definitionId = $definitionId;
        $this->position = $position;
        $this->displayOrder = $displayOrder;
        $this->options = $options;
        $this->active = $active;
    }

    public static function create($data)
    {
        if (!is_array($data) && !($data instanceof \XF\Mvc\Entity\Entity))
        {
            throw new \InvalidArgumentException(\XF::phrase('data_passed_into_create_widget_config_should_either_be_array_or_entity'));
        }

        if (is_array($data))
        {
            $data = array_replace([
                'stat_id'       => 0,
                'definition_id' => '',
                'position'      => '',
                'display_order' => 1,
                'options'       => [],
                'active'        => 1,
            ], $data);
        }

        return new self(
            $data['stat_id'],
            $data['definition_id'],
            $data['position'],
            $data['display_order'],
            $data['options'] ?: [],
            $data['active']
        );
    }
}