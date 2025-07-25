<?php

namespace FS\BulkMailer\Job;

use XF\Job\AbstractJob;
require __DIR__ . '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProcessFile extends AbstractJob
{
    protected $defaultData = [
        'mailing_list_id' => 0,
        'position' => 0
    ];

    public function run($maxRunTime)
    {
        $currentTime = \xf::$time;
        
        $mailingList = $this->app->finder('FS\BulkMailer:MailingList')
            ->where('mailing_list_id', $this->data['mailing_list_id'])
            ->fetchOne();

        if (!$mailingList || !$mailingList->file_path) {
            return $this->complete();
        }

        $filePath = \XF::getRootDirectory() . '/data/email-lists/' . $mailingList->file_path;
        $spreadsheet = IOFactory::load($filePath);
        
        
        $worksheet = $spreadsheet->getActiveSheet();
        $totalRows = $worksheet->getHighestRow();
        
        $db = $this->app->db();

        for ($row = 1; $row <= $totalRows; $row++) {
            
            $email = $worksheet->getCell('A' . $row)->getValue();
            
            $emailValidation=filter_var($email, FILTER_VALIDATE_EMAIL);
            
            if ($emailValidation) {
                
                $db->insert('xf_fs_mail_queue', [
                    'mailing_list_id' => $mailingList->mailing_list_id,
                    'email' => $email,
                    'status' => 'pending'
                ]);
                
            }elseif(!$emailValidation){
                
                $db->insert('xf_fs_mail_queue', [
                    'mailing_list_id' => $mailingList->mailing_list_id,
                    'email' => $email,
                    'status' => 'invalid'
                ]);
            }
        }

       
        
        if ($totalRows) {
            
            $mailingList->total_emails = $db->fetchOne('SELECT COUNT(*) FROM xf_fs_mail_queue WHERE mailing_list_id = ?', [$mailingList->mailing_list_id]);
            
            $mailingList->process_status=0;
            
            $mailingList->next_run= $currentTime + 1200;
            
            $mailingList->save();
            
            return $this->complete();
        }
        
        return $this->complete();


    }
    
    public function getStatusMessage()
    {
    }

    public function canCancel()
    {
        return true;
    }

    public function canTriggerByChoice()
    {
        return true;
    }
}