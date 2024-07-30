<?php

use Illuminate\Support\Facades\Route;
use SokeioModule\Reverb\Livewire\Apps\AppsForm;
use SokeioModule\Reverb\Livewire\Apps\AppsTable;

Route::group(['as' => 'reverb.', 'prefix' => 'reverb'], function () {
    routeCrud('apps', AppsTable::class, AppsForm::class);
});
