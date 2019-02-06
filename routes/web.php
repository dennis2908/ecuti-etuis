<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return redirect()->route('login');
    // return view('welcome');
});
Route::get('login/announcement/{id}', 'Auth\LoginController@announcement')->name('login.announcement');


Auth::routes();

// Route::prefix('api')->group(function () {
// 	Route::post('database', 'API\DatabaseController@index')->name('api.database');
// });

Route::prefix('home')->group(function () {
	Route::get('/', 'HomeController@index')->name('home');
	Route::get('list', 'HomeController@list')->name('home.list');
});

Route::prefix('general')->group(function () {
	Route::get('postcode-state/{postcode}', 'GeneralController@getStateFromPostcode')->name('general.getStateFromPostcode');
	Route::get('state-district/{state_id}', 'GeneralController@getDistrictFromState')->name('general.getDistrictFromState');
	Route::get('attachment/{attachment_id}/{filename}', 'GeneralController@getAttachment')->name('general.getAttachment');
	Route::get('letter/{letter_type_id}/{filename}', 'GeneralController@getLetterTemplate')->name('general.getLetterTemplate');
	Route::get('filing', 'GeneralController@getFilingDetails')->name('general.getFilingDetails');
});

Route::get('autologin/{id}', 'Auth\LoginController@autologin')->name('autologin');	//home

Route::prefix('handover')->group(function () {
	Route::get('{code}', 'Auth\HandOverController@index')->name('handover');
	Route::post('create', 'Auth\HandOverController@create')->name('handover.create');
});

// Email Verification
Route::get('auth/{username}/verify/{code}', 'Auth\RegisterController@verify')->name('auth.verify');

Route::prefix('inbox')->group(function () {
	Route::get('/', 'InboxController@index')->name('inbox');
	Route::get('{id}', 'InboxController@view')->name('inbox.view');
});

Route::prefix('monitoring')->group(function () {
	Route::get('/', 'MonitoringController@index')->name('monitoring');
});

Route::prefix('profile')->group(function () {
	Route::get('/', 'ProfileController@index')->name('profile');
	Route::post('/', 'ProfileController@update')->name('profile');
	Route::post('password', 'ProfileController@password')->name('profile.password');
	Route::post('handover', 'ProfileController@handover')->name('profile.handover');
	Route::get('picture/{filename}', 'ProfileController@picture')->name('profile.picture');
});

Route::prefix('search')->group(function () {
	Route::get('/', 'SearchController@index')->name('search');
	Route::get('list', 'SearchController@list')->name('search.list');
	Route::get('{id}', 'SearchController@view_search')->name('search.view');
});

Route::prefix('report')->group(function () {
	Route::get('/', 'ReportController@index')->name('report');
	Route::get('view', 'ReportController@view')->name('report.item');
});

Route::prefix('distribution')->group(function () {
	Route::get('/', 'DistributionController@index')->name('distribution');
	Route::get('{id}', 'DistributionController@edit')->name('distribution.form');
	Route::post('{id}', 'DistributionController@update')->name('distribution.form');
});

Route::prefix('announcement')->group(function () {
	Route::get('/', 'AnnouncementController@index')->name('announcement');
	Route::post('/', 'AnnouncementController@insert')->name('announcement');
	Route::get('{id}', 'AnnouncementController@edit')->name('announcement.form');
	Route::post('{id}', 'AnnouncementController@update')->name('announcement.form');
	Route::delete('{id}', 'AnnouncementController@delete')->name('announcement.form');
});

Route::prefix('registration')->group(function () {
	Route::prefix('appeal')->group(function () {
	    Route::get('form/{username}/{code}', 'Registration\AppealController@form')->name('appeal.form');
		Route::post('submit', 'Registration\AppealController@submit')->name('appeal.submit');

		Route::get('/', 'Registration\AppealController@index')->name('appeal');
		Route::get('list', 'Registration\AppealController@list')->name('appeal.list');

		Route::prefix('{id}')->group(function () {
			Route::prefix('process/result')->group(function () {
				Route::get('/', 'Registration\AppealController@process_result')->name('appeal.process.result');

				Route::prefix('approve')->group(function () {
					Route::get('/', 'Registration\AppealController@process_result_approve_edit')->name('appeal.process.result.approve');
					Route::post('/', 'Registration\AppealController@process_result_approve_update')->name('appeal.process.result.approve');
				});

				Route::prefix('reject')->group(function () {
					Route::get('/', 'Registration\AppealController@process_result_reject_edit')->name('appeal.process.result.reject');
					Route::post('/', 'Registration\AppealController@process_result_reject_update')->name('appeal.process.result.reject');
				});
			});
		});
	});

	Route::prefix('tenure')->group(function () {
		Route::get('/', 'Registration\TenureController@index')->name('tenure');
		Route::post('/', 'Registration\TenureController@insert')->name('tenure');
		Route::get('{id}', 'Registration\TenureController@edit')->name('tenure.form');
		Route::post('{id}', 'Registration\TenureController@update')->name('tenure.form');
		Route::delete('{id}', 'Registration\TenureController@delete')->name('tenure.form');
	});

	Route::prefix('branch')->group(function () {
		Route::get('/', 'Registration\BranchController@index')->name('branch');
		Route::post('/', 'Registration\BranchController@insert')->name('branch');
		Route::get('{id}', 'Registration\BranchController@edit')->name('branch.form');
		Route::post('{id}', 'Registration\BranchController@update')->name('branch.form');
		Route::delete('{id}', 'Registration\BranchController@delete')->name('branch.form');
	});

	Route::prefix('formb')->group(function () {
		Route::get('/', 'Registration\FormBController@index')->name('formb');
		Route::get('list', 'Registration\FormBController@list')->name('formb.list');
		Route::get('review', 'Registration\FormBController@review')->name('formb.review');
		Route::post('submit', 'Registration\FormBController@submit')->name('formb.submit');

		Route::prefix('b2')->group(function () {
			Route::get('/', 'Registration\FormBController@b2_index')->name('formb.b2');
			Route::get('download', 'Registration\FormBController@download')->name('download.formb');

			Route::prefix('requester')->group(function () {
				Route::get('/', 'Registration\FormBController@requester_index')->name('formb.b2.requester');
				Route::post('/', 'Registration\FormBController@requester_insert')->name('formb.b2.requester');
				Route::get('{id}', 'Registration\FormBController@requester_edit')->name('formb.b2.requester.form');
				Route::post('{id}', 'Registration\FormBController@requester_update')->name('formb.b2.requester.form');
				Route::delete('{id}', 'Registration\FormBController@requester_delete')->name('formb.b2.requester.form');
			});

			Route::prefix('officer')->group(function () {
				Route::get('/', 'Registration\FormBController@officer_index')->name('formb.b2.officer');
				Route::post('/', 'Registration\FormBController@officer_insert')->name('formb.b2.officer');
				Route::get('{id}', 'Registration\FormBController@officer_edit')->name('formb.b2.officer.form');
				Route::post('{id}', 'Registration\FormBController@officer_update')->name('formb.b2.officer.form');
				Route::delete('{id}', 'Registration\FormBController@officer_delete')->name('formb.b2.officer.form');
			});
		});

		Route::prefix('{id}/process')->group(function () {
			Route::prefix('document-receive')->group(function () {
				Route::get('/', 'Registration\FormBController@process_documentReceive_edit')->name('formb.process.document-receive');
				Route::post('/', 'Registration\FormBController@process_documentReceive_update')->name('formb.process.document-receive');
			});

			Route::prefix('query')->group(function () {
				Route::get('/', 'Registration\FormBController@process_query_edit')->name('formb.process.query');
				Route::post('/', 'Registration\FormBController@process_query_update')->name('formb.process.query');

				Route::get('item', 'Registration\FormBController@process_query_item_list')->name('formb.process.query.item');
				Route::post('item', 'Registration\FormBController@process_query_item_update')->name('formb.process.query.item');
				Route::delete('item/{query_id}', 'Registration\FormBController@process_query_item_delete')->name('formb.process.query.item.delete');
			});

			Route::prefix('recommend')->group(function () {
				Route::get('/', 'Registration\FormBController@process_recommend_edit')->name('formb.process.recommend');
				Route::post('/', 'Registration\FormBController@process_recommend_update')->name('formb.process.recommend');
			});

			Route::prefix('category')->group(function () {
				Route::get('/', 'Registration\FormBController@process_category_edit')->name('formb.process.category');
				Route::post('/', 'Registration\FormBController@process_category_update')->name('formb.process.category');
			});

			Route::prefix('delay')->group(function () {
				Route::get('/', 'Registration\FormBController@process_delay_edit')->name('formb.process.delay');
				Route::post('/', 'Registration\FormBController@process_delay_update')->name('formb.process.delay');
			});

			Route::prefix('result')->group(function () {
				Route::get('/', 'Registration\FormBController@process_result')->name('formb.process.result');

				Route::prefix('approve')->group(function () {
					Route::get('/', 'Registration\FormBController@process_result_approve_edit')->name('formb.process.result.approve');
					Route::post('/', 'Registration\FormBController@process_result_approve_update')->name('formb.process.result.approve');
				});

				Route::prefix('reject')->group(function () {
					Route::get('/', 'Registration\FormBController@process_result_reject_edit')->name('formb.process.result.reject');
					Route::post('/', 'Registration\FormBController@process_result_reject_update')->name('formb.process.result.reject');
				});
			});
		});

		Route::prefix('b3')->group(function () {
			Route::get('/', 'Registration\FormBController@b3_index')->name('formb.b3');
			Route::get('download', 'Registration\FormBController@b3_download')->name('download.formb3');
		});

		Route::prefix('b4')->group(function () {
			Route::get('/', 'Registration\FormBController@b4_index')->name('formb.b4');
			Route::get('download', 'Registration\FormBController@b4_download')->name('download.formb4');
		});
		
		Route::get('praecipe', 'Registration\FormBController@praecipe')->name('formb.praecipe');
	});

	Route::prefix('formo')->group(function () {
		Route::get('/', 'Registration\FormOController@index')->name('formo');
		Route::get('list', 'Registration\FormOController@list')->name('formo.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Registration\FormOController@edit')->name('formo.form');
			Route::post('/', 'Registration\FormOController@submit')->name('formo.form');
			Route::get('download', 'Registration\FormOController@download')->name('download.formo');
		});

	});

	Route::prefix('formbb')->group(function () {
		Route::get('/', 'Registration\FormBBController@index')->name('formbb');
		Route::get('list', 'Registration\FormBBController@list')->name('formbb.list');
		Route::get('review', 'Registration\FormBBController@review')->name('formbb.review');
		Route::post('submit', 'Registration\FormBBController@submit')->name('formbb.submit');

		Route::prefix('bb2')->group(function() {
			Route::get('/', 'Registration\FormBBController@bb2_index')->name('formbb.bb2');
			Route::get('download', 'Registration\FormBBController@download')->name('download.formbb');

			Route::prefix('officer')->group(function () {
				Route::get('/', 'Registration\FormBBController@officer_index')->name('formbb.bb2.officer');
				Route::post('/', 'Registration\FormBBController@officer_insert')->name('formbb.bb2.officer');
				Route::get('{id}', 'Registration\FormBBController@officer_edit')->name('formbb.bb2.officer.form');
				Route::post('{id}', 'Registration\FormBBController@officer_update')->name('formbb.bb2.officer.form');
				Route::delete('{id}', 'Registration\FormBBController@officer_delete')->name('formbb.bb2.officer.form');
			});
		});

		Route::prefix('{id}/process')->group(function () {
			Route::prefix('document-receive')->group(function () {
				Route::get('/', 'Registration\FormBBController@process_documentReceive_edit')->name('formbb.process.document-receive');
				Route::post('/', 'Registration\FormBBController@process_documentReceive_update')->name('formbb.process.document-receive');
			});

			Route::prefix('query')->group(function () {
				Route::get('/', 'Registration\FormBBController@process_query_edit')->name('formbb.process.query');
				Route::post('/', 'Registration\FormBBController@process_query_update')->name('formbb.process.query');

				Route::get('item', 'Registration\FormBBController@process_query_item_list')->name('formbb.process.query.item');
				Route::post('item', 'Registration\FormBBController@process_query_item_update')->name('formbb.process.query.item');
				Route::delete('item/{query_id}', 'Registration\FormBBController@process_query_item_delete')->name('formbb.process.query.item.delete');
			});

			Route::prefix('recommend')->group(function () {
				Route::get('/', 'Registration\FormBBController@process_recommend_edit')->name('formbb.process.recommend');
				Route::post('/', 'Registration\FormBBController@process_recommend_update')->name('formbb.process.recommend');
			});

			Route::prefix('category')->group(function () {
				Route::get('/', 'Registration\FormBBController@process_category_edit')->name('formbb.process.category');
				Route::post('/', 'Registration\FormBBController@process_category_update')->name('formbb.process.category');
			});

			Route::prefix('delay')->group(function () {
				Route::get('/', 'Registration\FormBBController@process_delay_edit')->name('formbb.process.delay');
				Route::post('/', 'Registration\FormBBController@process_delay_update')->name('formbb.process.delay');
			});

			Route::prefix('result')->group(function () {
				Route::get('/', 'Registration\FormBBController@process_result')->name('formbb.process.result');

				Route::prefix('approve')->group(function () {
					Route::get('/', 'Registration\FormBBController@process_result_approve_edit')->name('formbb.process.result.approve');
					Route::post('/', 'Registration\FormBBController@process_result_approve_update')->name('formbb.process.result.approve');
				});

				Route::prefix('reject')->group(function () {
					Route::get('/', 'Registration\FormBBController@process_result_reject_edit')->name('formbb.process.result.reject');
					Route::post('/', 'Registration\FormBBController@process_result_reject_update')->name('formbb.process.result.reject');
				});
			});
		});

		Route::prefix('bb3')->group(function() {
			Route::get('/', 'Registration\FormBBController@bb3_index')->name('formbb.bb3');
			Route::get('download', 'Registration\FormBBController@bb3_download')->name('download.formbb3');
		});

		Route::get('praecipe', 'Registration\FormBBController@praecipe')->name('formbb.praecipe');
	});
});

Route::prefix('amendment')->group(function () {
	Route::prefix('formg')->group(function () {
		Route::get('/', 'Amendment\FormGController@index')->name('formg');
		Route::get('list', 'Amendment\FormGController@list')->name('formg.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Amendment\FormGController@edit')->name('formg.form');
			Route::post('/', 'Amendment\FormGController@submit')->name('formg.form');
			Route::get('praecipe', 'Amendment\FormGController@praecipe')->name('formg.praecipe');

			Route::prefix('g1')->group(function () {
				Route::get('/', 'Amendment\FormGController@g1_index')->name('formg.g1');
				Route::get('download', 'Amendment\FormGController@download')->name('download.formg');

				Route::prefix('member')->group(function(){
					Route::get('/', 'Amendment\FormGController@member_index')->name('formg.g1.form.member');
					Route::post('/', 'Amendment\FormGController@member_insert')->name('formg.g1.form.member');
					Route::get('{member_id}', 'Amendment\FormGController@member_edit')->name('formg.g1.form.member.item');
					Route::post('{member_id}', 'Amendment\FormGController@member_update')->name('formg.g1.form.member.item');
					Route::delete('{member_id}', 'Amendment\FormGController@member_delete')->name('formg.g1.form.member.item');
				});
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'Amendment\FormGController@process_documentReceive_edit')->name('formg.process.document-receive');
					Route::post('/', 'Amendment\FormGController@process_documentReceive_update')->name('formg.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'Amendment\FormGController@process_query_edit')->name('formg.process.query');
					Route::post('/', 'Amendment\FormGController@process_query_update')->name('formg.process.query');

					Route::get('item', 'Amendment\FormGController@process_query_item_list')->name('formg.process.query.item');
					Route::post('item', 'Amendment\FormGController@process_query_item_update')->name('formg.process.query.item');
					Route::delete('item/{query_id}', 'Amendment\FormGController@process_query_item_delete')->name('formg.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'Amendment\FormGController@process_recommend_edit')->name('formg.process.recommend');
					Route::post('/', 'Amendment\FormGController@process_recommend_update')->name('formg.process.recommend');
				});

				Route::prefix('status')->group(function () {
					Route::get('/', 'Amendment\FormGController@process_status_edit')->name('formg.process.status');
					Route::post('/', 'Amendment\FormGController@process_status_update')->name('formg.process.status');
				});

				Route::prefix('delay')->group(function () {
					Route::get('/', 'Amendment\FormGController@process_delay_edit')->name('formg.process.delay');
					Route::post('/', 'Amendment\FormGController@process_delay_update')->name('formg.process.delay');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'Amendment\FormGController@process_result')->name('formg.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'Amendment\FormGController@process_result_approve_edit')->name('formg.process.result.approve');
						Route::post('/', 'Amendment\FormGController@process_result_approve_update')->name('formg.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'Amendment\FormGController@process_result_reject_edit')->name('formg.process.result.reject');
						Route::post('/', 'Amendment\FormGController@process_result_reject_update')->name('formg.process.result.reject');
					});
				});
			});

		});
	});

	Route::prefix('formj')->group(function () {
		Route::get('/', 'Amendment\FormJController@index')->name('formj');
		Route::get('list', 'Amendment\FormJController@list')->name('formj.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Amendment\FormJController@edit')->name('formj.form');
			Route::post('/', 'Amendment\FormJController@submit')->name('formj.form');
			Route::get('praecipe', 'Amendment\FormJController@praecipe')->name('formj.praecipe');
			Route::get('download', 'Amendment\FormJController@download')->name('download.formj');

			Route::prefix('j1')->group(function () {
				Route::get('/', 'Amendment\FormJController@j1_index')->name('formj.j1');
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'Amendment\FormJController@process_documentReceive_edit')->name('formj.process.document-receive');
					Route::post('/', 'Amendment\FormJController@process_documentReceive_update')->name('formj.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'Amendment\FormJController@process_query_edit')->name('formj.process.query');
					Route::post('/', 'Amendment\FormJController@process_query_update')->name('formj.process.query');

					Route::get('item', 'Amendment\FormJController@process_query_item_list')->name('formj.process.query.item');
					Route::post('item', 'Amendment\FormJController@process_query_item_update')->name('formj.process.query.item');
					Route::delete('item/{query_id}', 'Amendment\FormJController@process_query_item_delete')->name('formj.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'Amendment\FormJController@process_recommend_edit')->name('formj.process.recommend');
					Route::post('/', 'Amendment\FormJController@process_recommend_update')->name('formj.process.recommend');
				});

				Route::prefix('status')->group(function () {
					Route::get('/', 'Amendment\FormJController@process_status_edit')->name('formj.process.status');
					Route::post('/', 'Amendment\FormJController@process_status_update')->name('formj.process.status');
				});

				Route::prefix('delay')->group(function () {
					Route::get('/', 'Amendment\FormJController@process_delay_edit')->name('formj.process.delay');
					Route::post('/', 'Amendment\FormJController@process_delay_update')->name('formj.process.delay');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'Amendment\FormJController@process_result')->name('formj.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'Amendment\FormJController@process_result_approve_edit')->name('formj.process.result.approve');
						Route::post('/', 'Amendment\FormJController@process_result_approve_update')->name('formj.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'Amendment\FormJController@process_result_reject_edit')->name('formj.process.result.reject');
						Route::post('/', 'Amendment\FormJController@process_result_reject_update')->name('formj.process.result.reject');
					});
				});
			});
		});
	});

	Route::prefix('formk')->group(function () {
		Route::get('/', 'Amendment\FormKController@index')->name('formk');
		Route::get('list', 'Amendment\FormKController@list')->name('formk.list');
		Route::get('query', 'Amendment\FormKController@query')->name('formk.query');

		Route::post('add/{constitution_id}', 'Amendment\FormKController@add')->name('formk.add');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Amendment\FormKController@edit')->name('formk.form');
			Route::post('/', 'Amendment\FormKController@submit')->name('formk.form');
			Route::get('praecipe', 'Amendment\FormKController@praecipe')->name('formk.praecipe');
			Route::get('download', 'Amendment\FormKController@formk3_download')->name('download.formk3');

			Route::prefix('constitution')->group(function () {
				Route::get('/', 'Amendment\FormKController@editor')->name('formk.editor');
				Route::get('download', 'Amendment\FormKController@constitution_download')->name('download.constitution');
			});

			Route::prefix('k1')->group(function () {
				Route::get('/', 'Amendment\FormKController@k1_index')->name('formk.k1');
			Route::get('download', 'Amendment\FormKController@download')->name('download.formk');
			});

			Route::prefix('k2')->group(function () {
				Route::get('/', 'Amendment\FormKController@k2_index')->name('formk.k2');
				Route::get('list', 'Amendment\FormKController@k2_list')->name('formk.k2.list');
			Route::get('download', 'Amendment\FormKController@formk2_download')->name('download.formk2');

				Route::prefix('{formu_id}')->group(function () {
					Route::get('/', 'Amendment\FormKController@k2_edit')->name('formk.k2.form');
					Route::delete('/', 'Amendment\FormKController@k2_delete')->name('formk.k2.form');

					Route::prefix('examiner')->group(function () {
						Route::get('/', 'Amendment\FormKController@examiner_index')->name('formk.k2.form.examiner');
						Route::post('/', 'Amendment\FormKController@examiner_insert')->name('formk.k2.form.examiner');
						Route::get('{examiner_id}', 'Amendment\FormKController@examiner_edit')->name('formk.k2.form.examiner.form');
						Route::post('{examiner_id}', 'Amendment\FormKController@examiner_update')->name('formk.k2.form.examiner.form');
						Route::delete('{examiner_id}', 'Amendment\FormKController@examiner_delete')->name('formk.k2.form.examiner.form');
					});
				});
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'Amendment\FormKController@process_documentReceive_edit')->name('formk.process.document-receive');
					Route::post('/', 'Amendment\FormKController@process_documentReceive_update')->name('formk.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'Amendment\FormKController@process_query_edit')->name('formk.process.query');
					Route::post('/', 'Amendment\FormKController@process_query_update')->name('formk.process.query');

					Route::get('item', 'Amendment\FormKController@process_query_item_list')->name('formk.process.query.item');
					Route::post('item', 'Amendment\FormKController@process_query_item_update')->name('formk.process.query.item');
					Route::delete('item/{query_id}', 'Amendment\FormKController@process_query_item_delete')->name('formk.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'Amendment\FormKController@process_recommend_edit')->name('formk.process.recommend');
					Route::post('/', 'Amendment\FormKController@process_recommend_update')->name('formk.process.recommend');
				});

				Route::prefix('status')->group(function () {
					Route::get('/', 'Amendment\FormKController@process_status_edit')->name('formk.process.status');
					Route::post('/', 'Amendment\FormKController@process_status_update')->name('formk.process.status');
				});

				Route::prefix('delay')->group(function () {
					Route::get('/', 'Amendment\FormKController@process_delay_edit')->name('formk.process.delay');
					Route::post('/', 'Amendment\FormKController@process_delay_update')->name('formk.process.delay');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'Amendment\FormKController@process_result')->name('formk.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'Amendment\FormKController@process_result_approve_edit')->name('formk.process.result.approve');
						Route::post('/', 'Amendment\FormKController@process_result_approve_update')->name('formk.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'Amendment\FormKController@process_result_reject_edit')->name('formk.process.result.reject');
						Route::post('/', 'Amendment\FormKController@process_result_reject_update')->name('formk.process.result.reject');
					});

					Route::prefix('formk')->group(function () {
						Route::get('/', 'Amendment\FormKController@process_result_formk_edit')->name('formk.process.result.formk');
						Route::post('/', 'Amendment\FormKController@process_result_formk_update')->name('formk.process.result.formk');
					});
				});
			});
		});


	});
});

