<?php

namespace Ci4Common\Libraries;

class ZensivaLib
{
    public static function sendSms($no, $kode)
    {
         $userkey    = 'dc85ab108a7c';
         $passkey    = '5s3qrrnyg5';
         $telepon    = $no;
         $otp        = $kode;
         $url        = 'https://gsm.zenziva.net/api/sendOTP/';
         $curlHandle = curl_init();
         curl_setopt($curlHandle, CURLOPT_URL, $url);
         curl_setopt($curlHandle, CURLOPT_HEADER, 0);
         curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
         curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
         curl_setopt($curlHandle, CURLOPT_POST, 1);
         curl_setopt($curlHandle, CURLOPT_POSTFIELDS, [
                         'userkey'  => $userkey,
                         'passkey'  => $passkey,
                         'nohp'     => $telepon,
                         'kode_otp' => $otp,
                     ]);
         $results = json_decode(curl_exec($curlHandle), true);
         curl_close($curlHandle);
    }
    public static function sendWa($no, $kode)
    {
         $userkey    = 'dc85ab108a7c';
         $passkey    = '5s3qrrnyg5';
         $telepon    = $no;
         $message    = 'Pendaftaran akun Teman Mart. Kode OTP anda : ' . $kode;
         $url        = 'https://gsm.zenziva.net/api/sendWA/';
         $curlHandle = curl_init();
         curl_setopt($curlHandle, CURLOPT_URL, $url);
         curl_setopt($curlHandle, CURLOPT_HEADER, 0);
         curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
         curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
         curl_setopt($curlHandle, CURLOPT_POST, 1);
         curl_setopt($curlHandle, CURLOPT_POSTFIELDS, [
                         'userkey' => $userkey,
                         'passkey' => $passkey,
                         'nohp'    => $telepon,
                         'pesan'   => $message,
                     ]);
         $results = json_decode(curl_exec($curlHandle), true);
         curl_close($curlHandle);
    }
}
