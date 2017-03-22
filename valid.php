<?php
class valid
{
	public function checkmodel($model)
	{
		if(preg_match('/[a-zA-Z0-9! ]{1,}/', $model))
		{
			return 1;	
		}	
		else
		{
			return 0;
		}
	}
	
	public function checkdes($des)
	{
		if(preg_match('/[a-zA-Z0-9!\.\,\[\]\(\) ]{3,}/', $des))
		{
			return 1;	
		}	
		else
		{
			return 0;
		}
	}
	public function checkurl($url)
	{
		if(preg_match('/^(http|https|ftp|ftps|www):\/\/[a-z0-9-.ąćęłńóśźż]{1,}.[\.]{1}.[a-zA-Z]/', $url))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
}

$valid = new valid;
?>