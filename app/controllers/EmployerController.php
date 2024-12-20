<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class EmployerController extends Controller {

    public function __construct() {
        parent::__construct();
        if(! logged_in()) {
            redirect('auth/login');
        }
    }

    public function job_postings() {
        $user_id = get_user_id();

        $job_postings = $this->db->table('job_postings')
            ->select('*')
            ->where('employer_id', $user_id)
            ->where('is_archived', 0)
            ->order_by('created_at', 'DESC')
            ->get_all();

        $data = [
            'job_postings' => $job_postings
        ];
        $this->call->view('employer/job_posting/index', $data);
    }

    public function job_posting_create() {
        $this->call->view('employer/job_posting/create');
    }

    public function job_posting_store() {
    
        $data = [
            'employer_id' => get_user_id(),
            'job_title' => $this->io->post('job_title'),
            'job_type' => $this->io->post('job_type'),
            'location' => $this->io->post('location'),
            'salary_range' => $this->io->post('salary_range'),
            'application_deadline' => $this->io->post('application_deadline'),
            'start_date' => $this->io->post('start_date'),
            'job_description' => $this->io->post('job_description'),
            'requirements' => $this->io->post('requirements'),
            'benefits' => $this->io->post('benefits'),
            'required_skills' => $this->io->post('required_skills'),
        ];

        if ($this->db->table('job_postings')->insert($data)) {
            $_SESSION['toastr'] = ['type' => 'success', 'message' => 'Job posting created successfully!'];
            redirect('employer/job_postings');
        } else {
            $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Failed to create job posting. Please try again.'];
            redirect('employer/job_posting/create');
        }
    }

    public function job_posting_edit() {
        $job_id = $this->io->get('job_id');
    
        if (!$job_id) {
            $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Invalid job posting ID.'];
            redirect('employer/job_postings');
        }
    
        $user_id = get_user_id();
    
        $job_posting = $this->db->table('job_postings')
            ->select('*')
            ->where('id', $job_id)
            ->where('employer_id', $user_id)
            ->get();
    
        if (!$job_posting) {
            $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Job posting not found or you do not have permission to edit it.'];
            redirect('employer/job_postings');
        }
    
        $data = [
            'job' => $job_posting
        ];
    
        $this->call->view('employer/job_posting/edit', $data);
    }

    public function job_posting_update() {
        $job_id = $this->io->post('job_id');
    
        if (!$job_id) {
            $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Invalid job posting ID.'];
            redirect('employer/job_postings');
        }
    
        $user_id = get_user_id();
    
        $existing_job = $this->db->table('job_postings')
            ->select('id')
            ->where('id', $job_id)
            ->where('employer_id', $user_id)
            ->get();
    
        if (!$existing_job) {
            $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Job posting not found or you do not have permission to edit it.'];
            redirect('employer/job_postings');
        }
    
        $data = [
            'job_title' => $this->io->post('job_title'),
            'job_type' => $this->io->post('job_type'),
            'location' => $this->io->post('location'),
            'salary_range' => $this->io->post('salary_range'),
            'application_deadline' => $this->io->post('application_deadline'),
            'start_date' => $this->io->post('start_date'),
            'job_description' => $this->io->post('job_description'),
            'requirements' => $this->io->post('requirements'),
            'benefits' => $this->io->post('benefits'),
            'required_skills' => $this->io->post('required_skills'),
        ];
    
        if ($this->db->table('job_postings')->where('id', $job_id)->update($data)) {
            $_SESSION['toastr'] = ['type' => 'success', 'message' => 'Job posting updated successfully!'];
            redirect('employer/job_postings');
        } else {
            $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Failed to update job posting. Please try again.'];
            redirect('employer/job_posting/edit?job_id=' . $job_id);
        }
    }

    public function job_posting_archive() {
            $job_id = $this->io->post('job_id');

            if (!$job_id) {
                $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Invalid job posting ID.'];
                redirect('employer/job_postings');
            }

            $user_id = get_user_id();

            $existing_job = $this->db->table('job_postings')
                ->select('id')
                ->where('id', $job_id)
                ->where('employer_id', $user_id)
                ->get();

            if (!$existing_job) {
                $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Job posting not found or you do not have permission to archive it.'];
                redirect('employer/job_postings');
            }

            $data = [
                'is_archived' => 1
            ];

            if ($this->db->table('job_postings')->where('id', $job_id)->update($data)) {
                $_SESSION['toastr'] = ['type' => 'success', 'message' => 'Job posting archived successfully!'];
            } else {
                $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Failed to archive job posting. Please try again.'];
            }

            redirect('employer/job_postings');
    }

    public function job_posting_archives() {
        $user_id = get_user_id();

        $archived_job_postings = $this->db->table('job_postings')
            ->select('*')
            ->where('employer_id', $user_id)
            ->where('is_archived', 1)
            ->get_all();
        $data = [
            'archived_job_postings' => $archived_job_postings
        ];
        $this->call->view('employer/job_posting/archives', $data);
    }

    public function job_posting_unarchive() {
        $job_id = $this->io->post('job_id');

        if (!$job_id) {
            $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Invalid job posting ID.'];
            redirect('employer/job_posting/archives');
        }

        $user_id = get_user_id();

        $existing_job = $this->db->table('job_postings')
            ->select('id')
            ->where('id', $job_id)
            ->where('employer_id', $user_id)
            ->get();

        if (!$existing_job) {
            $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Job posting not found or you do not have permission to unarchive it.'];
            redirect('employer/job_posting/archives');
        }

        $data = [
            'is_archived' => 0
        ];

        if ($this->db->table('job_postings')->where('id', $job_id)->update($data)) {
            $_SESSION['toastr'] = ['type' => 'success', 'message' => 'Job posting unarchived successfully!'];
        } else {
            $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Failed to unarchive job posting. Please try again.'];
        }

        redirect('employer/job_posting/archives');
    }

    public function company_profile() {
        $employer_id = get_user_id();
    
        // Retrieve company profile data
        $company_profile = $this->db->table('company_profiles')
            ->where('employer_id', $employer_id)
            ->get();
    
        $data = [
            'company_profile' => $company_profile
        ];  
    
        $this->call->view('employer/company_profile/index', $data);
    }
    
    public function company_profile_update() {
        $employer_id = get_user_id();
    
        $company_profile_data = [
            'company_name' => $this->io->post('company_name'),
            'industry' => $this->io->post('industry'),
            'company_size' => $this->io->post('company_size'),
            'founded_year' => $this->io->post('founded_year') ?: null,
            'website' => $this->io->post('website'),
            'headquarters' => $this->io->post('headquarters'),
            'about' => $this->io->post('about'),
            'mission' => $this->io->post('mission'),
            'vision' => $this->io->post('vision'),
            'contact_email' => $this->io->post('contact_email'),
            'contact_phone' => $this->io->post('contact_phone')
        ];
    
        $existing_profile = $this->db->table('company_profiles')->where('employer_id', $employer_id)->get();
        if ($existing_profile) {
            $this->db->table('company_profiles')->where('employer_id', $employer_id)->update($company_profile_data);
        } else {
            $company_profile_data['employer_id'] = $employer_id;
            $this->db->table('company_profiles')->insert($company_profile_data);
        }
    
        redirect('employer/company_profile');
    }

    public function applicants() {
        $user_id = get_user_id();
    
        // Fetch job postings for the employer with applicant count
        $job_postings = $this->db->table('job_postings as jp')
            ->select('jp.id, jp.job_title, jp.created_at, COUNT(ja.id) as applicant_count')
            ->left_join('job_applications as ja', 'jp.id = ja.job_posting_id')
            ->where('jp.employer_id', $user_id)
            ->where('jp.is_archived', 0)
            ->group_by('jp.id')
            ->order_by('jp.created_at', 'DESC')
            ->get_all();
    
        $data = [
            'job_postings' => $job_postings
        ];
    
        $this->call->view('employer/applicants/index', $data);
    }
    
    public function view_applicants($job_posting_id) {
        $user_id = get_user_id();
    
        $job_posting = $this->db->table('job_postings')
            ->where('id', $job_posting_id)
            ->where('employer_id', $user_id)
            ->get();
    
        if (!$job_posting) {
            show_404();
        }
    
        $applicants = $this->db->table('job_applications as ja')
            ->select('ja.id as application_id, u.id as user_id, ui.first_name, ui.last_name, ui.email, ui.phone, ui.location, ui.summary, ja.status, ja.created_at')
            ->join('users as u', 'ja.employee_id = u.id')
            ->join('user_informations as ui', 'u.id = ui.user_id')
            ->where('ja.job_posting_id', $job_posting_id)
            ->order_by('ja.created_at', 'DESC')
            ->get_all();
    
        foreach ($applicants as &$applicant) {
            $applicant['education'] = $this->db->table('educations')
                ->where('user_id', $applicant['user_id'])
                ->order_by('graduation_date', 'DESC')
                ->get_all();
    
            $applicant['experience'] = $this->db->table('work_experiences')
                ->where('user_id', $applicant['user_id'])
                ->order_by('end_date', 'DESC')
                ->get_all();
    
            $applicant['certifications'] = $this->db->table('certifications')
                ->where('user_id', $applicant['user_id'])
                ->order_by('issue_date', 'DESC')
                ->get_all();
        }
    
        $data = [
            'job_posting' => $job_posting,
            'applicants' => $applicants
        ];
    
        $this->call->view('employer/applicants/view', $data);
    }
    
    
        
    
    public function update_status($application_id) {
        $user_id = get_user_id();
        $status = $this->io->post('status');
    
        if (!in_array($status, ['reviewed', 'rejected'])) {
            $this->session->set_flashdata('error', 'Invalid status');
            redirect($_SERVER['HTTP_REFERER']);
        }
    
        $application = $this->db->table('job_applications as ja')
            ->select('jp.employer_id, jp.id as job_posting_id')
            ->join('job_postings as jp', 'ja.job_posting_id = jp.id')
            ->where('ja.id', $application_id)
            ->get();
    
        if (!$application || $application['employer_id'] != $user_id) {
            show_404();
        }
    
        $this->db->table('job_applications')
            ->where('id', $application_id)
            ->update(['status' => $status]);
    
        $this->session->set_flashdata('success', 'Application status updated successfully');
        redirect('employer/applicants/view/' . $application['job_posting_id']);
    }


    public function download_all($job_posting_id) {
        $user_id = get_user_id();

        $job_posting = $this->db->table('job_postings')
            ->where('id', $job_posting_id)
            ->where('employer_id', $user_id)
            ->get();

        if (!$job_posting) {
            show_404();
        }

        $applicants = $this->db->table('job_applications as ja')
            ->select('ui.first_name, ui.last_name, u.email, ja.status, ja.created_at')
            ->join('users as u', 'ja.employee_id= u.id')
            ->join('user_informations as ui', 'u.id = ui.user_id')
            ->where('ja.job_posting_id', $job_posting_id)
            ->order_by('ja.created_at', 'DESC')
            ->get_all();

        // Generate CSV content
        $csv_content = "First Name,Last Name,Email,Status,Application Date\n";
        foreach ($applicants as $applicant) {
            $csv_content .= "{$applicant['first_name']},{$applicant['last_name']},{$applicant['email']},{$applicant['status']},{$applicant['created_at']}\n";
        }

        // Set headers for download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="applicants_list.csv"');

        // Output CSV content
        echo $csv_content;
        exit;
    }

    public function download_resume($application_id) {
        $user_id = get_user_id();

        $application = $this->db->table('job_applications as ja')
            ->select('ja.resume_path, jp.employer_id, u.first_name, u.last_name')
            ->join('job_postings as jp', 'ja.job_posting_id = jp.id')
            ->join('users as u', 'ja.employee_id = u.id')
            ->where('ja.id', $application_id)
            ->get();

        if (!$application || $application['employer_id'] != $user_id) {
            show_404();
        }

        $resume_path = FCPATH . 'uploads/resumes/' . $application['resume_path'];

        if (file_exists($resume_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $application['first_name'] . '_' . $application['last_name'] . '_resume.pdf"');
            readfile($resume_path);
            exit;
        } else {
            $this->session->set_flashdata('error', 'Resume file not found');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    
}
    
?>
