<?php
    class mail {
        public static function send_email($email) {
            echo 'hola send_email';
            exit;
            switch ($email['type']) {
                case 'contact';
                    $email['toEmail'] = '13salmu@gmail.com';
                    $email['fromEmail'] = 'secondchanceonti@gmail.com';
                    $email['inputEmail'] = 'secondchanceonti@gmail.com';
                    $email['inputMatter'] = 'Email verification';
                    $email['inputMessage'] = "<h2>Email verification.</h2><a href='http://localhost/Ejercicios/Framework_PHP_OO_MVC/index.php?module=contact&op=view'>Click here for verify your email.</a>";
                    break;
                case 'validate';
                    $email['fromEmail'] = 'secondchanceonti@gmail.com';
                    $email['inputEmail'] = 'secondchanceonti@gmail.com';
                    $email['inputMatter'] = 'Email verification';
                    $email['inputMessage'] = "<h2>Email verification.</h2><a href='http://localhost/Ejercicios/Framework_PHP_OO_MVC/module/login/verify/$email[token]'>Click here for verify your email.</a>";
                    break;
                case 'recover';
                    $email['fromEmail'] = 'secondchanceonti@gmail.com';
                    $email['inputEmail'] = 'secondchanceonti@gmail.com';
                    $email['inputMatter'] = 'Recover password';
                    $email['inputMessage'] = "<a href='http://localhost/Ejercicios/Framework_PHP_OO_MVC/module/login/recover/$email[token]'>Click here for recover your password.</a>";
                    break;
            }
            return self::resend_mail($email);
        }

        public static function resend_mail($values){
            echo 'hola resend_mail';
            exit;
        }
    }