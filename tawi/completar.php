<?php

require 'vendor/autoload.php';
$SECRET_KEY = "sk_test_lqbbhTfN8UzLSuqg";
$culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));

//var_dump( $_REQUEST );

$charge = $culqi->Charges->create(
        [
            "amount" => $_REQUEST["amount"],
            "capture" => true,
            "currency_code" => $_REQUEST["currency_code"],
            "description" => "La Bonbonniere",
            "email" => $_REQUEST["email"],
            "installments" => 0,
            "antifraud_details" => array(
                "address" => "Av. Lima 123",
                "address_city" => "LIMA",
                "country_code" => "PE",
                "first_name" => "Will",
                "last_name" => "Muro",
                "phone_number" => "9889678986",
            ),
            "source_id" => $_REQUEST["source_id"]
        ]
);
//Respuesta
$result = json_decode(json_encode($charge), true);
$return["estado"] = false;
$return["mensaje"] = $result["outcome"]["user_message"];
$return["titulo"] = $result["outcome"]["merchant_message"];
if ($result["outcome"]["type"] == "venta_exitosa") {
    $return["estado"] = true;
}
//echo "<pre>".print_r($result["outcome"],true)."</pre>";
echo json_encode($return);
?>