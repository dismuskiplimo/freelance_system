<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/', ['uses'=>'FrontController@index','as'=>'getHomePage']);

Route::get('order', ['uses'=>'FrontController@order','as'=>'getOrder']);

Route::get('authors', ['uses'=>'FrontController@getWriters','as'=>'getWriters']);

Route::get('author/{slug}/view', ['uses'=>'FrontController@getWriter','as'=>'getGuestWriter']);

Route::get('author/{slug}/reviews', ['uses'=>'FrontController@getWriterReviews','as'=>'getGuestWriterReviews']);

Route::get('recent-orders', ['uses'=>'FrontController@getRecentOrders','as'=>'getRecentOrders']);

Route::get('privacy-policy', ['uses'=>'FrontController@getPrivacyPolicy','as'=>'getPrivacyPolicy']);

Route::get('no-plagiarism-gurantee', ['uses'=>'FrontController@getNoPlagiarism','as'=>'getNoPlagiarism']);

Route::get('faq/students', ['uses'=>'FrontController@getFaqStudent','as'=>'getFaqStudent']);

Route::get('faq/writers', ['uses'=>'FrontController@getFaqWriter','as'=>'getFaqWriter']);

Route::get('terms-and-conditions', ['uses'=>'FrontController@getTerms','as'=>'getTerms']);

Route::get('rules', ['uses'=>'FrontController@getRules','as'=>'getRules']);

Route::get('about', ['uses'=>'FrontController@getAbout','as'=>'getAbout']);

Route::get('writers/search', ['uses'=>'FrontController@getSearchWriter','as'=>'getGuestSearchWriter']);

Route::get('dashboard', ['uses' => 'BackController@index', 'as' => 'getDashboard']);

Route::get('assignment/{id}', ['uses'=>'FrontController@getAssignment', 'as'=>'getPublicAssignment']);

Route::group(['prefix'=>'admin'], function(){
	
	Route::get('/', ['uses' => 'AdminController@index',]);
	Route::get('dashboard', ['uses' => 'AdminController@index', 'as' => 'getAdminDashboard']);
	
	Route::get('writers/{type}', ['uses' => 'AdminController@getWriters', 'as' => 'getAdminWriters']);
		
	Route::get('clients/{type}', ['uses' => 'AdminController@getClients', 'as' => 'getAdminClients']);
		
	Route::get('withdrawal-requests/{type}', ['uses' => 'AdminController@getWithdrawalRequests', 'as' => 'getAdminWithdrawalRequests']);
		
	Route::get('assignments/{type}', ['uses' => 'AdminController@getAssignments', 'as' => 'getAdminAssignments']);
	
	Route::get('assignment/{id}/view', ['uses' => 'AdminController@getAssignment', 'as' => 'getAdminAssignment']);
	
	Route::post('bid/{id}/comment', ['uses' => 'AdminController@postComment', 'as' => 'postAdminComment']);

	
	Route::get('user/{id}/view', ['uses' => 'AdminController@getUser', 'as' => 'getAdminUser']);
	Route::patch('user/{id}/update', ['uses' => 'AdminController@postUpdateUser', 'as' => 'postAdminUserUpdate']);
	Route::post('user/{id}/activate', ['uses' => 'AdminController@activateUser', 'as' => 'postActivateUser']);
	Route::post('user/{id}/deactivate', ['uses' => 'AdminController@deactivateUser', 'as' => 'postDeactivateUser']);

	Route::get('disciplines', ['uses' => 'AdminController@getDisciplines', 'as' => 'getAdminDisciplines']);
	Route::post('disciplines', ['uses' => 'AdminController@postDisciplines', 'as' => 'postAdminDisciplines']);
	Route::patch('disciplines/{id}/update', ['uses' => 'AdminController@updateDisciplines', 'as' => 'updateAdminDisciplines']);
	Route::delete('disciplines/{id}/delete', ['uses' => 'AdminController@deleteDisciplines', 'as' => 'deleteAdminDisciplines']);

	Route::get('subjects', ['uses' => 'AdminController@getSubjects', 'as' => 'getAdminSubjects']);
	Route::post('subjects', ['uses' => 'AdminController@postSubjects', 'as' => 'postAdminSubjects']);
	Route::patch('subjects/{id}/update', ['uses' => 'AdminController@updateSubjects', 'as' => 'updateAdminSubjects']);
	Route::delete('subjects/{id}/delete', ['uses' => 'AdminController@deleteSubjects', 'as' => 'deleteAdminSubjects']);


	Route::get('assignment-types', ['uses' => 'AdminController@getAssignmentTypes', 'as' => 'getAdminAssignmentTypes']);
	Route::post('assignment-types', ['uses' => 'AdminController@postAssignmentTypes', 'as' => 'postAdminAssignmentTypes']);
	Route::patch('assignment-types/{id}/update', ['uses' => 'AdminController@updateAssignmentTypes', 'as' => 'updateAdminAssignmentTypes']);
	Route::delete('assignment-types/{id}/delete', ['uses' => 'AdminController@deleteAssignmentTypes', 'as' => 'deleteAdminAssignmentTypes']);

	Route::get('languages', ['uses' => 'AdminController@getLanguages', 'as' => 'getAdminLanguages']);
	Route::post('languages', ['uses' => 'AdminController@postLanguages', 'as' => 'postAdminLanguages']);
	Route::patch('languages/{id}/update', ['uses' => 'AdminController@updateLanguages', 'as' => 'updateAdminLanguages']);
	Route::delete('languages/{id}/delete', ['uses' => 'AdminController@deleteLanguages', 'as' => 'deleteAdminLanguages']);


	Route::post('withdrawal-request/{id}/approve', ['uses' => 'AdminController@postApproveWithdrawalRequest', 'as' => 'postApproveWithdrawalRequest']);
	Route::post('withdrawal-request/{id}/reject', ['uses' => 'AdminController@postRejectWithdrawalRequest', 'as' => 'postRejectWithdrawalRequest']);
	
	Route::get('transactions/{type}/{amount}', ['uses' => 'AdminController@getTransactions', 'as' => 'getAdminTransactions']);
	
	Route::get('settings', ['uses' => 'AdminController@getSettings', 'as' => 'getAdminSettings']);
	Route::post('settings/contact-info', ['uses' => 'AdminController@postSiteContactInfo', 'as' => 'postSiteContactInfo']);
	Route::post('settings/prefferences', ['uses' => 'AdminController@postSitePrefferences', 'as' => 'postSitePrefferences']);
	
	
	Route::get('profile', ['uses' => 'AdminController@getProfile', 'as' => 'getAdminProfile']);
	Route::post('profile/picture/update', ['uses' => 'PicturesController@updateProfilePicture', 'as' => 'postAdminUpdateProfilePicture']);
	Route::patch('profile/details/update', ['uses' => 'AdminController@postAdminProfile', 'as' => 'postAdminProfile']);
	Route::patch('profile/password/update', ['uses' => 'AdminController@postUpdatePassword', 'as' => 'postAdminUpdatePassword']);
});

