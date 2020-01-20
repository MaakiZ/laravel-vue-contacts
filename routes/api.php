<?php

// Routes prefix, version API
$this->group(['prefix' => 'v1'], function() {

    // Rota de autenticação
    $this->post('auth', 'Auth\ApiLoginController@authenticate');

    // Atualização do TOKEN
    $this->post('auth-refresh', 'Auth\ApiLoginController@refreshToken');

    // Rotas autenticadas por token JWT
    $this->group(['middleware' => 'auth:api'], function () {
        // Retorna o usuário autenticado pelo token
        $this->get('me', 'Auth\ApiLoginController@getAuthenticatedUser');

        
        // API Contacts
	    $this->apiResource('contacts', 'Api\v1\ContactController');
    });
   
});