<?php

/**
 * Redaxscript Parser
 *
 * @since 2.0
 *
 * @package Redaxscript
 * @category Parser
 * @author Henry Ruhs
 */

class Redaxscript_Parser
{
	/**
	 * output
	 * @var string
	 */

	private $_output;

	/**
	 * route
	 * @var string
	 */

	protected $_route;

	/**
	 * tags
	 * @var array
	 */

	protected $_tags = array(
		'break' => array(
			'function' => '_parseBreak',
			'position' => ''
		),
		'code' => array(
			'function' => '_parseCode',
			'position' => ''
		),
		'function' => array(
			'function' => '_parseFunction',
			'position' => ''
		)
	);

	/**
	 * classes
	 * @var array
	 */

	protected $_classes = array(
		'break' => 'link_read_more',
		'code' => 'box_code'
	);

	/**
	 * forbiddenFunctions
	 * @var array
	 */

	protected $_forbiddenFunctions = array(
		'curl',
		'curl_exec',
		'curl_multi_exec',
		'exec',
		'eval',
		'fopen',
		'include',
		'include_once',
		'mysql',
		'passthru',
		'popen',
		'proc_open',
		'shell',
		'shell_exec',
		'system',
		'require',
		'require_once'
	);

	/**
	 * construct
	 *
	 * @since 2.0
	 *
	 * @param string $input
	 * @param string $route
	 */

	public function __construct($input = '', $route = '')
	{
		$this->_output = $input;
		$this->_route = $route;

		/* call init */

		$this->init();
	}

	/**
	 * init
	 *
	 * @since 2.0
	 */

	public function init()
	{
		foreach($this->_tags as $key => $value)
		{
			/* save tag related position */

			$position = $this->_tags[$key]['position'] = strpos($this->_output, '<' . $key . '>');

			/* call related function if tag found */

			if ($position > -1)
			{
				$function = $value['function'];
				$this->_output = $this->$function($this->_output);
			}
		}
	}

	/**
	 * getOutput
	 *
	 * @since 2.0
	 *
	 * @return string
	 */

	public function getOutput()
	{
		return $this->_output;
	}

	/**
	 * parseBreak
	 *
	 * @since 2.0
	 *
	 * @param string $input
	 * @return string
	 */

	protected function _parseBreak($input = '')
	{
		$output = str_replace('<break>', '', $input);
		if (LAST_TABLE === 'categories' || FULL_ROUTE === '' || check_alias(FIRST_PARAMETER, 1) === 1)
		{
			$output = substr($output, 0, $this->_tags['break']['position']);

			/* add read more */

			if ($this->_route)
			{
				$output .= anchor_element('internal', '', $this->_classes['break'], l('read_more'), $this->_route);
			}
		}
		return $output;
	}

	/**
	 * parseCode
	 *
	 * @since 2.0
	 *
	 * @param string $input
	 * @return string
	 */

	protected function _parseCode($input = '')
	{
		$output = str_replace(array(
			'<code>',
			'</code>'
		), '||', $input);
		$parts = explode('||', $output);

		/* parse needed parts */

		foreach ($parts as $key => $value)
		{
			if ($key % 2)
			{
				$parts[$key] = '<code class="' . $this->_classes['code'] . '">' . trim(htmlspecialchars($value)) . '</code>';
			}
		}
		$output = implode($parts);
		return $output;
	}

	/**
	 * parseFunction
	 *
	 * @since 2.0
	 *
	 * @param string $input
	 * @return string
	 */

	protected function _parseFunction($input = '')
	{
		$output = str_replace(array(
			'<function>',
			'</function>'
		), '||', $input);
		$parts = explode('||', $output);

		/* parse needed parts */

		foreach ($parts as $key => $value)
		{
			if ($key % 2)
			{
				/* decode to array */

				$json = json_decode($value, true);

				/* catch function output */

				ob_start();
				foreach ($json as $function => $parameter)
				{
					/* validate allowed functions */

					if (!in_array($function, $this->_forbiddenFunctions))
					{
						call_user_func_array($function, $parameter);
					}
				}
				$parts[$key] = ob_get_clean();
			}
		}
		$output = implode($parts);
		return $output;
	}
}
?>