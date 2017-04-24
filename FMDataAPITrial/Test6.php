<?php
/**
 * Created by PhpStorm.
 * User: msyk
 * Date: 2017/04/10
 * Time: 18:42
 */
include_once "lib.php";

$host = targetHost();

// Authentication
$result = callAPI(
    "https://{$host}/fmi/rest/api/auth/TestDB",
    null,
    json_encode(array(
            "user" => "web",
            "password" => "password",
            "layout" => "person_layout",)
    ),
    "POST");
$responseJSON = resultOutput($result);

// Query
if ($responseJSON->errorCode != 0) {
    echo "Authentication Error: {$responseJSON->errorCode}";
} else {
    $result = callAPI(
        "https://{$host}/fmi/rest/api/find/TestDB/postalcode",
        array("FM-Data-token: {$responseJSON->token}"),
        json_encode(array(
            "query" => array(
                array("f8"=>"中野*"),
            ),
            "sort" => array(
                array("fieldName" => "f3", "sortOrder" => "descend"),
                array("fieldName" => "id", "sortOrder" => "ascend"),
            ),
        )),
        "POST");
    resultOutput($result);
}