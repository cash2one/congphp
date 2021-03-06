<?php
class ev
{
	public $cookie;
	public $post;
	public $get;
	public $file;
	public $url;
	public $G;
	private $e;
    public $directory=null;

	public function __construct()
    {
    	$this->strings =& load_class('strings');
    	if (ini_get('magic_quotes_gpc')) {
			$get    = $this->stripSlashes($_REQUEST);
			$post   = $this->stripSlashes($_POST);
			$this->cookie = $this->stripSlashes($_COOKIE);
		} else {
			$get    = $_REQUEST;
			$post   = $_POST;
			$this->cookie = $_COOKIE;
		}

		$this->file = $_FILES;
		$this->get = $this->initData($get);
		$this->post = $this->initData($post);
		$this->url = $this->router();
        $this->class = $this->url(0);
        if(!$this->class) {
            $this->class = "welcome";
        }
        $this->method = $this->url(1);
        if(!$this->method) {
            $this->method = "index";
        }
        $this->params = array_slice($this->url,2);
		$this->cookie = $this->initData($this->cookie);
    }

	//解析url
	public function parseUrl()
	{
		if(isset($_REQUEST['route']))
		{
			return explode('-',$_REQUEST['route']);
		}
		elseif(isset($_SERVER['QUERY_STRING']))
		{
			$tmp = explode('#',$_SERVER['QUERY_STRING'],2);
			$tp = explode('&',$tmp[0],2);
			return explode('-',$tp[0]);
		}
		else
            return false;
	}

    public function router()
    {
        $uri    =   explode( '/', strtolower($this->_parse_request_uri()));
        return $uri;
//
//        array_shift($uri);
//        $class  = strtolower(array_shift($uri));
//        $method = strtolower(array_shift($uri));
//        $var    = strtolower(array_shift($uri));
    }

    protected function _parse_request_uri()
    {
        if ( ! isset($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']))
        {
            return '';
        }

        // parse_url() returns false if no host is present, but the path or query string
        // contains a colon followed by a number
        $uri = parse_url('http://dummy'.$_SERVER['REQUEST_URI']);
        $query = isset($uri['query']) ? $uri['query'] : '';
        $uri = isset($uri['path']) ? $uri['path'] : '';

        if (isset($_SERVER['SCRIPT_NAME'][0]))
        {
            if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0)
            {
                $uri = (string) substr($uri, strlen($_SERVER['SCRIPT_NAME']));
            }
            elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0)
            {
                $uri = (string) substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
            }
        }

        // This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
        // URI is found, and also fixes the QUERY_STRING server var and $_GET array.
        if (trim($uri, '/') === '' && strncmp($query, '/', 1) === 0)
        {
            $query = explode('?', $query, 2);
            $uri = $query[0];
            $_SERVER['QUERY_STRING'] = isset($query[1]) ? $query[1] : '';
        }
        else
        {
            $_SERVER['QUERY_STRING'] = $query;
        }

        parse_str($_SERVER['QUERY_STRING'], $_GET);

        if ($uri === '/' OR $uri === '')
        {
            return '/';
        }

        // Do some final cleaning of the URI and return it
        return $this->_remove_relative_directory($uri);
    }

    protected function _parse_query_string()
    {
        $uri = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : @getenv('QUERY_STRING');

        if (trim($uri, '/') === '')
        {
            return '';
        }
        elseif (strncmp($uri, '/', 1) === 0)
        {
            $uri = explode('?', $uri, 2);
            $_SERVER['QUERY_STRING'] = isset($uri[1]) ? $uri[1] : '';
            $uri = $uri[0];
        }

        parse_str($_SERVER['QUERY_STRING'], $_GET);

        return $this->_remove_relative_directory($uri);
    }

    protected function _remove_relative_directory($uri)
    {
        $uris = array();
        $tok = strtok($uri, '/');
        while ($tok !== FALSE)
        {
            if (( ! empty($tok) OR $tok === '0') && $tok !== '..')
            {
                $uris[] = $tok;
            }
            $tok = strtok('/');
        }

        return implode('/', $uris);
    }




    //返回$_REQUEST数组内的值
    public function get($par)
    {
    	if(isset($this->get[$par]))return $this->get[$par];
    	else return false;
    }

    //返回$_POST数组内的值
    public function post($par)
    {
    	if(isset($this->post[$par]))return $this->post[$par];
    	else return false;
    }

    //返回URL数组中的值
    public function url($par)
    {
    	$par = intval($par);
    	if(isset($this->url[$par]))
            return $this->url[$par];
    	else
            return false;
    }

	//设置COOKIE
	public function setCookie($name,$value,$time=3600)
    {
    	if($time)$time = TIME + $time;
		else $time = 0;
		if(CDO)setCookie(CH.$name,$value,$time,CP,CDO,false,false);
    	else setCookie(CH.$name,$value,$time,CP,'',false,false);
    }

	//获取cookie
	public function getCookie($par,$nohead = 0)
    {
    	if(isset($this->cookie[CH.$par]))return $this->cookie[CH.$par];
    	elseif(isset($this->cookie[$par]) && $nohead)return $this->cookie[$par];
    	else return false;
    }

	//获取$_FILE
	public function getFile($par)
    {
    	if(isset($this->file[$par]))return $this->file[$par];
    	else return false;
    }

    //初始化数据
    public function initData($data)
    {
		if(is_array($data))
		{
			foreach($data as $key => $value)
			{
				if($this->strings->isAllowKey($key) === false)
				{
					unset($data[$key]);
				}
				else
				$data[$key] = $this->initData($value);
			}
			return $data;
		}
		else
		{
			if(is_numeric($data))
			{
				if($data[0] === 0)return $this->addSlashes(htmlspecialchars($data));
				if(strlen($data) >= 11)return $this->addSlashes(htmlspecialchars($data));
				if(strpos($data,'.'))return floatval($data);
				else return $data;
			}
			if(is_string($data))return $this->addSlashes(htmlspecialchars($data));
			if(is_bool($data))return (bool)$data;
			return false;
		}
    }

	//去除转义字符
	public function stripSlashes($data)
    {
    	if (is_array($data)) {
	  		foreach ($data as $key => $value) {
	    		$data[$key] = $this->stripSlashes($value);
	  		}
		} else {
	  		$data = stripSlashes(trim($data));
		}

		return $data;
	}

	//添加转义字符
	public function addSlashes($data)
    {
    	if (is_array($data)) {
	  		foreach ($data as $key => $value) {
	    		$data[$key] = $this->addSlashes($value);
	  		}
		} else {
	  		$data = addSlashes(trim($data));
		}
		return $data;
	}

	//获取客户端IP
	public function getClientIp()
	{
		if(!isset($this->e['ip']))
		{
			if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
				$ip = getenv("HTTP_CLIENT_IP");
			else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
				$ip = getenv("HTTP_X_FORWARDED_FOR");
			else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
				$ip = getenv("REMOTE_ADDR");
			else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
				$ip = $_SERVER['REMOTE_ADDR'];
			else
				$ip = "unknown";
			$this->e['ip'] = $ip;
		}
		return $this->e['ip'];
	}

	//根据二级域名获取信息
	public function getSecondDomain()
	{
		$domain = $_SERVER['HTTP_HOST'];
		$domain = str_replace(array('com.cn','net.cn','gov.cn','org.cn'),'com',$domain);
		$tmp = explode('.',$domain);
		if(count($tmp) < 3)return false;
		elseif(is_numeric($tmp[0]))return false;
		else return $tmp[0];
	}
}
?>
