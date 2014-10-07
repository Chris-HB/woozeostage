(function() {

    'use strict';

    angular

            .module('demoApp', [])

// initialisation du client et encapsulation dans un service

            .service('FayeClient', function() {
        return new Faye.Client('http://localhost:3000/');
    })

// souscription au channel "/messages"

            .run(function($rootScope, FayeClient) {
        FayeClient.subscribe('/messages', function(message) {
            $rootScope.$broadcast('notification', message);
        });
    })

// utilisation depuis controller

            .controller('DemoCtrl', function($scope) {
        $scope.$on('notification', function(event, message) {
            alert('Nouveau message : ' + message.text);
        });
    })

            ;

})();


