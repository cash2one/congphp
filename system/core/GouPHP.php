<?php
/**
 * Created by PhpStorm.
 * User: liujuncong
 * Date: 15-9-30
 * Time: 下午10:08
 */
defined('BASEPATH') OR exit('No direct script access allowed');
define('GP_VERSION', '1.0.0');

require_once(BASEPATH.'core/common.php');

load_class('ev', 'lib');
load_class('tpl', 'lib');
load_class('session', 'lib');

require_once BASEPATH.'core/controller.php';

/**
 * Reference to the Gou_Controller method.
 *
 * Returns current GOU instance object
 *
 * @return object
 */
function &get_instance()
{
    return gou_controller::get_instance();
}
