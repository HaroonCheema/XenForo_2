<?php

namespace FS\DownloadThreadAttachments\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FS\DownloadThreadAttachments\Helper;

class Post extends XFCP_Post
{
    public function actionExportAttachments(ParameterBag $params)
    {
        $post = $this->assertViewablePost($params->post_id);
        
        if (!$post->Thread->canViewAttachments()) 
        {
            return $this->noPermission();
        }
        
        $visitor = \XF::visitor();
        // till now, guest user not allow to download (in future may be allowed then remove this conditaion and manage the guset downloadSize record )
        if (!$visitor->user_id) 
        {
            return $this->noPermission();
        }
        
        $userGroup = $this->getDisplayStyleGroup($visitor); // get user's displayStyleGroupId and get userGroup

                                    // Convert GB into Bytes
        $downloadSizeLimit = $this->gigabytesToBytes($userGroup->download_size_limit);
        $dailyDownloadSizeLimit = $this->gigabytesToBytes($userGroup->daily_download_size_limit);
        $weeklyDownloadSizeLimit = $this->gigabytesToBytes($userGroup->weekly_download_size_limit);
        
        $visitorDailyDownloadSize = $visitor->daily_download_size;
        $visitorWeeklyDownloadSize = $visitor->weekly_download_size;

        
        $attachments = $post->Attachments;

        if (!count($attachments)) throw $this->exception($this->notFound(\XF::phrase('fs_no_attachments_exist_in_this_post')));

        // this can be get via XenForo's entity system but with the help of lood on $attachments
        $sizeOfAttachments = $this->getPostAttachmentsSize($post);
        
        $templater = $this->app->templater();
        
        // -------------------------- Check Download Size Limits --------------------------
        if($downloadSizeLimit)
        {
            if ($sizeOfAttachments > $downloadSizeLimit)
            {
                $params = [
                    'downloadSizeLimit' => $templater->filterFileSize($templater, $downloadSizeLimit, $escape),
                    'sizeOfAttachments'  => $templater->filterFileSize($templater, $sizeOfAttachments, $escape),
                ];

                throw $this->exception($this->notFound(\XF::phrase('fs_dta_requested_file_size_is_larger_then_your_download_size_limit', $params)));
            }  
        }
        
        // -------------------------- Check Daily Download Size Limits --------------------------
        if($dailyDownloadSizeLimit)
        {
            if ($visitorDailyDownloadSize >= $dailyDownloadSizeLimit)
            {
                $params = [
                    'visitorDailyDownloadSize' => $templater->filterFileSize($templater, $visitorDailyDownloadSize, $escape),
                    'dailyDownloadSizeLimit'   => $templater->filterFileSize($templater, $dailyDownloadSizeLimit, $escape),
                ];

                throw $this->exception($this->notFound(\XF::phrase('fs_dta_daily_download_size_limit_reached',$params)));
            }
            
            $dailyRemainingDownloadSize = $dailyDownloadSizeLimit - $visitorDailyDownloadSize;
            
            if ($dailyRemainingDownloadSize < $sizeOfAttachments)
            {
                $params = [
                    'dailyRemainingDownloadSize' => $templater->filterFileSize($templater, $dailyRemainingDownloadSize, $escape),
                    'sizeOfAttachments'  => $templater->filterFileSize($templater, $sizeOfAttachments, $escape),
                ];

                throw $this->exception($this->notFound(\XF::phrase('fs_dta_requested_file_size_is_larger_then_your_daily_remaining_download_size', $params)));
            }  
        }
    
        // -------------------------------- Check weekly Download Size Limits ------------------------------ 
        if($weeklyDownloadSizeLimit)
        {
            if ($visitorWeeklyDownloadSize >= $weeklyDownloadSizeLimit)
            {
                $params = [
                    'visitorWeeklyDownloadSize' => $templater->filterFileSize($templater, $visitorWeeklyDownloadSize, $escape),
                    'weeklyDownloadSizeLimit'   => $templater->filterFileSize($templater, $weeklyDownloadSizeLimit, $escape),
                ];

                throw $this->exception($this->notFound(\XF::phrase('fs_dta_weekly_download_size_limit_reached',$params)));
            }
            
            $weeklyRemainingDownloadSize = $weeklyDownloadSizeLimit - $visitorWeeklyDownloadSize;
            
            if ($weeklyRemainingDownloadSize < $sizeOfAttachments)
            {
                $params = [
                   'weeklyRemainingDownloadSize' => $templater->filterFileSize($templater,  $weeklyRemainingDownloadSize, $escape),
                   'sizeOfAttachments'  => $templater->filterFileSize($templater,  $sizeOfAttachments, $escape),
               ];

               throw $this->exception($this->notFound(\XF::phrase('fs_dta_requested_file_size_is_larger_then_your_weekly_remaining_download_size', $params)));
           }
        }
        // --------------------------------------------------------------------------------------------------
        
        
        if ($this->isPost()) 
        {
            $rootPath = \XF::getRootDirectory();
            $visitor = \XF::visitor();
            
//            $threadTitle = Helper::prepareStringForUrl($post->Thread->title);
//            
            // ----------- get $firstFewWordsOfPost --------------
            $postMessage = $post->message;
            if(strlen($postMessage) > 5)
            {
                $firstFewWordsOfPost = substr($postMessage, 0, strpos($postMessage, ' ', 5));
            }
            else
            {
                $firstFewWordsOfPost = $postMessage;
            }
            //------------------------------------
            
            if(strlen($firstFewWordsOfPost) > 15)  // subtract str to 15 characters
            {
                $firstFewWordsOfPost = substr($firstFewWordsOfPost, 0, 15);
            }
            

            $firstFewWordsOfPost = Helper::prepareStringForUrl($firstFewWordsOfPost);
            
            
            $fileName = $firstFewWordsOfPost . '-' . $post->post_id . '-' . $visitor->user_id . '-All-Attachments-' . date("Y-m-d");

            $destinationDirPath = $rootPath . '/internal_data/fs_thread_attachments/' .  $fileName;

            foreach ($attachments as $attachment) 
            {
                $sourcePath = $rootPath . '/' . sprintf('internal_data/attachments/%d/%d-' . $attachment->Data->file_hash . '.data', floor($attachment->data_id / 1000), $attachment->data_id);

                if (!file_exists($destinationDirPath)) 
                {
                    mkdir($destinationDirPath, 0777, true);
                }

                if (file_exists($sourcePath)) 
                {
                    copy($sourcePath, $destinationDirPath . '/' . $attachment->getFilename());
                }
            }
            
            $this->addTxtFile($post, $destinationDirPath);

            $fileName .= '.zip';

            $finalZip = $this->MakeZip($destinationDirPath, $fileName, $download = true);

            $this->setResponseType('raw');
            $viewParams = [
                'zipFile' => $finalZip,
                'fileName' =>  $fileName,
                'dirPath' => $destinationDirPath,
                'sizeOfAttachments'  => $sizeOfAttachments,
            ];

            return $this->view('FS\DownloadThreadAttachments\XF\Pub\Views\DownloadZip', '', $viewParams);
        }

        // ----------- confirm page params -----------
        $params = [
            'post' => $post,
            'sizeOfAttachments' => $sizeOfAttachments ?? 0,
            
            'dailyDownloadSizeLimit' => $dailyDownloadSizeLimit,
            'weeklyDownloadSizeLimit' => $weeklyDownloadSizeLimit,
            
            'visitorDailyDownloadSize' => $visitorDailyDownloadSize,
            'visitorWeeklyDownloadSize' => $visitorWeeklyDownloadSize,
            
            'dailyRemainingDownloadSize' => isset($dailyRemainingDownloadSize)? $dailyRemainingDownloadSize: 0,
            'weeklyRemainingDownloadSize' => isset($weeklyRemainingDownloadSize) ? $weeklyRemainingDownloadSize : 0,
        ];
        // ----------------------------------------
        
        return $this->view('FS\DownloadThreadAttachments:Post', 'fs_export_post_attachments_confirm', $params);
    }
    