Route::group(['prefix'=>'client'], function(){
	Route::get('/', ['uses' => 'ClientController@index']);
	Route::get('dashboard', ['uses' => 'ClientController@index', 'as' => 'getClientDashboard']);
	Route::get('orders', ['uses' => 'ClientController@getClientOrders', 'as' => 'getClientOrders']);
	Route::get('ratings', ['uses' => 'ClientController@getMyClientRatings', 'as' => 'getMyClientRatings']);
	Route::get('order/create', ['uses' => 'ClientController@getCreateOrder', 'as' => 'getClientCreateOrder']);
	Route::post('order/create', ['uses' => 'ClientController@postCreateOrder', 'as' => 'postClientCreateOrder']);
	Route::post('order/mark/complete/{id}', ['uses' => 'ClientController@postMarkComplete', 'as' => 'postMarkComplete']);
	Route::post('order/deadline/{id}/update', ['uses' => 'ClientController@postUpdateDeadline', 'as' => 'postUpdateDeadline']);
	Route::get('order/view/{id}', ['uses' => 'ClientController@getOrder', 'as' => 'getSingleClientOrder']);
	Route::get('balance', ['uses' => 'ClientController@getBalance', 'as' => 'getClientBalance']);
	Route::get('withdraw', ['uses' => 'ClientController@getWithdraw', 'as' => 'getClientWithdraw']);
	Route::post('withdraw', ['uses' => 'ClientController@postWithdrawRequest', 'as' => 'postClientWithdrawRequest']);
	
	Route::get('order/review/assignment/{assignment_id}/writer/{writer_id}', ['uses' => 'ClientController@getCreateReview', 'as' => 'getCreateReview']);
	Route::post('order/review/assignment/{assignment_id}/writer/{writer_id}', ['uses' => 'ClientController@postCreateReview', 'as' => 'postCreateReview']);
	
	Route::post('add-funds', ['uses' => 'ClientController@postAddFunds', 'as' => 'postClientAddFunds']);
	Route::get('verify-payment', ['uses' => 'ClientController@getVerifyPayment', 'as' => 'getClientVerifyPayment']);
	Route::post('paypal/account/update', ['uses' => 'ClientController@postUpdatePaypal', 'as' => 'postClientUpdatePaypal']);
	Route::post('bid/{id}/comment', ['uses' => 'ClientController@postComment', 'as' => 'postClientComment']);

	Route::get('profile', ['uses' => 'ClientController@getProfile', 'as' => 'getClientProfile']);
	Route::post('profile/picture/update', ['uses' => 'PicturesController@updateProfilePicture', 'as' => 'postClientUpdateProfilePicture']);
	Route::post('profile/info/update', ['uses' => 'ClientController@postClientInfo', 'as' => 'postClientInfo']);
	Route::post('profile/education/update', ['uses' => 'ClientController@postEducation', 'as' => 'postClientEducation']);
	Route::post('profile/contact/update', ['uses' => 'ClientController@postClientContacts', 'as' => 'postClientContacts']);
	Route::post('profile/password/update', ['uses' => 'ClientController@postUpdatePassword', 'as' => 'postClientUpdatePassword']);
	
	Route::get('notifications', ['uses' => 'ClientController@getNotifications', 'as' => 'getClientNotifications']);
	Route::get('notification/{id}', ['uses' => 'ClientController@getNotification', 'as' => 'getClientNotification']);
	
	Route::post('messages/create/{id}', ['uses' => 'ClientController@postMessage', 'as' => 'postClientMessage']);
	Route::get('messages/conversations', ['uses' => 'ClientController@getConversations', 'as' => 'getClientConversations']);
	Route::get('messages/conversation/{id}', ['uses' => 'ClientController@getConversation', 'as' => 'getClientConversation']);
	
	Route::post('hire_writer/{id}', ['uses' => 'ClientController@postHireWriter', 'as' => 'postHireWriter']);
	
	Route::post('attachment/{id}/create', ['uses' => 'ClientController@postAddAttachment', 'as' => 'postAddAttachment']);
	Route::delete('attachment/{id}/delete', ['uses' => 'ClientController@destroyAttachment', 'as' => 'destroyAttachment']);

	Route::get('search', ['uses' => 'ClientController@getSearchWriter', 'as' => 'getSearchWriter']);
	Route::get('writers', ['uses' => 'ClientController@getWriters', 'as' => 'getClientWriters']);
	Route::get('writer/{slug}/view', ['uses' => 'ClientController@getWriter', 'as' => 'getClientWriter']);
	Route::get('writer/{slug}/reviews', ['uses' => 'ClientController@getReviews', 'as' => 'getClientReviews']);
	Route::get('writer/{slug}/assignments', ['uses' => 'ClientController@getAssignments', 'as' => 'getClientAssignments']);
});

