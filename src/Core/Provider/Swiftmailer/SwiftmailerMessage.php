<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Provider\Swiftmailer;


use Swift_Message;
use Swift_Attachment;

class SwiftmailerMessage extends Swift_Message
{
    /**
     * SwiftmailerMessage constructor.
     *
     * @param string|null $subject
     * @param string|null $body
     * @param string|null $contentType
     * @param string|null $charset
     */
    public function __construct($subject = null, $body = null, $contentType = null, $charset = null)
    {
        parent::__construct($subject, $body, $contentType, $charset);
    }

    /**
     * @param null $filePath
     *
     * @return $this
     */
    public function addAttach($filePath = null) : self
    {
        if (!empty($filePath)) {
            $this->attach(Swift_Attachment::fromPath($filePath));
        }
        return $this;
    }
}