<?php

//Route::get('/', 'HomeController@index')->name('/');
Route::get('/', 'HomeController@home')->name('home');
Route::get('about_us', 'HomeController@aboutUs');
Route::get('content-details/{id}', 'WebsiteController@contentDetail');

Route::get('who-we-are', 'WebsiteController@whoWeAre');
Route::get('mission-and-vision', 'WebsiteController@missionAndVision');
Route::get('our-specialty/{slug}', 'WebsiteController@ourSpecialty');
Route::get('affiliation-details/{slug}', 'WebsiteController@affiliationDetails');

Route::get('contact-us', 'WebsiteController@contactUs');
Route::get('gallery-album', 'WebsiteController@galleryAlbum');
Route::get('galleryweb/{slug}', 'WebsiteController@galleryPhotos');
Route::get('news-and-events', 'WebsiteController@newsAndEvents');
Route::get('news-and-events/{slug}', 'WebsiteController@postDetail');
Route::get('publications', 'WebsiteController@publication');
Route::get('publication/download/{id}', 'PublicationController@getDownload');
Route::get('sister-concerns', 'WebsiteController@concerns');
Route::get('product-details/{id}', 'WebsiteController@productDetails');

Route::get('jobs','JobsController@index');
Route::get('jobs/details/{id}','JobsController@jobDetails');
Route::get('jobs/apply/{id}','JobsController@apply');
Route::post('apply/proceed','JobsController@applyProceed');

Route::post('jobs/intro','JobsController@intro');
Route::post('jobs/verify','JobsController@verify');
Route::post('jobs/store','JobsController@store');

Route::post('purchase-request', 'WebsiteController@getPerchaseRequese');
Route::post('purchase-request-save', 'WebsiteController@perchaseRequeseSave');

Route::get('photo_gallery', 'HomeController@gallery');
Route::get('javacriptEnable', 'HomeController@javacriptEnable');

Route::post('forgotPassword', 'ForgotPasswordController@forgotPassword');
Route::get('recoverPassword/{id}', 'ForgotPasswordController@recoverPassword');
Route::post('resetPassword', 'ForgotPasswordController@resetPassword');

Route::get('mail', array('uses' => 'MailController@index'));
Auth::routes();





