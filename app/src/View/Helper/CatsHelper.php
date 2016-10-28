<?php

namespace App\View\Helper;

use Cake\View\Helper;

class CatsHelper extends Helper
{
    public $helpers = ['Html'];
    
    public function earOptions(){
        $ear_options = [
            '0' => $this->Html->image('/img/cat_ears/cat_normal.png', ['width'=>'24px']) . ' 処置なし', 
            '1' => $this->Html->image('/img/cat_ears/cat_donno.png', ['width'=>'24px']) . ' 不明',
            '2' => $this->Html->image('/img/cat_ears/cat_trimmed_right.png', ['width'=>'24px']) . ' 右耳に印',
            '3' => $this->Html->image('/img/cat_ears/cat_trimmed_left.png', ['width'=>'24px']) . ' 左耳に印'
        ];
        return $ear_options;
    }
}