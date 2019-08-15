<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/13 0013
 * Time: 11:50
 */

namespace Admin\Model;
class GoodsModel extends \Think\Model
{
  public function getGoodsByid($id)
  {
      return $this->find($id);
  }
}