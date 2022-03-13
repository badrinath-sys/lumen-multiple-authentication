//Authentication Api's
 
$router->group(['prefix' => 'user'], function ($router) {
    $router->post('login', 'UserController@login');
});

$router->group(['prefix' => 'admin'], function ($router) {
    $router->post('login', 'AdminController@login');


//Api to get all the users in database

    $router->group(['prefix' => 'users', 'middleware' => 'auth'], function ($router) {
        $router->get('', 'UserController@all');
    });
    
//Api to see user profile

$router->group(['prefix' => 'user', 'middleware' => 'auth'], function ($router) {
    $router->get('profile', 'UserController@profile');

});


  
  
  //Api for register user and admin
    
      
$router->group(['prefix' => 'user'], function ($router) {
    $router->post('register', 'UserController@register');
});

$router->group(['prefix' => 'admin'], function ($router) {
    $router->post('register', 'AdminController@register');
});

