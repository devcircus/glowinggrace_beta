<?php

Route::get('{any}', App\Http\Actions\Home::class)->where('any', '.*');
