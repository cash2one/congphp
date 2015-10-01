<?php
/**
 * Created by PhpStorm.
 * User: liujuncong
 * Date: 15-9-30
 * Time: 下午10:11
 */

if ( ! function_exists('load_class'))
{
    /**
     * Class registry
     *
     * This function acts as a singleton. If the requested class does not
     * exist it is instantiated and set to a static variable. If it has
     * previously been instantiated the variable is returned.
     *
     * @param	string	the class name being requested
     * @param	string	the directory where the class should be found
     * @param	string	an optional argument to pass to the class constructor
     * @return	object
     */
    function &load_class($class, $directory = 'lib', $param = NULL)
    {
        static $_classes = array();

        // Does the class exist? If so, we're done...
        if (isset($_classes[$class]))
        {
            return $_classes[$class];
        }

        $name = FALSE;

        // Look for the class first in the local application/libraries folder
        // then in the native system/libraries folder
        foreach (array(APPPATH, BASEPATH) as $path)
        {
            if (file_exists($path.$directory.'/'.$class.'.php'))
            {
                $name = $class;

                if (class_exists($name, FALSE) === FALSE)
                {
                    require_once($path.$directory.'/'.$class.'.php');
                }

                break;
            }
        }


        // Did we find the class?
        if ($name === FALSE)
        {
            // Note: We use exit() rather than show_error() in order to avoid a
            // self-referencing loop with the Exceptions class
            set_status_header(503);
            echo 'Unable to locate the specified class: '.$class.'.php';
            exit(5); // EXIT_UNK_CLASS
        }

        // Keep track of what we just loaded
        is_loaded($class);

        $_classes[$class] = isset($param) ? new $name($param) : new $name();
        return $_classes[$class];
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('is_loaded'))
{
    /**
     * Keeps track of which libraries have been loaded. This function is
     * called by the load_class() function above
     *
     * @param	string
     * @return	array
     */
    function &is_loaded($class = '')
    {
        static $_is_loaded = array();

        if ($class !== '')
        {
            $_is_loaded[strtolower($class)] = $class;
        }

        return $_is_loaded;
    }
}
