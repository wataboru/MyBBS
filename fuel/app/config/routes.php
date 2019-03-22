<?php
return array(
	'_root_'  => 'thread/index',  // The default route
	'_404_'   => 'error/404',    // The main 404 route

        // error
        'error/unknownError'  => 'error/unknownError',

	// Thread
	'thread/create'       => 'thread/create',
	'thread/edit/(:id)'   => 'thread/edit/$1',
	'thread/view/(:id)'   => 'thread/view/$1',
	'thread/delete/(:id)' => 'thread/delete/$1',
	'thread/responseDelete/(:reponseId)' => 'thread/responseDelete/$1',

	// Response
	'response/create/(:threadId)'   => 'response/create/$1',
	'response/edit/(:responseId)'   => 'response/edit/$1',
	'response/delete(:responseId)'  => 'response/delete/$1',

	// User	
        'user/login'      => 'user/login',
        'user/signup'     => 'user/signup',
        'user/edit'       => 'user/edit',
        'user/view/(:id)' => 'user/view/$1',
        'user/delete'     => 'user/delete',
);
