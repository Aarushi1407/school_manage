<?php


// Route::group(['middleware' => ['preventBackHistory','web']], function() {
	// Route::get('login', 'Auth\LoginController@login')->name('admin.login'); 
	
	Route::get('login', 'Auth\LoginController@loginTemplate')->name('admin.login'); 

	Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout.get');
	Route::get('logout_time', 'Auth\LoginController@logout')->name('admin.logout_time.get');
	Route::get('refreshcaptcha', 'Auth\LoginController@refreshCaptcha')->name('admin.refresh.captcha');
	
	//Login With Pass
	Route::get('loginPassword', 'Auth\LoginController@loginWithPassword')->name('admin.login.with.password');

	//Login With OTP
	Route::get('loginWithOtp', 'Auth\LoginController@loginWithOTP')->name('admin.login.with.otp');
	Route::post('send-otp', 'Auth\LoginController@wop_sendotp')->name('admin.login.wop_sendotp');
	Route::post('loginOTPPost', 'Auth\LoginController@loginOTPPost')->name('login.loginOTPPost');

	//Login With 2FA
	Route::get('loginWith2FA', 'Auth\LoginController@loginWith2FA')->name('admin.login.with.2FA');
	Route::post('send-Otp-2FA', 'Auth\LoginController@sendOtp_2FA')->name('admin.login.sendOtp_2FA');
	Route::post('loginWith2FAPost', 'Auth\LoginController@loginWith2FAPost')->name('login.loginWith2FAPost');


	Route::post('login-post', 'Auth\LoginController@loginPost')->name('login.post');


	Route::get('imageShowPath/{path}', 'Website\WebGalleryController@imageShowPath')->name('admin.common.imageShow.path');



	Route::get('payment/{s_code}', 'OnlinePaymentController@payment')->name('admin.online.payment');
// });

