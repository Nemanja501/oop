<?php
class Mail{
    private string $adress;
    private string $subject;
    private string $content;

    public function setAdress($adress){
        $this->adress = $adress;
    }

    public function setSubject($subject){
        $this->subject = $subject;
    }

    public function setContent($content){
        $this->content = $content;
    }

    public function getAdress(){
        return $this->adress;
    }

    public function getSubject(){
        return $this->subject;
    }

    public function getContent(){
        return $this->content;
    }
}

class MailService{
    private static $instance;
    private int $mailCounter = 0;

    private function __construct()
    {
        
    }

    static function getInstance(){
        if(self::$instance == NULL){
            self::$instance = new MailService();
        }

        return self::$instance;
    }

    public function sendMail(Mail $mail){
        echo "Sending mail to: " . $mail->getAdress() . "\n";
        $this->mailCounter++;
    }

    public function getCounter(){
        return $this->mailCounter;
    }
}

class MailFactory{
    public function makeMail($adress, $subject, $content){
        $mail = new Mail();
        $mail->setAdress($adress);
        $mail->setSubject($subject);
        $mail->setContent($content);
        return $mail;
    }
}

$mailFactory = new MailFactory();
$mail = $mailFactory->makeMail("marko@gmail.com", "new mail", "sdasfefa");
$mail2 = $mailFactory->makeMail("nemanja@gmail.com", "mail", "dasdsadf");
$mail3 = $mailFactory->makeMail("aleksa@gmail.com", "title", "vrsvsvvsvvsv");
MailService::getInstance()->sendMail($mail);
MailService::getInstance()->sendMail($mail2);
MailService::getInstance()->sendMail($mail3);
echo MailService::getInstance()->getCounter() . "\n";