Route::prefix('incorporation')->group(function () {
	Route::prefix('federation')->group(function () {
		Route::get('/', 'Incorporation\Federation\FormPQController@index')->name('federation');
		Route::get('list', 'Incorporation\Federation\FormPQController@list')->name('federation.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Incorporation\Federation\FormPQController@edit')->name('federation.form');
			Route::post('submit', 'Incorporation\Federation\FormPQController@submit')->name('federation.submit');

			Route::prefix('formp')->group(function () {
				Route::get('/', 'Incorporation\Federation\FormPController@index')->name('formp');
				Route::get('download', 'Incorporation\Federation\FormPController@download')->name('download.formp');
			});

			Route::prefix('formq')->group(function () {
				Route::get('/', 'Incorporation\Federation\FormQController@index')->name('formq');
				Route::get('download', 'Incorporation\Federation\FormQController@download')->name('download.formq');

				Route::prefix('member')->group(function () {
					Route::get('/', 'Incorporation\Federation\FormQController@member_index')->name('formq.member');
					Route::post('/', 'Incorporation\Federation\FormQController@member_insert')->name('formq.member');
					Route::get('{member_id}', 'Incorporation\Federation\FormQController@member_edit')->name('formq.member.form');
					Route::post('{member_id}', 'Incorporation\Federation\FormQController@member_update')->name('formq.member.form');
					Route::delete('{member_id}', 'Incorporation\Federation\FormQController@member_delete')->name('formq.member.form');
				});
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'Incorporation\Federation\FormPQController@process_documentReceive_edit')->name('federation.process.document-receive');
					Route::post('/', 'Incorporation\Federation\FormPQController@process_documentReceive_update')->name('federation.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'Incorporation\Federation\FormPQController@process_query_edit')->name('federation.process.query');
					Route::post('/', 'Incorporation\Federation\FormPQController@process_query_update')->name('federation.process.query');

					Route::get('item', 'Incorporation\Federation\FormPQController@process_query_item_list')->name('federation.process.query.item');
					Route::post('item', 'Incorporation\Federation\FormPQController@process_query_item_update')->name('federation.process.query.item');
					Route::delete('item/{query_id}', 'Incorporation\Federation\FormPQController@process_query_item_delete')->name('federation.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'Incorporation\Federation\FormPQController@process_recommend_edit')->name('federation.process.recommend');
					Route::post('/', 'Incorporation\Federation\FormPQController@process_recommend_update')->name('federation.process.recommend');
				});

				Route::prefix('delay')->group(function () {
					Route::get('/', 'Incorporation\Federation\FormPQController@process_delay_edit')->name('federation.process.delay');
					Route::post('/', 'Incorporation\Federation\FormPQController@process_delay_update')->name('federation.process.delay');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'Incorporation\Federation\FormPQController@process_result')->name('federation.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'Incorporation\Federation\FormPQController@process_result_approve_edit')->name('federation.process.result.approve');
						Route::post('/', 'Incorporation\Federation\FormPQController@process_result_approve_update')->name('federation.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'Incorporation\Federation\FormPQController@process_result_reject_edit')->name('federation.process.result.reject');
						Route::post('/', 'Incorporation\Federation\FormPQController@process_result_reject_update')->name('federation.process.result.reject');
					});
				});
			});
		});

	});

	Route::prefix('consultation')->group(function () {
		Route::prefix('formww')->group(function () {
			Route::get('/', 'Incorporation\Consultation\FormWWController@index')->name('formww');
			Route::get('list', 'Incorporation\Consultation\FormWWController@list')->name('formww.list');

			Route::prefix('{id}')->group(function () {
				Route::get('/', 'Incorporation\Consultation\FormWWController@edit')->name('formww.form');
				Route::post('/', 'Incorporation\Consultation\FormWWController@submit')->name('formww.form');
				Route::get('download', 'Incorporation\Consultation\FormWWController@download')->name('download.formww');

				Route::prefix('purpose')->group(function(){
					Route::get('/', 'Incorporation\Consultation\FormWWController@purpose_index')->name('formww.form.purpose');
					Route::post('/', 'Incorporation\Consultation\FormWWController@purpose_insert')->name('formww.form.purpose');
					Route::delete('{purpose_id}', 'Incorporation\Consultation\FormWWController@purpose_delete')->name('formww.form.purpose.item');
				});

				Route::prefix('officer')->group(function () {
					Route::get('/', 'Incorporation\Consultation\FormWWController@officer_index')->name('formww.officer');
					Route::post('/', 'Incorporation\Consultation\FormWWController@officer_insert')->name('formww.officer');
					Route::get('{officer_id}', 'Incorporation\Consultation\FormWWController@officer_edit')->name('formww.officer.form');
					Route::post('{officer_id}', 'Incorporation\Consultation\FormWWController@officer_update')->name('formww.officer.form');
					Route::delete('{officer_id}', 'Incorporation\Consultation\FormWWController@officer_delete')->name('formww.officer.form');
				});

				Route::prefix('process')->group(function () {
					Route::prefix('query')->group(function () {
						Route::get('/', 'Incorporation\Consultation\FormWWController@process_query_edit')->name('formww.process.query');
						Route::post('/', 'Incorporation\Consultation\FormWWController@process_query_update')->name('formww.process.query');

						Route::get('item', 'Incorporation\Consultation\FormWWController@process_query_item_list')->name('formww.process.query.item');
						Route::post('item', 'Incorporation\Consultation\FormWWController@process_query_item_update')->name('formww.process.query.item');
						Route::delete('item/{query_id}', 'Incorporation\Consultation\FormWWController@process_query_item_delete')->name('formww.process.query.item.delete');
					});

					Route::prefix('recommend')->group(function () {
						Route::get('/', 'Incorporation\Consultation\FormWWController@process_recommend_edit')->name('formww.process.recommend');
						Route::post('/', 'Incorporation\Consultation\FormWWController@process_recommend_update')->name('formww.process.recommend');
					});

					Route::prefix('delay')->group(function () {
						Route::get('/', 'Incorporation\Consultation\FormWWController@process_delay_edit')->name('formww.process.delay');
						Route::post('/', 'Incorporation\Consultation\FormWWController@process_delay_update')->name('formww.process.delay');
					});

					Route::prefix('result')->group(function () {
						Route::get('/', 'Incorporation\Consultation\FormWWController@process_result')->name('formww.process.result');

						Route::prefix('approve')->group(function () {
							Route::get('/', 'Incorporation\Consultation\FormWWController@process_result_approve_edit')->name('formww.process.result.approve');
							Route::post('/', 'Incorporation\Consultation\FormWWController@process_result_approve_update')->name('formww.process.result.approve');
						});

						Route::prefix('reject')->group(function () {
							Route::get('/', 'Incorporation\Consultation\FormWWController@process_result_reject_edit')->name('formww.process.result.reject');
							Route::post('/', 'Incorporation\Consultation\FormWWController@process_result_reject_update')->name('formww.process.result.reject');
						});
					});
				});
			});
		});

		Route::prefix('formw')->group(function () {
			Route::get('/', 'Incorporation\Consultation\FormWController@index')->name('formw');
			Route::get('list', 'Incorporation\Consultation\FormWController@list')->name('formw.list');

			Route::prefix('{id}')->group(function () {
				Route::get('/', 'Incorporation\Consultation\FormWController@edit')->name('formw.form');
				Route::post('/', 'Incorporation\Consultation\FormWController@submit')->name('formw.form');
				Route::get('download', 'Incorporation\Consultation\FormWController@download')->name('download.formw');

				Route::prefix('purpose')->group(function(){
					Route::get('/', 'Incorporation\Consultation\FormWController@purpose_index')->name('formw.form.purpose');
					Route::post('/', 'Incorporation\Consultation\FormWController@purpose_insert')->name('formw.form.purpose');
					Route::delete('{purpose_id}', 'Incorporation\Consultation\FormWController@purpose_delete')->name('formw.form.purpose.item');
				});

				Route::prefix('requester')->group(function(){
					Route::get('/', 'Incorporation\Consultation\FormWController@requester_index')->name('formw.form.requester');
					Route::post('/', 'Incorporation\Consultation\FormWController@requester_insert')->name('formw.form.requester');
					Route::delete('{officer_id}', 'Incorporation\Consultation\FormWController@requester_delete')->name('formw.form.requester.item');
				});

				Route::prefix('officer')->group(function () {
					Route::get('/', 'Incorporation\Consultation\FormWController@officer_index')->name('formw.officer');
					Route::post('/', 'Incorporation\Consultation\FormWController@officer_insert')->name('formw.officer');
					Route::get('{officer_id}', 'Incorporation\Consultation\FormWController@officer_edit')->name('formw.officer.form');
					Route::post('{officer_id}', 'Incorporation\Consultation\FormWController@officer_update')->name('formw.officer.form');
					Route::delete('{officer_id}', 'Incorporation\Consultation\FormWController@officer_delete')->name('formw.officer.form');
				});

				Route::prefix('process')->group(function () {
					Route::prefix('document-receive')->group(function () {
						Route::get('/', 'Incorporation\Consultation\FormWController@process_documentReceive_edit')->name('formw.process.document-receive');
						Route::post('/', 'Incorporation\Consultation\FormWController@process_documentReceive_update')->name('formw.process.document-receive');
					});

					Route::prefix('query')->group(function () {
						Route::get('/', 'Incorporation\Consultation\FormWController@process_query_edit')->name('formw.process.query');
						Route::post('/', 'Incorporation\Consultation\FormWController@process_query_update')->name('formw.process.query');

						Route::get('item', 'Incorporation\Consultation\FormWController@process_query_item_list')->name('formw.process.query.item');
						Route::post('item', 'Incorporation\Consultation\FormWController@process_query_item_update')->name('formw.process.query.item');
						Route::delete('item/{query_id}', 'Incorporation\Consultation\FormWController@process_query_item_delete')->name('formw.process.query.item.delete');
					});

					Route::prefix('recommend')->group(function () {
						Route::get('/', 'Incorporation\Consultation\FormWController@process_recommend_edit')->name('formw.process.recommend');
						Route::post('/', 'Incorporation\Consultation\FormWController@process_recommend_update')->name('formw.process.recommend');
					});

					Route::prefix('delay')->group(function () {
						Route::get('/', 'Incorporation\Consultation\FormWController@process_delay_edit')->name('formw.process.delay');
						Route::post('/', 'Incorporation\Consultation\FormWController@process_delay_update')->name('formw.process.delay');
					});

					Route::prefix('result')->group(function () {
						Route::get('/', 'Incorporation\Consultation\FormWController@process_result')->name('formw.process.result');

						Route::prefix('approve')->group(function () {
							Route::get('/', 'Incorporation\Consultation\FormWController@process_result_approve_edit')->name('formw.process.result.approve');
							Route::post('/', 'Incorporation\Consultation\FormWController@process_result_approve_update')->name('formw.process.result.approve');
						});

						Route::prefix('reject')->group(function () {
							Route::get('/', 'Incorporation\Consultation\FormWController@process_result_reject_edit')->name('formw.process.result.reject');
							Route::post('/', 'Incorporation\Consultation\FormWController@process_result_reject_update')->name('formw.process.result.reject');
						});
					});
				});
			});
		});
	});
});

Route::prefix('ectr4u')->group(function () {
	Route::get('/', 'ECTR4U\ECTR4UController@index')->name('ectr4u');
	Route::get('list', 'ECTR4U\ECTR4UController@list')->name('ectr4u.list');

	Route::prefix('{id}')->group(function () {
		Route::get('/', 'ECTR4U\ECTR4UController@edit')->name('ectr4u.form');
		Route::post('/', 'ECTR4U\ECTR4UController@submit')->name('ectr4u.form');
		Route::put('/', 'ECTR4U\ECTR4UController@complete')->name('ectr4u.form');
		Route::get('download', 'ECTR4U\ECTR4UController@download')->name('download.ectr4u');

		Route::prefix('attachment')->group(function () {
			Route::get('/', 'ECTR4U\ECTR4UController@attachment_index')->name('ectr4u.form.attachment');
			Route::post('/', 'ECTR4U\ECTR4UController@attachment_insert')->name('ectr4u.form.attachment');
			Route::delete('{attachment_id}', 'ECTR4U\ECTR4UController@attachment_delete')->name('ectr4u.form.attachment.item');
		});

		Route::prefix('process')->group(function () {
			Route::prefix('document-receive')->group(function () {
				Route::get('/', 'ECTR4U\ECTR4UController@process_documentReceive_edit')->name('ectr4u.process.document-receive');
				Route::post('/', 'ECTR4U\ECTR4UController@process_documentReceive_update')->name('ectr4u.process.document-receive');
			});

			Route::prefix('query')->group(function () {
				Route::get('/', 'ECTR4U\ECTR4UController@process_query_edit')->name('ectr4u.process.query');
				Route::post('/', 'ECTR4U\ECTR4UController@process_query_update')->name('ectr4u.process.query');

				Route::get('item', 'ECTR4U\ECTR4UController@process_query_item_list')->name('ectr4u.process.query.item');
				Route::post('item', 'ECTR4U\ECTR4UController@process_query_item_update')->name('ectr4u.process.query.item');
				Route::delete('item/{query_id}', 'ECTR4U\ECTR4UController@process_query_item_delete')->name('ectr4u.process.query.item.delete');
			});

			Route::prefix('recommend')->group(function () {
				Route::get('/', 'ECTR4U\ECTR4UController@process_recommend_edit')->name('ectr4u.process.recommend');
				Route::post('/', 'ECTR4U\ECTR4UController@process_recommend_update')->name('ectr4u.process.recommend');
			});

			Route::prefix('status')->group(function () {
				Route::get('/', 'ECTR4U\ECTR4UController@process_status_edit')->name('ectr4u.process.status');
				Route::post('/', 'ECTR4U\ECTR4UController@process_status_update')->name('ectr4u.process.status');
			});

			Route::prefix('result')->group(function () {
				Route::get('/', 'ECTR4U\ECTR4UController@process_result')->name('ectr4u.process.result');

				Route::prefix('approve')->group(function () {
					Route::get('/', 'ECTR4U\ECTR4UController@process_result_approve_edit')->name('ectr4u.process.result.approve');
					Route::post('/', 'ECTR4U\ECTR4UController@process_result_approve_update')->name('ectr4u.process.result.approve');
				});

				Route::prefix('reject')->group(function () {
					Route::get('/', 'ECTR4U\ECTR4UController@process_result_reject_edit')->name('ectr4u.process.result.reject');
					Route::post('/', 'ECTR4U\ECTR4UController@process_result_reject_update')->name('ectr4u.process.result.reject');
				});
			});
		});
	});
});

Route::prefix('affidavit')->group(function () {
	Route::get('/', 'Affidavit\AffidavitController@index')->name('affidavit');
	Route::get('list', 'Affidavit\AffidavitController@list')->name('affidavit.list');

	Route::prefix('{id}')->group(function () {
		Route::get('/', 'Affidavit\AffidavitController@edit')->name('affidavit.form');
		Route::post('/', 'Affidavit\AffidavitController@submit')->name('affidavit.form');
		Route::get('download', 'Affidavit\AffidavitController@download')->name('download.affidavit');

		Route::prefix('report')->group(function () {
			Route::get('/', 'Affidavit\AffidavitController@report')->name('affidavit.form.report');
			Route::post('/', 'Affidavit\AffidavitController@report_submit')->name('affidavit.form.report');

			Route::prefix('data')->group(function () {
				Route::get('/', 'Affidavit\AffidavitController@report_index')->name('affidavit.report');
				Route::post('/', 'Affidavit\AffidavitController@report_insert')->name('affidavit.report');
				Route::get('{report_id}', 'Affidavit\AffidavitController@report_edit')->name('affidavit.report.form');
				Route::post('{report_id}', 'Affidavit\AffidavitController@report_update')->name('affidavit.report.form');
				Route::delete('{report_id}', 'Affidavit\AffidavitController@report_delete')->name('affidavit.report.form');
			});

			Route::prefix('attachment')->group(function () {
				Route::get('/', 'Affidavit\AffidavitController@report_attachment_index')->name('affidavit.form.report.attachment');
				Route::post('/', 'Affidavit\AffidavitController@report_attachment_insert')->name('affidavit.form.report.attachment');
				Route::delete('{attachment_id}', 'Affidavit\AffidavitController@report_attachment_delete')->name('affidavit.form.report.attachment.item');
			});
		});

		Route::prefix('respondent')->group(function () {
			Route::get('/', 'Affidavit\AffidavitController@respondent_index')->name('affidavit.form.respondent');
			Route::post('/', 'Affidavit\AffidavitController@respondent_insert')->name('affidavit.form.respondent');
			Route::delete('{respondent_id}', 'Affidavit\AffidavitController@respondent_delete')->name('affidavit.form.respondent.form');
		});

		Route::prefix('attachment')->group(function () {
			Route::get('/', 'Affidavit\AffidavitController@attachment_index')->name('affidavit.form.attachment');
			Route::post('/', 'Affidavit\AffidavitController@attachment_insert')->name('affidavit.form.attachment');
			Route::delete('{attachment_id}', 'Affidavit\AffidavitController@attachment_delete')->name('affidavit.form.attachment.item');
		});

		Route::prefix('process')->group(function () {
			Route::prefix('query')->group(function () {
				Route::get('/', 'Affidavit\AffidavitController@process_query_edit')->name('affidavit.process.query');
				Route::post('/', 'Affidavit\AffidavitController@process_query_update')->name('affidavit.process.query');

				Route::get('item', 'Affidavit\AffidavitController@process_query_item_list')->name('affidavit.process.query.item');
				Route::post('item', 'Affidavit\AffidavitController@process_query_item_update')->name('affidavit.process.query.item');
				Route::delete('item/{query_id}', 'Affidavit\AffidavitController@process_query_item_delete')->name('affidavit.process.query.item.delete');
			});

			Route::prefix('status')->group(function () {
				Route::get('/', 'Affidavit\AffidavitController@process_status_edit')->name('affidavit.process.status');
				Route::post('/', 'Affidavit\AffidavitController@process_status_update')->name('affidavit.process.status');
			});
		});
	});
});

