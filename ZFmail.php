<?php
/**
 * mail.php
 *
 * A (very) simple mailer class written in PHP.
 *
 * @author Zachary Fox
 * @version 1.0
 */

class ZFmail{
    var $to = null;
    var $from = null;
    var $subject = null;
    var $body = null;
    var $headers = null;
    
    var $ENDLINE = "\r\n";

    function ZFmail($to,$from,$subject,$body){
        $this->to      = $to;
        $this->from    = $from;
        $this->subject = $subject;
        $this->body    = $body;
    }

    function send(){
        $this->addHeader('From: '.$this->from);
        $this->addHeader('Reply-To: '.$this->from);
        $this->addHeader('Return-Path: '.$this->from);
        $this->addHeader('X-mailer: ZFmail 1.0');
        return mail($this->to,$this->subject,$this->body,$this->headers);
    }

    function addHeader($header){
        $this->headers .= $header . $this->ENDLINE;
    }

}

