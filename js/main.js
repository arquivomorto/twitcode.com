// gráfico de contribuições
function getRandomTimeStamps(min, max, fromDate, isObject) {
    var return_list = [];

    var entries = randomInt(min, max);
    for (var i = 0; i < entries; i++) {
        var day = fromDate ? new Date(fromDate.getTime()) : new Date();

        //Genrate random
        var previous_date = randomInt(0, 365);
        if (!fromDate) {
            previous_date = -previous_date;
        }
        day.setDate(day.getDate() + previous_date);

        if (isObject) {
            var count = randomInt(1, 20);
            return_list.push({
                timestamp: day.getTime(),
                count: count
            });
        } else {
            return_list.push(day.getTime());
        }


    }

    return return_list;
}

function randomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}

// caixa de criação de mensagens

function messageCloseDialog() {
    var dialogMessage = $('#dialogMessage');
    dialogMessage.prop('open', false);
}

function messageOpenDialog() {
    var dialogMessage = $('#dialogMessage');
    dialogMessage.prop('open', true);
}

function messagePrepend(msgObject) {

}

function messageSend() {
    messageCloseDialog();
    var msg = $('#message').val();
    $('#message').val('');
    alert(msg);
}