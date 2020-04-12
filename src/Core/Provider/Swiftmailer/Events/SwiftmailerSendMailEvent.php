<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Provider\Swiftmailer\Events;

use Symfony\Contracts\EventDispatcher\Event;
use Potara\Core\Provider\Swiftmailer\SwiftmailerMessage;

class SwiftmailerSendMailEvent extends Event
{
    public const NAME = 'swift.send_mail';
    public const METHOD = 'onSendMail';

    protected $message;

    public function __construct(SwiftmailerMessage $message)
    {
        $this->message = $message;
    }

    /**
     * @return SwiftmailerMessage
     */
    public function getMessage() : SwiftmailerMessage
    {
        return $this->message;
    }


}