<?php

class FirebaseLib
{
    private static $url = 'https://fcm.googleapis.com/fcm/send';

    private static function key()
    {
        return 'AAAAHU07uD8:APA91bESqsuc1frZ0v0T0Q67D6y6Zk0CNMj5TtHjseWoG0cOBPpdGxAS7mm8YMKCpGzij7xbTFnDPXg--Wg1vuY6elOLoufpZu5hnojBIqHtPPt_Y2ITKBqCf_5W19cgVKdY81zB6DaY';
    }

    public static function notif($title = '', $text = '', $to = [], $click_action = '', $extends_data = [], $sound = '', $priority = 'high')
    {
        if ($sound === '') {
            $sound = 'content://settings/system/notification_sound';
        }

        $key = self::key();
        if ($to !== '') {
            // set the headers
            $list_header[] = 'Content-Type:application/json';
            $list_header[] = 'Authorization:key=' . $key;

            // default parameter for firebase
            $parameter['notification']['title']        = $title;
            $parameter['notification']['body']         = $text;
            $parameter['notification']['click_action'] = $click_action;
            $parameter['notification']['sound']        = $sound;
            // $parameter['to'] = $to;
               $parameter['registration_ids'] = $to;
            $parameter['priority']            = $priority;

            // if using some data to notif
            if (! empty($extends_data)) {
                for ($i = 0; $i < count($extends_data); $i++) {
                    $parameter['data'] = $extends_data[$i];
                }
            }

            // send notif
            $send = self::curl_request(self::$url, $parameter, $list_header);

            // decode hasil json
            $hasil   = json_decode($send, true);
            $success = isset($hasil['success']) ? $hasil['success'] : 0;
            $failure = isset($hasil['failure']) ? $hasil['failure'] : 0;

            $result = ($failure === 1) ? false : true;

            return $result;
        } else {
            return false;
        }
    }

    // curl request to firebase
    private static function curl_request($url = '', $parameter = '', $header = '')
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
                              CURLOPT_URL            => $url,
                              CURLOPT_SSL_VERIFYPEER => false,
                              CURLOPT_RETURNTRANSFER => true,
                              CURLOPT_ENCODING       => '',
                              CURLOPT_MAXREDIRS      => 10,
                              CURLOPT_TIMEOUT        => 10000,
                              CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                              CURLOPT_CUSTOMREQUEST  => 'POST',
                              CURLOPT_POSTFIELDS     => json_encode($parameter),
                              CURLOPT_HTTPHEADER     => $header,
                              CURLOPT_FRESH_CONNECT  => true,
                          ]);

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);
        if ($err) {
            $response = ($err);
        } else {
            $response;
        }

        return $response;
    }
}
