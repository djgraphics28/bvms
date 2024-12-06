<?php

use App\Livewire\Home;
use App\Livewire\Post\Show as PostShow;
use App\Livewire\SubmitIncidentReportPage;
use App\Livewire\SubmitIncidentReportSuccessPage;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/submit-incident-report', SubmitIncidentReportPage::class)->name('submit.incident.report');
Route::get('/submit-incident-report-success', SubmitIncidentReportSuccessPage::class)->name('incident.submission.succeed');
Route::get('/article/{post:slug}', PostShow::class)->name('post.show');
