<?php

namespace PunterForum\RelatedReviews\Service\Reviews;

use JmesPath\Env;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;

class Phones extends \XF\Service\AbstractService
{

    /**
     * Do search on escort hub.
     *
     * @param string $phone
     * @return array|null
     */
    public function searchEscortHub(string $phone): ?array
    {
        $url = "https://escorthub.info/jsonapi/node/annuncio?filter%5Bfield_tel%5D=" . str_replace("+", "", $phone);
        $json = $this->app->http()->client()->get($url)->getBody()->getContents();
        assert(!empty($json));
        return Env::search("[{title: data[0].attributes.title,url:join('',['https://escorthub.info',data[0].attributes.path.alias]),city:included[?type == 'node--citta']|[0].attributes.title}]", json_decode($json, true));
    }
}