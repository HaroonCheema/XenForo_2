<?php

namespace FS\DownloadThreadAttachments\Cron;
ini_set('max_execution_time', 0);

class DownloadSizeLimit
{       
    // Reset the Daily download size limit of all Users. Every day midnight (set daily_download_size column to 0 for all users after 24 hours.)
        public static function resetDailyDownloadSizeLimit()
	{   
            \XF::db()->query('Update xf_user set daily_download_size = 0');      
	}
        
    // Reset the Weekly download size limit of all Users. Every week on Monday midnight (set weekly_download_size column to 0 for all users after 7 days.)
        public static function resetWeeklyDownloadSizeLimit()
	{   
            \XF::db()->query('Update xf_user set weekly_download_size = 0');      
	}
}