<?php

    require __DIR__ . '/vendor/autoload.php';

    class ultramsg{

        public static function send_whatsapp($dataMessage){
            $dataUltramsg = parse_ini_file(UTILS . 'ultramsg.ini');
            $ultramsg_token = $dataUltramsg['ULTRAMSG_TOKEN'];
            $instance_id = $dataUltramsg['ULTRAMSG_INSTANCE_ID'];
            $client = new Ultramsg\WhatsAppApi($ultramsg_token,$instance_id);

            $tipo = $dataMessage['tipo'];
            $otp = $dataMessage['otp'];
            $tlf = $dataMessage['tlf'];
            // echo json_encode('hola ultramsg');
            // exit;

            try {
                switch($tipo){
                    case 'otp':
                        $to = $tlf;
                        $body = "Tu código OTP para iniciar sesión es:\n" . $otp;
                        $api = $client->sendChatMessage($to, $body);
                        break;
                }
                return 'whatsapp_send';
            } catch (\Exception $e) {
                // Puedes loguear el error o devolverlo para debug
                return 'error: ' . $e->getMessage();
            }
        }

    } // ultramsg

?>