<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14 0014
 * Time: 16:31
 */

namespace Admin\Controller;

use Think\Controller;

class EmptyController extends  Controller
{
    public function _empty()
    {
        $this->redirect('Public/404');
    }
}
