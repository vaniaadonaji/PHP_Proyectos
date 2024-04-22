<?php

namespace App\Libraries;

use CodeIgniter\Log\Handlers\BaseHandler;

class EmailLogHandler extends BaseHandler {
    public $email;

    public function __construct(array $config) {
        parent::__construct($config);
        $this->email = \Config\Services::email();
    }

    public function handle($level, $message): bool {
        $this->email->setFrom('benjagitgithub@gmail.com')
            ->setTo('vaniaadonaji@gmail.com')
            ->setSubject('Error ocurrido en sistema ' . $level)
            ->setMessage('<pre>' . $message . '</pre>')
            ->send();        
        $this->email->setFrom('vaniaadonaji@gmail.com')
            ->setTo('benjagitgithub@gmail.com')
            ->setSubject('Error ocurrido en sistema ' . $level)
            ->setMessage('<pre>' . $message . '</pre>')
            ->send();
        return true;
    }
}
