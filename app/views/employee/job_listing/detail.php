<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $job_posting['job_title']; ?> - JobConnect</title>
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
<body class="bg-gray-50 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include APP_DIR.'views/employee/sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top bar -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Job Details</h1>
                    <button id="sidebar-toggle" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <div class="max-w-4xl mx-auto">
                    <!-- Back button -->
                    <a href="<?php echo site_url('employee/job_postings'); ?>" class="inline-flex items-center mb-4 text-sm font-medium text-primary hover:text-primary-dark">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Job Listings
                    </a>

                    <!-- Job Details -->
                    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2"><?php echo $job_posting['job_title']; ?></h2>
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span><?php echo $job_posting['location']; ?></span>
                                <span class="mx-2">|</span>
                                <i class="fas fa-clock mr-2"></i>
                                <span><?php echo ucfirst(str_replace('_', ' ', $job_posting['job_type'])); ?></span>
                            </div>
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Job Description</h3>
                                <p class="text-gray-700"><?php echo nl2br($job_posting['job_description']); ?></p>
                            </div>
                            <?php if (!empty($job_posting['requirements'])): ?>
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Requirements</h3>
                                <ul class="list-disc list-inside text-gray-700">
                                    <?php foreach (explode("\n", $job_posting['requirements']) as $requirement): ?>
                                        <li><?php echo $requirement; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($job_posting['benefits'])): ?>
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Benefits</h3>
                                <ul class="list-disc list-inside text-gray-700">
                                    <?php foreach (explode("\n", $job_posting['benefits']) as $benefit): ?>
                                        <li><?php echo $benefit; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                            <div class="flex items-center justify-between">
                                <?php if (!empty($job_posting['salary_range'])): ?>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-money-bill-wave mr-2"></i>
                                    Salary: <?php echo $job_posting['salary_range']; ?>
                                </div>
                                <?php endif; ?>
                                <div class="text-sm text-gray-500">
                                    <i class="far fa-calendar mr-2"></i>
                                    Application Deadline: <?php echo date('F j, Y', strtotime($job_posting['application_deadline'])); ?>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <a href="<?php echo site_url('employee/job_application/apply/' . $job_posting['id']); ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                Apply for this position
                            </a>
                        </div>
                    </div>

                    <!-- Company Profile -->
                    <?php if (!empty($company_profile)): ?>
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Company Profile</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo $company_profile['company_name']; ?></h3>
                                    <?php if (!empty($company_profile['industry'])): ?>
                                    <p class="text-gray-700 mb-2"><i class="fas fa-industry mr-2"></i><?php echo $company_profile['industry']; ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($company_profile['company_size'])): ?>
                                    <p class="text-gray-700 mb-2"><i class="fas fa-users mr-2"></i><?php echo $company_profile['company_size']; ?> employees</p>
                                    <?php endif; ?>
                                    <?php if (!empty($company_profile['headquarters'])): ?>
                                    <p class="text-gray-700 mb-2"><i class="fas fa-map-marker-alt mr-2"></i><?php echo $company_profile['headquarters']; ?></p>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <?php if (!empty($company_profile['website'])): ?>
                                    <p class="text-gray-700 mb-2"><i class="fas fa-globe mr-2"></i><a href="<?php echo $company_profile['website']; ?>" target="_blank" class="text-primary hover:text-primary-dark"><?php echo $company_profile['website']; ?></a></p>
                                    <?php endif; ?>
                                    <?php if (!empty($company_profile['contact_email'])): ?>
                                    <p class="text-gray-700 mb-2"><i class="fas fa-envelope mr-2"></i><?php echo $company_profile['contact_email']; ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($company_profile['contact_phone'])): ?>
                                    <p class="text-gray-700 mb-2"><i class="fas fa-phone mr-2"></i><?php echo $company_profile['contact_phone']; ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($company_profile['founded_year'])): ?>
                                    <p class="text-gray-700 mb-2"><i class="fas fa-calendar mr-2"></i>Founded in <?php echo $company_profile['founded_year']; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if (!empty($company_profile['about'])): ?>
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">About the Company</h3>
                                <p class="text-gray-700"><?php echo nl2br($company_profile['about']); ?></p>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($company_profile['mission'])): ?>
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Mission</h3>
                                <p class="text-gray-700"><?php echo nl2br($company_profile['mission']); ?></p>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($company_profile['vision'])): ?>
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Vision</h3>
                                <p class="text-gray-700"><?php echo nl2br($company_profile['vision']); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.bg-primary').classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>

