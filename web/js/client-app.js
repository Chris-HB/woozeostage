
var client = new Faye.Client('http://localhost:3000/');

client.subscribe('/messages', function(message) {
    alert('Nouveau message : ' + message.text);
});


