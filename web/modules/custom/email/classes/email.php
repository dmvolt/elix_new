<?php

defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Email module
 *
 * Ported from Kohana 2.2.3 Core to Kohana 3.0 module
 * 
 * Updated to use Swiftmailer 4.0.4
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Email {

    // SwiftMailer instance
    protected static $mail;

    /**
     * Creates a SwiftMailer instance.
     *
     * @param   string  DSN connection string
     * @return  object  Swift object
     */
    public static function connect($config = NULL) {
        if (!class_exists('Swift_Mailer', FALSE)) {
            // Load SwiftMailer
            require Kohana::find_file('vendor', 'swift/swift_required');
        }

        // Load default configuration
        ($config === NULL) and $config = Kohana::$config->load('email');

        switch ($config['driver']) {
            case 'smtp':
                // Set port
                $port = empty($config['options']['port']) ? 25 : (int) $config['options']['port'];

                // Create SMTP Transport
                $transport = Swift_SmtpTransport::newInstance($config['options']['hostname'], $port);

                if (!empty($config['options']['encryption'])) {
                    // Set encryption
                    $transport->setEncryption($config['options']['encryption']);
                }

                // Do authentication, if part of the DSN
                empty($config['options']['username']) or $transport->setUsername($config['options']['username']);
                empty($config['options']['password']) or $transport->setPassword($config['options']['password']);

                // Set the timeout to 5 seconds
                $transport->setTimeout(empty($config['options']['timeout']) ? 5 : (int) $config['options']['timeout']);
                break;
            case 'sendmail':
                // Create a sendmail connection
                $transport = Swift_SendmailTransport::newInstance(empty($config['options']) ? "/usr/sbin/sendmail -bs" : $config['options']);

                break;
            default:
                // Use the native connection
                $transport = Swift_MailTransport::newInstance($config['options']);
                break;
        }

        // Create the SwiftMailer instance
        return Email::$mail = Swift_Mailer::newInstance($transport);
    }

    /**
     * Send an email message.
     *
     * @param   string|array  recipient email (and name), or an array of To, Cc, Bcc names
     * @param   string|array  sender email (and name)
     * @param   string        message subject
     * @param   string        message body
     * @param   boolean       send email as HTML
     * @return  integer       number of emails sent
     */
    public static function send($to, $from, $subject, $message, $html = FALSE) {
        // Connect to SwiftMailer
        (Email::$mail === NULL) and email::connect();

        // Determine the message type
        $html = ($html === TRUE) ? 'text/html' : 'text/plain';

        // Create the message
        $message = Swift_Message::newInstance($subject, $message, $html, 'utf-8');

        if (is_string($to)) {
            // Single recipient
            $message->setTo($to);
        } elseif (is_array($to)) {
            if (isset($to[0]) AND isset($to[1])) {
                // Create To: address set
                $to = array('to' => $to);
            }

            foreach ($to as $method => $set) {
                if (!in_array($method, array('to', 'cc', 'bcc'))) {
                    // Use To: by default
                    $method = 'to';
                }

                // Create method name
                $method = 'add' . ucfirst($method);

                if (is_array($set)) {
                    // Add a recipient with name
                    $message->$method($set[0], $set[1]);
                } else {
                    // Add a recipient without name
                    $message->$method($set);
                }
            }
        }

        if (is_string($from)) {
            // From without a name
            $message->setFrom($from);
        } elseif (is_array($from)) {
            // From with a name
            $message->setFrom($from[0], $from[1]);
        }

        return Email::$mail->send($message);
    }

    public static function get_email_template($template_id, $template_data, $module) {
        $email_data = array();

        $content = new Model_Email();
        $result = $content->get_content($template_id);

        $email_data['reg_data'] = (isset($template_data['reg_data'])) ? $template_data['reg_data'] : '';
        $email_data['pwrecovery_link'] = (isset($template_data['pwrecovery_link'])) ? $template_data['pwrecovery_link'] : '';

        $email_data['order_id'] = (isset($template_data['orderinfo']['id'])) ? $template_data['orderinfo']['id'] : '';
        $email_data['order_date'] = (isset($template_data['orderinfo']['date'])) ? $template_data['orderinfo']['date'] : '';
        $email_data['order_status'] = (isset($template_data['orderinfo']['status'])) ? $template_data['orderinfo']['status'] : '';
        $email_data['customer_name'] = (isset($template_data['customer_name'])) ? $template_data['customer_name'] : '';
        $email_data['customer_lastname'] = (isset($template_data['customer_lastname'])) ? $template_data['customer_lastname'] : '';

        $email_data['customer_info'] = (isset($template_data['customerinfo'])) ? $template_data['customerinfo'] : '';
        $email_data['cart_info'] = (isset($template_data['cartinfo'])) ? $template_data['cartinfo'] : '';

        $pre_email_tokens = Kohana::$config->load('email_tokens');

        $email_tokens = $pre_email_tokens[$module];

        foreach ($email_tokens as $key => $value) {

            $search = '[' . $key . ']';
            if (isset($email_data[$key])) {
                $replace = $email_data[$key];
            } else {
                $replace = '';
            }

            $result['body'] = str_replace($search, $replace, $result['body']);
        }
        $logo = Kohana::$config->load('site.logo');
        $template = View::factory('email')
                ->bind('logo', $logo)
                ->bind('email_data_body', $result['body']);
        return $template;
    }

}

// End email