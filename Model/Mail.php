<?php
App::uses('AppModel', 'Model');
/**
 * Mail model for CakePHP.
 *
 *
 * Developed for Rsaeel.com (http://rsaeel.com) using Cakephp
 * Copyright 2012-2012, SmartData, Inc. (http://smartdata.com.sa)
 *
 * Licensed under MIT License
 * Redistributions of files must retain the above copyright notice.
 * Visit https://github.com/mrahmadt/cakephp-email-model to get the latest version
 *
 * @copyright     Copyright 2012-2012, SmartData, Inc. (http://smartdata.com.sa)
 * @link          http://rsaeel.com Rsaeel Project
 * @version		  $Id$
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Model for sending emails by shell
 *
 * @package default
 * @author Shadow
 */
class Mail extends AppModel {
/**
 * Get email data and save it to database (Shell script should send it)
 *
 * 
 * @param string $template email template (views/Emails/)
 * @param string $name name of the recipient.
 * @param string $email email of the recipient.
 * @param string $subject email subject.
 * @param array $options any data you would like to send to the email template.
 * @param string $when Optional paramter to set after how many days you would like to send the email.
 * @return void
 * @author Shadow
 **/
	function sendEmail($template,$name,$email,$subject,$options,$when=null){
			$data = array(
				'template' => $template, 
				'name' => $name,
				'email' => $email,
				'subject' => $subject,
				'options'=>$options
			);
			if($when!=null){
				$when =  DboSource::expression('DATE_ADD(now(),INTERVAL ' . $when . ' DAY)');
			}
			$this->create();
			$this->save(array('when'=>$when, 'data' => json_encode($data)));
		
	}

}
