<?php
class AI_Mail{
    var $email_body;
    var $email_to, $email_to_name, $email_from, $email_subject;
    function onSignup($first_name, $email_id, $act_code){
        $m = new Mail_Template();
        $m -> setParam("name", $first_name);
        $m -> setParam("code", $act_code);
        $url = site_url('user/activate/?email_id=' . $email_id . '&actcode=' . $act_code);
        //$str = "Dear {name} <br />Thank you for Signup with OSG Marketing. <br />Please activate your link by clicking on the link below. ";
        //$str .= '<a href="'. $url .'">'. $url . '</a><br />Thanks<br />OSG Marketing';
	$str = "Dear {name} <br />Thank you for Signup with OSG Marketing. <br />You can now login to OSG Marketing Account. ";
        $this -> email_body = $m -> htmlRender($str);
        $this -> email_to = $email_id;
        $this -> email_to_name = $first_name;
        $this -> email_subject = "Account Registration for OSG Marketing";
        return $this;
    }

    function onContact($your_name, $email_id, $issue_type, $mobile_no, $order_no, $message){
        $m = new Mail_Template();
        $m -> setParam("name", $your_name);
        $str = 'Greetings of the day ....., <br/>One new enquiry through OSG Marketing.com contact us: Issue Type: '. $issue_type . '<br/>Mobile No.'.$mobile_no.'<br/>Email ID: ' .$email_id. '<br/>Order No. '.$order_no.'<br/>Message: '.$message;
        $this -> email_body = $m -> htmlRender($str);
        $this -> email_to = 'care@aldivo.com';
        $this -> email_from = $email_id;
        $this -> email_subject = "Contact Us Enquiry through Aldivo.com";
        return $this;
    }

    function onForward($email, $data){
        $m = new Mail_Template();
        $m -> setParam("first_name", $data['first_name'] . " " . $data['last_name']);
        $m -> setParam("email_id", $data['email_id']);
        $m -> setParam("mobile_no", $data['mobile_no']);
        $m -> setParam("message", $data['message']);
        $m -> setParam("choice", $data['choice']);

        $str = "Dear {first_name} <br />Thank you for your patience, Following are the leads by which you can generate business. <br />";
        $str .= '<br />Client Name:' . $data['first_name']. ''. $data['last_name']  . '<br/>Enquired for: '. $data['choice'] . '<br/>Email Id: '.$data['email_id'].'<br/>Contact No.: '.$data['mobile_no'].'<br/>Message: '.$data['message'].'<br/><br/>Thanks<br />OSG Marketing';
        $this -> email_body = $m -> htmlRender($str);
        $this -> email_to = $email;
        $this -> email_to_name = $data['first_name'];
        $this -> email_subject = "Lead Generation from OSG Marketing";
        return $this;
    }

    function sendMail(){
        $CI =& get_instance();
        $CI -> email -> to($this -> email_to, $this -> email_to_name);
        $CI -> email -> from(FROM_SEND_EMAIL, FROM_SEND_EMAIL_NAME);
        $CI -> email -> subject($this -> email_subject);
        $CI -> email -> message($this -> email_body);
        $CI -> email -> send();

        //Reset Value;
        $this -> email_to = $this -> email_to_name = $this -> email_subject = $this -> email_body = $this ->email_from = '';
    }

    function onSuccessVerification($name, $email){
        $m = new Mail_Template();
        $m -> setParam("first_name", $name);
        $m -> setParam("email_id", $email);
        $str = "Dear {first_name}<br />Congratulation!! Your account has been activated successfully. You can now login with the details. <br />Thanks<br />OSG Marketing";

        $this -> email_body = $m -> htmlRender($str);
        $this -> email_body = $m -> htmlRender($str);
        $this -> email_to = $email;
        $this -> email_to_name = $name;
        $this -> email_subject = "OSG Marketing: Account Activated";
        return $this;
    }

    function onResetPassword($name, $email, $password){
        $m = new Mail_Template();
        $m -> setParam("first_name", $name);
        $m -> setParam("email_id", $email);
        $m -> setParam("pass", $password);

        $text = "Dear {first_name}<br />You have asked for password Reset. Here is your login details: <br />Email: {email_id} <br />Password: {pass}<br /><br />Thanks<br />OSG Marketing";

        $this -> email_body = $m -> htmlRender($text);
        $this -> email_to = $email;
        $this -> email_to_name = $name;
        $this -> email_subject = "OSG Marketing: Reset Password";
        return $this;
    }

    function onSuccessResetPassword($name, $email){
        $m = new Mail_Template();
        $m -> setParam("first_name", $name);
        $m -> setParam("email_id", $email);
        $text = "Dear {first_name}<br />Your password has been changed successfully. <br /><br />Thanks<br />OSG Marketing";
        $this -> email_body = $m -> htmlRender($text);
        $this -> email_to = $email;
        $this -> email_to_name = $name;
        $this -> email_subject = "OSG Marketing: Password Changed Successfully";
        return $this;
    }

    function onUpdateTracking($name, $email, $tracking, $track_url){
        $m = new Mail_Template();
        $m -> setParam("first_name", $name);
        $m -> setParam("email_id", $email);
        $str = "Dear {first_name}<br />Congratulation!! Your order has been shipped. Your order tracking id is ".$tracking. "<br /><a href='".$track_url."'>Click here</a> to track order<br/>Thanks<br />OSG Marketing";

        $this -> email_body = $m -> htmlRender($str);
        $this -> email_body = $m -> htmlRender($str);
        $this -> email_to = $email;
        $this -> email_to_name = $name;
        $this -> email_subject = "OSG Marketing: Order Tracking";
        return $this;
    }

    function onConfirmOrder($name, $email, $order_no){
        $m = new Mail_Template();
        $m -> setParam("first_name", $name);
        $m -> setParam("email_id", $email);
        $str = "Dear {first_name}<br />Congratulation!! Your order has been received. <br />Your order no. is ".$order_no. "<br />Thanks<br />OSG Marketing";

        $this -> email_body = $m -> htmlRender($str);
        $this -> email_body = $m -> htmlRender($str);
        $this -> email_to = $email;
        $this -> email_to_name = $name;
        $this -> email_subject = "OSG Marketing: Order Tracking";
        return $this;
    }

    function onFailedOrder($name, $email, $order_no){
        $m = new Mail_Template();
        $m -> setParam("first_name", $name);
        $m -> setParam("email_id", $email);
        $str = "Dear {first_name}<br />Sorry!! Your Payment was been Failed. Your order no. is ".$order_no. "<br/>If any query please send your query.<br />Thanks<br />OSG Marketing";

        $this -> email_body = $m -> htmlRender($str);
        $this -> email_body = $m -> htmlRender($str);
        $this -> email_to = $email;
        $this -> email_to_name = $name;
        $this -> email_subject = "OSG Marketing: Order Tracking";
        return $this;
    }
}

class Mail_Template {

    var $arr;

    public function  __construct(){
        $this -> arr = array();
    }

    public function setParam($name, $value){
        $this -> arr[$name] = $value;
    }

    public function htmlRender($template){
        if(is_array($this -> arr) && count($this -> arr) > 0){
            foreach($this -> arr as $key => $val){
                $template = str_replace('{'.$key.'}', $val, $template);
            }
        }
        return $template;
    }

    function __destruct(){
        $this -> arr = array();
    }
}
