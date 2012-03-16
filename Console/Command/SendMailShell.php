<?php
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
 *
 *
 * Run this shell script every 1 minute to send emails from mail model
 *
 */
class SendMailShell extends AppShell {
	public $uses = array('Mails');

	public function main() {
		set_time_limit(0);
		ini_set('memory_limit', '64M');
		$mails = $this->Mails->find('all',array('limit'=>500,'order'=>'id DESC','conditions'=>array('sent'=>false,'OR'=>array('when'=>null,'when <='=> date("Y-m-d") ))) );
		App::uses('CakeEmail', 'Network/Email');
		$from = Configure::read('emailSender');
		$CakeEmail = new CakeEmail('default');
		foreach($mails as $each) {
			$data = json_decode($each['Mails']['data'], true);
			try{
				$CakeEmail->template($data['template']);
				$CakeEmail->viewVars($data['options']);
				//$CakeEmail->sendAs('both');
				$CakeEmail->to($data['email']);
				$CakeEmail->from($from);
				$CakeEmail->subject($data['subject']);
				$CakeEmail->emailFormat('both');
				if($CakeEmail->send()) {
					$data = array('id' => $each['Mails']['id'], 'sent' => 1);
					$this->Mails->save($data);
				}
			} catch (Exception $e) {
			    echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
			$CakeEmail->reset();
		}
	}
}