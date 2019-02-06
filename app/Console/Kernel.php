<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // the call method
        $schedule->call(function () {

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormB::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->tenure->meeting_at, 30+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 7,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormB\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormBB::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->tenure->meeting_at, 30+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 9,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormBB\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormPQ::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 11,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormPQ\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormWW::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 13,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormWW\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormW::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 14,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormW\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormL::has('formu')->where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 19,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormLU\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormL::doesntHave('formu')->where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 20,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormL\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormL1::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 21,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormL1\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormG::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->tenure->meeting_at, 30+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 16,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormG\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormK::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->tenure->meeting_at, 30+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 18,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormK\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormK::where('filing_status_id', 9)->whereHas('constitution', function($constitution) {
                return $constitution->where('filing_status_id', 2);
            })->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->logs()->where('activity_type_id', 16)->first()->created_at, 30+1), false) < 0 ) {

                    $filing->constitution->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 18,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Salinan buku peraturan tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormK\NotReceivedConstitution($filing, 'Salinan Buku Peraturan Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormJ::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::parse($filing->moved_at)->diffInDays(Carbon::now(), false) < 14 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 17,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormG\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\Insurance::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 23,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\Insurance\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\Fund::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 22,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\Fund\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\Levy::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 24,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\Levy\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormJL1::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 25,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormJL1\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormN::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 26,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormN\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\ExceptionPP30::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 35,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\PP30\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\ExceptionPP68::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 36,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\PP68\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\Strike::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 32,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\Strike\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\Lockout::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 53,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\Lockout\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormIEU::where('filing_status_id', 2)->get();

            foreach($filings as $filing) {
                if( Carbon::now()->diffInDays(nextWorkingDay($filing, $filing->applied_at, 7+1), false) < 0 ) {
                    $filing->update(['filing_status_id' => 8, 'is_editable' => 0]);

                    $filing->logs()->updateOrCreate(
                        [
                            'module_id' => 27,
                            'activity_type_id' => 16,
                            'filing_status_id' => 8,
                            'created_by_user_id' => 1,
                            'role_id' => 1
                        ],
                        [
                            'data' => 'Dokumen fizikal tidak diterima melebihi tempoh yang ditetapkan.'
                        ]
                    );

                    Mail::to($filing->created_by->email)->send(new \App\Mail\FormPQ\NotReceived($filing, 'Dokumen Fizikal Tidak Diterima'));
                }
            }

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $filings = \App\FilingModel\FormJ::where('filing_status_id', 9)->whereDate('moved_at', Carbon::now()->toDateString())->get();

            foreach($filings as $filing) {
                $filing->tenure->entity->addresses()->create(['address_id' => $filing->new_address_id]);
            }

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
