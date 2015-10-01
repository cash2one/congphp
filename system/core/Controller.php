<?php
/**
 * Created by PhpStorm.
 * User: liujuncong
 * Date: 15-9-30
 * Time: 下午8:51
 * 控制器基类
 */


defined('BASEPATH') OR exit('No direct script access allowed');

class gou_controller {

    private static $instance;

    public function __construct()
    {
        foreach (is_loaded() as $var => $class)
        {
            $this->$var =& load_class($class);
        }
    }

    /**
     * Get the CI singleton
     *
     * @static
     * @return	object
     */
    public static function &get_instance()
    {
        return self::$instance;
    }
}
