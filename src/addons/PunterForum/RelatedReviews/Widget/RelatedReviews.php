<?php

namespace PunterForum\RelatedReviews\Widget;

use PunterForum\RelatedReviews\Service\Reviews\Phones;
use Throwable;
use XF\Entity\Thread;
use XF\Widget\AbstractWidget;
use XF\Widget\WidgetRenderer;
use XFES\Listener;

class RelatedReviews extends AbstractWidget
{

    public function getOptionsTemplate(): string
    {
        return '';
    }

    public function render(): WidgetRenderer
    {

        $options = $this->app->options();
        /** @var Thread $thread $thread */
        $thread = $this->contextParams['thread'];
        /** @var Phones $service */
        $service = $this->service('PunterForum\RelatedReviews:Reviews\Phones');

        /** @var \PunterForum\PhoneCoreLibrary\Service\PhoneService $phoneService */
        $phoneService = $this->service('PunterForum\PhoneCoreLibrary:PhoneService');

        $phones = $phoneService->getPhoneNumberFromString($thread->title);

        $forum_related = [];
        $eh_related = [];

        try {
            if (!empty($phones) && !empty($phones[0])) {
                $phone = $phoneService->validatePhoneNumber($phones[0]);
            }
            if (!empty($phone)) {
                if ($options->xfesEnabled) {
                    $es = Listener::getElasticsearchApi($options->xfesConfig);

                    $data = [
                        "query" => [
                            "multi_match" => [
                                "query" => $phone,
                                "fields" => [
                                    "title",
                                    "message"
                                ]
                            ]
                        ]
                    ];

                    $response = $es->search($data);
                    $hits = $response['hits']['hits'];

                    foreach ($hits as $hit) {
                        if (!empty($hit["_id"])) {
                            $parts = explode('-', $hit["_id"]);
                            if ($parts[1] != $thread->thread_id && $parts[0] == "thread") {
                                $threadFound = $this->finder('XF:Thread')
                                    ->with('Forum')
                                    ->whereId($parts[1])
                                    ->fetchOne();
                                if ($threadFound instanceof Thread) {
                                    $forum_related[] = $threadFound;
                                }
                            }
                        }
                    }
                }

                $eh_related = $service->searchEscortHub($phone);
            }
        } catch (Throwable $exception) {
            $this->app->logException($exception);
        }

        $threadFound = $this->finder('XF:Thread')
            ->with('Forum')
            ->where('node_id', 208)
            ->order('thread_id', 'desc')
            ->fetch(3);

        return $this->renderer('widget_pf_related_reviews', [
            'forum_threads' => $threadFound,
            // 'forum_threads' => $forum_related,
            'eh_ads' => $eh_related
        ]);
    }
}
