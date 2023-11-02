<?php
declare(strict_types=1);

namespace Lib;

/**
 * validate :: FeBe - Framework
 */
abstract class validate {    
    /**
     * checkMail
     *
     * @param  string $mail
     * @return bool
     */
    public static function checkMail($mail): bool {
        // email ohne '@' und ohne '.'
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return false;
        }else{
            // existiert die Domain?
            $domain = explode('@', $mail);
            if (!checkdnsrr($domain[1])) {
                return false;
            }
            // wegwerf email?
            $wegwerf = array('wegwerfmail.de', 'trashmail.com', 'trashmail.de', 'trashmail.net', 'trashmail.org', 'temp-mail.org', 'tempmail.de', 'temp-mail.de', 'tempmailer.com', 'tempmailer.de', 'temporärmail.de', 'temporärmail.com', 'temporärmail.net', 'temporärmail.org', 'tempmailaddress.com', 'tempmailaddress.de', 'tempmailaddress.net', 'tempmailaddress.org', 'fakeinbox.com', 'fakeinbox.de', 'fakeinbox.net', 'fakeinbox.org', 'discardmail.com', 'discardmail.de', 'discardmail.net', 'discardmail.org', 'discard.email', 'discardmailaddress.com', 'discardmailaddress.de', 'discardmailaddress.net', 'discardmailaddress.org', 'trashmailer.com', 'trashmailer.de', 'trashmailer.net', 'trashmailer.org', 'wegwerfmail.de', 'wegwerfmail.net', 'wegwerfmail.org', 'wegwerfmailadresse.com', 'wegwerfmailadresse.de', 'wegwerfmailadresse.net', 'wegwerfmailadresse.org');
            if (in_array($domain[1], $wegwerf)) {
                return false;
            }
            return true;
        }
    }

}