<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case Binding
|--------------------------------------------------------------------------
| Semua test pada folder Unit & Feature menggunakan Tests\TestCase agar
| framework Laravel ter-boot penuh (model casting, helper now(), routing).
| RefreshDatabase hanya diterapkan pada Feature test yang menyentuh DB.
*/

uses(TestCase::class)->in('Unit', 'Feature');

uses(RefreshDatabase::class)->in('Feature');
