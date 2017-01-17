<?php

namespace api\models;

use api\components\CommonHelper;
use Yii;

class Mail
{
    const ACCTTYPE_USER = 'User';
    const ACCTTYPE_CANDIDATE = 'ExternalCandidate';

    public $SysFrom;

    public $SysTo;

    public $SysCc;

    public $From;

    public $FromName;

    public $To;

    public $Cc;

    public $ReplyTo;

    public $Subject;

    public $Message;

    public $EmlContent;

    public $Attachment;

    public $CreateDate;

    // Internal data - used on form only
    public $Data;
    public $ProfileNames;

    public static function getEmailList($emails)
    {
        $list = explode(";", $emails);
        $maillist = array();
        foreach ($list as $index => $word) {
            $addr = trim($word);
            if (!empty($addr)) {
                $maillist[] = $addr;
            }
        }
        return $maillist;
    }

    /*
     * 发送意见反馈
     */
    public static function sendFeedbackEmail($content,$from_name)
    {
        //发送邮件给管理员
        $mail = new Mail();
        $mail->Message = $content;
        $mail->Subject = '一起--APP反馈意见';
        $mail->FromName = $from_name;
        $mail->To = Yii::$app->params['adminEmail'];
        $mail->From = Yii::$app->params['smtpUsername'];
        $mail->ReplyTo = Yii::$app->params['adminEmail'];
        CommonHelper::sendMail($mail,false);
    }

}
