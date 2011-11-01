<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Hydrant Template Library
 *
 * @package     Hydrant Template Library
 * @subpackage  Libraries
 * @category    Template engine
 * @author      Paolo Pustorino
 * @link        https://github.com/stickgrinder/hydrant
 * @version     1.0
 *
 * This class integrates H2O Template engine in CodeIgniter and provides an
 * optional wrapper for native views so that porting a former project to
 * Hydrant could be done in a snap.
 *
 * H2O class is available both as a Ruby Gem and a PHP Class, so your templates
 * will be portable on Rails also. Since H2O is built from Django Templates,
 * porting to Django is a low-effort task (often zero-effort one).
 *
 * Learn more: http://www.h2o-template.com
 *
 * Hydrant is released under the "Don't Be a Dick Public License", which you can
 * read in all its glory here: http://philsturgeon.co.uk/code/dbad-license
 * 
 */
class Hydrant
{
  private $h2o;       /** Instance of H2O template engine parser */
  
  /**
   * Object constructor
   * 
   * @param string $config Configuration as passed by CI
   */
  public function __construct( $config = array() )
  {
    // check if config file is properly configured
    // TODO: check for real clues!!!
    if (count($config) < 1) show_error('Unable to load Hydrant configuration or missing mandatory option.');
    
    // if all went well, import configuration in properties
    $this->_initialize_config($config);
    
    // initalize h2o object
    require(SPARKPATH.'hydrant/vendor/h2o-php/h2o.php');
  }

  /**
   * Initialize H2O configuration exposed in config file.
   * 
   * @param string $config Configuration as passed by constructor
   */
  private function _initialize_config( $config = array() )
  {
   
    foreach($config as $key => $value)
    {
      if (substr($key,0,4) == 'env_')
      {
        // normalize environment values to match
        // to please H2O tastes
        $config[strtoupper(substr($key, 4))] = $value;
        unset($config[$key]);
      }
    }
    
    // Set user config and hardcoded config options
    $this->_config = $config;
    $this->_config['loader'] = 'file';
    $this->_config['cache'] = 'CI';
    $this->_config['cache_prefix'] = 'hydrant_';
    $this->_config['searchpath'] = array(APPPATH.'views/');
  }
  
  public function render($view = NULL, $data = array(), $return = FALSE)
  {
    try
    {
      $this->h2o = new h2o($view, $this->_config);
    }
    catch (Exception $e)
    {
      log_message('error', 'Hydrant Exception: '.$e->getMessage());
      show_error('Hydrant Template encountered an error initializing H2O parser: '.$e->getMessage());
    }

    if ($return == FALSE)
    {
        $CI =& get_instance();
        $CI->output->append_output($this->h2o->render($data));
        return TRUE;
    }
    return $this->h2o->render($data);
  }
}


/**
 * CodeIgniter Cache integration class for H2O
 *
 * This class is used by default at initialization and (as for version 1.0) can
 * not be overriden. Since one of the most important CI goals is to render
 * deploy easy and hassle-free, CI caching layer is the best choice not to mangle
 * with files and directories permissions.
 * Moreover CI supports APC, Memcache, files and a dummy caching out of the box.
 *
 */
class H2o_CI_Cache
{
    var $ttl = 3600;
    var $prefix = 'hydrant_';
    var $CI; /** Reference to CI framework */
    
    function __construct($options = array()) {
      
      $this->CI =& get_instance();
      $this->CI->load->driver('cache', array('adapter' => 'file'));
    
      if (isset($options['cache_ttl'])) {
        $this->ttl = $options['cache_ttl'];
      } 
      if(isset($options['cache_prefix'])) {
        $this->prefix = $options['cache_prefix'];
      }
    }
    
    function read($filename) {
      return $this->CI->cache->get($this->prefix.$filename);
    }

    function write($filename, $object) {
      return $this->CI->cache->save($this->prefix.$filename, $object, $this->ttl);   
    }
    
    function flush() {
      return $this->CI->cache->clean();
    }
}


// --------------------------------------------------------------------
/**
 * End of Hydrant
**/