Route::group(['middleware' => ['preventBackHistory','admin','web']], function() {
	Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

	Route::prefix('account')->group(function () {
		//Change Password
		Route::get('change-password', 'AccountController@changePassword')->name('admin.account.change.password');
		Route::post('change-password-store', 'AccountController@changePasswordStore')->name('admin.account.change.password.store');
		//Reset Password
		Route::get('reset-password', 'AccountController@resetPassWord')->name('admin.account.reset.password'); 
		Route::post('reset-password-change', 'AccountController@resetPassWordChange')->name('admin.account.reset.password.change');
		
	});

	//Class create (11)
	Route::group(['prefix' => 'class'], function() {
	    Route::get('ct_list', 'ClassTypeController@index')->name('admin.class.index');
	    Route::get('ct_edit/{id}', 'ClassTypeController@edit')->name('admin.class.edit');
	    Route::post('ct_update/{id}', 'ClassTypeController@update')->name('admin.class.update');
	    Route::get('ct_deleteclass/{id}', 'ClassTypeController@deleteclass')->name('admin.class.deleteclass');
	});

	//Suject Type (12)
	Route::group(['prefix' => 'subject-type'], function() {
    	Route::get('sub_type_list', 'SubjectTypeController@index')->name('admin.subjectType.index');
		Route::get('sub_type_edit/{id}', 'SubjectTypeController@edit')->name('admin.subjectType.edit');
   		Route::post('update/{id}', 'SubjectTypeController@update')->name('admin.subjectType.update');
   		Route::get('sub_type_delete/{id}', 'SubjectTypeController@destroy')->name('admin.subjectType.delete');
   		Route::get('sub_type_pdf-generate', 'SubjectTypeController@pdfGenerate')->name('admin.subjectType.pdf.generate');
 
	});
	//Class Subject (13)
	Route::group(['prefix' => 'subject'], function() {
    	Route::get('cl_sub_list', 'SubjectController@index')->name('admin.subject.manageSubject,index');
    	Route::get('cl_sub_list_search', 'SubjectController@search')->name('admin.subject.search');
    	Route::post('cl_sub_list_add', 'SubjectController@store')->name('admin.subject.add');
    	Route::get('cl_sub_list_delete/{id}', 'SubjectController@destroy')->name('admin.manageSubject.delete');
	});

	//chapter (14)
	Route::group(['prefix' => 'chapter'], function() {
		Route::get('index', 'ChapterController@index')->name('admin.chapter.index');
		Route::get('table', 'ChapterController@table')->name('admin.chapter.table');
		Route::post('store', 'ChapterController@store')->name('admin.chapter.store');
		Route::get('edit/{rec_id}', 'ChapterController@edit')->name('admin.chapter.edit');
		Route::post('update/{rec_id}', 'ChapterController@update')->name('admin.chapter.update');
		Route::get('delete/{rec_id}', 'ChapterController@delete')->name('admin.chapter.delete');
		
	});


	//upload video (15)
	Route::group(['prefix' => 'video'], function() {
		Route::get('v-index', 'VideoController@video_index')->name('admin.video.index');
		Route::get('v-table', 'VideoController@video_table')->name('admin.video.table');
		Route::post('v-store', 'VideoController@store')->name('admin.video.store');
		Route::post('/watch-event', 'VideoController@watchEvent')->name('video.watch.event');

		

		
		Route::get('p-index', 'VideoController@pdf_index')->name('admin.pdf.index');
		Route::get('p-table', 'VideoController@pdf_table')->name('admin.pdf.table');
		Route::post('p-store', 'VideoController@pdf_store')->name('admin.pdf.store');
		Route::get('p-delete/{rec_id}', 'VideoController@pdf_delete')->name('admin.pdf.delete');
		
	});

	Route::group(['prefix' => 'common'], function() {
		Route::get('cmnctl-ctsub', 'CommonController@classWiseSubject')->name('admin.common.class.wise.subjects');
		Route::get('get-chapter', 'CommonController@subjectWiseChapter')->name('admin.common.subjects.wise.chapter');
	});

	// Support
	Route::group(['prefix' => 'support'], function() {
		// // Feedback/Help/Error (751)
	 //    Route::get('desk_index', 'SupportController@deskIndex')->name('admin.support.desk.index');
	 //    Route::get('desk_table', 'SupportController@deskTable')->name('admin.support.desk.table');
	 //    Route::get('desk-form', 'SupportController@deskForm')->name('admin.support.desk.form');
	 //    Route::post('desk-store', 'SupportController@deskStore')->name('admin.support.desk.store');
	    
	    // Feedback/Solution (752)
	    Route::get('solution_index', 'SupportController@solutionIndex')->name('admin.support.solution.index');
	    Route::get('solution_table', 'SupportController@solutionTable')->name('admin.support.solution.table');
	    Route::get('solution_status/{rec_id}', 'SupportController@solutionStatus')->name('admin.support.solution.status');
	    Route::post('solution_store/{rec_id}', 'SupportController@solutionStore')->name('admin.support.solution.store');

	    // Error Exception (753)
	    Route::get('error_index', 'SupportController@errorIndex')->name('admin.support.error.index');
	    Route::get('error-show', 'SupportController@errorShow')->name('admin.support.error.show');
	    Route::get('error-resolved/{id}', 'SupportController@resolved')->name('admin.support.error.resolved');
	    Route::get('error-delete/{id}', 'SupportController@delete')->name('admin.support.error.delete');
	});
	Route::group(['prefix' => 'school-detail'], function() {
	    Route::get('index', 'SchoolDetailsController@index')->name('admin.school.detail.index');
	    Route::get('add/{id}', 'SchoolDetailsController@edit')->name('admin.school.detail.edit');
	    Route::post('store/{id}', 'SchoolDetailsController@update')->name('admin.school.detail.update');
	    Route::get('delete/{id}', 'SchoolDetailsController@destroy')->name('admin.school.detail.delete');
	});

	Route::group(['prefix' => 'school-activity'], function() {
	    Route::get('index', 'SchoolActivityController@index')->name('admin.school.activity.index');
	    Route::post('show', 'SchoolActivityController@show')->name('admin.school.activity.show');
	});

	// Book Demo Request
	Route::group(['prefix' => 'bdr'], function() {
	    Route::get('bdr-index', 'BookDemoRequestController@index')->name('admin.book.demo.request.index');
	});

	// Master School List
	Route::group(['prefix' => 'msl'], function() {
	    Route::get('msl-index', 'MasterSchoolListController@index')->name('admin.master.school.list.index');
	    Route::get('msl-addform/{id}', 'MasterSchoolListController@addform')->name('admin.master.school.list.addform');
	    Route::post('msl-store/{id}', 'MasterSchoolListController@store')->name('admin.master.school.list.store');
	    Route::get('msl-delete/{id}', 'MasterSchoolListController@delete')->name('admin.master.school.list.delete');

	    Route::get('msl-contact-detail/{id}', 'MasterSchoolListController@contactDetail')->name('admin.master.school.contact.detail');
	    Route::get('msl-contact-addform/{para}', 'MasterSchoolListController@contactAddForm')->name('admin.master.school.contact.addform');
	    Route::post('msl-contact-store/{para}', 'MasterSchoolListController@contactDetailStore')->name('admin.master.school.contact.store');
	    Route::get('msl-contact-delete/{id}', 'MasterSchoolListController@contactDetailDelete')->name('admin.master.school.contact.delete');
	});


	// WhatsApp Template Details (35)
	Route::group(['prefix' => 'wtd'], function() {
	    Route::get('wtd-index', 'WhatsAppTemplateDetailsController@index')->name('admin.whatsApp.template.detail.index');
	    Route::get('wtd-addform/{id}', 'WhatsAppTemplateDetailsController@addform')->name('admin.whatsApp.template.detail.addform');
	    Route::post('wtd-store/{id}', 'WhatsAppTemplateDetailsController@store')->name('admin.whatsApp.template.detail.store');
	    Route::get('wtd-delete/{id}', 'WhatsAppTemplateDetailsController@delete')->name('admin.whatsApp.template.detail.delete');

	    Route::get('wtd-test/{para}', 'WhatsAppTemplateDetailsController@textMessage')->name('admin.whatsApp.template.detail.test.message');
	    Route::post('wtd-test-send', 'WhatsAppTemplateDetailsController@textMessageSend')->name('admin.whatsApp.template.detail.test.message.send');

	    Route::get('whatsApp-template/view-file/{id}', 'WhatsAppTemplateDetailsController@viewFile')->name('admin.whatsApp.template.detail.view_file');
	});

	// Marketing Message Send (36)
	Route::group(['prefix' => 'mms'], function() {
	    Route::get('mms-index', 'MarketingMessageController@index')->name('admin.marketing.message.send.index');
	    Route::post('mms-show', 'MarketingMessageController@show')->name('admin.marketing.message.send.show');
	    Route::post('mms-send', 'MarketingMessageController@send')->name('admin.marketing.message.send.send');
	});

	// dictionary
	Route::group(['prefix' => 'dictionary'], function() {
	    Route::get('dictionary-index', 'DictionaryController@index')->name('admin.dictionary.index');
	    Route::get('fetchHindiName/{type?}', 'DictionaryController@fetchHindiName')->name('admin.dictionary.fetchHindiName');
	    Route::get('correctHindiName/{type?}', 'DictionaryController@correctHindiName')->name('admin.dictionary.correctHindiName');
	    Route::post('saveOrUpdateDictionary', 'DictionaryController@saveOrUpdateDictionary')->name('admin.dictionary.saveOrUpdateDictionary');
	});

	
 });