Route::group(['prefix'=>'writer'], function(){
	Route::get('/', ['uses' => 'WriterController@index']);
	Route::get('dashboard', ['uses' => 'WriterController@index', 'as' => 'getWriterDashboard']);
	Route::get('search', ['uses' => 'WriterController@getOrderSearch', 'as' => 'getOrderSearch']);
	Route::get('search/filter', ['uses' => 'WriterController@getOrderSearchFilter', 'as' => 'getOrderSearchFilter']);
	
	Route::get('orders', ['uses' => 'WriterController@getOrders', 'as' => 'getWriterOrders']);
	Route::get('order/view/{id}', ['uses' => 'WriterController@viewOrder', 'as' => 'getSingleWriterOrder']);
	Route::post('order/bid/{id}', ['uses' => 'WriterController@postBid', 'as' => 'postBid']);
	
	Route::post('bid/{id}/comment', ['uses' => 'WriterController@postComment', 'as' => 'postWriterComment']);
	
	Route::get('balance', ['uses' => 'WriterController@getBalance', 'as' => 'getWriterBalance']);
	Route::post('balance/withdraw', ['uses' => 'WriterController@postWithdrawRequest', 'as' => 'postWriterWithdrawRequest']);
	Route::post('paypal/account/update', ['uses' => 'WriterController@postUpdatePaypal', 'as' => 'postWriterUpdatePaypal']);

	Route::get('settings', ['uses' => 'WriterController@getSettings', 'as' => 'getWriterSettings']);
	
	Route::get('profile', ['uses' => 'WriterController@getProfile', 'as' => 'getWriterProfile']);
	Route::post('profile/picture/update', ['uses' => 'PicturesController@updateProfilePicture', 'as' => 'postWriterUpdateProfilePicture']);
	Route::post('profile/about/update', ['uses' => 'WriterController@postAbout', 'as' => 'postWriterAbout']);
	Route::post('profile/education/update', ['uses' => 'WriterController@postEducation', 'as' => 'postWriterEducation']);
	Route::post('profile/private/update', ['uses' => 'WriterController@postPrivateInfo', 'as' => 'postWriterPrivateDetails']);
	Route::post('profile/dob/update', ['uses' => 'WriterController@postDOB', 'as' => 'postWriterDOBInfo']);
	Route::post('profile/contact/update', ['uses' => 'WriterController@postContactInfo', 'as' => 'postWriterContactInfo']);
	Route::post('profile/password/update', ['uses' => 'WriterController@postUpdatePassword', 'as' => 'postUpdateWriterPassword']);
	
	Route::post('profile/language', ['uses' => 'WriterController@postLanguage', 'as' => 'postWriterLanguage']);
	Route::get('profile/language/{id}/delete', ['uses' => 'WriterController@deleteLanguage', 'as' => 'postWriterDeleteLanguage']);
	
	Route::post('profile/assignment-type', ['uses' => 'WriterController@postAssignmentType', 'as' => 'postWriterAssignmentType']);
	Route::get('profile/assignment-type/{id}/delete', ['uses' => 'WriterController@deleteAssignmentType', 'as' => 'postWriterDeleteAssignmentType']);
	
	Route::post('profile/discipline', ['uses' => 'WriterController@postDiscipline', 'as' => 'postWriterDiscipline']);
	Route::get('profile/discipline/{id}/delete', ['uses' => 'WriterController@deleteDiscipline', 'as' => 'postWriterDeleteDiscipline']);
	

	Route::post('profile/portfolio', ['uses' => 'WriterController@postPortfolio', 'as' => 'postPortfolio']);
	Route::get('profile/portfolio/{id}/delete', ['uses' => 'WriterController@deletePortfolio', 'as' => 'deletePortfolio']);
	
	Route::get('notifications', ['uses' => 'WriterController@getNotifications', 'as' => 'getWriterNotifications']);
	Route::get('notification/{id}', ['uses' => 'WriterController@getNotification', 'as' => 'getWriterNotification']);
	
	Route::post('messages/create/{id}', ['uses' => 'WriterController@postMessage', 'as' => 'postWriterMessage']);
	Route::get('messages/conversations', ['uses' => 'WriterController@getConversations', 'as' => 'getWriterConversations']);
	Route::get('messages/conversation/{id}', ['uses' => 'WriterController@getConversation', 'as' => 'getWriterConversation']);
	
	Route::get('commission', ['uses' => 'WriterController@getCommission', 'as' => 'getWriterCommission']);
	Route::get('blacklist', ['uses' => 'WriterController@getBlacklist', 'as' => 'getWriterBlacklist']);
	
	Route::get('withdraw', ['uses' => 'WriterController@getWithdraw', 'as' => 'getWriterWithdraw']);
	
	Route::get('writer/{slug}/view', ['uses' => 'WriterController@getUserProfile', 'as' => 'getUserProfile']);
	Route::get('writer/{slug}/reviews', ['uses' => 'WriterController@getReviews', 'as' => 'getWriterReviews']);
	Route::get('qualification', ['uses' => 'WriterController@getQualification', 'as' => 'getWriterQualification']);

	Route::post('attachment/{id}/create', ['uses' => 'WriterController@postAddAttachment', 'as' => 'postAddAttachmentWriter']);
	Route::delete('attachment/{id}/delete', ['uses' => 'WriterController@destroyAttachment', 'as' => 'destroyAttachmentWriter']);
});

Route::group(['middleware' => 'auth'], function(){
	Route::get('account-blocked', ['uses' => 'BackController@getBlockedPage', 'as' => 'getBlockedPage','middleware'=>'account_blocked']);
	Route::get('account-inactive', ['uses' => 'BackController@getInactivePage', 'as' => 'getInactivePage','middleware'=>'account_inactive']);
	Route::get('user/lastseen/update', ['uses' => 'BackController@getUpdateLastSeen', 'as' => 'getUpdateLastSeen']);
	
	Route::get('messages/count', ['uses' => 'BackController@getMessages', 'as' => 'getUserMessages']);
	Route::get('messages/conversation/{id}/check', ['uses' => 'BackController@getConversation', 'as' => 'getUserConversation']);
	
	Route::get('notifications/count', ['uses' => 'BackController@getNotifications', 'as' => 'getUserNotifications']);
	

	Route::get('downloads/download/{id}', ['uses' => 'BackController@download', 'as' => 'getDownload']);
	Route::get('downloads/portfolio/{id}', ['uses' => 'BackController@downloadPortfolio', 'as' => 'getPortfolio']);
});

