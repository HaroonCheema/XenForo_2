<?php

class VideoThumbnailGenerator
{
    protected $ffmpegPath;
    protected $thumbnailDir;

    public function __construct($ffmpegPath, $thumbnailDir)
    {
        $this->ffmpegPath = $ffmpegPath;
        $this->thumbnailDir = $thumbnailDir;

        if (!file_exists($this->ffmpegPath)) {
            throw new Exception('FFmpeg is not installed or the path is incorrect.');
        }

        if (!is_dir($this->thumbnailDir)) {
            mkdir($this->thumbnailDir, 0755, true);
        }
    }

    public function getTempThumbnailFromFfmpeg($abstractedDestination, $mediaType)
    {
        // Get the uploaded video file via the request
        $uploadedFile = $this->request->getFile('upload');

        // Ensure the file exists and is a valid video
        if (!$uploadedFile || !$uploadedFile->isValid() || $mediaType !== 'video') {
            return false;
        }

        // Move the uploaded file to a temporary directory
        $sourceFile = 'uploads/' . basename($uploadedFile->getClientFilename());
        $uploadedFile->moveTo($sourceFile);

        // Generate the thumbnail filename based on the video file name
        $thumbnailFile = $this->thumbnailDir . pathinfo($sourceFile, PATHINFO_FILENAME) . '.jpg';

        // Command to generate the thumbnail using FFmpeg
        $command = escapeshellcmd("{$this->ffmpegPath} -i " . escapeshellarg($sourceFile) . " -ss 00:00:01.000 -vframes 1 " . escapeshellarg($thumbnailFile));

        // Execute the FFmpeg command
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            return false; // Error during thumbnail generation
        }

        // Check if thumbnail file was created successfully
        if (!file_exists($thumbnailFile)) {
            return false;
        }

        // Check if the image can be resized (optional check)
        $imageInfo = @getimagesize($thumbnailFile);
        if (!$imageInfo) {
            return false;
        }

        // If the image is valid, copy the generated thumbnail to the abstracted path
        try {
            $this->copyThumbnailToDestination($thumbnailFile, $abstractedDestination);
        } catch (Exception $e) {
            // Handle any errors during the copy process
            return false;
        }

        return true;
    }

    protected function copyThumbnailToDestination($thumbnailFile, $abstractedDestination)
    {
        if (!copy($thumbnailFile, $abstractedDestination)) {
            throw new Exception("Error copying thumbnail to destination.");
        }

        // Optionally, delete the temporary thumbnail after copying
        unlink($thumbnailFile);
    }
}

// Usage example:

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $ffmpegPath = '/usr/bin/ffmpeg'; // Adjust according to your server configuration
        $thumbnailDir = 'thumbnails/';
        $destination = 'uploads/abstracted_destination.jpg'; // Specify the final destination for the thumbnail

        $videoThumbnailGenerator = new VideoThumbnailGenerator($ffmpegPath, $thumbnailDir);

        if ($videoThumbnailGenerator->getTempThumbnailFromFfmpeg($destination, 'video')) {
            echo "<h3>Thumbnail generated successfully!</h3>";
            echo "<img src='$destination' alt='Thumbnail'>";
        } else {
            echo "<p>There was an error generating the thumbnail.</p>";
        }
    } catch (Exception $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>
