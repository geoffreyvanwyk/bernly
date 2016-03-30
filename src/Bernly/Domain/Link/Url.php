<?php

namespace Bernly\Domain\Link;

use Bernly\Domain\Link\InvalidUrlException;

/**
 * Value object representing a Universal Resource Locator (URL). The regular
 * expression used in its validation has been copied from the Symfony framework.
 *
 * @link https://github.com/symfony/Validator/blob/master/Constraints/UrlValidator.php
 */
class Url
{
    /**
     * Regular expression for matching a protocol.
     *
     * @const string
     */
    const PROTOCOL = '^((https?|ftps?|file|ssh)://)?';

    /**
     * Regular expression for matching the basic HTTP authentication username
     * and password.
     *
     * @const string
     */
    const AUTH = '(([\pL\pN-]+:)?([\pL\pN-]+)@)?';

    /**
     * Regular expression for matching a domain name of a version 4 or 6 IP
     * address.
     *
     * @const string
     */
    const DOMAIN_OR_IP = '(
                ([\pL\pN\pS-\.])+(\.?([\pL]|xn\-\-[\pL\pN-]+)+\.?)
                    |
                \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}
                    |
                \[
                    (?:(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){6})
                    (?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|
                    (?:(?:(?:(?:(?:25[0-5]|
                    (?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|
                    (?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|
                    (?:(?:::(?:(?:(?:[0-9a-f]{1,4})):){5})
                    (?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|
                    (?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}
                    (?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|
                    (?:(?:(?:(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):)
                    {4})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|
                    (?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}
                    (?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|
                    (?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,1}
                    (?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){3})
                    (?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|
                    (?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}
                    (?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|
                    (?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,2}
                    (?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){2})
                    (?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|
                    (?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}
                    (?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|
                    (?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,3}
                    (?:(?:[0-9a-f]{1,4})))?::(?:(?:[0-9a-f]{1,4})):)
                    (?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|
                    (?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}
                    (?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|
                    (?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,4}
                    (?:(?:[0-9a-f]{1,4})))?::)(?:(?:(?:(?:(?:[0-9a-f]{1,4}))
                    :(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|
                    1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|
                    2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):)
                    {0,5}(?:(?:[0-9a-f]{1,4})))?::)(?:(?:[0-9a-f]{1,4})))|
                    (?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,6}
                    (?:(?:[0-9a-f]{1,4})))?::))))
                \]
    )';

    /**
     * Regular expression for matching the port number.
     *
     * @const string
     */
    const PORT = '(:[0-9]+)?';

    /**
     * Regular expression for matching the Universal Resource Indicator (URI)
     * section of the URL: path, query string, and fragment.
     *
     * @const string
     */
    const URI = '(/?|/\S+|\?\S*|\#\S*)$';

    /**
     * String representation of the URL.
     *
     * @var string
     */
    private $value;

    /**
     * Protocol of the URL.
     *
     * @var string
     */
    private $protocol;

    /**
     * Basic HTTP authentication username and password.
     *
     * @var string
     */
    private $auth;

    /**
     * Domain name or IP address.
     *
     * @var string
     */
    private $domainOrIp;

    /**
     * Port number.
     *
     * @var string
     */
    private $port;

    /**
     * Universal Resource Indicator (URI): path, query string, and fragment.
     *
     * @var string
     */
    private $uri;

    /**
     * Returns new instance of class via `new` keyword, if the given string is a
     * valid URL.
     *
     * @param string $value URL
     *
     * @throws Bernly\Domain\Link\InvalidUrlException
     * @return self
     */
    public function __construct($value)
    {
        $pattern = '~' .
            self::PROTOCOL .
            self::AUTH .
            self::DOMAIN_OR_IP .
            self::PORT .
            self::URI .
            '~ixu';

        if (! preg_match($pattern, $value, $matches)) {
            throw new InvalidUrlException(
                'The link you provided is not a valid URL.'
            );
        }

        $this->value = $value;
        $this->protocol = $matches[2];
        $this->auth = $matches[3];
        $this->domainOrIp = $matches[6];
        $this->port = $matches[10];
        $this->uri = $matches[11];
    }

    /**
     * Getter for Url::value.
     *
     * @return string
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Getter for Url::protocol.
     *
     * @return string
     */
    public function protocol()
    {
        return $this->protocol;
    }

    /**
     * Getter for Url::auth.
     *
     * @return string
     */
    public function auth()
    {
        return $this->auth;
    }

    /**
     * Getter for Url::domainOrIp.
     *
     * @return string
     */
    public function domainOrIp()
    {
        return $this->domainOrIp;
    }

    /**
     * Getter for Url::port.
     *
     * @return string
     */
    public function port()
    {
        return $this->port;
    }

     /**
     * Getter for Url::uri.
     *
     * @return string
     */
    public function uri()
    {
        return $this->uri;
    }

    /**
     * Checks whether two URLs are equal.
     *
     * @param \Bernly\Domain\Link\Url $that
     * @return boolean
     */
    public function equals(Url $that)
    {
        return $this->equalProtocol($that) &&
               $this->equalAuth($that) &&
               $this->equalDomainOrIp($that) &&
               $this->equalPort($that) &&
               $this->equalUri($that);
    }

    /**
     * Checks whether the protocols of two Urls are the same.
     *
     * @param \Bernly\Domain\Link\Url $that
     *
     * @return boolean
     */
    public function equalProtocol(Url $that)
    {
        return (
            strtolower($this->protocol()) === strtolower($that->protocol())
        );
    }

    /**
     * Checks whether the auths of two Urls are the same.
     *
     * @param \Bernly\Domain\Link\Url $that
     *
     * @return boolean
     */
    public function equalAuth(Url $that)
    {
        return $this->auth() === $that->auth();
    }

    /**
     * Checks whether the domains of IPs of two Urls are the same.
     *
     * @param \Bernly\Domain\Link\Url $that
     *
     * @return boolean
     */
    public function equalDomainOrIp(Url $that)
    {
        return (
            strtolower($this->domainOrIp()) === strtolower($that->domainOrIp())
        );
    }

    /**
     * Checks whether the ports of two Urls are the same.
     *
     * @param \Bernly\Domain\Link\Url $that
     *
     * @return boolean
     */
    public function equalPort(Url $that)
    {
        return $this->port() === $that->port();
    }

    /**
     * Checks whether the URIs of two Urls are the same.
     *
     * @param \Bernly\Domain\Link\Url $that
     *
     * @return boolean
     */
    public function equalUri(Url $that)
    {
        return $this->uri() === $that->uri();
    }
}
