﻿(function () {
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
            loadProfessions();
            loadAreas();
        }

        vm.loadToCallCandidates = loadToCallCandidates;

        function loadProfessions(){
            vm.search = false;
            CandidateService.GetAllProfession()
                .then(function (response) {
                    vm.professions = response.professions;
                    console.log(vm.professions.name);
                });

        }

        function loadAreas(){
            vm.search = false;
            CandidateService.GetAllArea()
                .then(function (response) {
                    vm.areas = response.areas;
                    console.log(vm.areas.area);
                });

        }

        function loadToCallCandidates(){
            vm.search = false;
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
/*

        vm.dtOptions = DTOptionsBuilder.newOptions()
            .withPaginationType('full_numbers')
            .withDisplayLength(2)
            .withDOM('pitrfl')
            .withOption('order', [, ]);
*/


        vm.loadMobile = function (index){
            console.log("load by mobile called",index,vm.toCallCandidates[index]);
            vm.toCallCandidates[index].mobile = parseInt(vm.toCallCandidates[index].mobile);
            vm.toCallCandidates[index].age = parseInt(vm.toCallCandidates[index].age);
            vm.user = vm.toCallCandidates[index];

        }

        vm.searchWorker = function () {
            console.log("searching Worker function");
            vm.dataLoading = true;

                CandidateService.Search(vm.userSearch)
                    .then(function (response) {
                        console.log("safa",response);
                        if (response.candidates) {
                            vm.dataLoading = false;
                            vm.user = null;
                            vm.toCallCandidates = response.candidates;
                        } else {
                            FlashService.Error(response.error.text);
                            vm.dataLoading = false;
                        }
                    });

        }

        vm.registerWorker = function registerWorker() {
            console.log("registerWorker function");
            vm.dataLoading = true;
            if(!vm.user.id){
            CandidateService.Create(vm.user)
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
            } else {
                CandidateService.Update(vm.user)
                    .then(function (response) {
                        console.log("safa",response);
                        if (response.status) {
                            FlashService.Success('Updated successful', true);
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
    }

})();