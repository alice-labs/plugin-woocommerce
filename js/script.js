// Alice Customer ID
var promise = new Promise(function (resolve, reject) {
    var interval = setInterval(function () {
        if (myaliceai.is_needed_migration) {
            var aliceDataString = localStorage.getItem("persist:inconnect:webchat:sdk"),
                aliceDataObj;

            if (aliceDataString !== null && (aliceDataObj = JSON.parse(aliceDataString))) {
                var aliceDataChatBotObj = JSON.parse(aliceDataObj.chatbot);

                if (aliceDataChatBotObj.customerID !== null) {
                    clearInterval(interval);

                    resolve(aliceDataChatBotObj.customerID);
                }
            }
        } else {
            var aliceDataString = localStorage.getItem("persist:myalice:webchat:sdk"),
                aliceDataObj;

            if (aliceDataString !== null && (aliceDataObj = JSON.parse(aliceDataString))) {
                var aliceDataChatBotObj = JSON.parse(aliceDataObj.livechat);

                if (aliceDataChatBotObj.customerId !== null) {
                    clearInterval(interval);

                    resolve(aliceDataChatBotObj.customerId);
                }
            }
        }
    }, 100);
});

promise.then(function (aliceCustomerId) {
    document.cookie = "aliceCustomerId = " + aliceCustomerId + ";path=/;";
});