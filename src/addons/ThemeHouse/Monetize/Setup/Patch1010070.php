<?php

namespace ThemeHouse\Monetize\Setup;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;
use XF\Db\SchemaManager;

/**
 * Trait Patch1010070
 * @package ThemeHouse\Monetize\Setup
 *
 * @method SchemaManager schemaManager
 */
trait Patch1010070
{
    /**
     *
     */
    public function upgrade1010070Step1()
    {
        if ($this->schemaManager()->tableExists('xf_th_monetize_alert')) {
          $this->schemaManager()->alterTable('xf_th_monetize_alert', function (Alter $table) {
              $table->renameColumn('limit_alerts', 'limit');
          });
        }
    }

    /**
     *
     */
    public function upgrade1010070Step2()
    {
        if ($this->schemaManager()->tableExists('xf_th_monetize_email')) {
            $this->schemaManager()->alterTable('xf_th_monetize_email', function (Alter $table) {
                $table->renameColumn('limit_emails', 'limit');
            });
        }
    }

    /**
     *
     */
    public function upgrade1010070Step3()
    {
        if ($this->schemaManager()->tableExists('xf_th_monetize_message')) {
            $this->schemaManager()->alterTable('xf_th_monetize_message', function (Alter $table) {
                $table->renameColumn('limit_messages', 'limit');
            });
        }
    }

    /**
     *
     */
    public function upgrade1010070Step4()
    {
        $this->schemaManager()->createTable('xf_th_monetize_communication_log', function (Create $table) {
            $table->addColumn('communication_log_id', 'int')->nullable()->autoIncrement();
            $table->addColumn('content_type', 'enum')->values(['email', 'alert', 'message']);
            $table->addColumn('content_id', 'int');
            $table->addColumn('log_date', 'int')->setDefault(0);
            $table->addColumn('user_id', 'int');
        });
    }

