<?php
include "RestAPI.php";


//username
$user_name = 'username';
//password.
$password = 'password';
//ContactID.
$ContactID = 'contactID';
//API Endpoint
$url = "https://shipit-wbm-preview01.gls-group.eu:8443/backend/rs/shipments";


try {

        $newRequest= New RestAPI($user_name,$password);

        $shipment = array(
            "Shipment"=> array(
                "ShipmentReference"=>["32131313131"],
                "ShippingDate"=> "2022-03-01",
                "Product"=>"PARCEL",
                "Consignee"=>array(
                    "ConsigneeID"=>"1234567890",
                    "Address"=>array(
                            "Name1"=>"Tim Test",
                            "Name2"=>"",
                            "Name3"=>"",
                            "CountryCode"=>"DE",
                            "ZIPCode"=>"65760",
                            "City"=>"Testingen",
                            "Street"=>"Testallee",
                            "eMail"=>"tim.test@gls.de",
                            "ContactPerson"=>"Laura Test",
                            "MobilePhoneNumber"=>"004912345678910",
                            "FixedLinePhonenumber"=>"004912345678910"
                    )
                ),
                "Shipper" => array(

                    "ContactID" => $ContactID
                )
                 ,
                "ShipmentUnit" => array(

                    ["Weight" => "5"]
                )
            ),
            'PrintingOptions'=> array(
                "ReturnLabels"=>array(
                    "TemplateSet"=>"NONE","LabelFormat"=>"PDF"
                )

            )
        );

        $newRequest->processShipment($shipment,$url);
        $newRequest->printLabel();

    }
    catch(Exception $e){
       echo  $e ;
    }
