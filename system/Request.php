<?
defined('_FRM') or die('No direct script access.');


class Request
{
	
        private $aParams = array();
        private $sController = null;
        private $sAction = null;
        private $sRequestUri = null;
        private $sPathInfo = null;
        
	
        /**
         * 
         * @param type $iId integer
         * @return type mixed
         * 
         */
	public function getParam($iId)
	{
            return isset($this->aParams[$iId])?$this->aParams[$iId]:null;
	}

        

	/**
         * Returns Post request param
         * @param type $sName string
         * @param type $mDefaultValue mixed
         * @return type mixed
         */
        
	public function getPostParam($sName,$mDefaultValue = null)
	{
            return isset($_POST[$sName]) ? $_POST[$sName] : $mDefaultValue;
	}


        public function getController()
        {
            return $this->sController;
        }
        
        public function getAction()
        {
            return ucfirst($this->sAction);
        }


        public function getHostInfo($schema='')
	{
            
	}

	
        public function getBaseUrl($absolute=false)
	{
            
	}


	


        public function parseRequestUri()
        {
            if(null === $this->sRequestUri)
                $this->setRequestUri ();
            $i = 0;
            foreach (explode('/',  $this->sRequestUri) AS $sV)
            {
                if(strlen(trim($sV)))
                {
                    if($i == 0)
                        $this->sController = $sV;
                    else if($i == 1)
                        $this->sAction = $sV;
                    else
                        $this->aParams[] = $sV;
                    
                    $i++;
                }
            }            
            
            if(null === $this->sController)
                // from config
                    $this->sController = 'index';
            
            if(null === $this->sAction)
                //from config
                    $this->sAction = 'index';
        }
        

        protected function decodePathInfo($sPathInfo)
	{
		$sPathInfo = urldecode($sPathInfo);

		// is it UTF-8?
		// http://w3.org/International/questions/qa-forms-utf-8.html
		if(preg_match('%^(?:
		   [\x09\x0A\x0D\x20-\x7E]            # ASCII
		 | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
		 | \xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs
		 | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
		 | \xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates
		 | \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
		 | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
		 | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
		)*$%xs', $sPathInfo))
		{
			return $sPathInfo;
		}
		else
		{
			return utf8_encode($sPathInfo);
		}
	}

	
        /**
         * 
         * From YII
         */
	public function setRequestUri()
	{
		if($this->sRequestUri===null)
		{
			if(isset($_SERVER['HTTP_X_REWRITE_URL'])) // IIS
				$this->sRequestUri=$_SERVER['HTTP_X_REWRITE_URL'];
			elseif(isset($_SERVER['REQUEST_URI']))
			{
				$this->sRequestUri=$_SERVER['REQUEST_URI'];
				if(!empty($_SERVER['HTTP_HOST']))
				{
					if(strpos($this->sRequestUri,$_SERVER['HTTP_HOST'])!==false)
						$this->sRequestUri=preg_replace('/^\w+:\/\/[^\/]+/','',$this->sRequestUri);
				}
				else
					$this->sRequestUri=preg_replace('/^(http|https):\/\/[^\/]+/i','',$this->sRequestUri);
			}
			elseif(isset($_SERVER['ORIG_PATH_INFO']))  // IIS 5.0 CGI
			{
				$this->sRequestUri=$_SERVER['ORIG_PATH_INFO'];
				if(!empty($_SERVER['QUERY_STRING']))
					$this->sRequestUri.='?'.$_SERVER['QUERY_STRING'];
			}
			else
				throw new Exception('Request is unable to determine the request URI.');
		}
	}

	/**
	 * Returns part of the request URL that is after the question mark.
	 * @return string part of the request URL that is after the question mark
	 */
	public function getQueryString()
	{
		return isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'';
	}

	/**
	 * Return if the request is sent via secure channel (https).
	 * @return boolean if the request is sent via secure channel (https)
	 */
	public function getIsSecureConnection()
	{
		return !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'],'off');
	}


	public function getRequestType()
	{
		if(isset($_POST['_method']))
			return strtoupper($_POST['_method']);

		return strtoupper(isset($_SERVER['REQUEST_METHOD'])?$_SERVER['REQUEST_METHOD']:'GET');
	}

	/**
	 * Returns whether this is a POST request.
	 * @return boolean whether this is a POST request.
	 */
	public function isPostRequest()
	{
		return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'],'POST');
	}

	
        
	public function isAjaxRequest()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest';
	}

        
	/**
	 * Returns the server name.
	 * @return string server name
	 */
	public function getServerName()
	{
		return $_SERVER['SERVER_NAME'];
	}

	/**
	 * Returns the server port number.
	 * @return integer server port number
	 */
	public function getServerPort()
	{
		return $_SERVER['SERVER_PORT'];
	}

	/**
	 * Returns the URL referrer, null if not present
	 * @return string URL referrer, null if not present
	 */
	public function getUrlReferrer()
	{
		return isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
	}

	/**
	 * Returns the user agent, null if not present.
	 * @return string user agent, null if not present
	 */
	public function getUserAgent()
	{
		return isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:null;
	}

	/**
	 * Returns the user IP address.
	 * @return string user IP address
	 */
	public function getUserHostAddress()
	{
		return isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'127.0.0.1';
	}

	/**
	 * Returns the user host name, null if it cannot be determined.
	 * @return string user host name, null if cannot be determined
	 */
	public function getUserHost()
	{
		return isset($_SERVER['REMOTE_HOST'])?$_SERVER['REMOTE_HOST']:null;
	}

	
        
	public function getBrowser($userAgent=null)
	{
		return get_browser($userAgent,true);
	}

	/**
	 * Returns user browser accept types, null if not present.
	 * @return string user browser accept types, null if not present
	 */
	public function getAcceptTypes()
	{
		return isset($_SERVER['HTTP_ACCEPT'])?$_SERVER['HTTP_ACCEPT']:null;
	}

	
        
	public function redirect($sUrl, $sStatusCode = 302)
	{
            header('Location: '.$sUrl, true, $sStatusCode);
	}
        
}
