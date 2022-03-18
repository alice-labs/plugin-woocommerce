// Alice Customer ID
var promise = new Promise(function (resolve, reject) {
    var interval = setInterval(function () {
        var aliceDataString = localStorage.getItem("persist:inconnect:webchat:sdk"),
            aliceDataObj;

        if (aliceDataString !== null && (aliceDataObj = JSON.parse(aliceDataString))) {
            var aliceDataChatBotObj = JSON.parse(aliceDataObj.chatbot);

            if (aliceDataChatBotObj.customerID !== null) {
                clearInterval(interval);

                resolve(aliceDataChatBotObj.customerID);
            }
        }
    }, 100);
});

promise.then(function (aliceCustomerId) {
    document.cookie = "aliceCustomerId = " + aliceCustomerId + ";path=/;";
});