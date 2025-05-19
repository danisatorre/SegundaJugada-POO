<?php

    require __DIR__ . '/vendor/autoload.php';

    class mail {
        public static function send_email($dataEmail) {
            // echo 'hola send_email';
            // exit;
            $getResendAK = parse_ini_file(UTILS . 'resend.ini');
            $resendAPIKEY = $getResendAK['RESEND_APIKEY'];
            $resend = Resend::client($resendAPIKEY);

            $tipo = $dataEmail['tipo'];
            $email = $dataEmail['email'];
            $username = $dataEmail['username'];
            
            switch ($tipo) {
                case 'welcome';
                    try {
                        $sendEmail = $resend->emails->send([
                            'from' => 'SegundaJugada <onboarding@resend.dev>',
                            'to' => ['danisatorrecucart@gmail.com'],
                            'subject' => 'Bienvenido a SegundaJugada',
                            'html' => '
                                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #eaeaea; border-radius: 10px; overflow: hidden;">
                                    <div style="background-color: #f5f5f5; padding: 20px; text-align: center;">
                                        <img src="https://i.imgur.com/BEsqPIV.png" alt="logo" style="max-width: 150px; margin-bottom: 10px;">
                                        <h2 style="color: #333;">¡Bienvenido a SegundaJugada, ' . $username . '!</h2>
                                    </div>
                                    <div style="padding: 20px; color: #444;">
                                        <p>Gracias por registrarte con el correo <strong>' . $email . '</strong>.</p>
                                        <p>En SegundaJugada te ayudamos a darle una nueva oportunidad a tus objetos favoritos. 🎯</p>
                                        <p>Ya puedes empezar a explorar, comprar, vender o seguir tus productos favoritos. ¡La cancha te espera!</p>
                                        <div style="text-align: center; margin: 30px 0;">
                                            <a href="http://localhost/SegundaJugada-POO/" style="background-color:goldenrod; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                                                Explorar SegundaJugada
                                            </a>
                                        </div>
                                    </div>
                                    <div style="background-color: #f0f0f0; padding: 15px; text-align: center; font-size: 12px; color: #999;">
                                        SegundaJugada © ' . date("Y") . ' | <a href="http://localhost/SegundaJugada-POO/" style="color: #999;">www.segundajugada.com</a>
                                    </div>
                                </div>
                            ',
                        ]);
                    } catch (\Exception $e) {
                        exit('Error: ' . $e->getMessage());
                    }
                break;
                case 'validate';
                    try {
                        $sendEmail = $resend->emails->send([
                            'from' => 'Acme <onboarding@resend.dev>',
                            'to' => ['danisatorrecucart@gmail.com'],
                            'subject' => 'Hello world',
                            'html' => '<strong>Hola ;)</strong>',
                        ]);
                    } catch (\Exception $e) {
                        exit('Error: ' . $e->getMessage());
                    }
                break;
                case 'recover';
                    // $email['fromEmail'] = 'secondchanceonti@gmail.com';
                    // $email['inputEmail'] = 'secondchanceonti@gmail.com';
                    // $email['inputMatter'] = 'Recover password';
                    // $email['inputMessage'] = "<a href='http://localhost/Ejercicios/Framework_PHP_OO_MVC/module/login/recover/$email[token]'>Click here for recover your password.</a>";
                break;
            }
            // return self::resend_mail($email);
        }

        

        public static function resend_mail($values){
            echo 'hola resend_mail';
            exit;
        }
    }