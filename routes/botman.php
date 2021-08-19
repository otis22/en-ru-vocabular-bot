<?php

$botman = resolve('botman');

$botman->hears('{userInput}', 'App\Http\Controllers\VocabularyController@newWord');
