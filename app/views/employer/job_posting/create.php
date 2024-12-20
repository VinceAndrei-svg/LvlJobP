<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Job Posting - JobConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        accent: '#8B5CF6',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include APP_DIR.'views/employer/sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top bar -->
            <header class="bg-white shadow-md">
                <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-primary flex items-center">
                        <i class="fas fa-file-plus fa-lg mr-3"></i>
                        Create New Job Posting
                    </h1>
                    <a href="<?php echo site_url('employer/job_postings'); ?>" class="text-gray-600 hover:text-primary transition-colors duration-200 flex items-center text-lg">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Job Postings
                    </a>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                <div class="max-w-full mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
                    <form action="<?php echo site_url('employer/job_posting/create'); ?>" method="POST" class="p-8 space-y-8">
                        <?php csrf_field(); ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div class="space-y-2">
                                <label for="job_title" class="block text-lg font-medium text-gray-700">Job Title</label>
                                <div class="relative">
                                    <i class="fas fa-briefcase absolute top-3 left-3 text-gray-400"></i>
                                    <input type="text" name="job_title" id="job_title" required class="pl-10 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-lg py-2">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="job_type" class="block text-lg font-medium text-gray-700">Job Type</label>
                                <div class="relative">
                                    <i class="fas fa-clock absolute top-3 left-3 text-gray-400"></i>
                                    <select name="job_type" id="job_type" required class="pl-10 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-lg py-2">
                                        <option value="">Select Job Type</option>
                                        <option value="full_time">Full Time</option>
                                        <option value="part_time">Part Time</option>
                                        <option value="contract">Contract</option>
                                        <option value="internship">Internship</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="location" class="block text-lg font-medium text-gray-700">Location</label>
                                <div class="relative">
                                    <i class="fas fa-map-marker-alt absolute top-3 left-3 text-gray-400"></i>
                                    <input type="text" name="location" id="location" required class="pl-10 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-lg py-2">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="salary_range" class="block text-lg font-medium text-gray-700">Salary Range</label>
                                <div class="relative">
                                    <i class="fas fa-dollar-sign absolute top-3 left-3 text-gray-400"></i>
                                    <input type="text" name="salary_range" id="salary_range" placeholder="e.g. $50,000 - $70,000" class="pl-10 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-lg py-2">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="application_deadline" class="block text-lg font-medium text-gray-700">Application Deadline</label>
                                <div class="relative">
                                    <i class="fas fa-calendar-alt absolute top-3 left-3 text-gray-400"></i>
                                    <input type="date" name="application_deadline" id="application_deadline" required class="pl-10 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-lg py-2">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="start_date" class="block text-lg font-medium text-gray-700">Start Date</label>
                                <div class="relative">
                                    <i class="fas fa-play absolute top-3 left-3 text-gray-400"></i>
                                    <input type="date" name="start_date" id="start_date" class="pl-10 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-lg py-2">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label for="job_description" class="block text-lg font-medium text-gray-700">Job Description</label>
                                <div class="relative">
                                    <i class="fas fa-align-left absolute top-3 left-3 text-gray-400"></i>
                                    <textarea name="job_description" id="job_description" rows="6" required class="pl-10 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-lg py-2"></textarea>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="requirements" class="block text-lg font-medium text-gray-700">Requirements</label>
                                <div class="relative">
                                    <i class="fas fa-list-ul absolute top-3 left-3 text-gray-400"></i>
                                    <textarea name="requirements" id="requirements" rows="6" class="pl-10 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-lg py-2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label for="benefits" class="block text-lg font-medium text-gray-700">Benefits</label>
                                <div class="relative">
                                    <i class="fas fa-gift absolute top-3 left-3 text-gray-400"></i>
                                    <textarea name="benefits" id="benefits" rows="4" class="pl-10 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-lg py-2"></textarea>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="required_skills" class="block text-lg font-medium text-gray-700">Required Skills (comma-separated)</label>
                                <div class="relative">
                                    <i class="fas fa-tools absolute top-3 left-3 text-gray-400"></i>
                                    <textarea name="required_skills" id="required_skills" rows="4" placeholder="e.g. JavaScript, React, Node.js" class="pl-10 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-lg py-2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <button type="button" onclick="window.history.back()" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-lg font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i>
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-lg font-medium rounded-lg shadow-sm text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200">
                                <i class="fas fa-check mr-2"></i>
                                Create Job Posting
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>