Route::prefix('eligibility-issue')->group(function () {
	Route::get('/', 'EligibilityIssue\EligibilityIssueController@index')->name('eligibility-issue');
	Route::get('list', 'EligibilityIssue\EligibilityIssueController@list')->name('eligibility-issue.list');

	Route::prefix('{id}')->group(function () {
		Route::get('/', 'EligibilityIssue\EligibilityIssueController@edit')->name('eligibility-issue.form');
		Route::post('/', 'EligibilityIssue\EligibilityIssueController@submit')->name('eligibility-issue.form');
		Route::get('download', 'EligibilityIssue\FormAController@download')->name('download.eligibility');

		Route::prefix('forma')->group(function () {
			Route::get('/', 'EligibilityIssue\FormAController@index')->name('eligibility-issue.forma');

			Route::prefix('attachment')->group(function () {
				Route::get('/', 'EligibilityIssue\FormAController@attachment_index')->name('eligibility-issue.forma.attachment');
				Route::post('/', 'EligibilityIssue\FormAController@attachment_insert')->name('eligibility-issue.forma.attachment');
				Route::delete('{attachment_id}', 'EligibilityIssue\FormAController@attachment_delete')->name('eligibility-issue.forma.attachment.item');
			});
		});

		Route::prefix('process')->group(function () {
			Route::prefix('document-receive')->group(function () {
				Route::get('/', 'EligibilityIssue\EligibilityIssueController@process_documentReceive_edit')->name('eligibility-issue.process.document-receive');
				Route::post('/', 'EligibilityIssue\EligibilityIssueController@process_documentReceive_update')->name('eligibility-issue.process.document-receive');
			});

			Route::prefix('query')->group(function () {
				Route::get('/', 'EligibilityIssue\EligibilityIssueController@process_query_edit')->name('eligibility-issue.process.query');
				Route::post('/', 'EligibilityIssue\EligibilityIssueController@process_query_update')->name('eligibility-issue.process.query');

				Route::get('item', 'EligibilityIssue\EligibilityIssueController@process_query_item_list')->name('eligibility-issue.process.query.item');
				Route::post('item', 'EligibilityIssue\EligibilityIssueController@process_query_item_update')->name('eligibility-issue.process.query.item');
				Route::delete('item/{query_id}', 'EligibilityIssue\EligibilityIssueController@process_query_item_delete')->name('eligibility-issue.process.query.item.delete');
			});

			Route::prefix('recommend')->group(function () {
				Route::get('/', 'EligibilityIssue\EligibilityIssueController@process_recommend_edit')->name('eligibility-issue.process.recommend');
				Route::post('/', 'EligibilityIssue\EligibilityIssueController@process_recommend_update')->name('eligibility-issue.process.recommend');
			});

			Route::prefix('delay')->group(function () {
				Route::get('/', 'EligibilityIssue\EligibilityIssueController@process_delay_edit')->name('eligibility-issue.process.delay');
				Route::post('/', 'EligibilityIssue\EligibilityIssueController@process_delay_update')->name('eligibility-issue.process.delay');
			});

			Route::prefix('result')->group(function () {
				Route::get('/', 'EligibilityIssue\EligibilityIssueController@process_result')->name('eligibility-issue.process.result');

				Route::prefix('approve')->group(function () {
					Route::get('/', 'EligibilityIssue\EligibilityIssueController@process_result_approve_edit')->name('eligibility-issue.process.result.approve');
					Route::post('/', 'EligibilityIssue\EligibilityIssueController@process_result_approve_update')->name('eligibility-issue.process.result.approve');
				});

				Route::prefix('reject')->group(function () {
					Route::get('/', 'EligibilityIssue\EligibilityIssueController@process_result_reject_edit')->name('eligibility-issue.process.result.reject');
					Route::post('/', 'EligibilityIssue\EligibilityIssueController@process_result_reject_update')->name('eligibility-issue.process.result.reject');
				});
			});

			Route::prefix('report')->group(function () {
				Route::get('/', 'EligibilityIssue\EligibilityIssueController@process_report')->name('eligibility-issue.process.report');

				Route::prefix('approve')->group(function () {
					Route::get('/', 'EligibilityIssue\EligibilityIssueController@process_report_approve_edit')->name('eligibility-issue.process.report.approve');
					Route::post('/', 'EligibilityIssue\EligibilityIssueController@process_report_approve_update')->name('eligibility-issue.process.report.approve');
				});

				Route::prefix('reject')->group(function () {
					Route::get('/', 'EligibilityIssue\EligibilityIssueController@process_report_reject_edit')->name('eligibility-issue.process.report.reject');
					Route::post('/', 'EligibilityIssue\EligibilityIssueController@process_report_reject_update')->name('eligibility-issue.process.report.reject');
				});
			});
		});
	});

	Route::prefix('memo3')->group(function () {
		Route::get('/', 'EligibilityIssue\Memo3Controller@index')->name('memo3');
	});
});



Route::prefix('exception')->group(function () {

	Route::prefix('pp68')->group(function () {
		Route::get('/', 'Exception\ExceptionPP68Controller@index')->name('pp68');
		Route::get('list', 'Exception\ExceptionPP68Controller@list')->name('pp68.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Exception\ExceptionPP68Controller@edit')->name('pp68.item');
			Route::post('/', 'Exception\ExceptionPP68Controller@submit')->name('pp68.item');
			Route::get('form', 'Exception\ExceptionPP68Controller@form')->name('pp68.form');
			Route::get('download', 'Exception\ExceptionPP68Controller@download')->name('download.exception_pp68');

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'Exception\ExceptionPP68Controller@process_documentReceive_edit')->name('pp68.process.document-receive');
					Route::post('/', 'Exception\ExceptionPP68Controller@process_documentReceive_update')->name('pp68.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'Exception\ExceptionPP68Controller@process_query_edit')->name('pp68.process.query');
					Route::post('/', 'Exception\ExceptionPP68Controller@process_query_update')->name('pp68.process.query');

					Route::get('item', 'Exception\ExceptionPP68Controller@process_query_item_list')->name('pp68.process.query.item');
					Route::post('item', 'Exception\ExceptionPP68Controller@process_query_item_update')->name('pp68.process.query.item');
					Route::delete('item/{query_id}', 'Exception\ExceptionPP68Controller@process_query_item_delete')->name('pp68.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'Exception\ExceptionPP68Controller@process_recommend_edit')->name('pp68.process.recommend');
					Route::post('/', 'Exception\ExceptionPP68Controller@process_recommend_update')->name('pp68.process.recommend');
				});

				Route::prefix('status')->group(function () {
					Route::get('/', 'Exception\ExceptionPP68Controller@process_status_edit')->name('pp68.process.status');
					Route::post('/', 'Exception\ExceptionPP68Controller@process_status_update')->name('pp68.process.status');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'Exception\ExceptionPP68Controller@process_result_edit')->name('pp68.process.result');
					Route::post('/', 'Exception\ExceptionPP68Controller@process_result_update')->name('pp68.process.result');
				});
			});
		});
	});

	Route::prefix('pp30')->group(function () {
		Route::get('/', 'Exception\ExceptionPP30Controller@index')->name('pp30');
		Route::get('list', 'Exception\ExceptionPP30Controller@list')->name('pp30.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Exception\ExceptionPP30Controller@edit')->name('pp30.item');
			Route::post('/', 'Exception\ExceptionPP30Controller@submit')->name('pp30.item');
			Route::get('form', 'Exception\ExceptionPP30Controller@form')->name('pp30.form');
			Route::get('download', 'Exception\ExceptionPP30Controller@download')->name('download.exception_pp30');

			Route::prefix('officer')->group(function () {
				Route::get('/', 'Exception\ExceptionPP30Controller@officer_index')->name('pp30.officer');
				Route::post('/', 'Exception\ExceptionPP30Controller@officer_insert')->name('pp30.officer');
				Route::delete('{officer_id}', 'Exception\ExceptionPP30Controller@officer_delete')->name('pp30.officer.form');
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'Exception\ExceptionPP30Controller@process_documentReceive_edit')->name('pp30.process.document-receive');
					Route::post('/', 'Exception\ExceptionPP30Controller@process_documentReceive_update')->name('pp30.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'Exception\ExceptionPP30Controller@process_query_edit')->name('pp30.process.query');
					Route::post('/', 'Exception\ExceptionPP30Controller@process_query_update')->name('pp30.process.query');

					Route::get('item', 'Exception\ExceptionPP30Controller@process_query_item_list')->name('pp30.process.query.item');
					Route::post('item', 'Exception\ExceptionPP30Controller@process_query_item_update')->name('pp30.process.query.item');
					Route::delete('item/{query_id}', 'Exception\ExceptionPP30Controller@process_query_item_delete')->name('pp30.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'Exception\ExceptionPP30Controller@process_recommend_edit')->name('pp30.process.recommend');
					Route::post('/', 'Exception\ExceptionPP30Controller@process_recommend_update')->name('pp30.process.recommend');
				});

				Route::prefix('status')->group(function () {
					Route::get('/', 'Exception\ExceptionPP30Controller@process_status_edit')->name('pp30.process.status');
					Route::post('/', 'Exception\ExceptionPP30Controller@process_status_update')->name('pp30.process.status');
				});

				Route::prefix('minister')->group(function () {
					Route::get('/', 'Exception\ExceptionPP30Controller@process_minister_edit')->name('pp30.process.minister');
					Route::post('/', 'Exception\ExceptionPP30Controller@process_minister_update')->name('pp30.process.minister');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'Exception\ExceptionPP30Controller@process_result_edit')->name('pp30.process.result');
					Route::post('/', 'Exception\ExceptionPP30Controller@process_result_update')->name('pp30.process.result');
				});
			});
		});
	});
});

Route::prefix('change-officer')->group(function () {

	Route::prefix('formlu')->group(function () {
		Route::get('/', 'ChangeOfficer\LUController@index')->name('formlu');
		Route::get('list', 'ChangeOfficer\LUController@list')->name('formlu.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'ChangeOfficer\LUController@edit')->name('formlu.form');
			Route::post('/', 'ChangeOfficer\LUController@submit')->name('formlu.form');
			Route::get('praecipe', 'ChangeOfficer\LUController@praecipe')->name('formlu.praecipe');

			Route::prefix('forml')->group(function () {
				Route::get('/', 'ChangeOfficer\LUController@forml')->name('formlu.forml');
				Route::get('download', 'ChangeOfficer\LUController@download')->name('download.formlu.forml');

				Route::prefix('leaving')->group(function () {
					Route::get('/', 'ChangeOfficer\LUController@leaving_index')->name('formlu.leaving');
					Route::post('/', 'ChangeOfficer\LUController@leaving_insert')->name('formlu.leaving');
					Route::get('{leaving_id}', 'ChangeOfficer\LUController@leaving_edit')->name('formlu.leaving.form');
					Route::post('{leaving_id}', 'ChangeOfficer\LUController@leaving_update')->name('formlu.leaving.form');
					Route::delete('{leaving_id}', 'ChangeOfficer\LUController@leaving_delete')->name('formlu.leaving.form');
				});

				Route::prefix('officer')->group(function () {
					Route::get('/', 'ChangeOfficer\LUController@officer_index')->name('formlu.officer');
					Route::post('/', 'ChangeOfficer\LUController@officer_insert')->name('formlu.officer');
					Route::get('{officer_id}', 'ChangeOfficer\LUController@officer_edit')->name('formlu.officer.form');
					Route::post('{officer_id}', 'ChangeOfficer\LUController@officer_update')->name('formlu.officer.form');
					Route::delete('{officer_id}', 'ChangeOfficer\LUController@officer_delete')->name('formlu.officer.form');
				});
			});

			Route::prefix('formu')->group(function () {
				Route::get('/', 'ChangeOfficer\LUController@formu')->name('formlu.formu');
				Route::get('download', 'ChangeOfficer\LUController@formu_download')->name('download.formlu.formu');

				Route::prefix('examiner')->group(function () {
					Route::get('/', 'ChangeOfficer\LUController@examiner_index')->name('formlu.examiner');
					Route::post('/', 'ChangeOfficer\LUController@examiner_insert')->name('formlu.examiner');
					Route::get('{examiner_id}', 'ChangeOfficer\LUController@examiner_edit')->name('formlu.examiner.form');
					Route::post('{examiner_id}', 'ChangeOfficer\LUController@examiner_update')->name('formlu.examiner.form');
					Route::delete('{examiner_id}', 'ChangeOfficer\LUController@examiner_delete')->name('formlu.examiner.form');
				});

				Route::prefix('arbitrator')->group(function () {
					Route::get('/', 'ChangeOfficer\LUController@arbitrator_index')->name('formlu.arbitrator');
					Route::post('/', 'ChangeOfficer\LUController@arbitrator_insert')->name('formlu.arbitrator');
					Route::get('{arbitrator_id}', 'ChangeOfficer\LUController@arbitrator_edit')->name('formlu.arbitrator.form');
					Route::post('{arbitrator_id}', 'ChangeOfficer\LUController@arbitrator_update')->name('formlu.arbitrator.form');
					Route::delete('{arbitrator_id}', 'ChangeOfficer\LUController@arbitrator_delete')->name('formlu.arbitrator.form');
				});

				Route::prefix('trustee')->group(function () {
					Route::get('/', 'ChangeOfficer\LUController@trustee_index')->name('formlu.trustee');
					Route::post('/', 'ChangeOfficer\LUController@trustee_insert')->name('formlu.trustee');
					Route::get('{trustee_id}', 'ChangeOfficer\LUController@trustee_edit')->name('formlu.trustee.form');
					Route::post('{trustee_id}', 'ChangeOfficer\LUController@trustee_update')->name('formlu.trustee.form');
					Route::delete('{trustee_id}', 'ChangeOfficer\LUController@trustee_delete')->name('formlu.trustee.form');
				});

			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'ChangeOfficer\LUController@process_documentReceive_edit')->name('formlu.process.document-receive');
					Route::post('/', 'ChangeOfficer\LUController@process_documentReceive_update')->name('formlu.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'ChangeOfficer\LUController@process_query_edit')->name('formlu.process.query');
					Route::post('/', 'ChangeOfficer\LUController@process_query_update')->name('formlu.process.query');

					Route::get('item', 'ChangeOfficer\LUController@process_query_item_list')->name('formlu.process.query.item');
					Route::post('item', 'ChangeOfficer\LUController@process_query_item_update')->name('formlu.process.query.item');
					Route::delete('item/{query_id}', 'ChangeOfficer\LUController@process_query_item_delete')->name('formlu.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'ChangeOfficer\LUController@process_recommend_edit')->name('formlu.process.recommend');
					Route::post('/', 'ChangeOfficer\LUController@process_recommend_update')->name('formlu.process.recommend');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'ChangeOfficer\LUController@process_result')->name('formlu.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'ChangeOfficer\LUController@process_result_approve_edit')->name('formlu.process.result.approve');
						Route::post('/', 'ChangeOfficer\LUController@process_result_approve_update')->name('formlu.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'ChangeOfficer\LUController@process_result_reject_edit')->name('formlu.process.result.reject');
						Route::post('/', 'ChangeOfficer\LUController@process_result_reject_update')->name('formlu.process.result.reject');
					});
				});
			});
		});
	});

	Route::prefix('forml1')->group(function () {
		Route::get('/', 'ChangeOfficer\L1Controller@index')->name('forml1');
		Route::get('list', 'ChangeOfficer\L1Controller@list')->name('forml1.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'ChangeOfficer\L1Controller@edit')->name('forml1.item');
			Route::post('/', 'ChangeOfficer\L1Controller@submit')->name('forml1.item');
			Route::get('form', 'ChangeOfficer\L1Controller@forml1')->name('forml1.form');
			Route::get('praecipe', 'ChangeOfficer\L1Controller@praecipe')->name('forml1.praecipe');
			Route::get('download', 'ChangeOfficer\L1Controller@download')->name('download.forml1');

			Route::prefix('resign')->group(function () {
				Route::get('/', 'ChangeOfficer\L1Controller@resign_index')->name('forml1.resign');
				Route::post('/', 'ChangeOfficer\L1Controller@resign_insert')->name('forml1.resign');
				Route::get('{resign_id}', 'ChangeOfficer\L1Controller@resign_edit')->name('forml1.resign.form');
				Route::post('{resign_id}', 'ChangeOfficer\L1Controller@resign_update')->name('forml1.resign.form');
				Route::delete('{resign_id}', 'ChangeOfficer\L1Controller@resign_delete')->name('forml1.resign.form');
			});

			Route::prefix('worker')->group(function () {
				Route::get('/', 'ChangeOfficer\L1Controller@worker_index')->name('forml1.worker');
				Route::post('/', 'ChangeOfficer\L1Controller@worker_insert')->name('forml1.worker');
				Route::get('{worker_id}', 'ChangeOfficer\L1Controller@worker_edit')->name('forml1.worker.form');
				Route::post('{worker_id}', 'ChangeOfficer\L1Controller@worker_update')->name('forml1.worker.form');
				Route::delete('{worker_id}', 'ChangeOfficer\L1Controller@worker_delete')->name('forml1.worker.form');
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'ChangeOfficer\L1Controller@process_documentReceive_edit')->name('forml1.process.document-receive');
					Route::post('/', 'ChangeOfficer\L1Controller@process_documentReceive_update')->name('forml1.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'ChangeOfficer\L1Controller@process_query_edit')->name('forml1.process.query');
					Route::post('/', 'ChangeOfficer\L1Controller@process_query_update')->name('forml1.process.query');

					Route::get('item', 'ChangeOfficer\L1Controller@process_query_item_list')->name('forml1.process.query.item');
					Route::post('item', 'ChangeOfficer\L1Controller@process_query_item_update')->name('forml1.process.query.item');
					Route::delete('item/{query_id}', 'ChangeOfficer\L1Controller@process_query_item_delete')->name('forml1.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'ChangeOfficer\L1Controller@process_recommend_edit')->name('forml1.process.recommend');
					Route::post('/', 'ChangeOfficer\L1Controller@process_recommend_update')->name('forml1.process.recommend');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'ChangeOfficer\L1Controller@process_result')->name('forml1.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'ChangeOfficer\L1Controller@process_result_approve_edit')->name('forml1.process.result.approve');
						Route::post('/', 'ChangeOfficer\L1Controller@process_result_approve_update')->name('forml1.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'ChangeOfficer\L1Controller@process_result_reject_edit')->name('forml1.process.result.reject');
						Route::post('/', 'ChangeOfficer\L1Controller@process_result_reject_update')->name('forml1.process.result.reject');
					});
				});
			});
		});
	});

	Route::prefix('forml')->group(function () {
		Route::get('/', 'ChangeOfficer\LController@index')->name('forml');
		Route::get('list', 'ChangeOfficer\LController@list')->name('forml.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'ChangeOfficer\LController@edit')->name('forml.item');
			Route::post('/', 'ChangeOfficer\LController@submit')->name('forml.item');
			Route::get('form', 'ChangeOfficer\LController@forml')->name('forml.form');
			Route::get('praecipe', 'ChangeOfficer\LController@praecipe')->name('forml.praecipe');
			Route::get('download', 'ChangeOfficer\LController@download')->name('download.forml');

			Route::prefix('leaving')->group(function () {
				Route::get('/', 'ChangeOfficer\LController@leaving_index')->name('forml.leaving');
				Route::post('/', 'ChangeOfficer\LController@leaving_insert')->name('forml.leaving');
				Route::get('{leaving_id}', 'ChangeOfficer\LController@leaving_edit')->name('forml.leaving.form');
				Route::post('{leaving_id}', 'ChangeOfficer\LController@leaving_update')->name('forml.leaving.form');
				Route::delete('{leaving_id}', 'ChangeOfficer\LController@leaving_delete')->name('forml.leaving.form');
			});

			Route::prefix('officer')->group(function () {
				Route::get('/', 'ChangeOfficer\LController@officer_index')->name('forml.officer');
				Route::post('/', 'ChangeOfficer\LController@officer_insert')->name('forml.officer');
				Route::get('{officer_id}', 'ChangeOfficer\LController@officer_edit')->name('forml.officer.form');
				Route::post('{officer_id}', 'ChangeOfficer\LController@officer_update')->name('forml.officer.form');
				Route::delete('{officer_id}', 'ChangeOfficer\LController@officer_delete')->name('forml.officer.form');
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'ChangeOfficer\LController@process_documentReceive_edit')->name('forml.process.document-receive');
					Route::post('/', 'ChangeOfficer\LController@process_documentReceive_update')->name('forml.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'ChangeOfficer\LController@process_query_edit')->name('forml.process.query');
					Route::post('/', 'ChangeOfficer\LController@process_query_update')->name('forml.process.query');

					Route::get('item', 'ChangeOfficer\LController@process_query_item_list')->name('forml.process.query.item');
					Route::post('item', 'ChangeOfficer\LController@process_query_item_update')->name('forml.process.query.item');
					Route::delete('item/{query_id}', 'ChangeOfficer\LController@process_query_item_delete')->name('forml.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'ChangeOfficer\LController@process_recommend_edit')->name('forml.process.recommend');
					Route::post('/', 'ChangeOfficer\LController@process_recommend_update')->name('forml.process.recommend');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'ChangeOfficer\LController@process_result')->name('forml.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'ChangeOfficer\LController@process_result_approve_edit')->name('forml.process.result.approve');
						Route::post('/', 'ChangeOfficer\LController@process_result_approve_update')->name('forml.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'ChangeOfficer\LController@process_result_reject_edit')->name('forml.process.result.reject');
						Route::post('/', 'ChangeOfficer\LController@process_result_reject_update')->name('forml.process.result.reject');
					});
				});
			});
		});
	});
});

