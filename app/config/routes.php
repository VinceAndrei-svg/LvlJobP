<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/

$router->get('/', 'Home::welcome_page');
$router->get('/home', 'Home::home_page');
$router->group('/auth', function() use ($router){
    $router->match('/register', 'Auth::register', ['POST', 'GET']);
    $router->match('/login', 'Auth::login', ['POST', 'GET']);
    $router->get('/logout', 'Auth::logout');
    $router->match('/password-reset', 'Auth::password_reset', ['POST', 'GET']);
    $router->match('/set-new-password', 'Auth::set_new_password', ['POST', 'GET']);
});

$router->get('/employee/home', 'EmployeeController');
$router->get('/employee/profile', 'EmployeeController::profile');
$router->post('/employee/profile/update', 'EmployeeController::profile_update');

$router->get('/employee/job_postings', 'EmployeeController::job_listings');
$router->get('/employee/job_posting/detail/{id}', 'EmployeeController::job_posting_detail');

$router->get('/employee/job_application/apply/{id}', 'EmployeeController::apply_for_job');

$router->get('/employee/applications', 'EmployeeController::applications');
$router->get('/employee/applications/view/{id}', 'EmployeeController::view_application');
$router->post('/employee/applications/withdraw/{id}', 'EmployeeController::withdraw_application');



$router->get('/employer/home', 'EmployerController');



$router->get('/employer/job_postings', 'EmployerController::job_postings');
$router->get('/employer/job_posting/create', 'EmployerController::job_posting_create');
$router->post('/employer/job_posting/create', 'EmployerController::job_posting_store');
$router->get('/employer/job_posting/edit', 'EmployerController::job_posting_edit');
$router->post('/employer/job_posting/edit', 'EmployerController::job_posting_update');
$router->post('/employer/job_posting/archive', 'EmployerController::job_posting_archive');
$router->get('/employer/job_posting/archives', 'EmployerController::job_posting_archives');
$router->post('/employer/job_posting/unarchive', 'EmployerController::job_posting_unarchive');


$router->get('/employer/applicants', 'EmployerController::applicants');
$router->get('/employer/applicants/view/{id}', 'EmployerController::view_applicants');

$router->post('/employer/applicants/update_status/{id}', 'EmployerController::update_status');
$router->post('/employer/applicants/download_all/{id}', 'EmployerController::download_all');
$router->post('/employer/applicants/download_resume/{id}', 'EmployerController::download_resume');

$router->get('/employer/company_profile', 'EmployerController::company_profile');
$router->post('/employer/company_profile/update', 'EmployerController::company_profile_update');