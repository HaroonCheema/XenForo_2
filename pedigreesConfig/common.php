<?php
define('__XF__', dirname(__DIR__));
require __XF__ . '/src/XF.php';

\XF::start(__XF__);

$app = \XF::setupApp('XF\Pub\App');

return [
    'app'      => $app,
    'request'  => $app->request(),
    'session'  => $app->session(),
    'db'       => \XF::db(),
    'visitor'  => \XF::em()->find('XF:User', $app->session()->get('userId')),
    // 'sourceDb' => \ScriptsPages\Setup::dbConnection('xenforo', 'admin', 'admin123')
    'sourceDb' => \ScriptsPages\Setup::dbConnection('visegrip_database', 'admin', 'admin123')
    // 'sourceDb' => \ScriptsPages\Setup::dbConnection('visegrip_database', 'natebull_forums_user', 'kw%=NJPb+*D7Cc4jGK')
];