Route::prefix('dissolution-cancellation')->group(function () {

	Route::prefix('dissolution')->group(function () {
		Route::get('/', 'DissolutionCancellation\Dissolution\DissolutionController@index')->name('dissolution');
		Route::get('list', 'DissolutionCancellation\Dissolution\DissolutionController@list')->name('dissolution.list');

		Route::prefix('{id}')->group(function() {
			Route::get('/', 'DissolutionCancellation\Dissolution\DissolutionController@edit')->name('dissolution.form');
			Route::post('/', 'DissolutionCancellation\Dissolution\DissolutionController@submit')->name('dissolution.form');
			Route::get('praecipe', 'DissolutionCancellation\Dissolution\DissolutionController@praecipe')->name('dissolution.praecipe');

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'DissolutionCancellation\Dissolution\DissolutionController@process_documentReceive_edit')->name('dissolution.process.document-receive');
					Route::post('/', 'DissolutionCancellation\Dissolution\DissolutionController@process_documentReceive_update')->name('dissolution.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'DissolutionCancellation\Dissolution\DissolutionController@process_query_edit')->name('dissolution.process.query');
					Route::post('/', 'DissolutionCancellation\Dissolution\DissolutionController@process_query_update')->name('dissolution.process.query');

					Route::get('item', 'DissolutionCancellation\Dissolution\DissolutionController@process_query_item_list')->name('dissolution.process.query.item');
					Route::post('item', 'DissolutionCancellation\Dissolution\DissolutionController@process_query_item_update')->name('dissolution.process.query.item');
					Route::delete('item/{query_id}', 'DissolutionCancellation\Dissolution\DissolutionController@process_query_item_delete')->name('dissolution.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'DissolutionCancellation\Dissolution\DissolutionController@process_recommend_edit')->name('dissolution.process.recommend');
					Route::post('/', 'DissolutionCancellation\Dissolution\DissolutionController@process_recommend_update')->name('dissolution.process.recommend');
				});

				Route::prefix('delay')->group(function () {
					Route::get('/', 'DissolutionCancellation\Dissolution\DissolutionController@process_delay_edit')->name('dissolution.process.delay');
					Route::post('/', 'DissolutionCancellation\Dissolution\DissolutionController@process_delay_update')->name('dissolution.process.delay');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'DissolutionCancellation\Dissolution\DissolutionController@process_result')->name('dissolution.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'DissolutionCancellation\Dissolution\DissolutionController@process_result_approve_edit')->name('dissolution.process.result.approve');
						Route::post('/', 'DissolutionCancellation\Dissolution\DissolutionController@process_result_approve_update')->name('dissolution.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'DissolutionCancellation\Dissolution\DissolutionController@process_result_reject_edit')->name('dissolution.process.result.reject');
						Route::post('/', 'DissolutionCancellation\Dissolution\DissolutionController@process_result_reject_update')->name('dissolution.process.result.reject');
					});
				});
			});

			Route::prefix('formi')->group(function () {
				Route::get('/', 'DissolutionCancellation\Dissolution\FormIController@index')->name('formi');
				Route::get('download', 'DissolutionCancellation\Dissolution\FormIController@download')->name('download.formi');

				Route::prefix('member')->group(function () {
					Route::get('/', 'DissolutionCancellation\Dissolution\FormIController@member_index')->name('formi.member');
					Route::post('/', 'DissolutionCancellation\Dissolution\FormIController@member_insert')->name('formi.member');
					Route::get('{member_id}', 'DissolutionCancellation\Dissolution\FormIController@member_edit')->name('formi.member.form');
					Route::post('{member_id}', 'DissolutionCancellation\Dissolution\FormIController@member_update')->name('formi.member.form');
					Route::delete('{member_id}', 'DissolutionCancellation\Dissolution\FormIController@member_delete')->name('formi.member.form');
				});
			});

			Route::prefix('forme')->group(function () {
			    Route::get('/', 'DissolutionCancellation\Dissolution\FormEController@index')->name('forme');
			    Route::get('download', 'DissolutionCancellation\Dissolution\FormEController@download')->name('download.forme');

				Route::prefix('member')->group(function () {
					Route::get('/', 'DissolutionCancellation\Dissolution\FormEController@member_index')->name('forme.member');
					Route::post('/', 'DissolutionCancellation\Dissolution\FormEController@member_insert')->name('forme.member');
					Route::get('{member_id}', 'DissolutionCancellation\Dissolution\FormEController@member_edit')->name('forme.member.form');
					Route::post('{member_id}', 'DissolutionCancellation\Dissolution\FormEController@member_update')->name('forme.member.form');
					Route::delete('{member_id}', 'DissolutionCancellation\Dissolution\FormEController@member_delete')->name('forme.member.form');
				});
			});

			Route::prefix('formu')->group(function () {
			    Route::get('/', 'DissolutionCancellation\Dissolution\FormUController@index')->name('formu');
			    Route::get('download', 'DissolutionCancellation\Dissolution\FormUController@download')->name('download.formieu.formu');

				Route::prefix('examiner')->group(function () {
					Route::get('/', 'DissolutionCancellation\Dissolution\FormUController@examiner_index')->name('formu.examiner');
					Route::post('/', 'DissolutionCancellation\Dissolution\FormUController@examiner_insert')->name('formu.examiner');
					Route::get('{examiner_id}', 'DissolutionCancellation\Dissolution\FormUController@examiner_edit')->name('formu.examiner.form');
					Route::post('{examiner_id}', 'DissolutionCancellation\Dissolution\FormUController@examiner_update')->name('formu.examiner.form');
					Route::delete('{examiner_id}', 'DissolutionCancellation\Dissolution\FormUController@examiner_delete')->name('formu.examiner.form');
				});
			});
		});
	});

	Route::prefix('cancellation')->group(function () {
		Route::get('/', 'DissolutionCancellation\Cancellation\CancellationController@index')->name('cancellation');
		Route::get('list', 'DissolutionCancellation\Cancellation\CancellationController@list')->name('cancellation.list');

		Route::prefix('{id}')->group(function() {
			Route::get('/', 'DissolutionCancellation\Cancellation\CancellationController@edit')->name('cancellation.form');
			Route::post('/', 'DissolutionCancellation\Cancellation\CancellationController@submit')->name('cancellation.form');
			Route::get('download', 'DissolutionCancellation\Cancellation\CancellationController@download')->name('download.formf');

			Route::prefix('attachment')->group(function () {
				Route::get('/', 'DissolutionCancellation\Cancellation\CancellationController@attachment_index')->name('cancellation.form.attachment');
				Route::post('/', 'DissolutionCancellation\Cancellation\CancellationController@attachment_insert')->name('cancellation.form.attachment');
				Route::delete('{attachment_id}', 'DissolutionCancellation\Cancellation\CancellationController@attachment_delete')->name('cancellation.form.attachment.item');
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'DissolutionCancellation\Cancellation\CancellationController@process_documentReceive_edit')->name('cancellation.process.document-receive');
					Route::post('/', 'DissolutionCancellation\Cancellation\CancellationController@process_documentReceive_update')->name('cancellation.process.document-receive');
				});

				Route::prefix('response-receive')->group(function () {
					Route::get('/', 'DissolutionCancellation\Cancellation\CancellationController@process_responseReceive_edit')->name('cancellation.process.response-receive');
					Route::post('/', 'DissolutionCancellation\Cancellation\CancellationController@process_responseReceive_update')->name('cancellation.process.response-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'DissolutionCancellation\Cancellation\CancellationController@process_query_edit')->name('cancellation.process.query');
					Route::post('/', 'DissolutionCancellation\Cancellation\CancellationController@process_query_update')->name('cancellation.process.query');

					Route::get('item', 'DissolutionCancellation\Cancellation\CancellationController@process_query_item_list')->name('cancellation.process.query.item');
					Route::post('item', 'DissolutionCancellation\Cancellation\CancellationController@process_query_item_update')->name('cancellation.process.query.item');
					Route::delete('item/{query_id}', 'DissolutionCancellation\Cancellation\CancellationController@process_query_item_delete')->name('cancellation.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'DissolutionCancellation\Cancellation\CancellationController@process_recommend_edit')->name('cancellation.process.recommend');
					Route::post('/', 'DissolutionCancellation\Cancellation\CancellationController@process_recommend_update')->name('cancellation.process.recommend');
				});

				Route::prefix('delay')->group(function () {
					Route::get('/', 'DissolutionCancellation\Cancellation\CancellationController@process_delay_edit')->name('cancellation.process.delay');
					Route::post('/', 'DissolutionCancellation\Cancellation\CancellationController@process_delay_update')->name('cancellation.process.delay');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'DissolutionCancellation\Cancellation\CancellationController@process_result')->name('cancellation.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'DissolutionCancellation\Cancellation\CancellationController@process_result_approve_edit')->name('cancellation.process.result.approve');
						Route::post('/', 'DissolutionCancellation\Cancellation\CancellationController@process_result_approve_update')->name('cancellation.process.result.approve');
					});
				});
			});
		});
	});
});

