<?
/********************************************************************************
 * The contents of this file are subject to the Common Public Attribution License
 * Version 1.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at
 * http://www.wikiarguments.net/license/. The License is based on the Mozilla
 * Public License Version 1.1 but Sections 14 and 15 have been added to cover
 * use of software over a computer network and provide for limited attribution
 * for the Original Developer. In addition, Exhibit A has been modified to be
 * consistent with Exhibit B.
 *
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 *
 * The Original Code is Wikiarguments. The Original Developer is the Initial
 * Developer and is Wikiarguments GbR. All portions of the code written by
 * Wikiarguments GbR are Copyright (c) 2012. All Rights Reserved.
 * Contributor(s):
 *     Andreas Wierz (andreas.wierz@gmail.com).
 *
 * Attribution Information
 * Attribution Phrase (not exceeding 10 words): Powered by Wikiarguments
 * Attribution URL: http://www.wikiarguments.net
 *
 * This display should be, at a minimum, the Attribution Phrase displayed in the
 * footer of the page and linked to the Attribution URL. The link to the Attribution
 * URL must not contain any form of 'nofollow' attribute.
 *
 * Display of Attribution Information is required in Larger Works which are
 * defined in the CPAL as a work which combines Covered Code or portions
 * thereof with code not governed by the terms of the CPAL.
 *******************************************************************************/

function generatePassword($len = 8, $alphabet = "ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789")
{
    $pass = "";
    $alph_len = strlen($alphabet) - 1;
    for($i = 0; $i < $len; $i++)
    {
        $pos = round(mt_rand(0, $alph_len));
        $pass .= substr($alphabet, $pos, 1);
    }

    return $pass;
}

function salt($len = 16)
{
    return generatePassword($len);
}

function a($value)
{
    if(!is_array($value))
    {
        return mysql_real_escape_string($value);
    }else
    {
        return NULL;
    }
}

function i($value)
{
    if(!is_array($value))
    {
        return intval($value);
    }else
    {
        return NULL;
    }
}

function send_mail_from($from, $fromName, $to, $subject, $message)
{
    $mail = new HTMLMail($to, $to, $fromName, $from);
    $mail->buildMessage($subject, $message);
    $mail->sendmail();
}

class Timer
{
    public function Timer()
    {
        $this->m_timer = 0;
        $this->m_start = 0;
    }

    public function start()
    {
        $this->m_start = microtime(true);
    }

    public function stop()
    {
        $this->m_timer += microtime(true) - $this->m_start;
        $this->m_start = 0;
    }

    public function getTimeElapsed()
    {
        return $this->m_timer;
    }

    public function getTimeElapsedMs()
    {
        return $this->m_timer * 1000;
    }

    public function isRunning()
    {
        return $this->m_start != 0 ? true : false;
    }

    private $m_timer;
    private $m_start;
}

/*
* valid usernames are alphanumeric and contain no badwords
*/
function isValidUsername($user_name)
{
    global $sDB;
    if(preg_match("/[^\\w-_!§\$%&\\(\\)\\[\\]{}*#\\|öäüÖÄÜáàâéèêíìîóòôúùû]/i", $user_name)) return false;
    $res = $sDB->exec("SELECT * FROM `badwords` WHERE `category` IN (".BADWORD_CATEGORY_ALL.", ".BADWORD_CATEGORY_USERNAME.");");
    while($row = mysql_fetch_object($res))
    {
        if(preg_match("/".$row->word."/i", $user_name))
        {
            return false;
        }
    }
    return true;
}

