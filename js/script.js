// Alice Customer ID
var promise = new Promise(function (resolve, reject) {
    var interval = setInterval(function () {
        var aliceDataString = localStorage.getItem("persist:myalice:webchat:sdk"),
            aliceDataObj;

        if (aliceDataString !== null && (aliceDataObj = JSON.parse(aliceDataString))) {
            var aliceDataChatBotObj = JSON.parse(aliceDataObj.livechat);

            if (aliceDataChatBotObj.customerId !== null) {
                clearInterval(interval);

                resolve(aliceDataChatBotObj.customerId);
            }
        }
    }, 100);
});

promise.then(function (aliceCustomerId) {
    document.cookie = "aliceCustomerId = " + aliceCustomerId + ";path=/;";
});