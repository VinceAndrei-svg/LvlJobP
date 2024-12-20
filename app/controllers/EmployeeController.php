<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class EmployeeController extends Controller {

    public function __construct() {
        parent::__construct();
        if(! logged_in()) {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_id = get_user_id();
    
        $employee = $this->db->table('users as u')
            ->left_join('user_informations as ui', 'u.id = ui.user_id')
            ->where('u.id', $user_id)
            ->select('u.id, u.username, u.email, u.created_at, ui.avatar')
            ->get();
    
        if ($employee) {
            if (empty($employee['avatar'])) {
                $firstLetter = strtoupper(substr($employee['username'], 0, 1));
                $employee['avatar'] = "https://ui-avatars.com/api/?name={$firstLetter}&background=random";
            }
    
            // Fetch recent job applications
            $recent_applications = $this->db->table('job_applications as ja')
                ->join('job_postings as jp', 'ja.job_posting_id = jp.id')
                ->join('company_profiles as cp', 'jp.employer_id = cp.employer_id')
                ->where('ja.employee_id', $user_id)
                ->select('jp.job_title, cp.company_name, ja.status, ja.created_at as applied_date')
                ->order_by('ja.created_at', 'DESC')
                ->limit(5)
                ->get_all();
    
            $data = [
                'employee' => $employee,
                'recent_applications' => $recent_applications
            ];
    
            $this->call->view('employee/dashboard/index', $data);
        } else {
            // Handle case where employee is not found
            // For example, redirect to login page or show an error
            redirect('auth/login');
        }
    }
    public function profile() {
        $user_id = get_user_id();

        // Retrieve user and user_information data
        $user = $this->db->table('users')
            ->where('id', $user_id)
            ->get();

        $user_data = $this->db->table('user_informations')
            ->where('user_id', $user_id)
            ->get();


        // Retrieve work experiences
        $work_experiences = $this->db->table('work_experiences')
            ->where('user_id', $user_id)
            ->get_all();

        // Retrieve educations
        $educations = $this->db->table('educations')
            ->where('user_id', $user_id)
            ->get_all();

        // Retrieve skills
        $skills = $this->db->table('skills')
            ->where('user_id', $user_id)
            ->get_all();

        // Retrieve languages
        $languages = $this->db->table('languages')
            ->where('user_id', $user_id)
            ->get_all();

        // Retrieve certifications
        $certifications = $this->db->table('certifications')
            ->where('user_id', $user_id)
            ->get_all();

        $data = [
            'user' => $user,
            'user_data' => $user_data,
            'work_experiences' => $work_experiences,
            'educations' => $educations,
            'skills' => $skills,
            'languages' => $languages,
            'certifications' => $certifications
        ];


        $this->call->view('employee/profile/index', $data);
    }

    public function profile_update() {
        $user_id = get_user_id();

        // Update user_informations table
        $user_info_data = [
            'first_name' => $this->io->post('first_name'),
            'last_name' => $this->io->post('last_name'),
            'email' => $this->io->post('email'),
            'phone' => $this->io->post('phone'),
            'date_of_birth' => $this->io->post('date_of_birth') ?: null,
            'location' => $this->io->post('location'),
            'summary' => $this->io->post('summary')
        ];
        $existing_info = $this->db->table('user_informations')->where('user_id', $user_id)->get();
        if ($existing_info) {
            $this->db->table('user_informations')->where('user_id', $user_id)->update($user_info_data);
        } else {
            $user_info_data['user_id'] = $user_id;
            $this->db->table('user_informations')->insert($user_info_data);
        }

        // Update work_experiences table
        $this->db->table('work_experiences')->where('user_id', $user_id)->delete();
        $job_titles = $this->io->post('job_title');
        $companies = $this->io->post('company');
        $start_dates = $this->io->post('start_date');
        $end_dates = $this->io->post('end_date');
        $job_descriptions = $this->io->post('job_description');
        if ($job_titles) {
            foreach ($job_titles as $key => $title) {
                $this->db->table('work_experiences')->insert([
                    'user_id' => $user_id,
                    'job_title' => $title,
                    'company' => $companies[$key],
                    'start_date' => !empty($start_dates[$key]) ? $start_dates[$key] : null,
                    'end_date' => !empty($end_dates[$key]) ? $end_dates[$key] : null,
                    'job_description' => $job_descriptions[$key]
                ]);
            }
        }

        // Update educations table
        $this->db->table('educations')->where('user_id', $user_id)->delete();
        $degrees = $this->io->post('degree');
        $institutions = $this->io->post('institution');
        $graduation_dates = $this->io->post('graduation_date');
        if ($degrees) {
            foreach ($degrees as $key => $degree) {
                $this->db->table('educations')->insert([
                    'user_id' => $user_id,
                    'degree' => $degree,
                    'institution' => $institutions[$key],
                    'graduation_date' => !empty($graduation_dates[$key]) ? $graduation_dates[$key] : null
                ]);
            }
        }

        // Update skills table
        $this->db->table('skills')->where('user_id', $user_id)->delete();
        $skills = $this->io->post('skills');
        if ($skills) {
            $skills = explode(',', $skills);
            foreach ($skills as $skill) {
                if (trim($skill) !== '') {
                    $this->db->table('skills')->insert([
                        'user_id' => $user_id,
                        'skill' => trim($skill)
                    ]);
                }
            }
        }

        // Update languages table
        $this->db->table('languages')->where('user_id', $user_id)->delete();
        $languages = $this->io->post('language');
        $proficiencies = $this->io->post('proficiency');
        if ($languages) {
            foreach ($languages as $key => $language) {
                $this->db->table('languages')->insert([
                    'user_id' => $user_id,
                    'language' => $language,
                    'proficiency' => $proficiencies[$key]
                ]);
            }
        }

        // Update certifications table
        $this->db->table('certifications')->where('user_id', $user_id)->delete();
        $certifications = $this->io->post('certification');
        $issuing_organizations = $this->io->post('issuing_organization');
        $issue_dates = $this->io->post('issue_date');
        if ($certifications) {
            foreach ($certifications as $key => $certification) {
                $this->db->table('certifications')->insert([
                    'user_id' => $user_id,
                    'certification' => $certification,
                    'issuing_organization' => $issuing_organizations[$key],
                    'issue_date' => !empty($issue_dates[$key]) ? $issue_dates[$key] : null
                ]);
            }
        }

        redirect('employee/profile');
    }

    public function job_listings()
    {
        $items_per_page = 10;
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($current_page - 1) * $items_per_page;
    
        // Fetch all active job listings
        $all_job_listings = $this->db->table('job_postings')
                                     ->where('is_archived', 0)
                                     ->order_by('created_at', 'DESC')
                                     ->get_all();
    
        // Calculate total jobs and pages
        $total_jobs = count($all_job_listings);
        $total_pages = ceil($total_jobs / $items_per_page);
    
        // Manually paginate the results
        $job_listings = array_slice($all_job_listings, $offset, $items_per_page);
    
        $data = [
            'job_listings' => $job_listings,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'total_jobs' => $total_jobs,
            'items_per_page' => $items_per_page
        ];
    
        // Load the view with the data
        $this->call->view('employee/job_listing/index', $data);
    }

    public function job_posting_detail($job_id = null)
    {
        if (!$job_id) {
            redirect('employee/job_listings');
        }
    
        $job_posting = $this->db->table('job_postings')
                                ->where('id', $job_id)
                                ->where('is_archived', 0)
                                ->get();
    
        if (!$job_posting) {
            // Set flash message
            $this->session->set_flashdata('error', 'Job posting not found.');
            // Redirect to job listings page
            redirect('employee/job_listings');
        }
    
        // Fetch company profile
        $company_profile = $this->db->table('company_profiles')
                                    ->where('employer_id', $job_posting['employer_id'])
                                    ->get();
    
        // Prepare data for the view
        $data = [
            'job_posting' => $job_posting,
            'company_profile' => $company_profile
        ];
    
        // Load the view with the data
        $this->call->view('employee/job_listing/detail', $data);
    }

    public function apply_for_job($job_id = null)
    {
        if (!$job_id) {
            $this->session->set_flashdata('error', 'Invalid job posting.');
            redirect('employee/job_listings');
        }

        $employee_id = get_user_id();

        $existing_application = $this->db->table('job_applications')
                                        ->where('job_posting_id', $job_id)
                                        ->where('employee_id', $employee_id)
                                        ->get();

        if ($existing_application) {
            $this->session->set_flashdata('error', 'You have already applied for this job.');
            redirect('employee/applications/'); 
        }

        $application_data = [
            'job_posting_id' => $job_id,
            'employee_id' => $employee_id,
            'application_date' => date('Y-m-d H:i:s'),
            'status' => 'pending'
        ];

        $inserted = $this->db->table('job_applications')->insert($application_data);

        if ($inserted) {
            $this->session->set_flashdata('success', 'Your application has been submitted successfully.');
        } else {
            $this->session->set_flashdata('error', 'There was an error submitting your application. Please try again.');
        }

        redirect('employee/applications/');
    }

    public function applications()
    {
        // Get the current employee's ID
        $employee_id = get_user_id();

        // Fetch all applications for the current employee
        $applications = $this->db->table('job_applications')
            ->select('job_applications.*, job_postings.job_title, company_profiles.company_name')
            ->join('job_postings', 'job_postings.id = job_applications.job_posting_id')
            ->join('company_profiles', 'company_profiles.employer_id = job_postings.employer_id')
            ->where('job_applications.employee_id', $employee_id)
            ->order_by('job_applications.application_date', 'DESC')
            ->get_all();

        $data = [
            'applications' => $applications
        ];

        $this->call->view('employee/applications/index', $data);
    }

    public function view_application($application_id)
    {
        // Get the current employee's ID
        $employee_id = $this->session->userdata('user_id');
    
        // Fetch the specific application
        $application = $this->db->table('job_applications')
            ->select('job_applications.*, job_postings.job_title, job_postings.job_description, job_postings.job_type, job_postings.location, company_profiles.company_name')
            ->join('job_postings', 'job_postings.id = job_applications.job_posting_id')
            ->join('company_profiles', 'company_profiles.employer_id = job_postings.employer_id')
            ->where('job_applications.id', $application_id)
            ->where('job_applications.employee_id', $employee_id)
            ->get();
    
        // If application not found or doesn't belong to the current employee, redirect
        if (!$application) {
            $this->session->set_flashdata('error', 'Application not found.');
            redirect('employee/applications');
        }
    
        $data = [
            'application' => $application
        ];
    
        // Load the view with the data
        $this->call->view('employee/applications/view', $data);
    }

    public function withdraw_application($application_id)
    {
        // Get the current employee's ID
        $employee_id = get_user_id();

        // Check if the application exists and belongs to the current employee
        $application = $this->db->table('job_applications')
            ->where('id', $application_id)
            ->where('employee_id', $employee_id)
            ->get();

        if (!$application) {
            $this->session->set_flashdata('error', 'Application not found or you do not have permission to withdraw it.');
            redirect('employee/applications');
        }

        // Check if the application is already withdrawn or rejected
        if ($application['status'] === 'withdrawn' || $application['status'] === 'rejected') {
            $this->session->set_flashdata('error', 'This application has already been ' . $application['status'] . '.');
            redirect('employee/applications/view/' . $application_id);
        }

        // Update the application status to 'withdrawn'
        $updated = $this->db->table('job_applications')
            ->where('id', $application_id)
            ->update(['status' => 'withdrawn']);

        if ($updated) {
            $this->session->set_flashdata('success', 'Application withdrawn successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to withdraw application. Please try again.');
        }

        redirect('employee/applications');
    }
}