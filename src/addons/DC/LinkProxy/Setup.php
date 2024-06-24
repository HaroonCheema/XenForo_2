<?php

namespace DC\LinkProxy;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;


    public function installStep1()
    {
        $this->createTabeForLinks();
    }

    /**
     * @param array $stateChanges
     *
     * @throws \Exception
     * @throws \XF\PrintableException
     */
    public function postInstall(array &$stateChanges)
    {
        /** @var \XF\Mvc\Router $router */
        $router = $this->app->container('router.public');

        $link = $router->buildLink('canonical:link-proxy-passwords');

        $embedLink = \XF::em()->create('DC\LinkProxy:EmbedLink');

        $embedLink->embed_link = $link;

        $embedLink->save();
    }


    public function uninstallStep1()
    {
        $sm = $this->schemaManager();
        $sm->dropTable('fs_link_Proxy_list');
        $sm->dropTable('fs_link_Proxy_tfa_auth');
        $sm->dropTable('fs_link_Proxy_embed_link');
    }

    protected function createTabeForLinks()
    {

        $this->createTable('fs_link_Proxy_list', function (\XF\Db\Schema\Create $table) {
            $table->addColumn('list_id', 'int')->autoIncrement();
            $table->addColumn('user_group_id', 'int')->nullable();
            $table->addColumn('redirect_time', 'int')->nullable();
            $table->addColumn('link_redirect_html', 'text')->nullable();
        });

        $this->createTable('fs_link_Proxy_tfa_auth', function (\XF\Db\Schema\Create $table) {
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('auth_password', 'mediumtext');
            $table->addColumn('created_at', 'int');
            $table->addColumn('expired_at', 'int');
            $table->addPrimaryKey('id');
        });

        $this->createTable('fs_link_Proxy_embed_link', function (\XF\Db\Schema\Create $table) {
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('embed_link', 'mediumtext');
            $table->addPrimaryKey('id');
        });
    }

    public function upgrade1020900Step1()
    {
        $this->createTable('fs_link_Proxy_embed_link', function (\XF\Db\Schema\Create $table) {
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('embed_link', 'mediumtext');
            $table->addPrimaryKey('id');
        });
    }

    /**
     * @param $previousVersion
     * @param array $stateChanges
     */
    protected function postUpgrade1020900($previousVersion, array &$stateChanges)
    {
        /** @var \XF\Mvc\Router $router */
        $router = $this->app->container('router.public');

        $link = $router->buildLink('canonical:link-proxy-passwords');

        $embedLink = \XF::em()->create('DC\LinkProxy:EmbedLink');

        $embedLink->embed_link = $link;

        $embedLink->save();
    }

    protected function generateTfaPassword($length = 10)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
