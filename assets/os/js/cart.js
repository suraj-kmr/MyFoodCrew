var app = angular.module("osg", []);
app.controller("SiteController", function($scope){
     $scope.myaccount = "My Account";
});
app.controller("CartController", function($scope){

     $scope.addcart = function(){
          console.log("Add to cart");
     }
});
