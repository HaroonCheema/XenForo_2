<?php

namespace FS\LatestThread\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
    public function getViewCountKM()
    {
        $number = $this->view_count;
        $precision = 1;

        if ($number >= 1000000000) {
            // Billions
            $shortened = number_format($number / 1000000000, $precision) . 'B';
        } elseif ($number >= 1000000) {
            // Millions
            $shortened = number_format($number / 1000000, $precision) . 'M';
        } elseif ($number >= 1000) {
            // Thousands
            $shortened = number_format($number / 1000, $precision) . 'K';
        } else {
            // Less than 1000
            $shortened = $number;
        }

        // Remove unnecessary decimal places (e.g., "2.0K" -> "2K")
        $shortened = str_replace('.0', '', $shortened);

        return $shortened;
    }

    public function getTimeStampThread()
    {
        // Get current time
        $now = time();

        // Calculate the difference in seconds
        $diff = $now - $this->post_date;

        // Convert the difference into a readable format
        if ($diff < 60) {
            return "just now";
        } elseif ($diff < 3600) {
            $minutes = floor($diff / 60);
            return $minutes . " minute" . ($minutes > 1 ? "s" : "");
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . " hour" . ($hours > 1 ? "s" : "");
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return $days . " day" . ($days > 1 ? "s" : "");
        } elseif ($diff < 2592000) {
            $weeks = floor($diff / 604800);
            return $weeks . " week" . ($weeks > 1 ? "s" : "");
        } elseif ($diff < 31536000) {
            $months = floor($diff / 2592000);
            return $months . " month" . ($months > 1 ? "s" : "");
        } else {
            $years = floor($diff / 31536000);
            return $years . " year" . ($years > 1 ? "s" : "");
        }
    }
}
