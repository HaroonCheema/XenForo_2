<?php

namespace FS\DeleteQuotedPosts\Service\DeleteQuotedPosts;

use XF\Service\AbstractService;

class DeleteQuotedPostService extends AbstractService
{
	protected $allowedCurrencies;

    protected $defaultCurrencies;
	protected $exchangeApiUrl;

	public function __construct(\XF\App $app)
	{
		parent::__construct($app);

	}

    public function deleteFirstQuotedPosts(){

        $threads = $this->finder('XF:Thread')->with('FirstPost')->fetch();

        foreach ($threads as $thread){

            $firstPostId = $thread->FirstPost->post_id;
            
            $quotingPosts = $this->findFirstQuotedPosts($firstPostId,$thread);

            foreach($quotingPosts as $post){

                /** @var \XF\Service\Post\Deleter $deleter */
                $deleter = $this->service('XF:Post\Deleter', $post);
                $deleter->delete('soft');

                $post->fastUpdate(['is_deleted_quoted_post' => true]);
            }
        }
    }

    public function deleteFirstQuotedPostsOfThreadId($threadId){
            //$thread = $this->app->em()->find('XF:Thread', $threadId);
            $thread = $this->finder('XF:Thread')->whereId($threadId)->with('FirstPost')->fetchOne();
            if ($thread)
            {
                $firstPostId = $thread->FirstPost->post_id;
                $quotingPosts = $this->findFirstQuotedPosts($firstPostId,$thread);

                foreach($quotingPosts as $post){

                    /** @var \XF\Service\Post\Deleter $deleter */
                    $deleter = $this->service('XF:Post\Deleter', $post);
                    $deleter->delete('soft');

                    $post->fastUpdate(['is_deleted_quoted_post' => true]);
                }

            }
    }

    public function findFirstQuotedPosts($firstPostId,$thread){
        $finder = \XF::finder('XF:Post');
        $finder->where('thread_id', $thread->thread_id);
        $finder->where('message_state', 'visible');
        //$pattern = '%[QUOTE=%post: ' . (int)$firstPostId . ',%"]%';
        //$escapedPattern = $finder->escapeLike($pattern, '%');

        $quotePattern = '%[QUOTE=%post: ' . (int)$firstPostId . ',%"]%';
        $finder->where('message', 'LIKE', $quotePattern);

        // Optional: exclude the first post itself if it somehow quotes itself (rare/unlikely)
        $finder->where('post_id', '<>', $firstPostId);
        $finder->order('post_date', 'ASC');
        $quotingPosts = $finder->fetch();

        return $quotingPosts;
    }

}