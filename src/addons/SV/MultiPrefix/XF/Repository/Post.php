<?php /** @noinspection PhpMissingReturnTypeInspection */

namespace SV\MultiPrefix\XF\Repository;



/**
 * Extends \XF\Repository\Post
 */
class Post extends XFCP_Post
{
    /**
     * @param \XF\Entity\Post $post
     * @param $action
     * @param $reason
     * @param array $extra
     * @return bool
     * @noinspection PhpMissingParamTypeInspection
     */
    public function sendModeratorActionAlert(\XF\Entity\Post $post, $action, $reason = '', array $extra = [])
    {
        $extra['sv_prefix_ids'] = $post->Thread->sv_prefix_ids ?? null;

        return parent::sendModeratorActionAlert($post, $action, $reason, $extra);
    }
}