Route::prefix('finance')->group(function () {

	Route::prefix('levy')->group(function () {
		Route::get('/', 'Finance\Levy\LevyController@index')->name('levy');
		Route::get('list', 'Finance\Levy\LevyController@list')->name('levy.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Finance\Levy\LevyController@edit')->name('levy.form');
			Route::post('/', 'Finance\Levy\LevyController@submit')->name('levy.form');
			Route::get('download', 'Finance\Levy\LevyController@download')->name('download.levy');

			Route::get('plv1', 'Finance\Levy\LevyController@plv1_index')->name('levy.plv1');

			Route::prefix('formu')->group(function () {
				Route::get('/', 'Finance\Levy\LevyController@formu_index')->name('levy.formu');				
			Route::get('download', 'Finance\Levy\LevyController@formu_download')->name('download.levy.formu');

				Route::prefix('examiner')->group(function () {
					Route::get('/', 'Finance\Levy\LevyController@examiner_index')->name('levy.formu.examiner');
					Route::post('/', 'Finance\Levy\LevyController@examiner_insert')->name('levy.formu.examiner');
					Route::get('{examiner_id}', 'Finance\Levy\LevyController@examiner_edit')->name('levy.formu.examiner.form');
					Route::post('{examiner_id}', 'Finance\Levy\LevyController@examiner_update')->name('levy.formu.examiner.form');
					Route::delete('{examiner_id}', 'Finance\Levy\LevyController@examiner_delete')->name('levy.formu.examiner.form');
				});
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'Finance\Levy\LevyController@process_documentReceive_edit')->name('levy.process.document-receive');
					Route::post('/', 'Finance\Levy\LevyController@process_documentReceive_update')->name('levy.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'Finance\Levy\LevyController@process_query_edit')->name('levy.process.query');
					Route::post('/', 'Finance\Levy\LevyController@process_query_update')->name('levy.process.query');

					Route::get('item', 'Finance\Levy\LevyController@process_query_item_list')->name('levy.process.query.item');
					Route::post('item', 'Finance\Levy\LevyController@process_query_item_update')->name('levy.process.query.item');
					Route::delete('item/{query_id}', 'Finance\Levy\LevyController@process_query_item_delete')->name('levy.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'Finance\Levy\LevyController@process_recommend_edit')->name('levy.process.recommend');
					Route::post('/', 'Finance\Levy\LevyController@process_recommend_update')->name('levy.process.recommend');
				});

				Route::prefix('status')->group(function () {
					Route::get('/', 'Finance\Levy\LevyController@process_status_edit')->name('levy.process.status');
					Route::post('/', 'Finance\Levy\LevyController@process_status_update')->name('levy.process.status');
				});

				Route::prefix('delay')->group(function () {
					Route::get('/', 'Finance\Levy\LevyController@process_delay_edit')->name('levy.process.delay');
					Route::post('/', 'Finance\Levy\LevyController@process_delay_update')->name('levy.process.delay');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'Finance\Levy\LevyController@process_result')->name('levy.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'Finance\Levy\LevyController@process_result_approve_edit')->name('levy.process.result.approve');
						Route::post('/', 'Finance\Levy\LevyController@process_result_approve_update')->name('levy.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'Finance\Levy\LevyController@process_result_reject_edit')->name('levy.process.result.reject');
						Route::post('/', 'Finance\Levy\LevyController@process_result_reject_update')->name('levy.process.result.reject');
					});
				});
			});
		});
	});

	Route::prefix('insurance')->group(function () {
		Route::get('/', 'Finance\Insurance\InsuranceController@index')->name('insurance');
		Route::get('list', 'Finance\Insurance\InsuranceController@list')->name('insurance.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Finance\Insurance\InsuranceController@edit')->name('insurance.form');
			Route::post('/', 'Finance\Insurance\InsuranceController@submit')->name('insurance.form');
			Route::get('download', 'Finance\Insurance\InsuranceController@download')->name('download.insurance');

			Route::prefix('ins1')->group(function () {
				Route::get('/', 'Finance\Insurance\InsuranceController@ins1_index')->name('insurance.ins1');
			});

			Route::prefix('formu')->group(function () {
				Route::get('/', 'Finance\Insurance\InsuranceController@formu_index')->name('insurance.formu');				
				Route::get('download', 'Finance\Insurance\InsuranceController@formu_download')->name('download.insurance.formu');

				Route::prefix('examiner')->group(function () {
					Route::get('/', 'Finance\Insurance\InsuranceController@examiner_index')->name('insurance.formu.form.examiner');
					Route::post('/', 'Finance\Insurance\InsuranceController@examiner_insert')->name('insurance.formu.form.examiner');
					Route::get('{examiner_id}', 'Finance\Insurance\InsuranceController@examiner_edit')->name('insurance.formu.form.examiner.form');
					Route::post('{examiner_id}', 'Finance\Insurance\InsuranceController@examiner_update')->name('insurance.formu.form.examiner.form');
					Route::delete('{examiner_id}', 'Finance\Insurance\InsuranceController@examiner_delete')->name('insurance.formu.form.examiner.form');
				});
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'Finance\Insurance\InsuranceController@process_documentReceive_edit')->name('insurance.process.document-receive');
					Route::post('/', 'Finance\Insurance\InsuranceController@process_documentReceive_update')->name('insurance.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'Finance\Insurance\InsuranceController@process_query_edit')->name('insurance.process.query');
					Route::post('/', 'Finance\Insurance\InsuranceController@process_query_update')->name('insurance.process.query');

					Route::get('item', 'Finance\Insurance\InsuranceController@process_query_item_list')->name('insurance.process.query.item');
					Route::post('item', 'Finance\Insurance\InsuranceController@process_query_item_update')->name('insurance.process.query.item');
					Route::delete('item/{query_id}', 'Finance\Insurance\InsuranceController@process_query_item_delete')->name('insurance.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'Finance\Insurance\InsuranceController@process_recommend_edit')->name('insurance.process.recommend');
					Route::post('/', 'Finance\Insurance\InsuranceController@process_recommend_update')->name('insurance.process.recommend');
				});

				Route::prefix('status')->group(function () {
					Route::get('/', 'Finance\Insurance\InsuranceController@process_status_edit')->name('insurance.process.status');
					Route::post('/', 'Finance\Insurance\InsuranceController@process_status_update')->name('insurance.process.status');
				});

				Route::prefix('delay')->group(function () {
					Route::get('/', 'Finance\Insurance\InsuranceController@process_delay_edit')->name('insurance.process.delay');
					Route::post('/', 'Finance\Insurance\InsuranceController@process_delay_update')->name('insurance.process.delay');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'Finance\Insurance\InsuranceController@process_result')->name('insurance.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'Finance\Insurance\InsuranceController@process_result_approve_edit')->name('insurance.process.result.approve');
						Route::post('/', 'Finance\Insurance\InsuranceController@process_result_approve_update')->name('insurance.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'Finance\Insurance\InsuranceController@process_result_reject_edit')->name('insurance.process.result.reject');
						Route::post('/', 'Finance\Insurance\InsuranceController@process_result_reject_update')->name('insurance.process.result.reject');
					});
				});
			});
		});
	});

	Route::prefix('fund')->group(function () {
		Route::get('/', 'Finance\Fund\FundController@index')->name('fund');
		Route::get('list', 'Finance\Fund\FundController@list')->name('fund.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Finance\Fund\FundController@edit')->name('fund.form');
			Route::post('/', 'Finance\Fund\FundController@submit')->name('fund.form');
			Route::get('id1', 'Finance\Fund\FundController@id1_index')->name('fund.id1');
			Route::get('download', 'Finance\Fund\FundController@download')->name('download.fund');

			Route::prefix('participant')->group(function () {
				Route::get('/', 'Finance\Fund\FundController@participant_index')->name('fund.id1.participant');
				Route::post('/', 'Finance\Fund\FundController@participant_insert')->name('fund.id1.participant');
				Route::get('{participant_id}', 'Finance\Fund\FundController@participant_edit')->name('fund.id1.participant.form');
				Route::post('{participant_id}', 'Finance\Fund\FundController@participant_update')->name('fund.id1.participant.form');
				Route::delete('{participant_id}', 'Finance\Fund\FundController@participant_delete')->name('fund.id1.participant.form');
			});

			Route::prefix('collection')->group(function () {
				Route::get('/', 'Finance\Fund\FundController@collection_index')->name('fund.id1.collection');
				Route::post('/', 'Finance\Fund\FundController@collection_insert')->name('fund.id1.collection');
				Route::get('{collection_id}', 'Finance\Fund\FundController@collection_view')->name('fund.id1.collection.form');
				Route::delete('{collection_id}', 'Finance\Fund\FundController@collection_delete')->name('fund.id1.collection.form');
			});

			Route::prefix('bank')->group(function () {
				Route::get('/', 'Finance\Fund\FundController@bank_index')->name('fund.id1.bank');
				Route::post('/', 'Finance\Fund\FundController@bank_insert')->name('fund.id1.bank');
				Route::get('{bank_id}', 'Finance\Fund\FundController@bank_edit')->name('fund.id1.bank.form');
				Route::post('{bank_id}', 'Finance\Fund\FundController@bank_update')->name('fund.id1.bank.form');
				Route::delete('{bank_id}', 'Finance\Fund\FundController@bank_delete')->name('fund.id1.bank.form');
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'Finance\Fund\FundController@process_documentReceive_edit')->name('fund.process.document-receive');
					Route::post('/', 'Finance\Fund\FundController@process_documentReceive_update')->name('fund.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'Finance\Fund\FundController@process_query_edit')->name('fund.process.query');
					Route::post('/', 'Finance\Fund\FundController@process_query_update')->name('fund.process.query');

					Route::get('item', 'Finance\Fund\FundController@process_query_item_list')->name('fund.process.query.item');
					Route::post('item', 'Finance\Fund\FundController@process_query_item_update')->name('fund.process.query.item');
					Route::delete('item/{query_id}', 'Finance\Fund\FundController@process_query_item_delete')->name('fund.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'Finance\Fund\FundController@process_recommend_edit')->name('fund.process.recommend');
					Route::post('/', 'Finance\Fund\FundController@process_recommend_update')->name('fund.process.recommend');
				});

				Route::prefix('status')->group(function () {
					Route::get('/', 'Finance\Fund\FundController@process_status_edit')->name('fund.process.status');
					Route::post('/', 'Finance\Fund\FundController@process_status_update')->name('fund.process.status');
				});

				Route::prefix('delay')->group(function () {
					Route::get('/', 'Finance\Fund\FundController@process_delay_edit')->name('fund.process.delay');
					Route::post('/', 'Finance\Fund\FundController@process_delay_update')->name('fund.process.delay');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'Finance\Fund\FundController@process_result')->name('fund.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'Finance\Fund\FundController@process_result_approve_edit')->name('fund.process.result.approve');
						Route::post('/', 'Finance\Fund\FundController@process_result_approve_update')->name('fund.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'Finance\Fund\FundController@process_result_reject_edit')->name('fund.process.result.reject');
						Route::post('/', 'Finance\Fund\FundController@process_result_reject_update')->name('fund.process.result.reject');
					});
				});
			});
		});
	});

	Route::prefix('statement')->group(function () {

		Route::prefix('ks')->group(function () {
			Route::get('/', 'Finance\Statement\FormNController@index')->name('statement.ks');
			Route::get('list', 'Finance\Statement\FormNController@list')->name('statement.ks.list');

			Route::prefix('{id}')->group(function () {
				Route::get('/', 'Finance\Statement\FormNController@edit')->name('statement.ks.form');
				Route::post('/', 'Finance\Statement\FormNController@submit')->name('statement.ks.form');

				Route::prefix('formn')->group(function () {
					Route::get('/', 'Finance\Statement\FormNController@formn_index')->name('formn');
					Route::get('download', 'Finance\Statement\FormNController@download')->name('download.formn');

					Route::prefix('salary')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@salary_index')->name('formn.salary');
						Route::post('/', 'Finance\Statement\FormNController@salary_insert')->name('formn.salary');
						Route::get('{salary_id}', 'Finance\Statement\FormNController@salary_edit')->name('formn.salary.form');
						Route::post('{salary_id}', 'Finance\Statement\FormNController@salary_update')->name('formn.salary.form');
						Route::delete('{salary_id}', 'Finance\Statement\FormNController@salary_delete')->name('formn.salary.form');
					});

					Route::prefix('expenditure')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@expenditure_index')->name('formn.expenditure');
						Route::post('/', 'Finance\Statement\FormNController@expenditure_insert')->name('formn.expenditure');
						Route::get('{expenditure_id}', 'Finance\Statement\FormNController@expenditure_edit')->name('formn.expenditure.form');
						Route::post('{expenditure_id}', 'Finance\Statement\FormNController@expenditure_update')->name('formn.expenditure.form');
						Route::delete('{expenditure_id}', 'Finance\Statement\FormNController@expenditure_delete')->name('formn.expenditure.form');
					});

					Route::prefix('debt')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@debt_index')->name('formn.debt');
						Route::post('/', 'Finance\Statement\FormNController@debt_insert')->name('formn.debt');
						Route::get('{debt_id}', 'Finance\Statement\FormNController@debt_edit')->name('formn.debt.form');
						Route::post('{debt_id}', 'Finance\Statement\FormNController@debt_update')->name('formn.debt.form');
						Route::delete('{debt_id}', 'Finance\Statement\FormNController@debt_delete')->name('formn.debt.form');
					});

					Route::prefix('cash')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@cash_index')->name('formn.cash');
						Route::post('/', 'Finance\Statement\FormNController@cash_insert')->name('formn.cash');
						Route::get('{cash_id}', 'Finance\Statement\FormNController@cash_edit')->name('formn.cash.form');
						Route::post('{cash_id}', 'Finance\Statement\FormNController@cash_update')->name('formn.cash.form');
						Route::delete('{cash_id}', 'Finance\Statement\FormNController@cash_delete')->name('formn.cash.form');
					});

					Route::prefix('bank')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@bank_index')->name('formn.bank');
						Route::post('/', 'Finance\Statement\FormNController@bank_insert')->name('formn.bank');
						Route::get('{bank_id}', 'Finance\Statement\FormNController@bank_edit')->name('formn.bank.form');
						Route::post('{bank_id}', 'Finance\Statement\FormNController@bank_update')->name('formn.bank.form');
						Route::delete('{bank_id}', 'Finance\Statement\FormNController@bank_delete')->name('formn.bank.form');
					});

					Route::prefix('loan')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@loan_index')->name('formn.loan');
						Route::post('/', 'Finance\Statement\FormNController@loan_insert')->name('formn.loan');
						Route::get('{loan_id}', 'Finance\Statement\FormNController@loan_edit')->name('formn.loan.form');
						Route::post('{loan_id}', 'Finance\Statement\FormNController@loan_update')->name('formn.loan.form');
						Route::delete('{loan_id}', 'Finance\Statement\FormNController@loan_delete')->name('formn.loan.form');
					});

					Route::prefix('lent')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@lent_index')->name('formn.lent');
						Route::post('/', 'Finance\Statement\FormNController@lent_insert')->name('formn.lent');
						Route::get('{lent_id}', 'Finance\Statement\FormNController@lent_edit')->name('formn.lent.form');
						Route::post('{lent_id}', 'Finance\Statement\FormNController@lent_update')->name('formn.lent.form');
						Route::delete('{lent_id}', 'Finance\Statement\FormNController@lent_delete')->name('formn.lent.form');
					});

					Route::prefix('liability')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@liability_index')->name('formn.liability');
						Route::post('/', 'Finance\Statement\FormNController@liability_insert')->name('formn.liability');
						Route::get('{liability_id}', 'Finance\Statement\FormNController@liability_edit')->name('formn.liability.form');
						Route::post('{liability_id}', 'Finance\Statement\FormNController@liability_update')->name('formn.liability.form');
						Route::delete('{liability_id}', 'Finance\Statement\FormNController@liability_delete')->name('formn.liability.form');
					});

					Route::prefix('leaving')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@leaving_index')->name('formn.leaving');
						Route::post('/', 'Finance\Statement\FormNController@leaving_insert')->name('formn.leaving');
						Route::get('{leaving_id}', 'Finance\Statement\FormNController@leaving_edit')->name('formn.leaving.form');
						Route::post('{leaving_id}', 'Finance\Statement\FormNController@leaving_update')->name('formn.leaving.form');
						Route::delete('{leaving_id}', 'Finance\Statement\FormNController@leaving_delete')->name('formn.leaving.form');
					});

					Route::prefix('appointed')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@appointed_index')->name('formn.appointed');
						Route::post('/', 'Finance\Statement\FormNController@appointed_insert')->name('formn.appointed');
						Route::get('{appointed_id}', 'Finance\Statement\FormNController@appointed_edit')->name('formn.appointed.form');
						Route::post('{appointed_id}', 'Finance\Statement\FormNController@appointed_update')->name('formn.appointed.form');
						Route::delete('{appointed_id}', 'Finance\Statement\FormNController@appointed_delete')->name('formn.appointed.form');
					});

					Route::prefix('security')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@security_index')->name('formn.security');
						Route::post('/', 'Finance\Statement\FormNController@security_insert')->name('formn.security');
						Route::get('{security_id}', 'Finance\Statement\FormNController@security_edit')->name('formn.security.form');
						Route::post('{security_id}', 'Finance\Statement\FormNController@security_update')->name('formn.security.form');
						Route::delete('{security_id}', 'Finance\Statement\FormNController@security_delete')->name('formn.security.form');
					});
				});

				Route::prefix('attachment')->group(function () {
					Route::get('/', 'Finance\Statement\FormNController@attachment_index')->name('statement.ks.form.attachment');
					Route::post('/', 'Finance\Statement\FormNController@attachment_insert')->name('statement.ks.form.attachment');
					Route::delete('{attachment_id}', 'Finance\Statement\FormNController@attachment_delete')->name('statement.ks.form.attachment.item');
				});

				Route::prefix('process')->group(function () {
					Route::prefix('document-receive')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@process_documentReceive_edit')->name('statement.ks.process.document-receive');
						Route::post('/', 'Finance\Statement\FormNController@process_documentReceive_update')->name('statement.ks.process.document-receive');
					});

					Route::prefix('query')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@process_query_edit')->name('statement.ks.process.query');
						Route::post('/', 'Finance\Statement\FormNController@process_query_update')->name('statement.ks.process.query');

						Route::get('item', 'Finance\Statement\FormNController@process_query_item_list')->name('statement.ks.process.query.item');
						Route::post('item', 'Finance\Statement\FormNController@process_query_item_update')->name('statement.ks.process.query.item');
						Route::delete('item/{query_id}', 'Finance\Statement\FormNController@process_query_item_delete')->name('statement.ks.process.query.item.delete');
					});

					Route::prefix('recommend')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@process_recommend_edit')->name('statement.ks.process.recommend');
						Route::post('/', 'Finance\Statement\FormNController@process_recommend_update')->name('statement.ks.process.recommend');
					});

					Route::prefix('status')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@process_status_edit')->name('statement.ks.process.status');
						Route::post('/', 'Finance\Statement\FormNController@process_status_update')->name('statement.ks.process.status');
					});

					Route::prefix('delay')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@process_delay_edit')->name('statement.ks.process.delay');
						Route::post('/', 'Finance\Statement\FormNController@process_delay_update')->name('statement.ks.process.delay');
					});

					Route::prefix('result')->group(function () {
						Route::get('/', 'Finance\Statement\FormNController@process_result')->name('statement.ks.process.result');

						Route::prefix('approve')->group(function () {
							Route::get('/', 'Finance\Statement\FormNController@process_result_approve_edit')->name('statement.ks.process.result.approve');
							Route::post('/', 'Finance\Statement\FormNController@process_result_approve_update')->name('statement.ks.process.result.approve');
						});

						Route::prefix('reject')->group(function () {
							Route::get('/', 'Finance\Statement\FormNController@process_result_reject_edit')->name('statement.ks.process.result.reject');
							Route::post('/', 'Finance\Statement\FormNController@process_result_reject_update')->name('statement.ks.process.result.reject');
						});
					});
				});

			});
		});

		Route::prefix('auditor')->group(function () {
			Route::get('/', 'Finance\Statement\FormJL1Controller@index')->name('statement.audit');
			Route::get('list', 'Finance\Statement\FormJL1Controller@list')->name('statement.audit.list');

			Route::prefix('{id}')->group(function () {
				Route::get('/', 'Finance\Statement\FormJL1Controller@edit')->name('statement.audit.form');
				Route::post('/', 'Finance\Statement\FormJL1Controller@submit')->name('statement.audit.form');

				Route::prefix('formjl1')->group(function () {
					Route::get('/', 'Finance\Statement\FormJL1Controller@formjl1_index')->name('formjl1');
					Route::get('download', 'Finance\Statement\FormJL1Controller@download')->name('download.formjl1');

					Route::prefix('formn')->group(function () {
						Route::get('/', 'Finance\Statement\FormJL1Controller@formn_index')->name('formjl1.formn');
						Route::post('/', 'Finance\Statement\FormJL1Controller@formn_insert')->name('formjl1.formn');
						Route::get('{formn_id}', 'Finance\Statement\FormJL1Controller@formn_edit')->name('formjl1.formn.form');
						Route::post('{formn_id}', 'Finance\Statement\FormJL1Controller@formn_update')->name('formjl1.formn.form');
						Route::delete('{formn_id}', 'Finance\Statement\FormJL1Controller@formn_delete')->name('formjl1.formn.form');
					});
				});

				Route::prefix('process')->group(function () {
					Route::prefix('document-receive')->group(function () {
						Route::get('/', 'Finance\Statement\FormJL1Controller@process_documentReceive_edit')->name('statement.audit.process.document-receive');
						Route::post('/', 'Finance\Statement\FormJL1Controller@process_documentReceive_update')->name('statement.audit.process.document-receive');
					});

					Route::prefix('query')->group(function () {
						Route::get('/', 'Finance\Statement\FormJL1Controller@process_query_edit')->name('statement.audit.process.query');
						Route::post('/', 'Finance\Statement\FormJL1Controller@process_query_update')->name('statement.audit.process.query');

						Route::get('item', 'Finance\Statement\FormJL1Controller@process_query_item_list')->name('statement.audit.process.query.item');
						Route::post('item', 'Finance\Statement\FormJL1Controller@process_query_item_update')->name('statement.audit.process.query.item');
						Route::delete('item/{query_id}', 'Finance\Statement\FormJL1Controller@process_query_item_delete')->name('statement.audit.process.query.item.delete');
					});

					Route::prefix('recommend')->group(function () {
						Route::get('/', 'Finance\Statement\FormJL1Controller@process_recommend_edit')->name('statement.audit.process.recommend');
						Route::post('/', 'Finance\Statement\FormJL1Controller@process_recommend_update')->name('statement.audit.process.recommend');
					});

					Route::prefix('delay')->group(function () {
						Route::get('/', 'Finance\Statement\FormJL1Controller@process_delay_edit')->name('statement.audit.process.delay');
						Route::post('/', 'Finance\Statement\FormJL1Controller@process_delay_update')->name('statement.audit.process.delay');
					});

					Route::prefix('pw_result')->group(function () {
						Route::get('/', 'Finance\Statement\FormJL1Controller@process_pw_result')->name('statement.audit.process.pw_result');
						Route::post('approve', 'Finance\Statement\FormJL1Controller@process_pw_result_approve')->name('statement.audit.process.result.pw_approve');
						Route::post('reject', 'Finance\Statement\FormJL1Controller@process_pw_result_reject')->name('statement.audit.process.result.pw_reject');
					});

					Route::prefix('result')->group(function () {
						Route::get('/', 'Finance\Statement\FormJL1Controller@process_result')->name('statement.audit.process.result');

						Route::prefix('approve')->group(function () {
							Route::get('/', 'Finance\Statement\FormJL1Controller@process_result_approve_edit')->name('statement.audit.process.result.approve');
							Route::post('/', 'Finance\Statement\FormJL1Controller@process_result_approve_update')->name('statement.audit.process.result.approve');
						});

						Route::prefix('reject')->group(function () {
							Route::get('/', 'Finance\Statement\FormJL1Controller@process_result_reject_edit')->name('statement.audit.process.result.reject');
							Route::post('/', 'Finance\Statement\FormJL1Controller@process_result_reject_update')->name('statement.audit.process.result.reject');
						});
					});
				});
			});
		});

	});
});

