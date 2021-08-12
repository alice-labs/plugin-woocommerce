// Alice Customer ID
let aliceDataString = localStorage.getItem("persist:inconnect:webchat:sdk");
let aliceDataObj = JSON.parse(aliceDataString);
let aliceDataChatBotObj = JSON.parse(aliceDataObj.chatbot);
let aliceCustomerId = aliceDataChatBotObj.customerID;
document.cookie = "aliceCustomerId = " + aliceCustomerId + ";path=/;";