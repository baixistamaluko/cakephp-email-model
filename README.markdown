CakePHP eMail Model
============================================================

Simple code for any cakephp project (version 2), that will allow you to send all your web application emails from Cakephp shell and also allow you to schedule email for future date.

This designed for reducing the latency of page views in web applications by running the email sending process in background (Cakephp shell) without keeping your users waiting for your application (e.g. sending to groups)

How to add it to CakePHP project
-------------------------------------------------------

Very simple!:

1. Model/Mail.php to your Model directory.
2. Console/SendMailShell.php to your Console directory.
3. Add your email to core configuration file (core.php):
		Configure::write('emailSender','noreply@example.com');
4. Create the below table in your database.

		CREATE TABLE IF NOT EXISTS `mails` (`id` int(10) unsigned NOT NULL AUTO_INCREMENT,`sent` tinyint(1) NOT NULL DEFAULT '0',`data` text NOT NULL,`when` date DEFAULT NULL,`created` datetime NOT NULL,PRIMARY KEY (`id`),KEY `sent` (`sent`),KEY `when` (`when`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

How to use it
-------------------------------------------------------

When you want to send email just write the following code:

	ClassRegistry::init('Mail')->sendEmail($template,$name,$email,$data,null);

Where:

 * @param string $template email template (views/Emails/)
 * @param string $name name of the recipient.
 * @param string $email email of the recipient.
 * @param string $subject email subject.
 * @param array $options any data you would like to send to the email template.
 * @param string $when Optional paramter to set after how many days you would like to send the email.
 
 Also make sure to run the the Cakephp Shell SendMailShell (run it every 1 minute using cron job for example or run it in a terminal)
