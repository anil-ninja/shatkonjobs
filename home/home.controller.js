(function () {
    'use strict';

    angular
        .module('app')
        .controller('HomeController', HomeController);

    HomeController.$inject = ['UserService',  'CandidateService','$rootScope', 'FlashService'];
    function HomeController(UserService, CandidateService,  $rootScope, FlashService) {
        var vm = this;

        vm.user = null;
        vm.allUsers = [];
        vm.deleteUser = deleteUser;

        initController();

        function initController() {
          //  loadCurrentUser();
           // loadAllUsers();
            loadToCallCandidates();
        }

        function loadToCallCandidates(){
            CandidateService.GetAll()
                .then(function (response) {
                    vm.toCallCandidates = response.candidates;
                    console.log(vm.toCallCandidates[1].name);
                });

        }

        /*function loadCurrentUser() {
            UserService.GetByUsername($rootScope.globals.currentUser.username)
                .then(function (user) {
                    vm.user = user;
                });
        }*/

        function loadAllUsers() {
            UserService.GetAll()
                .then(function (users) {
                    vm.allUsers = users;
                });
        }

        function deleteUser(id) {
            UserService.Delete(id)
            .then(function () {
                loadAllUsers();
            });
        }

        vm.registerWorker = function registerWorker() {
            console.log("registerWorker function");
            vm.dataLoading = true;
            CandidateService.CreateWorker(vm.user)
                .then(function (response) {
                    console.log("safa",response);
                    if (response.candidate) {
                        FlashService.Success('Registration successful', true);
                        vm.dataLoading = false;
                        vm.user = null;
                        loadToCallCandidates();
                        //$location.path('/login');
                    } else {
                        FlashService.Error(response.error.text);
                        vm.dataLoading = false;
                    }
                });
        }
    }

})();