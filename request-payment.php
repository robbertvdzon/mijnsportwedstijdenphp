<?
namespace payment;

function buyedMonth( $userID, $paymentResult ) {
    logPayment( $userID , "payment result", $paymentResult);
    return \dbcalls\addPayment($userID,"P1M");
}

function buyedYear( $userID, $paymentResult ) {
    logPayment( $userID , "payment result", $paymentResult);
    return \dbcalls\addPayment($userID,"P1Y");
}

function logPayment( $userID , $action, $actionResult) {
    return \dbcalls\logPayment($userID, $actionResult,$action);
}


?>