Route::prefix('enforcement')->group(function () {

	Route::get('/', 'Enforcement\EnforcementController@list')->name('enforcement');
	Route::post('/', 'Enforcement\EnforcementController@insert')->name('enforcement');

	Route::prefix('{id}')->group(function () {
		Route::get('/', 'Enforcement\EnforcementController@index')->name('enforcement.form');
		Route::post('/', 'Enforcement\EnforcementController@submit')->name('enforcement.form');
		Route::get('download', 'Enforcement\EnforcementController@download')->name('download.enforcement');

		Route::prefix('pbp2')->group(function () {
			Route::get('/', 'Enforcement\PBP2Controller@index')->name('pbp2');
			Route::get('download', 'Enforcement\PBP2Controller@download')->name('download.pbp2');
			Route::get('a1_download', 'Enforcement\PBP2Controller@a1_download')->name('download.pbp2.a1');
			Route::get('a2_download', 'Enforcement\PBP2Controller@a2_download')->name('download.pbp2.a2');
			Route::get('a3_download', 'Enforcement\PBP2Controller@a3_download')->name('download.pbp2.a3');
			Route::get('a4_download', 'Enforcement\PBP2Controller@a4_download')->name('download.pbp2.a4');
			Route::get('a5_download/{branch_id}', 'Enforcement\PBP2Controller@a5_download')->name('download.pbp2.a5');
			Route::get('a6_download', 'Enforcement\PBP2Controller@a6_download')->name('download.pbp2.a6');
			Route::get('b1_download', 'Enforcement\PBP2Controller@b1_download')->name('download.pbp2.b1');
			Route::get('c1_download', 'Enforcement\PBP2Controller@c1_download')->name('download.pbp2.c1');
			Route::get('d1_download', 'Enforcement\PBP2Controller@d1_download')->name('download.pbp2.d1');

			Route::prefix('internal')->group(function () {
				Route::get('/', 'Enforcement\PBP2Controller@internal_index')->name('pbp2.internal');
				Route::post('/', 'Enforcement\PBP2Controller@internal_insert')->name('pbp2.internal');
				Route::get('{internal_id}', 'Enforcement\PBP2Controller@internal_edit')->name('pbp2.internal.form');
				Route::post('{internal_id}', 'Enforcement\PBP2Controller@internal_update')->name('pbp2.internal.form');
				Route::delete('{internal_id}', 'Enforcement\PBP2Controller@internal_delete')->name('pbp2.internal.form');
			});

			Route::prefix('external')->group(function () {
				Route::get('/', 'Enforcement\PBP2Controller@external_index')->name('pbp2.external');
				Route::post('/', 'Enforcement\PBP2Controller@external_insert')->name('pbp2.external');
				Route::get('{external_id}', 'Enforcement\PBP2Controller@external_edit')->name('pbp2.external.form');
				Route::post('{external_id}', 'Enforcement\PBP2Controller@external_update')->name('pbp2.external.form');
				Route::delete('{external_id}', 'Enforcement\PBP2Controller@external_delete')->name('pbp2.external.form');
			});

			Route::prefix('meeting')->group(function () {
				Route::get('/', 'Enforcement\PBP2Controller@meeting_index')->name('pbp2.meeting');
				Route::post('/', 'Enforcement\PBP2Controller@meeting_insert')->name('pbp2.meeting');
				Route::get('{meeting_id}', 'Enforcement\PBP2Controller@meeting_edit')->name('pbp2.meeting.form');
				Route::post('{meeting_id}', 'Enforcement\PBP2Controller@meeting_update')->name('pbp2.meeting.form');
				Route::delete('{meeting_id}', 'Enforcement\PBP2Controller@meeting_delete')->name('pbp2.meeting.form');
			});

			Route::prefix('notice')->group(function () {
				Route::get('/', 'Enforcement\PBP2Controller@notice_index')->name('pbp2.notice');
				Route::post('/', 'Enforcement\PBP2Controller@notice_insert')->name('pbp2.notice');
				Route::get('{notice_id}', 'Enforcement\PBP2Controller@notice_edit')->name('pbp2.notice.form');
				Route::post('{notice_id}', 'Enforcement\PBP2Controller@notice_update')->name('pbp2.notice.form');
				Route::delete('{notice_id}', 'Enforcement\PBP2Controller@notice_delete')->name('pbp2.notice.form');
			});

			Route::prefix('account')->group(function () {
				Route::get('/', 'Enforcement\PBP2Controller@account_index')->name('pbp2.account');
				Route::post('/', 'Enforcement\PBP2Controller@account_insert')->name('pbp2.account');
				Route::get('{account_id}', 'Enforcement\PBP2Controller@account_edit')->name('pbp2.account.form');
				Route::post('{account_id}', 'Enforcement\PBP2Controller@account_update')->name('pbp2.account.form');
				Route::delete('{account_id}', 'Enforcement\PBP2Controller@account_delete')->name('pbp2.account.form');
			});

			Route::prefix('fd-account')->group(function () {
				Route::get('/', 'Enforcement\PBP2Controller@fd_account_index')->name('pbp2.fd-account');
				Route::post('/', 'Enforcement\PBP2Controller@fd_account_insert')->name('pbp2.fd-account');
				Route::get('{fdaccount_id}', 'Enforcement\PBP2Controller@fd_account_edit')->name('pbp2.fd-account.form');
				Route::post('{fdaccount_id}', 'Enforcement\PBP2Controller@fd_account_update')->name('pbp2.fd-account.form');
				Route::delete('{fdaccount_id}', 'Enforcement\PBP2Controller@fd_account_delete')->name('pbp2.fd-account.form');
			});

			Route::prefix('record')->group(function () {
				Route::get('/', 'Enforcement\PBP2Controller@record_index')->name('pbp2.record');
				Route::post('/', 'Enforcement\PBP2Controller@record_insert')->name('pbp2.record');
				Route::get('{record_id}', 'Enforcement\PBP2Controller@record_edit')->name('pbp2.record.form');
				Route::post('{record_id}', 'Enforcement\PBP2Controller@record_update')->name('pbp2.record.form');
				Route::delete('{record_id}', 'Enforcement\PBP2Controller@record_delete')->name('pbp2.record.form');
			});

			Route::prefix('auditor')->group(function () {
				Route::get('/', 'Enforcement\PBP2Controller@auditor_index')->name('pbp2.auditor');
				Route::post('/', 'Enforcement\PBP2Controller@auditor_insert')->name('pbp2.auditor');
				Route::get('{auditor_id}', 'Enforcement\PBP2Controller@auditor_edit')->name('pbp2.auditor.form');
				Route::post('{auditor_id}', 'Enforcement\PBP2Controller@auditor_update')->name('pbp2.auditor.form');
				Route::delete('{auditor_id}', 'Enforcement\PBP2Controller@auditor_delete')->name('pbp2.auditor.form');
			});

			Route::prefix('a1')->group(function () {
				Route::get('/', 'Enforcement\AttachmentPBP2Controller@a1_index')->name('pbp2.a1');
				Route::post('/', 'Enforcement\AttachmentPBP2Controller@a1_insert')->name('pbp2.a1');
				Route::get('{a1_id}', 'Enforcement\AttachmentPBP2Controller@a1_edit')->name('pbp2.a1.form');
				Route::post('{a1_id}', 'Enforcement\AttachmentPBP2Controller@a1_update')->name('pbp2.a1.form');
				Route::delete('{a1_id}', 'Enforcement\AttachmentPBP2Controller@a1_delete')->name('pbp2.a1.form');
			});

			Route::prefix('a2')->group(function () {
				Route::get('/', 'Enforcement\AttachmentPBP2Controller@a2_index')->name('pbp2.a2');
				Route::post('/', 'Enforcement\AttachmentPBP2Controller@a2_insert')->name('pbp2.a2');
				Route::get('{a2_id}', 'Enforcement\AttachmentPBP2Controller@a2_edit')->name('pbp2.a2.form');
				Route::post('{a2_id}', 'Enforcement\AttachmentPBP2Controller@a2_update')->name('pbp2.a2.form');
				Route::delete('{a2_id}', 'Enforcement\AttachmentPBP2Controller@a2_delete')->name('pbp2.a2.form');
			});

			Route::prefix('a3')->group(function () {
				Route::get('/', 'Enforcement\AttachmentPBP2Controller@a3_index')->name('pbp2.a3');
				Route::get('list', 'Enforcement\AttachmentPBP2Controller@a3_list')->name('pbp2.a3.list');

				Route::prefix('{a3_id}')->group(function () {
					Route::get('/', 'Enforcement\AttachmentPBP2Controller@a3_edit')->name('pbp2.a3.form');
					Route::delete('/', 'Enforcement\AttachmentPBP2Controller@a3_delete')->name('pbp2.a3.form');

					Route::prefix('allowance')->group(function () {
						Route::get('/', 'Enforcement\AttachmentPBP2Controller@allowance_index')->name('pbp2.a3.allowance');
						Route::post('/', 'Enforcement\AttachmentPBP2Controller@allowance_insert')->name('pbp2.a3.allowance');
						Route::get('{allowance_id}', 'Enforcement\AttachmentPBP2Controller@allowance_edit')->name('pbp2.a3.allowance.form');
						Route::post('{allowance_id}', 'Enforcement\AttachmentPBP2Controller@allowance_update')->name('pbp2.a3.allowance.form');
						Route::delete('{allowance_id}', 'Enforcement\AttachmentPBP2Controller@allowance_delete')->name('pbp2.a3.allowance.form');
					});

					Route::prefix('incentive')->group(function () {
						Route::get('/', 'Enforcement\AttachmentPBP2Controller@incentive_index')->name('pbp2.a3.incentive');
						Route::post('/', 'Enforcement\AttachmentPBP2Controller@incentive_insert')->name('pbp2.a3.incentive');
						Route::get('{incentive_id}', 'Enforcement\AttachmentPBP2Controller@incentive_edit')->name('pbp2.a3.incentive.form');
						Route::post('{incentive_id}', 'Enforcement\AttachmentPBP2Controller@incentive_update')->name('pbp2.a3.incentive.form');
						Route::delete('{incentive_id}', 'Enforcement\AttachmentPBP2Controller@incentive_delete')->name('pbp2.a3.incentive.form');
					});
				});
			});

			Route::prefix('a4')->group(function () {
				Route::get('/', 'Enforcement\AttachmentPBP2Controller@a4_index')->name('pbp2.a4');
				Route::get('list', 'Enforcement\AttachmentPBP2Controller@a4_list')->name('pbp2.a4.list');

				Route::prefix('{a4_id}')->group(function () {
					Route::get('/', 'Enforcement\AttachmentPBP2Controller@a4_edit')->name('pbp2.a4.form');
					Route::delete('/', 'Enforcement\AttachmentPBP2Controller@a4_delete')->name('pbp2.a4.form');

					Route::prefix('allowance')->group(function () {
						Route::get('/', 'Enforcement\AttachmentPBP2Controller@a4_allowance_index')->name('pbp2.a4.allowance');
						Route::post('/', 'Enforcement\AttachmentPBP2Controller@a4_allowance_insert')->name('pbp2.a4.allowance');
						Route::get('{allowance_id}', 'Enforcement\AttachmentPBP2Controller@a4_allowance_edit')->name('pbp2.a4.allowance.form');
						Route::post('{allowance_id}', 'Enforcement\AttachmentPBP2Controller@a4_allowance_update')->name('pbp2.a4.allowance.form');
						Route::delete('{allowance_id}', 'Enforcement\AttachmentPBP2Controller@a4_allowance_delete')->name('pbp2.a4.allowance.form');
					});

					Route::prefix('incentive')->group(function () {
						Route::get('/', 'Enforcement\AttachmentPBP2Controller@a4_incentive_index')->name('pbp2.a4.incentive');
						Route::post('/', 'Enforcement\AttachmentPBP2Controller@a4_incentive_insert')->name('pbp2.a4.incentive');
						Route::get('{incentive_id}', 'Enforcement\AttachmentPBP2Controller@a4_incentive_edit')->name('pbp2.a4.incentive.form');
						Route::post('{incentive_id}', 'Enforcement\AttachmentPBP2Controller@a4_incentive_update')->name('pbp2.a4.incentive.form');
						Route::delete('{incentive_id}', 'Enforcement\AttachmentPBP2Controller@a4_incentive_delete')->name('pbp2.a4.incentive.form');
					});
				});
			});

			Route::prefix('a5')->group(function () {
				Route::get('/', 'Enforcement\AttachmentPBP2Controller@a5_index')->name('pbp2.a5');
				Route::prefix('{a5_id}')->group(function () {
					Route::get('/', 'Enforcement\AttachmentPBP2Controller@a5_edit')->name('pbp2.a5.form');
				});
			});

			Route::prefix('a6')->group(function () {
				Route::get('/', 'Enforcement\AttachmentPBP2Controller@a6_index')->name('pbp2.a6');
				Route::post('/', 'Enforcement\AttachmentPBP2Controller@a6_insert')->name('pbp2.a6');
				Route::get('{a6_id}', 'Enforcement\AttachmentPBP2Controller@a6_edit')->name('pbp2.a6.form');
				Route::post('{a6_id}', 'Enforcement\AttachmentPBP2Controller@a6_update')->name('pbp2.a6.form');
				Route::delete('{a6_id}', 'Enforcement\AttachmentPBP2Controller@a6_delete')->name('pbp2.a6.form');
			});

			Route::prefix('b1')->group(function () {
				Route::get('/', 'Enforcement\AttachmentPBP2Controller@b1_index')->name('pbp2.b1');
				Route::post('/', 'Enforcement\AttachmentPBP2Controller@b1_insert')->name('pbp2.b1');
				Route::get('{b1_id}', 'Enforcement\AttachmentPBP2Controller@b1_edit')->name('pbp2.b1.form');
				Route::post('{b1_id}', 'Enforcement\AttachmentPBP2Controller@b1_update')->name('pbp2.b1.form');
				Route::delete('{b1_id}', 'Enforcement\AttachmentPBP2Controller@b1_delete')->name('pbp2.b1.form');
			});

			Route::prefix('c1')->group(function () {
				Route::get('/', 'Enforcement\AttachmentPBP2Controller@c1_index')->name('pbp2.c1');
			});

			Route::prefix('d1')->group(function () {
				Route::get('/', 'Enforcement\AttachmentPBP2Controller@d1_index')->name('pbp2.d1');

				Route::prefix('examiner')->group(function () {
					Route::get('/', 'Enforcement\AttachmentPBP2Controller@examiner_index')->name('pbp2.d1.examiner');
					Route::post('/', 'Enforcement\AttachmentPBP2Controller@examiner_insert')->name('pbp2.d1.examiner');
					Route::get('{examiner_id}', 'Enforcement\AttachmentPBP2Controller@examiner_edit')->name('pbp2.d1.examiner.form');
					Route::post('{examiner_id}', 'Enforcement\AttachmentPBP2Controller@examiner_update')->name('pbp2.d1.examiner.form');
					Route::delete('{examiner_id}', 'Enforcement\AttachmentPBP2Controller@examiner_delete')->name('pbp2.d1.examiner.form');
				});

				Route::prefix('trustee')->group(function () {
					Route::get('/', 'Enforcement\AttachmentPBP2Controller@trustee_index')->name('pbp2.d1.trustee');
					Route::post('/', 'Enforcement\AttachmentPBP2Controller@trustee_insert')->name('pbp2.d1.trustee');
					Route::get('{trustee_id}', 'Enforcement\AttachmentPBP2Controller@trustee_edit')->name('pbp2.d1.trustee.form');
					Route::post('{trustee_id}', 'Enforcement\AttachmentPBP2Controller@trustee_update')->name('pbp2.d1.trustee.form');
					Route::delete('{trustee_id}', 'Enforcement\AttachmentPBP2Controller@trustee_delete')->name('pbp2.d1.trustee.form');
				});

				Route::prefix('arbitrator')->group(function () {
					Route::get('/', 'Enforcement\AttachmentPBP2Controller@arbitrator_index')->name('pbp2.d1.arbitrator');
					Route::post('/', 'Enforcement\AttachmentPBP2Controller@arbitrator_insert')->name('pbp2.d1.arbitrator');
					Route::get('{arbitrator_id}', 'Enforcement\AttachmentPBP2Controller@arbitrator_edit')->name('pbp2.d1.arbitrator.form');
					Route::post('{arbitrator_id}', 'Enforcement\AttachmentPBP2Controller@arbitrator_update')->name('pbp2.d1.arbitrator.form');
					Route::delete('{arbitrator_id}', 'Enforcement\AttachmentPBP2Controller@arbitrator_delete')->name('pbp2.d1.arbitrator.form');
				});
			});

		});

		Route::prefix('process')->group(function () {
			Route::prefix('document-receive')->group(function () {
				Route::get('/', 'Enforcement\EnforcementController@process_documentReceive_edit')->name('enforcement.process.document-receive');
				Route::post('/', 'Enforcement\EnforcementController@process_documentReceive_update')->name('enforcement.process.document-receive');
			});

			Route::prefix('query')->group(function () {
				Route::get('/', 'Enforcement\EnforcementController@process_query_edit')->name('enforcement.process.query');
				Route::post('/', 'Enforcement\EnforcementController@process_query_update')->name('enforcement.process.query');

				Route::get('item', 'Enforcement\EnforcementController@process_query_item_list')->name('enforcement.process.query.item');
				Route::post('item', 'Enforcement\EnforcementController@process_query_item_update')->name('enforcement.process.query.item');
				Route::delete('item/{query_id}', 'Enforcement\EnforcementController@process_query_item_delete')->name('enforcement.process.query.item.delete');
			});

			Route::prefix('recommend')->group(function () {
				Route::get('/', 'Enforcement\EnforcementController@process_recommend_edit')->name('enforcement.process.recommend');
				Route::post('/', 'Enforcement\EnforcementController@process_recommend_update')->name('enforcement.process.recommend');
			});

			Route::prefix('status')->group(function () {
				Route::get('/', 'Enforcement\EnforcementController@process_status_edit')->name('enforcement.process.status');
				Route::post('/', 'Enforcement\EnforcementController@process_status_update')->name('enforcement.process.status');
			});

			Route::prefix('delay')->group(function () {
				Route::get('/', 'Enforcement\EnforcementController@process_delay_edit')->name('enforcement.process.delay');
				Route::post('/', 'Enforcement\EnforcementController@process_delay_update')->name('enforcement.process.delay');
			});

			Route::prefix('result')->group(function () {
				Route::get('/', 'Enforcement\EnforcementController@process_result')->name('enforcement.process.result');

				Route::prefix('kpks')->group(function () {
					Route::get('/', 'Enforcement\EnforcementController@process_result_edit')->name('enforcement.process.result-kpks');
					Route::post('/', 'Enforcement\EnforcementController@process_result_update')->name('enforcement.process.result-kpks');
				});
			});

			Route::prefix('result-pw')->group(function () {
				Route::get('/', 'Enforcement\EnforcementController@process_result_pw')->name('enforcement.process.result-pw');

				Route::prefix('approve')->group(function () {
					Route::get('/', 'Enforcement\EnforcementController@process_result_pw_approve_edit')->name('enforcement.process.result-pw.approve');
					Route::post('/', 'Enforcement\EnforcementController@process_result_pw_approve_update')->name('enforcement.process.result-pw.approve');
				});

				Route::prefix('reject')->group(function () {
					Route::get('/', 'Enforcement\EnforcementController@process_result_pw_reject_edit')->name('enforcement.process.result-pw.reject');
					Route::post('/', 'Enforcement\EnforcementController@process_result_pw_reject_update')->name('enforcement.process.result-pw.reject');
				});
			});
		});
	});
});

