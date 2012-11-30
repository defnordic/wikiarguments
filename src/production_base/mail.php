<?
define("HEAD_CRLF","\r\n");

class HTMLMail {
    var $secVersion     = '1.0';
    var $to             = '';
    var $Cc             = array();
    var $Bcc            = array();
    var $subject        = '';
    var $message        = '';
    var $attachment     = array();
    var $embed          = array();
    var $charset        = 'UTF-8';
    var $emailboundary  = '';
    var $emailheader    = '';
    var $textheader     = '';
    var $errors         = array();

    function HTMLMail($toname, $toemail, $fromname, $fromemail)
    {
        $this->emailboundary = uniqid(time());
        $this->to            = $this->validateEmail($toemail);
        $this->emailheader  .= "From: ".$fromname."<".$fromemail.">".PHP_EOL;
        $this->emailheader  .= "Return-Path: ".$fromemail.PHP_EOL;
    }

    function validateEmail($email)
    {
        return $email;
    }

    function Cc($email)
    {
        $this->Cc[] = $this->validateEmail($email);
    }

    function Bcc($email)
    {
        $this->Bcc[] = $this->validateEmail($email);
    }

    function buildHead($type)
    {
        $count = count($this->$type);
        if($count > 0)
        {
            $this->emailheader .= "{$type}: ";
            $array              = $this->$type;
            for($i=0; $i < $count; $i++)
            {
                if($i > 0) $this->emailheader .= ',';
                $this->emailheader .= $this->validateEmail($array[$i]);
            }
            $this->emailheader .= PHP_EOL;
        }
    }

    function buildMimeHead()
    {
        $this->buildHead('Cc');
        $this->buildHead('Bcc');

        $this->emailheader .= "MIME-Version: 1.0".PHP_EOL;
    }

    function headerQuotedPrintableEncode($string, $encoding='UTF-8')
    {
        $string = str_replace(" ", "_", trim($string)) ;
        // We need to delete "=\r\n" produced by imap_8bit() and replace '?'
        $string = str_replace("?", "=3F", str_replace("=\r\n", "", imap_8bit($string))) ;

        // Now we split by \r\n - i'm not sure about how many chars (header name counts or not?)
        $string = chunk_split($string, 73);
        // We also have to remove last unneeded \r\n :
        $string = substr($string, 0, strlen($string)-2);
        // replace newlines with encoding text "=?UTF ..."
        $string = str_replace("\r\n", "?=".HEAD_CRLF." =?".$encoding."?Q?", $string) ;

        return '=?'.$encoding.'?Q?'.$string.'?=';
    }

    function buildMessage($subject, $message = '')
    {
        $message        = str_replace(Array('Ä','ä','Ö','ö','Ü','ü', 'ß'),
                                      Array('&Auml;','&auml;','&Ouml;','&ouml;','&Uuml;','&uuml;', '&szlig;'),
                                      $message);
        $messagePlain   = utf8_encode($message);

        $subject        = str_replace(Array('&Auml;','&auml;','&Ouml;','&ouml;','&Uuml;','&uuml;', '&szlig;'),
                                      Array('Ä','ä','Ö','ö','Ü','ü', 'ß'),
                                      $subject);
        $subject        = $this->headerQuotedPrintableEncode($subject);

        $textboundary   = uniqid(time());
        $this->subject  = $subject;

        $this->textheader = "Content-Type: multipart/alternative; boundary=\"$textboundary\"".PHP_EOL.PHP_EOL;
        $this->textheader .= "--{$textboundary}".PHP_EOL;
        $this->textheader .= "Content-Type: text/plain; charset=\"{$this->charset}\"".PHP_EOL;
        //$this->textheader .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
        $this->textheader .= "Content-Transfer-Encoding: 8bit".PHP_EOL.PHP_EOL;
        $this->textheader .= strip_tags($messagePlain).PHP_EOL.PHP_EOL;
        $this->textheader .= "--$textboundary".PHP_EOL;
        $this->textheader .= "Content-Type: text/html; charset=\"$this->charset\"".PHP_EOL;
        //$this->textheader .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
        $this->textheader .= "Content-Transfer-Encoding: 8bit".PHP_EOL.PHP_EOL;
        $this->textheader .= "<html>\n<body>\n".$message."\n</body>\n</html>".PHP_EOL.PHP_EOL;
        $this->textheader .= "--{$textboundary}--".PHP_EOL.PHP_EOL;
    }

    function mime_type($file)
    {
        return (function_exists('mime_content_type')) ? mime_content_type($file) : trim(exec('file -bi '.escapeshellarg($file)));
    }

    function attachment($file)
    {
        if(is_file($file))
        {
            $basename = basename($file);
            $attachmentheader = "--{$this->emailboundary}\r\n";
            $attachmentheader .= "Content-Type: ".$this->mime_type($file)."; name=\"{$basename}\"\r\n";
            $attachmentheader .= "Content-Transfer-Encoding: base64\r\n";
            $attachmentheader .= "Content-Disposition: attachment; filename=\"{$basename}\"\r\n\r\n";
            $attachmentheader .= chunk_split(base64_encode(fread(fopen($file,"rb"),filesize($file))),72)."\r\n";

            $this->attachment[] = $attachmentheader;
        } else
        {
            //die('The File '.$file.' does not exsist.');
        }
    }

    function embed($file)
    {
        if(is_file($file))
        {
            $basename     = basename($file);
            $fileinfo     = pathinfo($basename);
            $contentid    = md5(uniqid(time())); //.".".$fileinfo['extension'];
            $embedheader  = "--{$this->emailboundary}\r\n";
            $embedheader .= "Content-Type: ".$this->mime_type($file)."; name=\"{$basename}\"\r\n";
            $embedheader .= "Content-Transfer-Encoding: base64\r\n";
            $embedheader .= "Content-Disposition: inline; filename=\"{$basename}\"\r\n";
            $embedheader .= "Content-ID: <{$contentid}>\r\n\r\n";
            $embedheader .= chunk_split(base64_encode(fread(fopen($file,"rb"),filesize($file))),72)."\r\n";

            $this->embed[] = $embedheader;

            return "<img src=\"cid:{$contentid}\">";
        } else
        {
            //die('The File '.$file.' does not exsist.');
        }
    }

    function sendmail()
    {
        $this->buildMimeHead();

        $header = $this->emailheader;

        $attachcount = count($this->attachment);
        $embedcount = count($this->embed);

        if($attachcount > 0 || $embedcount > 0)
        {
            $header .= "Content-Type: multipart/mixed; boundary=\"{$this->emailboundary}\"".PHP_EOL.PHP_EOL;
            $header .= "--{$this->emailboundary}".PHP_EOL;
            $header .= $this->textheader;

            if($attachcount > 0) $header .= implode("",$this->attachment);

            if($embedcount > 0) $header .= implode("",$this->embed);

            $header .= "--{$this->emailboundary}--".PHP_EOL.PHP_EOL;
        } else
        {
            $header .= $this->textheader;
        }

        return mail($this->to, $this->subject, $this->message, $header);
    }
}
?>
