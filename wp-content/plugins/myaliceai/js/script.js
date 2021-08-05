// Alice Customer ID
let aliceDataString = localStorage.getItem("persist:inconnect:webchat:sdk");
let aliceDataObj = JSON.parse(aliceDataString);
let aliceDataChatBotObj = JSON.parse(aliceDataObj.chatbot);
let aliceCustomerId = aliceDataChatBotObj.customerID;
//console.log(XlData);
//console.log(typeof XlData);
console.log(aliceCustomerId);
document.cookie = "aliceCustomerId = " + aliceCustomerId;


;(function ($) {
    $(document).ready(function () {
        // alert('Hello!');


    })
})(jQuery);