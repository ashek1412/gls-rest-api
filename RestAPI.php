<?php


class RestAPI
{

    public $user_name;
    public $password;
    public $url;
    public $shipment;
    public $response;
    public $headers;


    function __construct( $user, $pass ) {
        $this->user_name = $user;
        $this->password = $pass;



        $this->headers = array
        (
            "Authorization: Basic ". base64_encode("$this->user_name:$this->password"),
            "Accept: application/glsVersion1+json, application/json",
            "Content-type: application/glsVersion1+json",
            "Accept-Encoding: gzip, deflate, br"

        );

    }


    public function processShipment($shipment_data,$shipmenturl) {
        $this->url = $shipmenturl;
        try
        {
            $this->shipment = json_encode($shipment_data);
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $shipmenturl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_SSLVERSION, 6);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            //curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt( $ch,CURLOPT_POSTFIELDS, $this->shipment );
            //curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, true );
            $result = curl_exec($ch);

            $this->response = json_decode($result);
            curl_close($ch);


        }
        catch(Exception $e){
            echo  $e ;
        }
    }


    public function printLabel() {

        try
        {


          $fileName=  "labels/".$this->response->CreatedShipment->ParcelData[0]->TrackID.".pdf";
          $download_name = basename($fileName);
          $pdfData = base64_decode( $this->response->CreatedShipment->PrintData[0]->Data );
          header("Content-Type: application/pdf");
          header("Content-Disposition: attachment; filename=".$download_name);
          file_put_contents($fileName, $pdfData);
          readfile($fileName);

        }
        catch(Exception $e){
            echo  $e ;
        }


    }













}