<?php

namespace api\components;

use Yii;
use api\extensions\mailer\EMailer;
use api\models\Mail;

class CommonHelper {
    // send mail
    public static function sendMail($email, $async = false, $html = false)
    {
        $mailer = new EMailer();
        $mailer->Host =   Yii::$app->params['smtpHost'];
        $mailer->SMTPAuth = true;
        //$mailer->SMTPSecure = 'tls';
        $mailer->Username = Yii::$app->params['smtpUsername'];
        $mailer->Password = Yii::$app->params['smtpPassword'];
        $mailer->IsSMTP();
        $mailer->Sender = Yii::$app->params['smtpUsername'];
        $mailer->IsHTML(true);
        // LIE TODO: we need to customize the From and the FromName according to the login user and companyId
        $mailer->From = $email->From; // 
        $mailer->FromName = $email->FromName; // $email->CreateUser . Yii::app()->user->CompanyName;
        $mailer->AddReplyTo($email->ReplyTo);

        Yii::trace('================ sending mails ======');
        // To list
        if (!empty($email->To)) {
            $addrList = Mail::getEmailList($email->To);
            if (!empty($addrList)) {
                foreach ($addrList as $addr) {
                    $mailer->AddAddress($addr);
                  //  Yii::trace("to: $addr");
                }
            }
        }

        // CC list
        if (!empty($email->Cc)) {
            $addrList = Mail::getEmailList($email->Cc);
            if (!empty($addrList)) {
                foreach ($addrList as $addr) {
                    $mailer->AddCc($addr);
                }
            }
        }

        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = $email->Subject;

        if ($html) {
            $mailer->IsHTML(true);
        }

        $message = $email->Message;
        $mailer->Body = $message;

        if(!empty($email->Attachment)){
            $attachments = explode(';',$email->Attachment);
            foreach($attachments as $attachment){
                if(!empty($attachment)){
                    $path = 'app-assets/contents/tmp/'.$attachment;
                    $mailer->AddAttachment($path);
                }
            }
        }

        // send
        $outDir = $_SERVER['DOCUMENT_ROOT'] . Yii::$app->params['tmpDir'];
        $eml = $outDir . '/' . date("YmdHis") . '_' . md5(uniqid()) . '.eml';
        if ($async) {
            // save eml file
            $mailer->PreSend();
            file_put_contents($eml, $mailer->GetSentMIMEMessage());

            // execute the format application
            $sendMailApp = '/opt/boleplus/apps/daemons/sendmail.sh';
            $logFile = $eml . '.log';
            $shellcmd = "$sendMailApp $eml > $logFile 2>&1 &";
            shell_exec($shellcmd);

        } else {
            $mailer->PreSend();
            file_put_contents($eml, $mailer->GetSentMIMEMessage());
            $mailer->Send();
        }

     //   Yii::trace('==============mailes sent....');
    }

    public static function getPlatformInfo()
    {
        $agent =  strtolower(Yii::$app->request->getUserAgent());

        if(strpos($agent,'android') !== false){
            return 'android';
        }

        return 'ios';
    }

    /*
     * 计算距离
     */
    public static function getDistance($lng1, $lat1, $lng2, $lat2)
    {
        //将角度转为狐度
        $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
        return $s;
    }
} 