Route::prefix('investigation')->group(function () {

	Route::prefix('complaint')->group(function () {
		Route::get('/', 'Investigation\ComplaintController@index')->name('investigation.complaint');
		Route::get('list', 'Investigation\ComplaintController@list')->name('investigation.complaint.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Investigation\ComplaintController@edit')->name('investigation.complaint.item');
			Route::post('/', 'Investigation\ComplaintController@submit')->name('investigation.complaint.item');
			Route::get('form', 'Investigation\ComplaintController@form')->name('investigation.complaint.item.form');
			Route::get('download', 'Investigation\ComplaintController@download')->name('download.complaint');

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'Investigation\ComplaintController@process_documentReceive_edit')->name('investigation.complaint.item.process.document-receive');
					Route::post('/', 'Investigation\ComplaintController@process_documentReceive_update')->name('investigation.complaint.item.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'Investigation\ComplaintController@process_query_edit')->name('investigation.complaint.item.process.query');
					Route::post('/', 'Investigation\ComplaintController@process_query_update')->name('investigation.complaint.item.process.query');

					Route::get('item', 'Investigation\ComplaintController@process_query_item_list')->name('investigation.complaint.item.process.query.item');
					Route::post('item', 'Investigation\ComplaintController@process_query_item_update')->name('investigation.complaint.item.process.query.item');
					Route::delete('item/{query_id}', 'Investigation\ComplaintController@process_query_item_delete')->name('investigation.complaint.item.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'Investigation\ComplaintController@process_recommend_edit')->name('investigation.complaint.item.process.recommend');
					Route::post('/', 'Investigation\ComplaintController@process_recommend_update')->name('investigation.complaint.item.process.recommend');
				});

				Route::prefix('status')->group(function () {
					Route::get('/', 'Investigation\ComplaintController@process_status_edit')->name('investigation.complaint.item.process.status');
					Route::post('/', 'Investigation\ComplaintController@process_status_update')->name('investigation.complaint.item.process.status');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'Investigation\ComplaintController@process_result_edit')->name('investigation.complaint.item.process.result');
					Route::post('/', 'Investigation\ComplaintController@process_result_update')->name('investigation.complaint.item.process.result');
				});
			});
		});
	});

	Route::prefix('strike')->group(function () {
		Route::get('/', 'Investigation\StrikeController@index')->name('strike');
		Route::get('list', 'Investigation\StrikeController@list')->name('strike.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Investigation\StrikeController@edit')->name('strike.form');
			Route::post('/', 'Investigation\StrikeController@submit')->name('strike.form');
			Route::get('form', 'Investigation\StrikeController@strike_index')->name('strike.index');
			Route::get('download', 'Investigation\StrikeController@download')->name('download.strike');

			Route::prefix('attachment')->group(function () {
				Route::get('/', 'Investigation\StrikeController@attachment_index')->name('strike.form.attachment');
				Route::post('/', 'Investigation\StrikeController@attachment_insert')->name('strike.form.attachment');
				Route::delete('{attachment_id}', 'Investigation\StrikeController@attachment_delete')->name('strike.form.attachment.item');
			});

			Route::prefix('period')->group(function () {
				Route::get('/', 'Investigation\StrikeController@period_index')->name('strike.period');
				Route::post('/', 'Investigation\StrikeController@period_insert')->name('strike.period');
				Route::get('{period_id}', 'Investigation\StrikeController@period_edit')->name('strike.period.form');
				Route::post('{period_id}', 'Investigation\StrikeController@period_update')->name('strike.period.form');
				Route::delete('{period_id}', 'Investigation\StrikeController@period_delete')->name('strike.period.form');
			});

			Route::prefix('formu')->group(function () {
				Route::get('/', 'Investigation\StrikeController@formu_index')->name('strike.formu');
				Route::get('download', 'Investigation\StrikeController@formu_download')->name('download.strike.formu');

				Route::prefix('examiner')->group(function () {
					Route::get('/', 'Investigation\StrikeController@examiner_index')->name('strike.formu.examiner');
					Route::post('/', 'Investigation\StrikeController@examiner_insert')->name('strike.formu.examiner');
					Route::get('{examiner_id}', 'Investigation\StrikeController@examiner_edit')->name('strike.formu.examiner.form');
					Route::post('{examiner_id}', 'Investigation\StrikeController@examiner_update')->name('strike.formu.examiner.form');
					Route::delete('{examiner_id}', 'Investigation\StrikeController@examiner_delete')->name('strike.formu.examiner.form');
				});
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'Investigation\StrikeController@process_documentReceive_edit')->name('strike.process.document-receive');
					Route::post('/', 'Investigation\StrikeController@process_documentReceive_update')->name('strike.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'Investigation\StrikeController@process_query_edit')->name('strike.process.query');
					Route::post('/', 'Investigation\StrikeController@process_query_update')->name('strike.process.query');

					Route::get('item', 'Investigation\StrikeController@process_query_item_list')->name('strike.process.query.item');
					Route::post('item', 'Investigation\StrikeController@process_query_item_update')->name('strike.process.query.item');
					Route::delete('item/{query_id}', 'Investigation\StrikeController@process_query_item_delete')->name('strike.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'Investigation\StrikeController@process_recommend_edit')->name('strike.process.recommend');
					Route::post('/', 'Investigation\StrikeController@process_recommend_update')->name('strike.process.recommend');
				});

				Route::prefix('status')->group(function () {
					Route::get('/', 'Investigation\StrikeController@process_status_edit')->name('strike.process.status');
					Route::post('/', 'Investigation\StrikeController@process_status_update')->name('strike.process.status');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'Investigation\StrikeController@process_result')->name('strike.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'Investigation\StrikeController@process_result_approve_edit')->name('strike.process.result.approve');
						Route::post('/', 'Investigation\StrikeController@process_result_approve_update')->name('strike.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'Investigation\StrikeController@process_result_reject_edit')->name('strike.process.result.reject');
						Route::post('/', 'Investigation\StrikeController@process_result_reject_update')->name('strike.process.result.reject');
					});
				});
			});
		});
	});

	Route::prefix('lockout')->group(function () {
		Route::get('/', 'Investigation\LockoutController@index')->name('lockout');
		Route::get('list', 'Investigation\LockoutController@list')->name('lockout.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Investigation\LockoutController@edit')->name('lockout.form');
			Route::post('/', 'Investigation\LockoutController@submit')->name('lockout.form');
			Route::get('form', 'Investigation\LockoutController@lockout_index')->name('lockout.index');
			Route::get('download', 'Investigation\LockoutController@download')->name('download.lockout');

			Route::prefix('attachment')->group(function () {
				Route::get('/', 'Investigation\LockoutController@attachment_index')->name('lockout.form.attachment');
				Route::post('/', 'Investigation\LockoutController@attachment_insert')->name('lockout.form.attachment');
				Route::delete('{attachment_id}', 'Investigation\LockoutController@attachment_delete')->name('lockout.form.attachment.item');
			});

			Route::prefix('period')->group(function () {
				Route::get('/', 'Investigation\LockoutController@period_index')->name('lockout.period');
				Route::post('/', 'Investigation\LockoutController@period_insert')->name('lockout.period');
				Route::get('{period_id}', 'Investigation\LockoutController@period_edit')->name('lockout.period.form');
				Route::post('{period_id}', 'Investigation\LockoutController@period_update')->name('lockout.period.form');
				Route::delete('{period_id}', 'Investigation\LockoutController@period_delete')->name('lockout.period.form');
			});

			Route::prefix('formu')->group(function () {
				Route::get('/', 'Investigation\LockoutController@formu_index')->name('lockout.formu');
				Route::get('download', 'Investigation\LockoutController@formu_download')->name('download.lockout.formu');

				Route::prefix('examiner')->group(function () {
					Route::get('/', 'Investigation\LockoutController@examiner_index')->name('lockout.formu.examiner');
					Route::post('/', 'Investigation\LockoutController@examiner_insert')->name('lockout.formu.examiner');
					Route::get('{examiner_id}', 'Investigation\LockoutController@examiner_edit')->name('lockout.formu.examiner.form');
					Route::post('{examiner_id}', 'Investigation\LockoutController@examiner_update')->name('lockout.formu.examiner.form');
					Route::delete('{examiner_id}', 'Investigation\LockoutController@examiner_delete')->name('lockout.formu.examiner.form');
				});
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'Investigation\LockoutController@process_documentReceive_edit')->name('lockout.process.document-receive');
					Route::post('/', 'Investigation\LockoutController@process_documentReceive_update')->name('lockout.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'Investigation\LockoutController@process_query_edit')->name('lockout.process.query');
					Route::post('/', 'Investigation\LockoutController@process_query_update')->name('lockout.process.query');

					Route::get('item', 'Investigation\LockoutController@process_query_item_list')->name('lockout.process.query.item');
					Route::post('item', 'Investigation\LockoutController@process_query_item_update')->name('lockout.process.query.item');
					Route::delete('item/{query_id}', 'Investigation\LockoutController@process_query_item_delete')->name('lockout.process.query.item.delete');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'Investigation\LockoutController@process_recommend_edit')->name('lockout.process.recommend');
					Route::post('/', 'Investigation\LockoutController@process_recommend_update')->name('lockout.process.recommend');
				});

				Route::prefix('status')->group(function () {
					Route::get('/', 'Investigation\LockoutController@process_status_edit')->name('lockout.process.status');
					Route::post('/', 'Investigation\LockoutController@process_status_update')->name('lockout.process.status');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'Investigation\LockoutController@process_result')->name('lockout.process.result');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'Investigation\LockoutController@process_result_approve_edit')->name('strike.process.result.approve');
						Route::post('/', 'Investigation\LockoutController@process_result_approve_update')->name('strike.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'Investigation\LockoutController@process_result_reject_edit')->name('strike.process.result.reject');
						Route::post('/', 'Investigation\LockoutController@process_result_reject_update')->name('strike.process.result.reject');
					});
				});
			});
		});
	});

	Route::prefix('prosecution')->group(function () {
		Route::get('/', 'Investigation\ProsecutionController@pdw01_index')->name('prosecution.pdw01');
		Route::get('list', 'Investigation\ProsecutionController@list')->name('prosecution.list');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Investigation\ProsecutionController@index')->name('prosecution.form');
			Route::post('/', 'Investigation\ProsecutionController@submit')->name('prosecution.form');

			Route::prefix('pdw01')->group(function () {
				Route::get('/', 'Investigation\ProsecutionController@pdw01_edit')->name('prosecution.pdw01.form');
				Route::post('/', 'Investigation\ProsecutionController@pdw01_update')->name('prosecution.pdw01.form');
				Route::get('download', 'Investigation\ProsecutionController@download')->name('download.pdw01');

				Route::prefix('attachment')->group(function () {
					Route::get('/', 'Investigation\ProsecutionController@pdw01_attachment_index')->name('prosecution.pdw01.form.attachment');
					Route::post('/', 'Investigation\ProsecutionController@pdw01_attachment_insert')->name('prosecution.pdw01.form.attachment');
					Route::delete('{attachment_id}', 'Investigation\ProsecutionController@pdw01_attachment_delete')->name('prosecution.pdw01.form.attachment.item');
				});
			});

			Route::prefix('pdw02')->group(function () {
				Route::get('/', 'Investigation\ProsecutionController@pdw02_index')->name('prosecution.pdw02.form');
				Route::post('/', 'Investigation\ProsecutionController@pdw02_submit')->name('prosecution.pdw02.form');
				Route::get('download', 'Investigation\ProsecutionController@pdw02_download')->name('download.pdw02');
			});

			Route::prefix('pdw13')->group(function () {
				Route::get('/', 'Investigation\ProsecutionController@pdw13_index')->name('prosecution.pdw13.form');
				Route::post('/', 'Investigation\ProsecutionController@pdw13_submit')->name('prosecution.pdw13.form');
				Route::get('download', 'Investigation\ProsecutionController@pdw13_download')->name('download.pdw13');

				Route::prefix('accused')->group(function () {
					Route::get('/', 'Investigation\ProsecutionController@accused_index')->name('prosecution.accused');
					Route::post('/', 'Investigation\ProsecutionController@accused_insert')->name('prosecution.accused');
					Route::get('{accused_id}', 'Investigation\ProsecutionController@accused_edit')->name('prosecution.accused.form');
					Route::post('{accused_id}', 'Investigation\ProsecutionController@accused_update')->name('prosecution.accused.form');
					Route::delete('{accused_id}', 'Investigation\ProsecutionController@accused_delete')->name('prosecution.accused.form');
				});
			});

			Route::prefix('pdw14')->group(function () {
				Route::get('/', 'Investigation\ProsecutionController@pdw14_index')->name('prosecution.pdw14.form');
				Route::post('/', 'Investigation\ProsecutionController@pdw14_submit')->name('prosecution.pdw14.form');
				Route::get('download', 'Investigation\ProsecutionController@pdw14_download')->name('download.pdw14');
			});

			Route::prefix('process')->group(function () {
				Route::prefix('document-receive')->group(function () {
					Route::get('/', 'Investigation\ProsecutionController@process_documentReceive_edit')->name('prosecution.process.document-receive');
					Route::post('/', 'Investigation\ProsecutionController@process_documentReceive_update')->name('prosecution.process.document-receive');
				});

				Route::prefix('query')->group(function () {
					Route::get('/', 'Investigation\ProsecutionController@process_query_edit')->name('prosecution.process.query');
					Route::post('/', 'Investigation\ProsecutionController@process_query_update')->name('prosecution.process.query');

					Route::get('item', 'Investigation\ProsecutionController@process_query_item_list')->name('prosecution.process.query.item');
					Route::post('item', 'Investigation\ProsecutionController@process_query_item_update')->name('prosecution.process.query.item');
					Route::delete('item/{query_id}', 'Investigation\ProsecutionController@process_query_item_delete')->name('prosecution.process.query.item.delete');
				});

				Route::prefix('status')->group(function () {
					Route::get('/', 'Investigation\ProsecutionController@process_status_edit')->name('prosecution.process.status');
					Route::post('/', 'Investigation\ProsecutionController@process_status_update')->name('prosecution.process.status');
				});

				Route::prefix('recommend')->group(function () {
					Route::get('/', 'Investigation\ProsecutionController@process_recommend_edit')->name('prosecution.process.recommend');
					Route::post('/', 'Investigation\ProsecutionController@process_recommend_update')->name('prosecution.process.recommend');
				});

				Route::prefix('result')->group(function () {
					Route::get('/', 'Investigation\ProsecutionController@process_result_edit')->name('prosecution.process.result');
					Route::post('/', 'Investigation\ProsecutionController@process_result_update')->name('prosecution.process.result');

					/////////////////////////////// PUU //////////////////////////////

					Route::get('puu', 'Investigation\ProsecutionController@process_result')->name('prosecution.process.result-puu');

					Route::prefix('approve')->group(function () {
						Route::get('/', 'Investigation\ProsecutionController@process_result_approve_edit')->name('prosecution.process.result.approve');
						Route::post('/', 'Investigation\ProsecutionController@process_result_approve_update')->name('prosecution.process.result.approve');
					});

					Route::prefix('reject')->group(function () {
						Route::get('/', 'Investigation\ProsecutionController@process_result_reject_edit')->name('prosecution.process.result.reject');
						Route::post('/', 'Investigation\ProsecutionController@process_result_reject_update')->name('prosecution.process.result.reject');
					});
				});
			});
		});
	});

});
Route::prefix('staff')->middleware('staff')->group(function () {

	Route::prefix('settings')->group(function () {
		Route::get('/', 'Staff\SettingsController@index')->name('staff.settings');
		Route::post('/', 'Staff\SettingsController@update')->name('staff.settings');
	});
	
	Route::prefix('holiday')->group(function () {
		Route::get('/', 'Staff\HolidayController@index')->name('staff.holiday');
		Route::prefix('general')->group(function () {
			Route::get('/', 'Staff\HolidayController@general_index')->name('staff.holiday.general');
			Route::post('/', 'Staff\HolidayController@general_insert')->name('staff.holiday.general');
			Route::get('{id}', 'Staff\HolidayController@general_edit')->name('staff.holiday.general.form');
			Route::post('{id}', 'Staff\HolidayController@general_update')->name('staff.holiday.general.form');
			Route::delete('{id}', 'Staff\HolidayController@general_delete')->name('staff.holiday.general.form');
		});

		Route::prefix('specific')->group(function () {
			Route::get('/', 'Staff\HolidayController@specific_index')->name('staff.holiday.specific');
			Route::post('/', 'Staff\HolidayController@specific_insert')->name('staff.holiday.specific');
			Route::get('{id}', 'Staff\HolidayController@specific_edit')->name('staff.holiday.specific.form');
			Route::post('{id}', 'Staff\HolidayController@specific_update')->name('staff.holiday.specific.form');
			Route::delete('{id}', 'Staff\HolidayController@specific_delete')->name('staff.holiday.specific.form');
		});

		Route::prefix('weekend')->group(function() {
			Route::post('/', 'Staff\HolidayController@weekend_update')->name('staff.holiday.weekend');
		});
	});
	
	Route::prefix('holiday_approved')->group(function () {
		Route::get('/', 'Staff\HolidayApprovedController@index')->name('staff.holiday_approved');
		Route::prefix('general')->group(function () {
			Route::get('/', 'Staff\HolidayApprovedController@general_index')->name('staff.holiday_approved.general');
			Route::post('/', 'Staff\HolidayApprovedController@general_insert')->name('staff.holiday_approved.general');
			Route::get('{id}', 'Staff\HolidayApprovedController@general_edit')->name('staff.holiday_approved.general.form');
			Route::post('{id}', 'Staff\HolidayApprovedController@general_update')->name('staff.holiday_approved.general.form');
			Route::get('{id}', 'Staff\HolidayApprovedController@upd_approved')->name('staff.holiday_approved.general.form');
		});

		Route::prefix('specific')->group(function () {
			Route::get('/', 'Staff\HolidayApprovedController@specific_index')->name('staff.holiday_approved.specific');
			Route::post('/', 'Staff\HolidayApprovedController@specific_insert')->name('staff.holiday_approved.specific');
			Route::get('{id}', 'Staff\HolidayApprovedController@specific_edit')->name('staff.holiday_approved.specific.form');
			Route::post('{id}', 'Staff\HolidayApprovedController@specific_update')->name('staff.holiday_approved.specific.form');
			Route::delete('{id}', 'Staff\HolidayApprovedController@specific_delete')->name('staff.holiday_approved.specific.form');
		});
		
		Route::prefix('upd_approved')->group(function () {
			Route::get('/', 'Staff\HolidayApprovedController@upd_approved')->name('staff.holiday_approved.upd_approved');
			Route::post('/', 'Staff\HolidayApprovedController@upd_approved')->name('staff.holiday_approved.upd_approved');
			Route::get('{id}', 'Staff\HolidayApprovedController@upd_approved')->name('staff.holiday_approved.upd_approved.form');
			Route::post('{id}', 'Staff\HolidayApprovedController@upd_approved')->name('staff.holiday_approved.upd_approved.form');
			Route::delete('{id}', 'Staff\HolidayApprovedController@upd_approved')->name('staff.holiday_approved.upd_approved.form');
		});

		Route::prefix('weekend')->group(function() {
			Route::post('/', 'Staff\HolidayApprovedController@weekend_update')->name('staff.holiday_approved.weekend');
		});
		
		//Route::get('/upd_approved/{id}', 'Staff\HolidayApprovedController@upd_approved')->name('staff.holiday_approved.upd_approved');
	});
	
});