Route::group(['middleware' => 'auth'], function () {

//    Route::get('manual/', 'ManualController@index')->name('manual');
//    Route::get('manual/download/{id}', 'ManualController@manualDownload');

    Route::post('setRecordPerPage', 'UsersController@setRecordPerPage');




    Route::get('dashboard', 'Admin\DashboardController@index');

    Route::get('forcePasswordChange', 'Admin\DashboardController@forcePasswordChange');
    Route::post('forcePasswordChange', 'Admin\DashboardController@updatePassword');

    Route::get('dashboard/admin', 'Admin\DashboardController@admin');
    Route::post('dashboard/change_picture', 'Admin\DashboardController@changePicture');




    // Users Management Access Admin/OC All Program. Check this Controller Construct Method
    // Only cpself and editProfile Method Access All Program all User
    // :::::::: Start User Route ::::::::::::::
    Route::post('users/cpself/', 'UsersController@cpself');
    Route::get('users/cpself/', function() {
        return View::make('users/change_password_self');
    });
    Route::get('users/profile/', function () {
        return View::make('users/user_profile');
    });
    Route::post('users/editProfile/', 'UsersController@editProfile');
    Route::resource('users', 'UsersController', ['except' => ['show']]);
    Route::get('users/activate/{id}/{param?}', 'UsersController@active');
    Route::post('users/pup/', 'UsersController@pup');
    Route::post('users/filter/', 'UsersController@filter');
    Route::get('users/cp/{id}/{param?}', 'UsersController@change_pass');
    // :::::::: End User Route ::::::::::::::
    // :::::::: Start Notice Route ::::::::::::::
    // Notice  Access Admin/OC/CI All Program. Check this Controller Construct Method
    // Only index Method Access All Program all User
    Route::resource('notice', 'NoticeController', ['except' => ['show']]);
    Route::get('notice/download/{id}', 'NoticeController@getDownload');
    Route::post('notice/filter', 'NoticeController@filter');
    // :::::::: End Notice Route ::::::::::::::

    Route::get('message', 'MessageController@index');
    //// this Controller Access all user and All program
    //    Applicant
    Route::get('applicant', 'ApplicantController@index');
    Route::post('applicant/filter', 'ApplicantController@filter');
    Route::post('applicant/applicant-discard-modal', 'ApplicantController@applicantDiscard');
    Route::post('applicant/applicant-discard', 'ApplicantController@discard');
    Route::post('applicant/applicant-participated', 'ApplicantController@participated');
    Route::post('applicant/applicant-recruited', 'ApplicantController@recruited');
    Route::post('applicant/applicant-reviewed-modal', 'ApplicantController@applicantReviewed');
    Route::post('applicant/applicant-reviewed', 'ApplicantController@Reviewed');
    Route::get('applicant/applicantion-info', 'ApplicantController@applicantionInfo');
    //    Circuler
    Route::get('circular', 'CircularController@index');
    Route::get('circular/circular-info', 'CircularController@circularInfo');
    Route::get('circular/create', 'CircularController@create');
    Route::post('circular/store', 'CircularController@store');
    Route::get('circular/{id}/edit', 'CircularController@edit');
    Route::patch('circular/{id}/update', 'CircularController@update')->name('circular.update');
    Route::delete('circular/delete/{id}','CircularController@destroy');
    Route::post('circular/filter', 'CircularController@filter');
    //    Job Nature
    Route::get('jobNature', 'JobNatureController@index');
    Route::get('jobNature/create', 'JobNatureController@create');
    Route::post('jobNature/store', 'JobNatureController@store');
    Route::get('jobNature/{id}/edit', 'JobNatureController@edit');
    Route::patch('jobNature/{id}/update', 'JobNatureController@update')->name('jobNature.update');
    Route::delete('jobNature/delete/{id}', 'JobNatureController@destroy');
    Route::post('jobNature/filter', 'JobNatureController@filter');
    
//    Route::resource('JobNature', 'JobNatureController');
    
//    Discarded
    Route::get('discardedApplication', 'DiscardedApplicationController@index');
    Route::post('discardedApplication/filter', 'DiscardedApplicationController@filter');
    Route::post('applicant/applicant-pending', 'DiscardedApplicationController@Pending');
//    Reviewed
    Route::get('reviewedApplication', 'ReviewedApplicationController@index');
    Route::post('reviewedApplication/filter', 'ReviewedApplicationController@filter');
//    Select for interview
    Route::get('selectForInterview', 'SelectForInterviewController@index');
    Route::post('selectForInterview/filter', 'SelectForInterviewController@filter');
    Route::post('applicant/applicant-selected', 'SelectForInterviewController@selectForInterview');
    Route::post('applicant/set-activity-log-modal', 'SelectForInterviewController@setActivityLog');
    Route::post('applicant/view-activity-log-modal', 'SelectForInterviewController@viewActivityLog');
    Route::post('applicant/saveActivityModal', 'SelectForInterviewController@saveActivityLog');
    
//    Confirmed contoller
    Route::get('confirmedApplication', 'ConfirmedApplicationController@index');
    Route::post('confirmedApplication/filter', 'ConfirmedApplicationController@filter');
//    Participated Controller
    Route::get('participatedApplicant', 'ParticipatedApplicantController@index');
    Route::post('participatedApplicant/filter', 'ParticipatedApplicantController@filter');
//    Recruited Controller
    Route::get('recruitedApplicant', 'RecruitedApplicantController@index');
    Route::post('recruitedApplicant/filter', 'RecruitedApplicantController@filter');
    
  
});

