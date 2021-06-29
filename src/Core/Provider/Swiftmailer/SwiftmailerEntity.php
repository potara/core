<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Provider\Swiftmailer;


use Potara\Core\Crud\AbstractEntity;


class SwiftmailerEntity extends AbstractEntity
{
    public $transport;

    public $mailer;

    public $message;

    /**
     * @var type=string
     */
    public $host;

    /**
     * @var type=integer
     */
    public $port;

    /**
     * @var type=string
     */
    public $encryption;

    /**
     * @var type=string
     */
    public $username;

    /**
     * @var type=string
     */
    public $password;

    /**
     * @var type=string
     */
    public $auth;

    /**
     * @var type=array
     */
    public $stream_options;

    public function __construct($conf = [])
    {
        $conf['host']       = !empty($conf['host']) ? $conf['host'] : 'localhost';
        $conf['port']       = !empty($conf['port']) ? $conf['port'] : 25;
        $conf['encryption'] = !empty($conf['encryption']) ? $conf['encryption'] : null;

        parent::__construct($conf);

        if (class_exists(\Swift_SmtpTransport::class) && class_exists(\Swift_Mailer::class)) {
            $this->transport = new \Swift_SmtpTransport($this->host, $this->port, $this->encryption);
            empty($this->username) ?: $this->transport->setUsername($this->username);
            empty($this->password) ?: $this->transport->setPassword($this->password);
            empty($this->auth) ?: $this->transport->setAuthMode($this->auth);
            empty($this->stream_options) ?: $this->transport->setStreamOptions($this->stream_options);

            $this->mailer  = new \Swift_Mailer($this->transport);
            $this->message = new SwiftmailerMessage();;
        }
    }

    public function send()
    {
        return $this->mailer->send($this->message);
    }
}