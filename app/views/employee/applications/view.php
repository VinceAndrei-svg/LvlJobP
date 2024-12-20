<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details - JobConnect</title>
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
                    <h1 class="text-2xl font-bold text-gray-900">Application Details</h1>
                    <button id="sidebar-toggle" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <div class="max-w-4xl mx-auto">
                    <!-- Back button -->
                    <a href="<?php echo site_url('employee/applications'); ?>" class="inline-flex items-center mb-4 text-sm font-medium text-primary hover:text-primary-dark">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Applications
                    </a>

                    <!-- Application Details -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h2 class="text-2xl font-bold text-gray-900"><?php echo $application['job_title']; ?></h2>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500"><?php echo $application['company_name']; ?></p>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Application Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-<?php echo $application['status'] === 'pending' ? 'yellow' : ($application['status'] === 'rejected' ? 'red' : 'green'); ?>-100 text-<?php echo $application['status'] === 'pending' ? 'yellow' : ($application['status'] === 'rejected' ? 'red' : 'green'); ?>-800">
                                            <?php echo ucfirst($application['status']); ?>
                                        </span>
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Date Applied</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo date('F j, Y', strtotime($application['application_date'])); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Job Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo ucfirst(str_replace('_', ' ', $application['job_type'])); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Location</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo $application['location']; ?></dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Job Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo nl2br($application['job_description']); ?></dd>
                                </div>
                                <?php if (!empty($application['cover_letter'])): ?>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Your Cover Letter</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo nl2br($application['cover_letter']); ?></dd>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($application['resume_url'])): ?>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Your Resume</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="<?php echo $application['resume_url']; ?>" target="_blank" class="text-primary hover:text-primary-dark">View Resume</a>
                                    </dd>
                                </div>
                                <?php endif; ?>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo date('F j, Y H:i:s', strtotime($application['created_at'])); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo date('F j, Y H:i:s', strtotime($application['updated_at'])); ?></dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-end">
                        <?php if ($application['status'] !== 'withdrawn'): ?>
                            <form action="<?php echo site_url('employee/applications/withdraw/' . $application['id']); ?>" method="POST" onsubmit="return confirm('Are you sure you want to withdraw this application? This action cannot be undone.');">
                                <button type="submit" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Withdraw Application
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
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

