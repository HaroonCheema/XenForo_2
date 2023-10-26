<?php

namespace CRUD\XF\Pub\Controller;

// require __DIR__ . '/../../../vendor/autoload.php';

// // use FFMpeg\FFMpeg;
// // use FFMpeg\Coordinate\TimeCode;

// require 'vendor/autoload.php';

// use FFMpeg\FFMpeg;
// use FFMpeg\Coordinate\TimeCode;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;


class Crud extends AbstractController
{

    // public function generateThumbnail()
    // {
    //     try {
    //         // Initialize FFMpeg
    //         $ffmpeg = FFMpeg::create();

    //         // Open the input video file
    //         $video = $ffmpeg->open('video.mp4');

    //         // Capture a frame at the specified time (default: 3 seconds) and save it as a thumbnail
    //         $frame = $video->frame(TimeCode::fromSeconds(2));
    //         $frame->save('thumbnail.jpg');

    //         return true; // Thumbnail capture successful
    //     } catch (\Exception $e) {
    //         // Handle any exceptions, e.g., log the error
    //         error_log('Error capturing thumbnail: ' . $e->getMessage());
    //         return false; // Thumbnail capture failed
    //     }
    // }

    // public function actionIndex(ParameterBag $params)
    // {

    //     $thumb = $this->generateThumbnail();

    //     var_dump($thumb);
    //     exit;

    //     // // Initialize FFMpeg
    //     // $ffmpeg = FFMpeg::create();

    //     // // Open the input video file
    //     // $video = $ffmpeg->open('video.mp4');

    //     // // Capture a frame at 2 seconds and save it as a thumbnail
    //     // $frame = $video->frame(TimeCode::fromSeconds(3));
    //     // $frame->save('thumbnail.jpg');

    //     // exit;


    //     // $sec = 10;
    //     // // $movie = 'test.mp4';
    //     // $thumbnail = 'thumbnail.png';
    //     // $movie = 'data://video/0/330-6ad3a94ff07e7210031a24eeb1f11849.mp4';

    //     // $ffmpeg = FFMpeg\FFMpeg::create();
    //     // $video = $ffmpeg->open($movie);
    //     // $frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($sec));
    //     // $frame->save($thumbnail);
    //     // echo '<img src="' . $thumbnail . '">';

    //     // exit;

    //     // $frame = 1;
    //     // $movie = 'data://video/0/330-6ad3a94ff07e7210031a24eeb1f11849.mp4';
    //     // $thumbnail = 'thumbnail.png';

    //     // $mov = new ffmpeg_movie($movie);
    //     // $frame = $mov->getFrame($frame);

    //     // var_dump($frame);
    //     // exit;
    //     // if ($frame) {
    //     //     $gd_image = $frame->toGDImage();
    //     //     if ($gd_image) {
    //     //         imagepng($gd_image, $thumbnail);
    //     //         imagedestroy($gd_image);
    //     //         echo '<img src="' . $thumbnail . '">';
    //     //     }
    //     // }


    //     $db = $this->app->db();
    //     $em = $this->app->em();
    //     $imageManager = $this->app->imageManager();

    //     /** @var \XF\Entity\AttachmentData $attachData */
    //     $attachData = $em->find('XF:AttachmentData', 331);
    //     // $attachData = $em->find('XF:AttachmentData', 330);
    //     $abstractedPath = $attachData->getAbstractedDataPath();

    //     // if (
    //     //     $attachData && $attachData->width && $attachData->height
    //     //     && $imageManager->canResize($attachData->width, $attachData->height)
    //     //     && $this->app->fs()->has($abstractedPath)
    //     // ) {
    //     $tempFile = \XF\Util\File::copyAbstractedPathToTempFile($abstractedPath);

    //     // var_dump($tempFile);
    //     // exit;

    //     // temp files are automatically cleaned up at the end of the request

    //     /** @var \XF\Service\Attachment\Preparer $insertService */
    //     $insertService = \XF::app()->service('XF:Attachment\Preparer');

    //     $tempThumb = $insertService->generateAttachmentThumbnail($tempFile, $thumbWidth, $thumbHeight);

    //     // var_dump($tempThumb);
    //     // exit;

    //     // echo "<pre>";
    //     // var_dump($tempThumb);
    //     // exit;

    //     // if ($tempThumb) {
    //     $db->beginTransaction();

    //     // $attachData->thumbnail_width = $thumbWidth;
    //     // $attachData->thumbnail_height = $thumbHeight;
    //     // $attachData->save(true, false);

