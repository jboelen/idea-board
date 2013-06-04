
var app = angular.module('ideaboardApp', ['ui.bootstrap'], function($routeProvider, $locationProvider) {

    $routeProvider.
    when('/help', { templateUrl: 'views/page/help.php', controller: HelpCntl }).
    when('/', { templateUrl: 'views/page/list.php',controller: ListCtnl }).
    when('/list', { templateUrl: 'views/page/list.php',controller: ListCtnl }).
    when('/list/:filter', { templateUrl: 'views/page/list.php',controller: ListCtnl }).
    when('/account/:action', {}).
    when('/login', { templateUrl: 'views/page/login.php', controller: LoginCntl }).
    when('/logout', { templateUrl: 'views/page/logout.php', controller: LogoutCntl }).
    when('/discuss/new', { templateUrl: 'views/page/edit.php', controller: NewCntl }).
    when('/discuss/edit/:id', { templateUrl: 'views/page/edit.php', controller: EditCntl }).
    when('/discuss/:id', { templateUrl: 'views/page/discuss.php', controller: DiscussCntl });

    // configure html5 to get links working on jsfiddle
    $locationProvider.html5Mode(true);
});

app.directive("login", function($window, $http){
    return {
        restrict: "E",
        templateUrl: 'views/components/login.php',
        scope:{
        },
        link: function(scope){
            scope.model= {
                email: '',
                    password: ''
            };

            scope.error = {
                title: 'Unable to Sign In!',
                    message: 'The email and password combination you supplied did not have a match.',
                    visible: false
            };

            scope.submit = function(){
                $http.post('/idea/api/authenticate.php', scope.model).
                    success(function(){$window.location.href= document.baseURI+ 'list/new'; }).
                    error(function(){scope.error.visible = true;});
            };
        }
    };
});

app.directive("vote", function(){
    return {
        restrict: "E",
        template: '<span class="btn btn-small {{class}}"><i class="icon-arrow-{{direction}} {{arrowClass}}"></i></span>',
        scope:{
            value:'=',
            itemId: '='
        },
        link: function(scope, element, attrs){
            scope.class = '';
            scope.direction = attrs.direction;


            if (scope.value === 1 && attrs.direction == 'up')
                scope.class='btn-success';
            else if (scope.value === -1 && attrs.direction == 'down')
                scope.class='btn-danger';

            scope.arrowClass = (scope.class !== '' ? 'icon-white' : '');
        }
    }
});

function MainCntl($scope, $route, $routeParams, $location) {
    $scope.$route = $route;
    $scope.$location = $location;
    $scope.$routeParams = $routeParams;
}

function HelpCntl($scope, $routeParams, $location) {
    $scope.name = "HelpCntl";
    $scope.$location = $location;
    $scope.params = $routeParams;
}

function ListCtnl($scope, $routeParams, $http, $location) {
    var url = '/idea/api/list.php' + ($routeParams.filter ? '/' + $routeParams.filter : '' );
    $http.get(url).success(function(data){ $scope.data = data; });
    $scope.name = "ListCtnl";
    $scope.$location = $location;
    $scope.params = $routeParams;
    $scope.delete = function(id){
        var deleteUrl = '/idea/api/discuss.php/' + id;
        $http.delete(deleteUrl).success(function(){
            $http.get(url).success(function(data){
                $scope.data = data;
            });
        });
    }

    $scope.voteUp = function(vote){
        return vote === 1 ? 'btn-success' : '';

    }

    $scope.voteDown = function(vote){
        return vote === -1 ? 'btn-danger' : '';
    }
}

function DiscussCntl($scope, $route, $routeParams, $location, $http) {
    $scope.$route = $route;
    $scope.$location = $location;
    $scope.$routeParams = $routeParams;
    var url = '/idea/api/discuss.php' + ($routeParams.id ? '/' + $routeParams.id : '' );
    $http.get(url).success(function(data){ $scope.data = data; });
}

function NewCntl($scope, $route, $routeParams, $location, $http) {
    $scope.$route = $route;
    $scope.$location = $location;
    $scope.$routeParams = $routeParams;
    $scope.new = true;
    $scope.edit = false;

    $("#title").charCount({
        allowed: 50,
        warning: 10,
        counterText: ''
    });

    $scope.submit = function(){
        var url = '/idea/api/discuss.php';
        $http.post(url,$scope.data).success(function(data){ $location.url(data.uri);});
    };
}

function EditCntl($scope, $route, $routeParams, $location, $http) {
    $scope.$route = $route;
    $scope.$location = $location;
    $scope.$routeParams = $routeParams;
    $scope.new = false;
    $scope.edit = true;

    var url = '/idea/api/discuss.php' + ($routeParams.id ? '/' + $routeParams.id : '' );
    $http.get(url).success(function(data){ $scope.data = data; });

    $("#title").charCount({
        allowed: 50,
        warning: 10,
        counterText: ''
    });

    $scope.submit = function(){
        $http.put(url,$scope.data).success(function(data){ $location.url(data.uri);});
    };
}

function LoginCntl($scope, $location, $routeParams) {
    $scope.name = "LoginCntl";
    $scope.$location = $location;
    $scope.params = $routeParams;
}

function LogoutCntl($scope, $routeParams, $location, $q, $timeout, $window) {
    $scope.name = "LogoutCntl";
    $scope.$location = $location;
    $scope.params = $routeParams;
    var defer = $q.defer();
    defer.promise.then(function(){
        $window.location.href= document.baseURI;
    });

    $timeout(function(){
        defer.resolve();
    }, 3000);

}