<?php

namespace DC\LinkProxy\Pub\Controller;

use XF\Pub\Controller\AbstractController;

class Passwords extends AbstractController
{
    public function actionIndex()
    {
        $options = $this->options();

        $host = $options->DC_LinkProxy_db_host;
        $dbname = $options->DC_LinkProxy_db_name;
        $username = $options->DC_LinkProxy_db_username;
        $dbPassword = $options->DC_LinkProxy_db_password;

        $errors = array();

        $config = [
            'host' => $host,
            'dbname' => $dbname,
            'username' => $username,
            'password' => $dbPassword,
            'port' => 3306,
            'charset' => 'utf8mb4',
            'tablePrefix' => '',
        ];

        try {
            $sourceDb = new \XF\Db\Mysqli\Adapter($config, false);
            $sourceDb->getConnection();

            // $sourceDb->isConnected();

            $validDbConnection = true;

            $passwords = $sourceDb->fetchAll('SELECT * FROM fs_link_Proxy_tfa_auth WHERE expired_at > ?', time());
        } catch (\XF\Db\Exception $e) {

            $errors[] = \XF::phrase('source_database_connection_details_not_correct_x', ['message' => $e->getMessage()]);
            $passwords = $this->Finder('DC\LinkProxy:TFAuth')->where('expired_at', '>', time())->fetch();
        }

        $viewParams = [

            'passwords' => $passwords,
            'total' => count($passwords),
        ];

        return $this->view('DC\LinkProxy:LinkProxy', 'dc_link_proxy_passwords', $viewParams);
    }
}