    /**
     * @throws \XF\Db\Exception
     */
    public function upgrade1010070Step5()
    {
        $db = \XF::db();
        if ($this->schemaManager()->tableExists('xf_th_monetize_email_log')) {
            $db->query("
        INSERT INTO
          xf_th_monetize_communication_log
        SELECT
          null AS communication_log_id,
          'email' AS content_type,
          email_id AS content_id,
          log_date,
          user_id
        FROM
          xf_th_monetize_email_log
    ");
        }
    }

    /**
     * @throws \XF\Db\Exception
     */
    public function upgrade1010070Step6()
    {
        $db = \XF::db();
        if ($this->schemaManager()->tableExists('xf_th_monetize_message_log')) {
            $db->query("
        INSERT INTO
          xf_th_monetize_communication_log
        SELECT
          null AS communication_log_id,
          'message' AS content_type,
          message_id AS content_id,
          log_date,
          user_id
        FROM
          xf_th_monetize_message_log
    ");
        }
    }

    /**
     * @throws \XF\Db\Exception
     */
    public function upgrade1010070Step7()
    {
        $db = \XF::db();
        if ($this->schemaManager()->tableExists('xf_th_monetize_alert_log')) {
            $db->query("
        INSERT INTO
          xf_th_monetize_communication_log
        SELECT
          null AS communication_log_id,
          'alert' AS content_type,
          alert_id AS content_id,
          log_date,
          user_id
        FROM
          xf_th_monetize_alert_log
    ");
        }
    }

    /**
     *
     */
    public function upgrade1010070Step8()
    {
        if($this->schemaManager()->tableExists('xf_th_monetize_email_log')) {
            $this->schemaManager()->dropTable('xf_th_monetize_email_log');
        }
    }

    /**
     *
     */
    public function upgrade1010070Step9()
    {
        if($this->schemaManager()->tableExists('xf_th_monetize_message_log')) {
            $this->schemaManager()->dropTable('xf_th_monetize_message_log');
        }
    }

    /**
     *
     */
    public function upgrade1010070Step10()
    {
        if($this->schemaManager()->tableExists('xf_th_monetize_alert_log')) {
            $this->schemaManager()->dropTable('xf_th_monetize_alert_log');
        }
    }

    /**
     *
     */
    public function upgrade1010070Step11()
    {
      if (!$this->schemaManager()->tableExists('xf_th_monetize_communication')) {
          $this->schemaManager()->createTable('xf_th_monetize_communication', function (Create $table) {
              $table->addColumn('communication_id', 'int')->nullable()->autoIncrement();
              $table->addColumn('send_rules', 'blob');
              $table->addColumn('title', 'varchar', 150);
              $table->addColumn('body', 'text');
              $table->addColumn('active', 'tinyint')->setDefault(1);
              $table->addColumn('user_upgrade_criteria', 'blob');
              $table->addColumn('user_criteria', 'blob');
              $table->addColumn('next_send', 'int')->setDefault(0);
              $table->addColumn('limit_days', 'int')->setDefault(0);
              $table->addColumn('limit', 'int')->setDefault(0);
              $table->addColumn('user_id', 'int')->nullable();
              $table->addColumn('type_options', 'blob');
              $table->addColumn('type', 'enum')->values(['email', 'alert', 'message']);
              $table->addColumn('old_id', 'int')->setDefault(0);
          });
      }
    }

    /**
     * @param array $array
     * @param array $keys
     * @return array
     */
    private function split_array(array $array, array $keys)
    {
        $remainingKeys = array_diff(array_keys($array), $keys);
        $keys = array_flip($keys);

        return [array_intersect_key($array, array_flip($remainingKeys)), array_intersect_key($array, $keys)];
    }

    /**
     *
     */
    public function upgrade1010070Step12()
    {
        if ($this->schemaManager()->tableExists('xf_th_monetize_email')) {
            $emails = \XF::db()->fetchAll('
            SELECT
              *
            FROM
              xf_th_monetize_email
        ');

            $newEmails = [];
            foreach ($emails as $email) {
                list($email, $typeOptions) = $this->split_array($email,
                    ['receive_admin_email_only', 'unsub', 'wrapped', 'format', 'from_name', 'from_email']);

                $newEmail = array_merge([
                    'type' => 'email',
                    'type_options' => json_encode($typeOptions),
                    'old_id' => $email['email_id'],
                    'limit' => isset($email['limit_emails']) ? $email['limit_emails'] : null
                ], $email);

                unset($newEmail['email_id'], $newEmail['limit_emails']);
                $newEmails[] = $newEmail;
            }
            if (!empty($newEmails)) {
                \XF::db()->insertBulk('xf_th_monetize_communication', $newEmails);
            }
        }
    }

    /**
     *
     */
    public function upgrade1010070Step13()
    {
        if ($this->schemaManager()->tableExists('xf_th_monetize_alert')) {
            $alerts = \XF::db()->fetchAll('
            SELECT
              *
            FROM
              xf_th_monetize_alert
        ');

            $newAlerts = [];
            foreach ($alerts as $alert) {
                list($alert, $typeOptions) = $this->split_array($alert,
                    ['link_url', 'link_title']);

                $newAlert = array_merge([
                    'type' => 'alert',
                    'type_options' => json_encode($typeOptions),
                    'old_id' => $alert['alert_id'],
                    'limit' => isset($email['limit_alerts']) ? $email['limit_alerts'] : null
                ], $alert);

                unset($newAlert['alert_id'], $newAlert['limit_alerts']);
                $newAlerts[] = $newAlert;
            }
            if (!empty($newAlerts)) {
                \XF::db()->insertBulk('xf_th_monetize_communication', $newAlerts);
            }
        }
    }

    /**
     *
     */
    public function upgrade1010070Step14()
    {
        if ($this->schemaManager()->tableExists('xf_th_monetize_message')) {
            $messages = \XF::db()->fetchAll('
            SELECT
              *
            FROM
              xf_th_monetize_message
        ');

            $newMessages = [];
            foreach ($messages as $message) {
                list($message, $typeOptions) = $this->split_array($message,
                    ['open_invite', 'conversation_locked', 'delete_type']);

                $newMessage = array_merge([
                    'type' => 'message',
                    'type_options' => json_encode($typeOptions),
                    'old_id' => $message['message_id'],
                    'limit' => isset($email['limit_messages']) ? $email['limit_messages'] : null
                ], $message);

                unset($newMessage['message_id'], $newMessage['limit_messages']);
                $newMessages[] = $newMessage;
            }
            if (!empty($newMessages)) {
                \XF::db()->insertBulk('xf_th_monetize_communication', $newMessages);
            }
        }
    }

    /**
     */
    public function upgrade1010070Step15()
    {
        \XF::db()->beginTransaction();

        $this->schemaManager()->alterTable('xf_th_monetize_communication', function (Alter $table) {
            $table->addColumn('old_id', 'int')->setDefault(0);
        });

        $this->schemaManager()->alterTable('xf_th_monetize_communication_log', function (Alter $table) {
            $table->addColumn('communication_id', 'int')->setDefault(0);
        });

        $communcations = \XF::db()->fetchAll('
        SELECT
          communication_id,
          type,
          old_id
        FROM
          xf_th_monetize_communication
    ');

        foreach ($communcations as $communcation) {
            \XF::db()->update('xf_th_monetize_communication_log',
                ['communication_id' => $communcation['communication_id']],
                'content_type = ? AND content_id = ?',
                [$communcation['type'], $communcation['old_id']]);
        }

        $this->schemaManager()->alterTable('xf_th_monetize_communication', function (Alter $table) {
            $table->dropColumns(['old_id']);
        });

        $this->schemaManager()->alterTable('xf_th_monetize_communication_log', function (Alter $table) {
            $table->dropColumns(['content_type', 'content_id']);
        });

        \XF::db()->commit();
    }

    /**
     *
     */
    public function upgrade1010070Step16()
    {
        \XF::db()->insertBulk('xf_route_filter', [
            [
                'prefix' => 'thmonetize-affiliate-links',
                'find_route' => 'thmonetize-affiliate-links',
                'replace_route' => 'affiliate-links',
                'enabled' => 1,
                'url_to_route_only' => 0
            ],
            [
                'prefix' => 'thmonetize-sponsors',
                'find_route' => 'thmonetize-sponsors',
                'replace_route' => 'sponsors',
                'enabled' => 1,
                'url_to_route_only' => 0
            ]
        ], false, false, 'IGNORE');

        /** @var \XF\Repository\RouteFilter $repo */
        $repo = \XF::repository('XF:RouteFilter');
        \XF::runOnce('routeFilterCachesRebuild', function () use ($repo) {
            $repo->rebuildRouteFilterCache();
        });
    }

    /**
     *
     */
    public function upgrade1010070Step17()
    {
        $this->schemaManager()->alterTable('xf_th_monetize_sponsor', function (Alter $table) {
            $table->addColumn('notes', 'text')->nullable();
        });
    }

    /**
     *
     */
    public function upgrade1010070Step18()
    {
        $upgrades = \XF::db()->fetchAll('select * from xf_user_upgrade');

        foreach ($upgrades as $upgrade) {
            if ($upgrade['thmonetize_features']) {
                $oldFeatures = json_decode($upgrade['thmonetize_features']);

                if (is_array($oldFeatures)) {
                    $newFeatures = [];
                    foreach ($oldFeatures as $feature) {
                        $newFeatures[] = [
                            'text' => $feature,
                            'description' => '',
                        ];
                    }

                    $this->db()->update('xf_user_upgrade', [
                        'thmonetize_features' => json_encode($newFeatures),
                    ], 'user_upgrade_id = ?', [$upgrade['user_upgrade_id']]);
                }
            }
        }
    }

    public function upgrade1010111Step1() {
        $this->schemaManager()->alterTable('xf_user_upgrade', function(Alter $table) {
            $table->addColumn('thmonetize_redirect_url', 'text')->nullable();
        });
    }
}