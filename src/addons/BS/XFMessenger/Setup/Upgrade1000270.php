<?php

namespace BS\XFMessenger\Setup;

use XF\Db\Schema\Alter;

trait Upgrade1000270
{
    public function upgrade1000270Step1()
    {
        $sm = $this->schemaManager();
        $sm->alterTable('xf_conversation_message', static function (Alter $table) {
            $table->addColumn('xfm_message_date', 'bigint', 20)
                ->nullable(true)
                ->setDefault(null);
        });
    }

    public function upgrade1000270Step2()
    {
        $this->updateXfmMessageDateInMessages();
    }

    protected function updateXfmMessageDateInMessages()
    {
        $this->db()->query("
            UPDATE xf_conversation_message
            SET xfm_message_date = message_date * 1000
            WHERE xfm_message_date IS NULL
        ");
    }

    public function upgrade1000270Step3()
    {
        $sm = $this->schemaManager();
        $sm->alterTable('xf_conversation_user', static function (Alter $table) {
            $table->addColumn('xfm_last_message_date', 'bigint', 20)
                ->nullable(false)
                ->setDefault(0);
        });
    }

    public function upgrade1000270Step4()
    {
        $this->updateXfmLastMessageDateInConvUsers();
    }

    protected function updateXfmLastMessageDateInConvUsers()
    {
        $this->db()->query("
            UPDATE xf_conversation_user
            SET xfm_last_message_date = last_message_date * 1000
            WHERE xfm_last_message_date = 0
        ");
    }

    public function upgrade1000270Step5()
    {
        $sm = $this->schemaManager();
        $sm->alterTable('xf_conversation_recipient', static function (Alter $table) {
            $table->addColumn('xfm_last_read_date', 'bigint', 20)
                ->nullable(false)
                ->setDefault(0);
        });
    }

    public function upgrade1000270Step6()
    {
        $this->updateXfmLastReadDateInConvRecipients();
    }

    protected function updateXfmLastReadDateInConvRecipients()
    {
        $this->db()->query("
            UPDATE xf_conversation_recipient
            SET xfm_last_read_date = last_read_date * 1000
            WHERE xfm_last_read_date = 0
        ");
    }
}
