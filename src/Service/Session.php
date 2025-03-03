<?php

namespace Service;

use Service\Exception\SessionException;

class Session
{
    public static function start()
    {
        $status = session_status();
        if (PHP_SESSION_NONE == $status) {
            if (headers_sent()) {
                throw new SessionException('Session started before starting session');
            }
            if (!session_start()) {
                throw new SessionException('Failed to start session');
            }
        } elseif (PHP_SESSION_DISABLED == $status) {
            throw new SessionException('Session disabled');
        } elseif (PHP_SESSION_ACTIVE == $status) {
            //pass
        } else {
            throw new SessionException('Invalid session');
        }
    }
}