    public function MakeZip($rootPath, $zipName, $download)
    {
        $zip = new \ZipArchive();

        $zip->open($zipName, \ZipArchive::CREATE);



        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );


        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        return $zip->filename;
    }
    
    
    
    protected function gigabytesToBytes($gigabytes) 
    {
        // 1 gigabyte is equal to 1,073,741,824 bytes (2^30 bytes).
        $bytes = $gigabytes * pow(2, 30);
        return $bytes;
    }
    
    
    
    protected function getDisplayStyleGroup(\XF\Entity\User $visitor)
    {
        $dispayStyleGroupId = $visitor->display_style_group_id ?: $this->repository('XF:UserGroup')->getDisplayGroupIdForUser($visitor);
        
        $userGroup = $this->em()->find('XF:UserGroup',$dispayStyleGroupId);
        if(!$userGroup)
        {
            throw $this->exception($this->notFound(\XF::phrase('fs_dta_requested_userGroup_not_found')));
        }
        
        return $userGroup;
    }
    
    protected function getPostAttachmentsSize(\XF\Entity\Post $post)
    {
        $sizeOfAttachments = $this->app()->db()->fetchOne("
                            SELECT SUM(a_data.file_size) AS total_size
                            FROM xf_attachment AS a
                            INNER JOIN xf_attachment_data AS a_data ON (a.data_id = a_data.data_id)
                            WHERE a.content_type = 'post'
                            AND a.content_id = ?
                        ", $post->post_id);
        
        return $sizeOfAttachments;
    }
    
    
    protected function addTxtFile($post, $destinationDirPath)
    {   
        $postFulLink = $post->getContentUrl(true);

        $stringFormatter = $this->app()->stringFormatter();

        $postMessage = $stringFormatter->stripBbCode($post->message, [
            'stripQuote' => true,
        ]);

        $textFileName = "Post Message.txt"; // Name of the text file
        $fileContent = $postMessage . "\n\nPost Url :-  $postFulLink";

        // Path to the text file
        $textFilePath = $destinationDirPath . "/" . $textFileName;

        // Create the text file and write content to it
        file_put_contents($textFilePath, $fileContent);
    }
}
