<?php

Route::group(['prefix' => 'dash/students', 'middleware' => 'auth'], function() {

	Route::get('/list', 'StudentController@getStudentList')->name('students.list');

});

Route::group(['prefix' => 'dash/student', 'middleware' => 'auth'], function() {

	Route::get('/new', 'StudentController@getStudentNew')->name('student.new');
	Route::post('/new', 'StudentController@postStudentNew');

	Route::get('/{id}/details/view', 'StudentController@getStudentDetailView')->name('student.details.view');

	Route::get('/{id}/details/edit', 'StudentController@getStudentDetailEdit')->name('student.details.edit');
	Route::post('/{id}/details/edit', 'StudentController@postStudentDetailEdit');

	Route::get('/{id}/contacts/view', 'StudentController@getStudentAddressesView')->name('student.addresses.view');
	Route::get('/{id}/contacts/edit', 'StudentController@getStudentAddressesEdit')->name('student.addresses.edit');

	Route::get('/{id}/contact/new', 'StudentController@getStudentAddressNew')->name('student.address.new');
	Route::post('/{id}/contact/new', 'StudentController@postStudentAddressNew');

	Route::get('/{id}/contact/{cid}/edit', 'StudentController@getStudentAddressEdit')->name('student.address.edit');
	Route::post('/{id}/contact/{cid}/edit', 'StudentController@postStudentAddressEdit');

	Route::get('/{id}/contact/{cid}/delete', 'StudentController@getStudentAddressDelete')->name('student.address.delete');
	
	Route::get('/{id}/account/view', 'StudentController@getStudentAccountView')->name('student.account.view');

	Route::get('/{id}/account/edit', 'StudentController@getStudentAccountEdit')->name('student.account.edit');
	Route::post('/{id}/account/edit', 'StudentController@postStudentAccountEdit');

	Route::get('/{id}/assign_class', 'StudentController@getStudentClassAssign')->name('student.assign_class');
	Route::post('/{id}/assign_class', 'StudentController@postStudentClassAssign');

});

Route::group(['prefix' => 'dash/student_categories', 'middleware' => 'auth'], function() {

	Route::get('/list', 'StudentCategoriesController@getStudentCategoriesList')->name('student_categories.list');
});

Route::group(['prefix' => 'dash/student_category', 'middleware' => 'auth'], function() {

	Route::get('/new', 'StudentCategoriesController@getStudentCategoryNew')->name('student_category.new');
	Route::post('/new', 'StudentCategoriesController@postStudentCategoryNew');

	Route::get('/{id}/edit', 'StudentCategoriesController@getStudentCategoryEdit')->name('student_category.edit');
	Route::post('/{id}/edit', 'StudentCategoriesController@postStudentCategoryEdit');
});
