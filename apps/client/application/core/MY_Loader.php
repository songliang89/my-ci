<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 14/12/26
 * Time: 下午6:25
 */

class MY_Loader extends CI_Loader
{
	protected $_ci_biz_paths = array();
	protected $_ci_bizes = array();

	function __construct()
	{
		parent::__construct();
		$this->_ci_biz_paths = array(APPPATH, BASEPATH);
	}
	public function database($params = '', $return = FALSE, $active_record = NULL)
	{
		$CI =& get_instance();
		if (class_exists('CI_DB') AND $return == FALSE AND $active_record == NULL AND isset($CI->db) AND is_object($CI->db)) {
			return FALSE;
		}
		if(file_exists(APPPATH.'core/database/DB.php')) {
			require_once(APPPATH.'core/database/DB.php');
		} else {
			require_once(BASEPATH.'database/DB.php');
		}
		if ($return === TRUE) {
			return DB($params, $active_record);
		}
		$CI->db = '';
		$CI->db =& DB($params, $active_record);
	}

	/**
	 * Model Loader
	 *
	 * This function lets users load and instantiate models.
	 *
	 * @param	string	the name of the class
	 * @param	string	name for the biz
	 * @param	array	params of the biz
	 * @return	void
	 */
	public function biz($biz, $name = '', Array $params = array()) {
		if (is_array($biz)) {
			foreach ($biz as $babe) {
				$this->biz($babe);
			}
			return;
		}

		if ($biz == '') {
			return;
		}

		$path = '';

		// Is the biz in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($biz, '/')) !== FALSE) {
			// The path is in front of the last slash
			$path = substr($biz, 0, $last_slash + 1);

			// And the biz name behind it
			$biz = substr($biz, $last_slash + 1);
		}

		if ($name == '') {
			$name = $biz;
		}

		if (in_array($name, $this->_ci_bizes, TRUE)) {
			return;
		}
		$CI = & get_instance();
		if (isset($CI->$name)) {
			show_error('The biz name you are loading is the name of a resource that is already being used: ' . $name);
		}

		$biz = strtolower($biz);

		foreach ($this->_ci_biz_paths as $mod_path) {
			if (!file_exists($mod_path . 'biz/' . $path . $biz . '.php')) {
				continue;
			}

			if (!class_exists('CI_Biz')) {
				load_class('Biz', 'core');
			}

			require_once($mod_path . 'biz/' . $path . $biz . '.php');

			$biz = ucfirst($biz);

			$CI->$name = new $biz($params);

			$this->_ci_bizes[] = $name;
			return;
		}
		// couldn't find the biz
		show_error('Unable to locate the biz you have specified: ' . $biz);
	}
}
/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */