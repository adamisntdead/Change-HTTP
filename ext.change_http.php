<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package     ExpressionEngine
 * @author      ExpressionEngine Dev Team
 * @copyright   Copyright (c) 2003 - 2018, EllisLab, Inc.
 * @license     http://expressionengine.com/user_guide/license.html
 * @link        http://expressionengine.com
 * @since       Version 2.0
 * @filesource
 */

/**
 * Change HTTP Extension
 *
 * @package    ExpressionEngine
 * @subpackage Addons
 * @category   Extension
 * @author     Adam Kelly
 * @link       github.com/adamisntdead
 */
class Change_http_ext
{
    public $settings       = array();
    public $description    = 'Changes HTTP to HTTPS';
    public $docs_url       = '';
    public $name           = 'Change HTTP';
    public $settings_exist = 'n';
    public $version        = '1.0.0';

    /**
     * Constructor
     *
     * @param   mixed Settings array or empty string if none exist.
     */
    public function __construct($settings = '')
    {
        $this->settings = $settings;
    }

    /**
     * Activate Extension
     *
     * This function enters the extension into the exp_extensions table
     *
     * @see http://codeigniter.com/user_guide/database/index.html for
     * more information on the db class.
     *
     * @return void
     */
    public function activate_extension()
    {
        // Setup custom settings in this array.
        $this->settings = array();

        ee()->db->insert_batch('extensions', array(
            array(
                'class' => __CLASS__,
                'method' => 'template_post_parse',
                'hook' => 'template_post_parse',
                'settings' => serialize($this->settings),
                'version' => $this->version,
                'enabled' => 'y',
            ),
        ));
    }

    /**
     * template_post_parse Hook
     *
     * @param
     * @return
     */
    public function template_post_parse($final, $is_partial, $site_id)
    {
        return str_replace('http://', 'https://', $final);
    }

    /**
     * Disable Extension
     *
     * This method removes information from the exp_extensions table
     *
     * @return void
     */
    public function disable_extension()
    {
        ee()->db->delete('extensions', array('class' => __CLASS__));
    }

    /**
     * Update Extension
     *
     * This function performs any necessary db updates when the extension
     * page is visited
     *
     * @return  mixed void on update / false if none
     */
    public function update_extension($current = '')
    {
        if ($current == '' OR $current == $this->version)
        {
            return FALSE;
        }

        ee()->db->update('extensions', array('version' => $this->version), array('class' => __CLASS__));
    }
}

/* End of file ext.change_http.php */
/* Location: /system/expressionengine/third_party/change_http/ext.change_http.php */