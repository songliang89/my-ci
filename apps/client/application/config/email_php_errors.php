<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/2/28
 * Time: 下午5:33
 */
/**
 * where to send php errors to and from
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file email_php_errors.php
 */

// to enable, set this to true
$config['email_php_errors'] = true;

$config['php_error_from'] = 'reply@smzdm.com';
$config['php_error_to'] = 'linzhenlong@smzdm.com';

// available shortcodes are {{severity}}, {{message}}, {{filepath}}, {{line}}
$config['php_error_subject'] = 'PHP Error';
$config['php_error_content'] = 'Severity: {{severity}} --> {{message}} File Path: {{filepath}} Line: {{line}}';

/* End of file email_php_errors.php */
/* Location: ./application/config/email_php_errors.php */