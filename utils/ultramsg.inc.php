<?php

    //require __DIR__ . '/vendor/autoload.php';
    // require_once ('vendor/autoload.php');
    require_once('ultramsg.class.php');

    class ultramsg{

        public static function send_whatsapp($dataMessage){
            // echo json_encode('hola send_whatsapp ultramsg');
            // exit;
            $dataUltramsg = parse_ini_file(UTILS . 'ultramsg.ini');
            // echo json_encode('hola send_whatsapp ultramsg despues de parse ini file');
            // echo json_encode($dataUltramsg);
            // exit;
            $ultramsg_token = $dataUltramsg['ULTRAMSG_TOKEN'];
            // echo json_encode($ultramsg_token);
            // exit;
            $instance_id = $dataUltramsg['ULTRAMSG_INSTANCE_ID'];
            // echo json_encode($instance_id);
            // exit;
            // if (class_exists('Ultramsg\WhatsAppApi')) {
            //     echo json_encode("La clase Ultramsg WhatsAppApi existe");
            //     exit;
            // } else {
            //     echo json_encode("La clase Ultramsg WhatsAppApi no existe");
            //     exit;
            // }
            $client = new Ultramsg\WhatsAppApi($ultramsg_token,$instance_id);
            // echo json_encode('hola send_whatsapp despues de $client');
            // exit;

            $tipo = $dataMessage['tipo'];
            // echo json_encode($tipo);
            // exit;
            $otp = $dataMessage['otp'];
            // echo json_encode($otp);
            // exit;
            $tlf = $dataMessage['tlf'];
            // echo json_encode($tlf);
            // exit;
            // echo json_encode('hola ultramsg');
            // exit;

            try {
                switch($tipo){
                    case 'otp':
                        $to = $tlf;
                        $body = "Tu código OTP para iniciar sesión en SegundaJugada es:\n" . $otp;
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