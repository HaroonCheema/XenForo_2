<?php

namespace DC\LinkProxy\Pub\Controller;

use XF\Pub\Controller\AbstractController;

class Passwords extends AbstractController
{   
        public function actionIndex()
        {   
            $passwords = $this->Finder('DC\LinkProxy:TFAuth')->where('expired_at', '>', time());
            
            $total = $passwords->total();

            $viewParams = [
                
                'passwords' => $passwords->fetch(),
                'total' => $total,
            ];

            return $this->view('DC\LinkProxy:LinkProxy', 'dc_link_proxy_passwords', $viewParams);
        }
}