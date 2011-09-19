<?php
namespace Xi\Zend\Mvc\View;

use Zend_Json;

/**
 * @category   Xi
 * @package    Zend
 * @subpackage Mvc
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */
class JsonHelper
{
	/**
	 * Creates a JSON string representation using Zend_Json 
	 * 
	 * @param array|object $data
	 * @return string
	 */
	public function json($data)
	{
		return '(' . Zend_Json::encode($data) . ')';
	}
}