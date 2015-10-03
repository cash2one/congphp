<?php
/**
 * Created by PhpStorm.
 * User: liujuncong
 * Date: 15-9-30
 * Time: 下午10:08
 */
defined('BASEPATH') OR exit('No direct script access allowed');
define('GP_VERSION', '1.0.0');

require_once WEBPATH."config.inc.php";

require_once(BASEPATH.'core/common.php');

$ev =& load_class('ev', 'lib');
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


 $class = $ev->class;
$method = $ev->method;

if (empty($class) OR ! file_exists(WEBPATH.'controller/'.$ev->directory.$class.'.php'))
{
    $e404 = TRUE;
}
else
{
    require_once(WEBPATH.'controller/'.$ev->directory.$class.'.php');

    if ( ! class_exists($class, FALSE) OR $method[0] === '_' OR method_exists('gou_controller', $method))
    {
        $e404 = TRUE;
    }

    elseif ( ! in_array(strtolower($method), array_map('strtolower', get_class_methods($class)), TRUE))
    {
        $e404 = TRUE;
    }
}

$gou = new $class();

call_user_func_array(array(&$gou, $method), $ev->params);
?>