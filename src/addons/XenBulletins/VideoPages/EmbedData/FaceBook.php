<?php

namespace XenBulletins\VideoPages\EmbedData;

class FaceBook extends BaseData
{
	public function getTempThumbnailPath($url, $bbCodeMediaSiteId, $siteMediaId)
	{
            echo 'facebook';
//            var_dump($url);exit;
            
               $explodeUrl = explode('/', $url);
               
//                var_dump($explodeUrl[5]);exit;
//               $videoId = $explodeUrl[5];
               
//		if (strpos($siteMediaId, ':') !== false)
//		{
//			$siteMediaId = preg_replace('/(.*)(:\d+)/', '\\1', $siteMediaId);
//		}
//
//		$siteMediaId = rawurlencode($siteMediaId);
//
//		$preferredThumbnail = "https://i.ytimg.com/vi/{$siteMediaId}/maxresdefault.jpg";
//		$fallbackThumbnail = "https://i.ytimg.com/vi/{$siteMediaId}/hqdefault.jpg";
//
//		$reader = $this->app->http()->reader();
//
//		$response = $reader->getUntrusted($preferredThumbnail);
//		if (!$response || $response->getStatusCode() != 200)
//		{
//			$response = $reader->getUntrusted($fallbackThumbnail);
//			if (!$response || $response->getStatusCode() != 200)
//			{
//				return null;
//			}
//			$body = $response->getBody();
//		}
//		else
//		{
//			$body = $response->getBody();
//		}
               
//               url -X GET "https://graph.facebook.com/oauth/access_token
//  ?client_id={your-app-id}
//  &client_secret={your-app-secret}
//  &grant_type=client_credentials"
            
            
            
//            $data = file_get_contents("https://graph.facebook.com/$videoId?fields=format");
//            var_dump($data);exit;
//                if ($data !== FALSE)
//                {
//                 $result=json_decode($data);
//                 $count=count($result->format)-1;
//                 $thumbnail=$result->format[$count]->picture;
//                }
                
                
                $accessToken = "1036215970498341|SnQRE3KgKz3vHGwDbCvSw92L7t0";
                $data = file_get_contents("https://graph.facebook.com/353707671940932/thumbnails?access_token=$accessToken");
                var_dump($data);exit;
                if ($data !== FALSE)
                {
                 $result=json_decode($data);
                 $thumbnail=$result->data[0]->uri;
                }

		return $this->createTempThumbnailFromBody($body);
	}
}