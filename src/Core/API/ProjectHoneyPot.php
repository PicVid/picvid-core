<?php
/**
 * Namespace for all API classes of PicVid.
 */
namespace PicVid\Core\API;

/**
 * Class ProjectHoneypot
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Core\API
 */
class ProjectHoneyPot
{
    /**
     * Type for "search engine".
     * @var int
     */
    const SEARCH_ENGINE = 0;

    /**
     * Type for "suspicious".
     * @var int
     */
    const SUSPICIOUS = 1;

    /**
     * Type for "harvester".
     * @var int
     */
    const HARVESTER = 2;

    /**
     * Type for "comment spammer".
     * @var int
     */
    const COMMENT_SPAMMER = 4;

    /**
     * The access key of the Project Honeypot API.
     * @see https://www.projecthoneypot.org/httpbl_api.php
     * @var string
     */
    private $accessKey = '';

    /**
     * The number of days since last activity.
     * @var int
     */
    public $lastActivity = 0;

    /**
     * The Threat Rating is a metric that describes how dangerous an IP is
     * based off its observed suspicious activity.
     * @see http://www.projecthoneypot.org/threat_info.php
     * @var int
     */
    public $threatScore = 0;

    /**
     * The type of visitor. Defined types include: "search engine," "suspicious,"
     * "harvester," and "comment spammer."
     * @var int
     */
    public $visitorType = 0;

    /**
     * ProjectHoneypot constructor.
     * @param string $accessKey The access key of the Project Honeypot API.
     */
    public function __construct(string $accessKey)
    {
        $this->accessKey = ($this->isValidAccessKey($accessKey)) ? $accessKey : '';
    }

    /**
     * Method to check if a IP is suspiciously.
     * @param string $ip The IP address which will be checked.
     * @return bool The state if the IP address is suspiciously.
     */
    public function check(string $ip) : bool
    {
        //reset the properties.
        $this->lastActivity = 0;
        $this->threatScore = 0;
        $this->visitorType = 0;

        //check if the IP address have a valid format.
        if ($this->isValidIP($ip) === false) {
            return false;
        }

        //check if the access key is available (can be empty if not valid).
        if ($this->isValidAccessKey($this->accessKey) === false) {
            return false;
        }

        //get the information from Project Honeypot API.
        $info = dns_get_record($this->accessKey.'.'.$this->reverseIP($ip).'.dnsbl.httpbl.org', DNS_A);

        //check if the response information is available.
        if (isset($info[0]['ip'])) {
            $responseIP = $info[0]['ip'];

            //check if the IP address is valid.
            if ($this->isValidIP($responseIP) === false) {
                return false;
            }

            //get the information parts.
            $infos = explode('.', $responseIP);

            //check if all parts available and the response is successfull.
            if ((count($infos) === 4) && ($infos[0] === "127")) {
                $this->lastActivity = (int) $infos[1];
                $this->threatScore = (int) $infos[2];
                $this->visitorType = (int) $infos[3];
                return true;
            }
        }

        //return the default state.
        return false;
    }

    /**
     * Method to get the state if the IP is a "spammer".
     * @return bool The state if the IP is a "spammer".
     */
    public function isCommentSpammer() : bool
    {
        return (($this->visitorType & self::COMMENT_SPAMMER) === self::COMMENT_SPAMMER);
    }

    /**
     * Method to get the state if the IP is a "harvester".
     * @return bool The state if the IP is a "harvester".
     */
    public function isHarvester() : bool
    {
        return (($this->visitorType & self::HARVESTER) === self::HARVESTER);
    }

    /**
     * Method to get the state if the IP is a "search engine".
     * @return bool The state if the IP is a "search engine".
     */
    public function isSearchEngine() : bool
    {
        //check if all values empty.
        if (($this->visitorType === 0) && ($this->lastActivity === 0) && ($this->threatScore === 0)) {
            return false;
        } else {
            return (($this->visitorType ^ self::SEARCH_ENGINE) === self::SEARCH_ENGINE);
        }
    }

    /**
     * Method to get the state if the IP is "suspicious".
     * @return bool The state if the IP is "suspicious".
     */
    public function isSuspicious() : bool
    {
        return (($this->visitorType & self::SUSPICIOUS) === self::SUSPICIOUS);
    }

    /**
     * Method to check if the access key have a valid format.
     * @param string $accessKey The access key which will be checked.
     * @return bool The state if the access key have a valid format.
     */
    private function isValidAccessKey(string $accessKey) : bool
    {
        return (preg_match('/^[a-z]{12}$/', $accessKey) === 1);
    }

    /**
     * Method to check if the IP address have a valid format.
     * @param string $ip The IP address which will be checked.
     * @return bool The state if the IP have a valid format.
     */
    private function isValidIP(string $ip) : bool
    {
        $regex = '/(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/';
        return (preg_match($regex, $ip) === 1) ? true : false;
    }

    /**
     * Method to reverse the octets of an IP address.
     * @param string $ip The IP address which will be reversed.
     * @return string The reversed IP address.
     */
    private function reverseIP(string $ip) : string
    {
        return implode('.', array_reverse(explode('.', $ip)));
    }
}
