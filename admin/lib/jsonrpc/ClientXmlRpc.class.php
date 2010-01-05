<?php
/**
*Class ClientXmlRpc
*
* Classe client d'appel XML-RPC
*
* @package Tools
* @author Poulain Patrick
* @since 28/11/2006
**/
class ClientXmlRpc
{
	/** @var Serveur pour l'appel */
	private $host;
	/** @var Chemin pour l'appel */
	private $path;
	/** @var Port pour l'appel 80 par default*/
	private $port;
	/** @var Timout de la requete*/
	private $timeout;
	/** @var Headers de l'appel*/
	private $call_headers;
	/** @var Reponse de l'appel*/
	private $call_content;
	/** @var Statut de l'appel (Reponse HTPP)*/
	public 	$call_status;



	/** Constructeur
	 *
	 * @param string $url URL du server (le port peut etre passés a l'aider de :80)
	 * @param int $timeout Timeout pour la requete
	**/
	public function __construct($url,$timeout=1)
	{
		$parse_url=parse_url($url);

		$this->host=$parse_url['host'];
		$this->path=$parse_url['path'];
		$this->port=isset($parse_url['port'])?$parse_url['port']:80;
		$this->timeout=$timeout;
		$this->call_content='';
		$this->call_headers='';
		$this->call_status=false;
	}

	/** Requete au serveur
	 *
	 * @param string $method nom de la methode appelé
	 * @param array $params parmetres de la requete 'nom'=>valeur
	 * @return true si callstatus=200
	**/
	public function call($method,$params)
	{

		$fp = @fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
		if($fp!==false)
		{
			//Contruction de la requete avec le nom de la methode
			$request="<?xml version=\"1.0\"?>\r\n<methodCall>\r\n<methodName>".$method."</methodName>\r\n";
			if(count($params>0))
			{
				//Ajout des parametre
				$request.="<params>\r\n";
				foreach ($params as $p)
				{
					$request.="<param>\r\n";
					$type=gettype($p);
					$request.="<value><$type>$p</$type></value>\r\n";
					$request.="</param>\r\n";
				}
				$request.="</params>\r\n";
			}
			$request.="</methodCall>";
			$headers="POST ".$this->path." HTTP/1.0\r\nHost: ".$this->host."\r\nContent-Type: text/xml\r\nUser-Agent: PcrRpcClient\r\nContent-Length: ".strlen($request)."\r\n\Connection: close\r\n\r\n";
			//Envoie de la requete
			fputs($fp, $headers.$request);
			$headers=true;
			//Lecture de la reponse
			$content=&$this->call_headers;
			while (!feof($fp))
			{
				//Time out de lecture
				stream_set_timeout($fp, $this->timeout);
				$buffer = fgets($fp, 4096);
				$content.=$buffer;
				//Recuperation du status de la requete
				if ($headers&&substr($buffer, 0, 7) === 'HTTP/1.')
				{
					$this->call_status = (int) substr($buffer, 9, 3);
				}
				if(trim($buffer)==='')
				{
					//Fin des headers on passe au contenu
					$content=&$this->call_content;
					$headers=false;
				}
			}
			fclose($fp);
		}
		return $this->call_status===200;
	}
	/**Analyse de la reponse et construction du tableau
	* @return array $method_response faux si $this->call_status!=200 ou si la methode appelé renvoie un erreur
	**/
	public function get_method_response()
	{
		$method_response=false;
		if($this->call_status===200)
		{
			$method_response=array();
			if(($params=$this->get_tag_value('params',$this->call_content))!==false)
			{
				//Il y a des parametre dans la reponses la methode renvoie une reponse
				$return=true;
				preg_match_all('~<param>[\n \t\r]*<value>(.*?)</value>[\n \t\r]*</param>~si',$params,$preg);
				$preg_count=count($preg[0]);
				for($i=0;$i<$preg_count;$i++)
				{
					$method_response[]=$this->get_value($preg[1][$i]);
				}
			}
			else
			{
				//Il n'y a pas de parametre dans la reponse alors le retour est une erreur
				if(($value=$this->get_tag_value('struct',$preg[1]))!==false)
				{
					$method_response[]=$this->get_value_from_struct($value);
				}
			}

		}
		return $method_response;
	}

	private function get_value($value)
	{
		if(preg_match('~<(.*?)>~',$value,$type));
		{
			$type=isset($type[1])?$type[1]:'default';
			switch ($type)
			{
				case 'struct':
					return $this->get_value_from_struct($value);
					break;
				case 'boolean':
					return $this->get_value_from_boolean($value);
					break;
				case 'i4':
				case 'int':
					return $this->get_value_from_int($value,$type);
					break;
				case 'double':
					return $this->get_value_from_float($value);
					break;
				case 'string':
					return $this->get_value_from_string($value);
					break;
				default:
					return $value;
			}
		}
	}
	private function get_value_from_struct($value)
	{
		preg_match_all("~<member>[\n \t\r]*<name>(.*?)</name>[\n \t\r]*<value>(.*?)</value>[\n \t\r]*</member>~si",$value,$member);
		$member_count=count($member[0]);
		$return=null;
		if($member_count>0)
		{
			$return=array();
			for($i=0;$i<$member_count;$i++)
			{
				$return[]=array('name'=>$member[1][$i],'value'=>$this->get_value($member[2][$i]));
			}
		}
		return $return;
	}
	private function get_value_from_boolean($value)
	{
		$return=null;
		if(($type=$this->get_tag_value('boolean',$value))!==false)
		{
			$return=(bool)$type;
		}
		return $return;
	}
	private function get_value_from_int($value,$tag)
	{
		$return=null;
		if(($type=$this->get_tag_value($tag,$value))!==false)
		{
			$return=(int)$type;
		}
		return $return;
	}
	private function get_value_from_float($value)
	{
		$return=null;
		if(($type=$this->get_tag_value('double',$value))!==false)
		{
			$return=(float)$type;
		}
		return $return;
	}
	private function get_value_from_string($value)
	{
		$return=null;
		if(($type=$this->get_tag_value('string',$value))!==false)
		{
			$return=$type;
		}
		return $return;
	}
	private function get_tag_value($tag,$string)
	{
		if(($start_pos=strpos($string,'<'.$tag.'>'))!==false&&($end_pos=strpos($string,'</'.$tag.'>'))!==false)
		{
			$start_pos+=strlen($tag)+2;
			$str_len=strlen($string);
			$length=$str_len-$start_pos-($str_len-$end_pos);
			return substr($string,$start_pos,$length);
		}
		else
		{
			return false;
		}
	}
}

?>