Route::prefix('admin')->middleware('admin')->group(function () {

	Route::prefix('settings')->group(function () {
		Route::get('/', 'Admin\SettingsController@index')->name('admin.settings');
		Route::post('/', 'Admin\SettingsController@update')->name('admin.settings');
	});

	Route::prefix('holiday')->group(function () {
		Route::get('/', 'Admin\HolidayController@index')->name('admin.holiday');

		Route::prefix('general')->group(function () {
			Route::get('/', 'Admin\HolidayController@general_index')->name('admin.holiday.general');
			Route::post('/', 'Admin\HolidayController@general_insert')->name('admin.holiday.general');
			Route::get('{id}', 'Admin\HolidayController@general_edit')->name('admin.holiday.general.form');
			Route::post('{id}', 'Admin\HolidayController@general_update')->name('admin.holiday.general.form');
			Route::delete('{id}', 'Admin\HolidayController@general_delete')->name('admin.holiday.general.form');
		});
		
		Route::prefix('specific')->group(function () {
			Route::get('/', 'Admin\HolidayController@specific_index')->name('admin.holiday.specific');
			Route::post('/', 'Admin\HolidayController@specific_insert')->name('admin.holiday.specific');
			Route::get('{id}', 'Admin\HolidayController@specific_edit')->name('admin.holiday.specific.form');
			Route::post('{id}', 'Admin\HolidayController@specific_update')->name('admin.holiday.specific.form');
			Route::delete('{id}', 'Admin\HolidayController@specific_delete')->name('admin.holiday.specific.form');
		});

		Route::prefix('weekend')->group(function() {
			Route::post('/', 'Admin\HolidayController@weekend_update')->name('admin.holiday.weekend');
		});
	});
	
	Route::prefix('m_holiday')->group(function () {
		Route::get('/', 'Admin\Master\HolidayTypeController@index')->name('admin.m_holiday');

		Route::prefix('general')->group(function () {
			Route::get('{id}', 'Admin\HolidayTypeController.php@general_edit')->name('admin.m_holiday.general.form');
			Route::post('{id}', 'Admin\HolidayTypeController.php@general_update')->name('admin.m_holiday.general.form');
			Route::delete('{id}', 'Admin\HolidayTypeController.php@general_delete')->name('admin.m_holiday.general.form');
		});
		
		Route::prefix('specific')->group(function () {
			Route::get('/', 'Admin\HolidayController@specific_index')->name('admin.holiday.specific');
			Route::post('/', 'Admin\HolidayController@specific_insert')->name('admin.holiday.specific');
			Route::get('{id}', 'Admin\HolidayController@specific_edit')->name('admin.holiday.specific.form');
			Route::post('{id}', 'Admin\HolidayController@specific_update')->name('admin.holiday.specific.form');
			Route::delete('{id}', 'Admin\HolidayController@specific_delete')->name('admin.holiday.specific.form');
		});

		Route::prefix('weekend')->group(function() {
			Route::post('/', 'Admin\HolidayController@weekend_update')->name('admin.holiday.weekend');
		});
	});

	Route::prefix('user')->group(function () {
		Route::prefix('internal')->group(function () {
			Route::get('/', 'Admin\User\UserInternalController@index')->name('admin.user.internal');
			Route::post('/', 'Admin\User\UserInternalController@insert')->name('admin.user.internal');
			Route::get('{id}', 'Admin\User\UserInternalController@edit')->name('admin.user.internal.form');
			Route::post('{id}', 'Admin\User\UserInternalController@update')->name('admin.user.internal.form');
			Route::get('password/{id}', 'Admin\User\UserInternalController@edit_password')->name('admin.user.internal.password.form');
			Route::post('password/{id}', 'Admin\User\UserInternalController@update_password')->name('admin.user.internal.password.form');
			Route::delete('{id}', 'Admin\User\UserInternalController@delete')->name('admin.user.internal.form');
		});

		Route::prefix('external')->group(function () {
			Route::get('/', 'Admin\User\UserExternalController@index')->name('admin.user.external');
			Route::get('{id}', 'Admin\User\UserExternalController@edit')->name('admin.user.external.form');
			Route::post('{id}', 'Admin\User\UserExternalController@update')->name('admin.user.external.form');
			Route::delete('{id}', 'Admin\User\UserExternalController@delete')->name('admin.user.external.form');
			Route::get('password/{id}', 'Admin\User\UserExternalController@edit_password')->name('admin.user.external.password.form');
			Route::post('password/{id}', 'Admin\User\UserExternalController@update_password')->name('admin.user.external.password.form');
			Route::get('handover/{id}', 'Admin\User\UserExternalController@request_handover')->name('admin.user.external.handover.form');
			Route::post('handover/{id}', 'Admin\User\UserExternalController@send_handover')->name('admin.user.external.handover.form');
		});
	});

	Route::prefix('role')->group(function () {
		Route::get('/', 'Admin\RoleController@index')->name('admin.role');
		Route::post('/', 'Admin\RoleController@insert')->name('admin.role');
		Route::get('{id}', 'Admin\RoleController@edit')->name('admin.role.form');
		Route::post('{id}', 'Admin\RoleController@update')->name('admin.role.form');
		Route::delete('{id}', 'Admin\RoleController@delete')->name('admin.role.form');
	});
	

	Route::prefix('permission')->group(function () {
		Route::get('/', 'Admin\PermissionController@index')->name('admin.permission');
		Route::post('/', 'Admin\PermissionController@insert')->name('admin.permission');
		Route::get('{id}', 'Admin\PermissionController@edit')->name('admin.permission.form');
		Route::post('{id}', 'Admin\PermissionController@update')->name('admin.permission.form');
		Route::delete('{id}', 'Admin\PermissionController@delete')->name('admin.permission.form');
	});

	Route::prefix('backup')->group(function () {
		Route::get('/', 'Admin\BackupController@index')->name('admin.backup');
		Route::post('/', 'Admin\BackupController@store')->name('admin.backup');
        Route::delete('{filename}', 'Admin\BackupController@delete')->name('admin.backup.data');
        Route::get('{filename}', 'Admin\BackupController@download')->name('admin.backup.data');
	});

	Route::prefix('notification')->group(function () {
		Route::get('/', 'Admin\NotificationController@index')->name('admin.notification');
			Route::post('/', 'Admin\NotificationController@insert')->name('admin.notification');
			Route::get('{id}', 'Admin\NotificationController@edit')->name('admin.notification.form');
			Route::post('{id}', 'Admin\NotificationController@update')->name('admin.notification.form');
			Route::delete('{id}', 'Admin\NotificationController@delete')->name('admin.notification.form');
	});

	Route::prefix('letter')->group(function () {
		Route::get('/', 'Admin\LetterController@index')->name('admin.letter');

		Route::prefix('{id}')->group(function () {
			Route::get('/', 'Admin\LetterController@edit')->name('admin.letter.form');

			Route::prefix('attachment')->group(function () {
				Route::get('/', 'Admin\LetterController@attachment_index')->name('admin.letter.attachment');
				Route::post('/', 'Admin\LetterController@attachment_insert')->name('admin.letter.attachment');
				Route::delete('/', 'Admin\LetterController@attachment_delete')->name('admin.letter.attachment.item');
			});

		});
	});

	Route::prefix('log')->group(function () {
		Route::get('/', 'Admin\LogController@index')->name('admin.log');
		Route::get('{id}', 'Admin\LogController@view')->name('admin.log.view');
	});

	Route::prefix('master')->group(function () {
		Route::prefix('announcement-type')->group(function () {
			Route::get('/', 'Admin\Master\AnnouncementTypeController@index')->name('admin.master.announcement-type');
			Route::post('/', 'Admin\Master\AnnouncementTypeController@insert')->name('admin.master.announcement-type');
			Route::get('{id}', 'Admin\Master\AnnouncementTypeController@edit')->name('admin.master.announcement-type.form');
			Route::post('{id}', 'Admin\Master\AnnouncementTypeController@update')->name('admin.master.announcement-type.form');
			Route::delete('{id}', 'Admin\Master\AnnouncementTypeController@delete')->name('admin.master.announcement-type.form');
		});

		Route::prefix('holiday-type')->group(function () {
			Route::get('/', 'Admin\Master\HolidayTypeController@index')->name('admin.master.holiday-type');
			Route::post('/', 'Admin\Master\HolidayTypeController@insert')->name('admin.master.holiday-type');
			Route::get('{id}', 'Admin\Master\HolidayTypeController@edit')->name('admin.master.holiday-type.form');
			Route::post('{id}', 'Admin\Master\HolidayTypeController@update')->name('admin.master.holiday-type.form');
			Route::delete('{id}', 'Admin\Master\HolidayTypeController@delete')->name('admin.master.holiday-type.form');
		});

		Route::prefix('attorney')->group(function () {
			Route::get('/', 'Admin\Master\AttorneyController@index')->name('admin.master.attorney');
			Route::post('/', 'Admin\Master\AttorneyController@insert')->name('admin.master.attorney');
			Route::get('{id}', 'Admin\Master\AttorneyController@edit')->name('admin.master.attorney.form');
			Route::post('{id}', 'Admin\Master\AttorneyController@update')->name('admin.master.attorney.form');
			Route::delete('{id}', 'Admin\Master\AttorneyController@delete')->name('admin.master.attorney.form');
		});

		Route::prefix('province-office')->group(function () {
			Route::get('/', 'Admin\Master\ProvinceOfficeController@index')->name('admin.master.province-office');
			Route::post('/', 'Admin\Master\ProvinceOfficeController@insert')->name('admin.master.province-office');
			Route::get('{id}', 'Admin\Master\ProvinceOfficeController@edit')->name('admin.master.province-office.form');
			Route::post('{id}', 'Admin\Master\ProvinceOfficeController@update')->name('admin.master.province-office.form');
			Route::delete('{id}', 'Admin\Master\ProvinceOfficeController@delete')->name('admin.master.province-office.form');
		});

		Route::prefix('court')->group(function () {
			Route::get('/', 'Admin\Master\CourtController@index')->name('admin.master.court');
			Route::post('/', 'Admin\Master\CourtController@insert')->name('admin.master.court');
			Route::get('{id}', 'Admin\Master\CourtController@edit')->name('admin.master.court.form');
			Route::post('{id}', 'Admin\Master\CourtController@update')->name('admin.master.court.form');
			Route::delete('{id}', 'Admin\Master\CourtController@delete')->name('admin.master.court.form');
		});

		Route::prefix('programme-type')->group(function() {
			Route::get('/', 'Admin\Master\ProgrammeTypeController@index')->name('admin.master.programme-type');
			Route::post('/', 'Admin\Master\ProgrammeTypeController@insert')->name('admin.master.programme-type');
			Route::get('{id}', 'Admin\Master\ProgrammeTypeController@edit')->name('admin.master.programme-type.form');
			Route::post('{id}', 'Admin\Master\ProgrammeTypeController@update')->name('admin.master.programme-type.form');
			Route::delete('{id}', 'Admin\Master\ProgrammeTypeController@delete')->name('admin.master.programme-type.form');
		});

		Route::prefix('designation')->group(function () {
			Route::get('/', 'Admin\Master\DesignationController@index')->name('admin.master.designation');
			Route::post('/', 'Admin\Master\DesignationController@insert')->name('admin.master.designation');
			Route::get('{id}', 'Admin\Master\DesignationController@edit')->name('admin.master.designation.form');
			Route::post('{id}', 'Admin\Master\DesignationController@update')->name('admin.master.designation.form');
			Route::delete('{id}', 'Admin\Master\DesignationController@delete')->name('admin.master.designation.form');
		});

		Route::prefix('sector')->group(function () {
			Route::get('/', 'Admin\Master\SectorController@index')->name('admin.master.sector');
			Route::post('/', 'Admin\Master\SectorController@insert')->name('admin.master.sector');
			Route::get('{id}', 'Admin\Master\SectorController@edit')->name('admin.master.sector.form');
			Route::post('{id}', 'Admin\Master\SectorController@update')->name('admin.master.sector.form');
			Route::delete('{id}', 'Admin\Master\SectorController@delete')->name('admin.master.sector.form');
		});

		Route::prefix('complaint-classification')->group(function () {
			Route::get('/', 'Admin\Master\ComplaintClassificationController@index')->name('admin.master.complaint-classification');
			Route::post('/', 'Admin\Master\ComplaintClassificationController@insert')->name('admin.master.complaint-classification');
			Route::get('{id}', 'Admin\Master\ComplaintClassificationController@edit')->name('admin.master.complaint-classification.form');
			Route::post('{id}', 'Admin\Master\ComplaintClassificationController@update')->name('admin.master.complaint-classification.form');
			Route::delete('{id}', 'Admin\Master\ComplaintClassificationController@delete')->name('admin.master.complaint-classification.form');
		});

		Route::prefix('meeting-type')->group(function () {
			Route::get('/', 'Admin\Master\MeetingTypeController@index')->name('admin.master.meeting-type');
			Route::post('/', 'Admin\Master\MeetingTypeController@insert')->name('admin.master.meeting-type');
			Route::get('{id}', 'Admin\Master\MeetingTypeController@edit')->name('admin.master.meeting-type.form');
			Route::post('{id}', 'Admin\Master\MeetingTypeController@update')->name('admin.master.meeting-type.form');
			Route::delete('{id}', 'Admin\Master\MeetingTypeController@delete')->name('admin.master.meeting-type.form');
		});

		Route::prefix('union-type')->group(function () {
			Route::get('/', 'Admin\Master\UnionTypeController@index')->name('admin.master.union-type');
			Route::post('/', 'Admin\Master\UnionTypeController@insert')->name('admin.master.union-type');
			Route::get('{id}', 'Admin\Master\UnionTypeController@edit')->name('admin.master.union-type.form');
			Route::post('{id}', 'Admin\Master\UnionTypeController@update')->name('admin.master.union-type.form');
			Route::delete('{id}', 'Admin\Master\UnionTypeController@delete')->name('admin.master.union-type.form');
		});

		Route::prefix('federation-type')->group(function () {
			Route::get('/', 'Admin\Master\FederationTypeController@index')->name('admin.master.federation-type');
			Route::post('/', 'Admin\Master\FederationTypeController@insert')->name('admin.master.federation-type');
			Route::get('{id}', 'Admin\Master\FederationTypeController@edit')->name('admin.master.federation-type.form');
			Route::post('{id}', 'Admin\Master\FederationTypeController@update')->name('admin.master.federation-type.form');
			Route::delete('{id}', 'Admin\Master\FederationTypeController@delete')->name('admin.master.federation-type.form');
		});

		Route::prefix('region')->group(function () {
			Route::get('/', 'Admin\Master\RegionController@index')->name('admin.master.region');
			Route::post('/', 'Admin\Master\RegionController@insert')->name('admin.master.region');
			Route::get('{id}', 'Admin\Master\RegionController@edit')->name('admin.master.region.form');
			Route::post('{id}', 'Admin\Master\RegionController@update')->name('admin.master.region.form');
			Route::delete('{id}', 'Admin\Master\RegionController@delete')->name('admin.master.region.form');
		});

		Route::prefix('sector-category')->group(function () {
			Route::get('/', 'Admin\Master\SectorCategoryController@index')->name('admin.master.sector-category');
			Route::post('/', 'Admin\Master\SectorCategoryController@insert')->name('admin.master.sector-category');
			Route::get('{id}', 'Admin\Master\SectorCategoryController@edit')->name('admin.master.sector-category.form');
			Route::post('{id}', 'Admin\Master\SectorCategoryController@update')->name('admin.master.sector-category.form');
			Route::delete('{id}', 'Admin\Master\SectorCategoryController@delete')->name('admin.master.sector-category.form');
		});
		
	});
});

Route::prefix('complaint')->group(function() {
	Route::post('/', 'ComplaintController@insert')->name('complaint');
});

Route::prefix('letter')->group(function () {
	Route::get('/', 'Letter\LetterController@index')->name('letter');

	Route::prefix('{id}')->group(function () {
		Route::get('/', 'Letter\LetterController@edit')->name('letter.item');
		Route::post('/', 'Letter\LetterController@update')->name('letter.item');

		Route::prefix('attachment')->group(function () {
			Route::get('/', 'Letter\LetterController@attachment_index')->name('letter.item.attachment');
			Route::post('/', 'Letter\LetterController@attachment_insert')->name('letter.item.attachment');
			Route::delete('{attachment_id}', 'Letter\LetterController@attachment_delete')->name('letter.item.attachment.item');
		});

		Route::prefix('formb')->group(function () {
			Route::get('approve', 'Letter\FormBController@approve')->name('letter.formb.approve');
			Route::get('disapprove', 'Letter\FormBController@disapprove')->name('letter.formb.disapprove');
			Route::get('formd', 'Letter\FormBController@formd')->name('letter.formb.formd');
			Route::get('jppm', 'Letter\FormBController@jppm')->name('letter.formb.jppm');
			Route::get('pnmb', 'Letter\FormBController@pnmb')->name('letter.formb.pnmb');
		});

		Route::prefix('formbb')->group(function () {
			Route::get('approve', 'Letter\FormBBController@approve')->name('letter.formbb.approve');
			Route::get('disapprove', 'Letter\FormBBController@disapprove')->name('letter.formbb.disapprove');
			Route::get('formdd', 'Letter\FormBBController@formd')->name('letter.formbb.formdd');
			Route::get('jppm', 'Letter\FormBBController@jppm')->name('letter.formbb.jppm');
			Route::get('pnmb', 'Letter\FormBBController@pnmb')->name('letter.formbb.pnmb');
		});

		Route::prefix('formpq')->group(function () {
			Route::get('approve', 'Letter\FormPQController@approve')->name('letter.formpq.approve');
		});

		Route::prefix('formww')->group(function () {
			Route::get('letter', 'Letter\FormWWController@letter')->name('letter.formww.letter');
		});

		Route::prefix('formw')->group(function () {
			Route::get('letter', 'Letter\FormWController@letter')->name('letter.formw.letter');
		});

		Route::prefix('ectr4u')->group(function () {
			Route::get('gov_acknowledge', 'Letter\ECTR4UController@gov_acknowledge')->name('letter.ectr4u.gov_acknowledge');
			Route::get('gov_acknowledge_oversea', 'Letter\ECTR4UController@gov_acknowledge_oversea')->name('letter.ectr4u.gov_acknowledge_oversea');
			Route::get('private_acknowledge', 'Letter\ECTR4UController@private_acknowledge')->name('letter.ectr4u.private_acknowledge');
			Route::get('gov_non_acknowledge', 'Letter\ECTR4UController@gov_non_acknowledge')->name('letter.ectr4u.gov_non_acknowledge');
			Route::get('gov_non_acknowledge_oversea', 'Letter\ECTR4UController@gov_non_acknowledge_oversea')->name('letter.ectr4u.gov_non_acknowledge_oversea');
			Route::get('private_non_acknowledge', 'Letter\ECTR4UController@private_non_acknowledge')->name('letter.ectr4u.private_non_acknowledge');
			Route::get('cancelled', 'Letter\ECTR4UController@cancelled')->name('letter.ectr4u.cancelled');
		});

		Route::prefix('formg')->group(function () {
			Route::get('approve', 'Letter\FormGController@approve')->name('letter.formg.approve');
			Route::get('disapprove', 'Letter\FormGController@disapprove')->name('letter.formg.disapprove');
			Route::get('certificate', 'Letter\FormGController@certificate')->name('letter.formg.certificate');
			Route::get('pnmb', 'Letter\FormGController@pnmb')->name('letter.formg.pnmb');
		});

		Route::prefix('formj')->group(function () {
			Route::get('approve', 'Letter\FormJController@approve')->name('letter.formj.approve');
			Route::get('disapprove', 'Letter\FormJController@disapprove')->name('letter.formj.disapprove');
			Route::get('pnmb', 'Letter\FormJController@pnmb')->name('letter.formj.pnmb');
		});

		Route::prefix('formk')->group(function () {
			Route::get('approve', 'Letter\FormKController@approve')->name('letter.formk.approve');
			Route::get('disapprove', 'Letter\FormKController@disapprove')->name('letter.formk.disapprove');
			Route::get('approve_disapprove', 'Letter\FormKController@approve_disapprove')->name('letter.formk.approve_disapprove');
			Route::get('constitution_complete', 'Letter\FormKController@constitution_complete')->name('letter.formk.constitution_complete');
			Route::get('constitution_incomplete', 'Letter\FormKController@constitution_incomplete')->name('letter.formk.constitution_incomplete');
			Route::get('constitution_list', 'Letter\FormKController@constitution_list')->name('letter.formk.constitution_list');
		});

		Route::prefix('formlu')->group(function () {
			Route::get('approve', 'Letter\FormLUController@approve')->name('letter.formlu.approve');
		});

		Route::prefix('forml')->group(function () {
			Route::get('approve', 'Letter\FormLController@approve')->name('letter.forml.approve');
		});

		Route::prefix('forml1')->group(function () {
			Route::get('approve', 'Letter\FormL1Controller@approve')->name('letter.forml1.approve');
		});

		Route::prefix('strike')->group(function () {
			Route::get('disobey', 'Letter\StrikeController@disobey')->name('letter.strike.disobey');
		});

		Route::prefix('lockout')->group(function () {
			Route::get('disobey', 'Letter\LockoutController@disobey')->name('letter.lockout.disobey');
		});

		Route::prefix('complaint')->group(function () {
			Route::get('memo', 'Letter\ComplaintController@memo')->name('letter.complaint.memo');
		});

		Route::prefix('formieu')->group(function () {
			Route::get('approve', 'Letter\FormIEUController@approve')->name('letter.formieu.approve');
			Route::get('memo', 'Letter\FormIEUController@memo')->name('letter.formieu.memo');
		});

		Route::prefix('affidavit')->group(function () {
			Route::get('letter', 'Letter\AffidavitController@letter')->name('letter.affidavit.letter');
		});

		Route::prefix('fund')->group(function () {
			Route::get('approve', 'Letter\FundController@approve')->name('letter.fund.approve');
			Route::get('disapprove', 'Letter\FundController@disapprove')->name('letter.fund.disapprove');
		});

		Route::prefix('levy')->group(function () {
			Route::get('approve', 'Letter\LevyController@approve')->name('letter.levy.approve');
			Route::get('disapprove', 'Letter\LevyController@disapprove')->name('letter.levy.disapprove');
		});

		Route::prefix('insurance')->group(function () {
			Route::get('approve', 'Letter\LevyController@approve')->name('letter.insurance.approve');
			Route::get('disapprove', 'Letter\LevyController@disapprove')->name('letter.insurance.disapprove');
		});

		Route::prefix('formjl')->group(function () {
			Route::get('approve', 'Letter\FormJLController@approve')->name('letter.formjl.approve');
			Route::get('disapprove', 'Letter\FormJLController@disapprove')->name('letter.formjl.disapprove');
			Route::get('external_approve', 'Letter\FormJLController@external_approve')->name('letter.formjl.external_approve');
			Route::get('external_disapprove', 'Letter\FormJLController@external_disapprove')->name('letter.formjl.external_disapprove');
		});

		Route::prefix('enforcement')->group(function () {
			Route::get('letter', 'Letter\EnforcementController@letter')->name('letter.enforcement.letter');
			Route::get('memo', 'Letter\EnforcementController@memo')->name('letter.enforcement.memo');
			Route::get('notice', 'Letter\EnforcementController@notice')->name('letter.enforcement.notice');
		});

		Route::prefix('pp30')->group(function () {
			Route::get('application', 'Letter\PP30Controller@application')->name('letter.pp30.application');
			Route::get('approve', 'Letter\PP30Controller@approve')->name('letter.pp30.approve');
			Route::get('command', 'Letter\PP30Controller@command')->name('letter.pp30.command');
			Route::get('memo', 'Letter\PP30Controller@memo')->name('letter.pp30.memo');
		});

		Route::prefix('pp68')->group(function () {
			Route::get('ap1', 'Letter\PP68Controller@ap1')->name('letter.pp68.ap1');
			Route::get('ap3', 'Letter\PP68Controller@ap3')->name('letter.pp68.ap3');
			Route::get('ap5', 'Letter\PP68Controller@ap5')->name('letter.pp68.ap5');
			Route::get('disapprove', 'Letter\PP68Controller@disapprove')->name('letter.pp68.disapprove');
			Route::get('approve_disapprove', 'Letter\PP68Controller@approve_disapprove')->name('letter.pp68.approve_disapprove');
		});

		Route::prefix('eligibility')->group(function () {
			Route::get('include', 'Letter\EligibilityController@include')->name('letter.eligibility.include');
			Route::get('exclude', 'Letter\EligibilityController@exclude')->name('letter.eligibility.exclude');
			Route::get('letter_investigation', 'Letter\EligibilityController@letter_investigation')->name('letter.eligibility.letter_investigation');
			Route::get('memo_investigation', 'Letter\EligibilityController@memo_investigation')->name('letter.eligibility.memo_investigation');
			Route::get('memo_reminder', 'Letter\EligibilityController@memo_reminder')->name('letter.eligibility.memo_reminder');
			Route::get('memo_result', 'Letter\EligibilityController@memo_result')->name('letter.eligibility.memo_result');
			Route::get('memo_retract', 'Letter\EligibilityController@memo_retract')->name('letter.eligibility.memo_retract');
		});

		Route::prefix('investigation')->group(function () {
			Route::get('appoint_po', 'Letter\InvestigationController@appoint_po')->name('letter.investigation.appoint_po');
			Route::get('appoint_io', 'Letter\InvestigationController@appoint_io')->name('letter.investigation.appoint_io');
			Route::get('memo_puu', 'Letter\InvestigationController@memo_puu')->name('letter.investigation.memo_puu');
			Route::get('warrant', 'Letter\InvestigationController@warrant')->name('letter.investigation.warrant');
			Route::get('warrant_application', 'Letter\InvestigationController@warrant_application')->name('letter.investigation.warrant_application');
			Route::get('memo_case', 'Letter\InvestigationController@memo_case')->name('letter.investigation.memo_case');

		});

	});
});