    //     $thumbPath = $attachData->getAbstractedThumbnailPath();

    //     // echo "<pre>";
    //     // var_dump($thumbPath);
    //     // exit;

    //     try {
    //         \XF\Util\File::copyFileToAbstractedPath($tempThumb, $thumbPath);
    //         $db->commit();
    //     } catch (\Exception $e) {
    //         $db->rollback();
    //         $this->app->logException($e, false, "Thumb rebuild for #: ");
    //     }
    //     // }
    //     // }

    //     var_dump("Temp Thumb : " . $tempThumb . "\nTemp Path : " . $thumbPath);
    //     exit;
    // }

    // Fatch all records from xf_crud database

    // http://localhost/xenforo/index.php?crud/


    public function actionIndex(ParameterBag $params)
    {

        $filePath = 'e-dewan
        
        
        // /data/video/29/29528-5c31d513e48b136a676e2f46e012785c.mp4';
        $filePath = 'e-dewan.ams3.cdn.digitaloceanspaces.com/data/video/29/29528-5c31d513e48b136a676e2f46e012785c.mp4';

        // https://e-dewan.ams3.cdn.digitaloceanspaces.com/data/video/29/29528-5c31d513e48b136a676e2f46e012785c.mp4

        // rmdir($file);
        unlink($filePath);

        exit;

        // $adapter = \XF::app()->fileSystem();

        // $filePath = 'e-dewan/data/video/29/29528-5c31d513e48b136a676e2f46e012785c.mp4';

        // $adapter->delete($filePath);

        $finder = $this->finder('CRUD\XF:Crud');

        // ager filter search wala set hai to ye code chaley ga or is k ander wala function or code run ho ga
        if ($this->filter('search', 'uint')) {
            $finder = $this->getCrudSearchFinder();

            if (count($finder->getConditions()) == 0) {
                return $this->error(\XF::phrase('please_complete_required_field'));
            }
        }
        // nai to ye wala run ho ga code jo is ka defaul hai or sarey record show kerwaye ga
        else {
            $finder->order('id', 'DESC');
        }


        $page = $params->page;
        $perPage = 3;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'data' => $finder->fetch(),

            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),