function getPositionByPostalCode($country_code, $postal_code)
{
    global $sDB;
    $ret = Array("lon" => 0, "lat" => 0, "city" => "");

    $res = $sDB->exec("SELECT lat, lon, place_name, admin_name1, admin_name2, admin_name3 FROM `geonames` WHERE `country_code` = '".mysql_real_escape_string($country_code)."' AND `postal_code` = '".mysql_real_escape_string($postal_code)."' AND `lat` != 0 AND `lon` != 0 LIMIT 1;");
    if(!mysql_num_rows($res) && ctype_digit($postal_code))
    { // try a range lookup if the postal_code is integral
        $res = $sDB->exec("SELECT lat, lon, place_name, admin_name1, admin_name2, admin_name3 FROM `geonames`
                           WHERE `country_code` = '".mysql_real_escape_string($country_code)."' AND
                                 `postal_code` >= '".i($postal_code)."' AND
                                 `postal_code` <= '".i($postal_code + 1000)."' AND
                                 `lat` != 0 AND
                                 `lon` != 0
                           ORDER BY `postal_code` LIMIT 1;");
    }
    if(mysql_num_rows($res))
    {
        $row = mysql_fetch_object($res);
        $ret["lon"]         = $row->lon;
        $ret["lat"]         = $row->lat;
        $ret["city"]        = $row->place_name;
        $ret["admin_name1"] = $row->admin_name1;
        $ret["admin_name2"] = $row->admin_name2;
        $ret["admin_name3"] = $row->admin_name3;
    }

    return $ret;
}

function validateFaction($faction, $redirect = true)
{
    global $sTemplate;

    if(!in_array($faction, Array(ARGUMENT_PRO, ARGUMENT_CON)))
    {
        if($redirect)
        {
            $sTemplate->error($sTemplate->getString("ERROR_INVALID_FACTION"));
        }

        return false;
    }

    return true;
}

function complementFaction($faction)
{
    if($faction == FACTION_PRO)
    {
        return FACTION_CON;
    }else if($faction == FACTION_CON)
    {
        return FACTION_PRO;
    }

    return FACTION_NONE;
}

function timeSinceString($date)
{
    global $sTemplate;

    $diff = max(time() - $date, 1);

    $years = floor($diff / (60 * 60 * 24 * 30 * 12));
    $diff -= $years * (60 * 60 * 24 * 30 * 12);

    $month = floor($diff / (60 * 60 * 24 * 30));
    $diff -= $month * (60 * 60 * 24 * 30);

    $days = floor($diff / (60 * 60 * 24));
    $diff -= $days * (60 * 60 * 24);

    $hours = floor($diff / (60 * 60));
    $diff -= $hours * (60 * 60);

    $minutes = floor($diff / 60);
    $diff -= $minutes * 60;

    $seconds = $diff;

    $langVar = false;
    $var     = false;
    $suffix  = "";

    if($years)
    {
        $var     = $years;
        $langVar = "TIME_SINCE_YEARS";
    }else if($month)
    {
        $var     = $month;
        $langVar = "TIME_SINCE_MONTHS";
    }else if($days)
    {
        $var     = $days;
        $langVar = "TIME_SINCE_DAYS";
    }else if($hours)
    {
        $var     = $hours;
        $langVar = "TIME_SINCE_HOURS";
    }else if($minutes)
    {
        $var     = $minutes;
        $langVar = "TIME_SINCE_MINUTES";
    }else
    {
        $var     = $seconds;
        $langVar = "TIME_SINCE_SECONDS";
    }

    return $sTemplate->getStringNumber($langVar,
                                     Array("[YEARS]", "[MONTHS]", "[DAYS]", "[HOURS]", "[MINUTES]", "[SECONDS]"),
                                     Array($years, $month, $days, $hours, $minutes, $seconds), $var);
}

class Packet
{
    public function Packet($opcode = "SMSG_UNKNOWN_OPCODE", $data = "")
    {
        $this->opcode = $opcode;
        $this->data = $data;
    }

    public $opcode;
    public $data;
}

class Request
{
    public function Request()
    {
    }

    public function getString($key)
    {
        return mysql_real_escape_string($this->getPlain($key));
    }

    public function getStringPlain($key)
    {
        return (is_string($this->getPlain($key)) ? $this->getPlain($key) : '');
    }

    public function getObject($key)
    {
        return (is_object($this->getPlain($key)) ? $this->getPlain($key) : new stdClass());
    }

    public function getArray($key)
    {
        return (is_array($this->getPlain($key)) ? $this->getPlain($key) : Array());
    }

    public function getInt($key)
    {
        return i($this->getPlain($key));
    }

    private function getPlain($key)
    {
        if(@$_GET[$key])
        {
            return $_GET[$key];
        }
        if(@$_POST[$key])
        {
            return $_POST[$key];
        }
        return @$_REQUEST[$key];
    }

    private $data;
}

/*
 * Basic packet handler class.
*/
class PacketHandler
{
    public function PacketHandler()
    {
    }
}

class BaseConvert
{
    public function BaseConvert( $_number='', $_frBase=10, $_toBase=62 )
    {

        $_10to62 =  array('0'  => '0', '1'  => '1', '2'  => '2', '3'  => '3', '4'  => '4', '5'  => '5', '6'  => '6', '7'  => '7', '8'  => '8', '9'  => '9', '00' => '0', '01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7',
                          '10' => 'A', '11' => 'B', '12' => 'C', '13' => 'D', '14' => 'E', '15' => 'F', '16' => 'G', '17' => 'H', '18' => 'I', '19' => 'J', '20' => 'K', '21' => 'L', '22' => 'M', '23' => 'N', '24' => 'O', '25' => 'P', '26' => 'Q', '27' => 'R',
                          '30' => 'U', '31' => 'V', '32' => 'W', '33' => 'X', '34' => 'Y', '35' => 'Z', '36' => 'a', '37' => 'b', '38' => 'c', '39' => 'd', '40' => 'e', '41' => 'f', '42' => 'g', '43' => 'h', '44' => 'i', '45' => 'j', '46' => 'k', '47' => 'l',
                          '50' => 'o', '51' => 'p', '52' => 'q', '53' => 'r', '54' => 's', '55' => 't', '56' => 'u', '57' => 'v', '58' => 'w', '59' => 'x', '60' => 'y', '61' => 'z'  );

        $_62to10 =  array('0' => '00', '1' => '01', '2' => '02', '3' => '03', '4' => '04', '5' => '05', '6' => '06', '7' => '07', '8' => '08', '9' => '09', 'A' => '10', 'B' => '11', 'C' => '12', 'D' => '13', 'E' => '14', 'F' => '15', 'G' => '16', 'H' => '17',
                          'I' => '18', 'J' => '19', 'K' => '20', 'L' => '21', 'M' => '22', 'N' => '23', 'O' => '24', 'P' => '25', 'Q' => '26', 'R' => '27', 'S' => '28', 'T' => '29', 'U' => '30', 'V' => '31', 'W' => '32', 'X' => '33', 'Y' => '34', 'Z' => '35',
                          'a' => '36', 'b' => '37', 'c' => '38', 'd' => '39', 'e' => '40', 'f' => '41', 'g' => '42', 'h' => '43', 'i' => '44', 'j' => '45', 'k' => '46', 'l' => '47', 'm' => '48', 'n' => '49', 'o' => '50', 'p' => '51', 'q' => '52', 'r' => '53',
                          's' => '54', 't' => '55', 'u' => '56', 'v' => '57', 'w' => '58', 'x' => '59', 'y' => '60', 'z' => '61' );

        // convert to base10

        $_in_b10        =   0;
        $_pwr_of_frB    =   1;
        $_chars         =   str_split( $_number );
        $_str_len       =   strlen( $_number );
        $_pos           =   0;

        while     (  $_pos++ < $_str_len )  {
            $_char          =   $_chars[$_str_len - $_pos];
            $_in_b10       +=   (((int) $_62to10[$_char] ) * $_pwr_of_frB);
            $_pwr_of_frB   *=   $_frBase;
        }

        // convert to new base

        $_dividend      = (int)$_in_b10;
        $_in_toB        = '';

        while     ( $_dividend > 0 )        {

            $_quotient  =   (int) ( $_dividend / $_toBase );
            $_remainder =   ''  .  ( $_dividend % $_toBase );
            $_in_toB    =   $_10to62[$_remainder] . $_in_toB;
            $_dividend  =   $_quotient;
        }

        if  ( $_in_toB  ==  '' )
              $_in_toB  =   '0';

        $this->_in_toB = $_in_toB;
    }

    public function val()
    {
        return $this->_in_toB;
    }

    private $_in_toB;
};

function url_sanitize($url)
{
    mb_internal_encoding("UTF-8");
    $url = str_replace(" ", "-", mb_strtolower($url));

    return $url;
}
?>