// <--- End of only ISSP,JCSC (All) program Admin,OC,CI,Student access --->
Route::group(['middleware' => ['auth']], function () {

  Route::post('branch/filter', 'BranchController@filter');
  Route::resource('userGroup', 'UserGroupController');

//  Route::resource('rank', 'RankController');
  Route::resource('designation', 'DesignationController');
  Route::resource('appointment', 'AppointmentController');
  Route::resource('branch', 'BranchController');

    // website
    Route::resource('slider', 'SliderController');

    Route::resource('menu', 'MenuController');
    Route::post('menu/getOrder/', 'MenuController@getOrder');
    Route::post('menu/filter/', 'MenuController@filter');
    Route::post('menu/getTypeWiseField/', 'MenuController@getTypeWiseField');

    // content
    Route::resource('content', 'ContentController');

    //HOME : Who We Are
    Route::get('whoWeAre', 'WhoWeAreController@index');
    Route::Post('whoWeAre', 'WhoWeAreController@update')->name('whoWeAre.update');


    Route::get('businessSegments', 'BusinessSegmentsController@index');
    Route::Post('businessSegments', 'BusinessSegmentsController@update')->name('businessSegments.update');

    //HOME : At A Glance
    Route::resource('ourSpecialty', 'OurSpecialtyController');

    //HOME : Our Affiliations
    Route::resource('affiliations', 'AffiliationsController');

    // Services
    Route::resource('services', 'ServicesController');

    // Sister Concerns
    Route::resource('sisterConcerns', 'SisterConcernsController');

    // Certifications
    Route::resource('certifications', 'CertificationsController');

    // Statistics
    Route::resource('statistics', 'StatisticsController');

    // Quality Factor
    Route::resource('qualityFactor', 'QualityFactorController');

    // Product
    Route::resource('product', 'ProductController');

    // News And Events
    Route::resource('newsAndEvents', 'NewsAndEventsController');

    //Publication
    Route::post('publication/filter/', 'PublicationController@filter');
    Route::post('/publication/getOrder/', 'PublicationController@getOrder');
    Route::resource('publication', 'PublicationController');

    Route::post('catpublication/filter/', 'PublicationCategoryController@filter');
    Route::resource('catpublication', 'PublicationCategoryController');

    // Gallery
    Route::resource('gAlbum', 'GAlbumController');
    Route::post('gAlbum/filter/', 'GAlbumController@filter');
    Route::resource('gallery', 'GalleryController');


    //Footer
    Route::get('footer', 'FooterController@index');

    Route::resource('contact-info', 'ContactInfoController');
    Route::resource('ourService', 'OurServiceController');
    Route::resource('support', 'SupportController');
    Route::resource('downloads', 'DownloadController');
    Route::resource('follow-us', 'FollowUsController');
    
    Route::post('userSubcription', 'SubcriptionController@subcription');
    
  
    Route::resource('majorCategories', 'MajorCategoriesController');
    
 
    //product category
    Route::post('productCategory/filter/', 'ProductCategoryController@filter');
    Route::get('productCategory', 'ProductCategoryController@index')->name('productCategory.index');
    Route::get('productCategory/create', 'ProductCategoryController@create')->name('productCategory.create');
    Route::post('productCategory', 'ProductCategoryController@store')->name('productCategory.store');
    Route::get('productCategory/{id}/edit', 'ProductCategoryController@edit')->name('productCategory.edit');
    Route::patch('productCategory/{id}', 'ProductCategoryController@update')->name('productCategory.update');
    Route::delete('productCategory/{id}', 'ProductCategoryController@destroy')->name('productCategory.destroy');
    
    
      //product
    Route::post('product/filter/', 'ProductController@filter');
    Route::get('product', 'ProductController@index')->name('product.index');
    Route::get('product/create', 'ProductController@create')->name('product.create');
    Route::post('product/loadProductNameCreate', 'ProductController@loadProductNameCreate');
    Route::post('product/store', 'ProductController@store')->name('product.store');
    Route::get('product/{id}/edit', 'ProductController@edit')->name('product.edit');
    Route::post('product/loadProductNameEdit', 'ProductController@loadProductNameEdit');
    Route::post('product/update', 'ProductController@update')->name('product.update');
    Route::delete('product/{id}', 'ProductController@destroy')->name('product.destroy');

    //set product image
    Route::get('product/{id}/getProductImage', 'ProductController@getProductImage');
    Route::post('product/setProductImage', 'ProductController@setProductImage');
    Route::post('product/newProductImage', 'ProductController@newProductImage')->name('product.newProductImage');
    
        //HOME : Our Programs
    Route::resource('ourPrograms', 'OurProgramsController');
    
    // program Gallery
    Route::get('ourPrograms/{id}/gallery', 'ProgramGalleryController@gallery');
    Route::get('programGallery/{programId}/create', 'ProgramGalleryController@create');
    Route::post('programGallery/store', 'ProgramGalleryController@store');
    Route::get('programGallery/{id}/edit', 'ProgramGalleryController@edit');
    Route::post('programGallery/update', 'ProgramGalleryController@update');
    Route::post('programGallery/destroy', 'ProgramGalleryController@destroy');
    
    Route::get('welcomeDcare', 'WelcomeDcareController@index');
    Route::Post('welcomeDcare', 'WelcomeDcareController@update')->name('welcomeDcare.update');
    //new
    // pending 
    Route::get('orderSate/pending', 'OrderStateController@pending');
    Route::post('orderSate/pending/getOrderFrom', 'OrderStateController@getOrderFrom');
    Route::post('orderSate/pending/orderSave', 'OrderStateController@orderSave');
    Route::post('orderSate/pending/getPaymentFrom', 'OrderStateController@getPaymentFrom');
    Route::post('orderSate/pending/paymentSave', 'OrderStateController@paymentSave');
    Route::post('orderSate/pending/pendingFilter', 'OrderStateController@pendingFilter');
    //Processing
    Route::get('orderSate/processing', 'OrderStateController@processing');
    Route::post('orderSate/processing/processingFilter', 'OrderStateController@processingFilter');
    
       //Delivered
    Route::get('orderSate/delivered', 'OrderStateController@delivered');
    Route::post('orderSate/delivered/deliveredFilter', 'OrderStateController@deliveredFilter');
    
    //Close
    Route::get('orderSate/close', 'OrderStateController@close');
    Route::post('orderSate/close/closeFilter', 'OrderStateController@closeFilter');
    
    Route::get('orderSate/trackingOrder', 'OrderStateController@trackingOrder');
    Route::post('orderSate/trackingOrder/trackingOrderFilter', 'OrderStateController@trackingOrderFilter');

});
