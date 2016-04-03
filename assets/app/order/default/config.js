requirejs.config({
    baseUrl: '/assets/app',
    paths: {
        jquery: 'http://lib.sinaapp.com/js/jquery/1.10.2/jquery-1.10.2.min',
        bootstrap: 'http://lib.sinaapp.com/js/bootstrap/v3.0.0/js/bootstrap.min',
        create: 'order/default/create'
    }
});

requirejs(['jquery', 'bootstrap'], function($, bootstrap){

});