            // ager filter me koch search kia hai to wo is k zareiye hm input tag me show kerwa sakte hain
            'conditions' => $this->filterSearchConditions(),
        ];

        return $this->view('CRUD\XF:Crud\Index', 'crud_record_all', $viewParams);
    }


    public function actionUpload()
    {
        $em = $this->app->em();

        /** @var \XF\Entity\AttachmentData $attachData */
        $attachData = $em->find('XF:AttachmentData', 330);
        $abstractedPath = $attachData->getAbstractedDataPath();

        $abstractedPath = "data://video/0/330-6ad3a94ff07e7210031a24eeb1f11849.mp4";

        $videoFile = $_FILES['bunny_video'];

        $tempFile = $videoFile['tmp_name'];

        $fileDataPath = 'data://CrudTesting/';

        $video = 'data://CrudTesting/Video.mp4';

        // Define the data stream path
        // $videoStreamPath = 'data://CrudTesting/Video.mp4';

        // Read the content of the data stream
        // $videoContents = file_get_contents($videoStreamPath);

        var_dump($videoFile);
        exit;


        $videoExtenion = pathinfo($videoFile['name'], PATHINFO_EXTENSION);

        // $moveVideo = \XF\Util\File::copyFileToAbstractedPath($videoFile['tmp_name'],  $fileDataPath . time() . "." . $videoExtenion);

        $thumbnailPath = $fileDataPath . time() . '_thumbnail.jpg';

        /** @var \XF\Service\Attachment\Preparer $insertService */
        $insertService = \XF::app()->service('XF:Attachment\Preparer');

        $tempThumb = $insertService->generateAttachmentThumbnail($tempFile, $thumbWidth, $thumbHeight);

        var_dump($tempThumb);
        exit;

        $db = $this->app->db();

        if ($tempThumb) {
            $db->beginTransaction();

            // $attachData->thumbnail_width = $thumbWidth;
            // $attachData->thumbnail_height = $thumbHeight;
            // $attachData->save(true, false);

            // $thumbPath = $attachData->getAbstractedThumbnailPath();
            try {
                $thumbIsSave = \XF\Util\File::copyFileToAbstractedPath($tempThumb, $thumbnailPath);
                $db->commit();
            } catch (\Exception $e) {
                $db->rollback();
                $this->app->logException($e, false, "Thumb rebuild for #: ");
            }
        }

        // Generate a video thumbnail using the PHP-FFMpeg library

        var_dump($thumbIsSave);
        exit;


        // Capture the video thumbnail using PHP-FFMpeg (new code)
        // $videoPath = $fileDataPath . basename($moveVideo); // Path to the uploaded video
        // $thumbnailPath = $fileDataPath . time() . '_thumbnail.jpg'; // Path to save the thumbnail

        // if (captureVideoThumbnail($videoPath, $thumbnailPath)) {
        //     // Thumbnail capture successful
        //     echo 'Video and thumbnail uploaded successfully.';
        // } else {
        //     // Thumbnail capture failed
        //     echo 'Error capturing video thumbnail.';
        // }

        // exit;
        // $ffmpegCommand = "ffmpeg -i " . escapeshellarg($videoFile['tmp_name']) . " -ss 00:00:02 -vframes 1 " . escapeshellarg($thumbnailPath);

        // exec($ffmpegCommand);

        // // var_dump(exec($ffmpegCommand));
        // // exit;

        // if (file_exists($thumbnailPath)) {
        //     $videoThumbnail = $thumbnailPath;
        // } else {
        //     $videoThumbnail = null;
        // }

        var_dump("videoThumbnail : " . $videoThumbnail);
        exit;

        $viewParams = [
            'status' => $moveVideo ?  true : false,
            'bunnyVideoId' => $createVideo ? $createVideo['guid'] : ''
        ];

        $this->setResponseType('json');
        $view = $this->view();
        $view->setJsonParam('data', $viewParams);
        return $view;
    }

    public function actionAdd()
    {
        $crud = $this->em()->create('CRUD\XF:Crud');
        return $this->crudAddEdit($crud);
    }

    public function actionEdit(ParameterBag $params)
    {
        $crud = $this->assertDataExists($params->id);
        return $this->crudAddEdit($crud);
    }

    protected function crudAddEdit(\CRUD\XF\Entity\Crud $crud)
    {
        $viewParams = [
            'crud' => $crud
        ];

        return $this->view('CRUD\XF:Crud\Add', 'crud_record_insert', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->id) {
            $crud = $this->assertDataExists($params->id);
        } else {
            $crud = $this->em()->create('CRUD\XF:Crud');
        }

        $this->crudSaveProcess($crud)->run();

        return $this->redirect($this->buildLink('crud'));
    }

    protected function crudSaveProcess(\CRUD\XF\Entity\Crud $crud)
    {
        $input = $this->filter([
            'name' => 'str',
            'class' => 'str',
            'rollNo' => 'int',
        ]);

        $form = $this->formAction();
        $form->basicEntitySave($crud, $input);

        return $form;
    }

    public function actionDeleteRecord(ParameterBag $params)
    {
        $replyExists = $this->assertDataExists($params->id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $replyExists,
            $this->buildLink('crud/delete-record', $replyExists),
            null,
            $this->buildLink('crud'),
            "{$replyExists->id} - {$replyExists->name}"
        );
    }

    // plugin for check id exists or not 

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \CRUD\XF\Entity\Crud
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('CRUD\XF:Crud', $id, $extraWith, $phraseKey);
    }

    // filter bar k input tag k ander value ko get or set krney k liye ye method call kr rahey hain

    protected function filterSearchConditions()
    {
        return $this->filter([
            'name' => 'str',
            'rClass' => 'str',
            'rollNo' => 'str',
        ]);
    }

    // filter wala form show kerwaney k liye ye use ho ga

    public function actionRefineSearch()
    {

        $viewParams = [
            'conditions' => $this->filterSearchConditions(),
        ];

        return $this->view('CRUD\XF:Crud\RefineSearch', 'crud_record_search_filter', $viewParams);
    }

    // ider hm condition apply kr rahey hain kr filter me koi ho gi to or wapis index waley function me return kr k result ko show kerwa rahey hain

    protected function getCrudSearchFinder()
    {
        $conditions = $this->filterSearchConditions();

        $finder = $this->finder('CRUD\XF:Crud');

        if ($conditions['name'] != '') {
            $finder->where('name', 'LIKE', '%' . $finder->escapeLike($conditions['name']) . '%');
        }

        if ($conditions['rClass'] != '') {
            $finder->where('class', 'LIKE', '%' . $finder->escapeLike($conditions['rClass']) . '%');
        }

        if ($conditions['rollNo'] != '') {
            $finder->where('rollNo', 'LIKE', '%' . $finder->escapeLike($conditions['rollNo']) . '%');
        }

        return $finder;
    }
}
