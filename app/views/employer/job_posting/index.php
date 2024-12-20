<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Postings - JobConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
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
                <div class="max-w-full mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-primary flex items-center">
                        <i data-lucide="briefcase" class="w-8 h-8 mr-2"></i>
                        Job Postings
                    </h1>
                    <a href="<?php echo site_url('employer/job_posting/create'); ?>" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200 flex items-center">
                        <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i>
                        Create New Job
                    </a>
                    <a href="<?php echo site_url('employer/job_posting/archives'); ?>" class="ml-4 text-primary hover:text-blue-700 transition-colors duration-200 flex items-center">
                        <i data-lucide="archive" class="w-5 h-5 mr-2"></i>
                        View Archived Jobs
                    </a>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 bg-gray-100">
                <div class="max-w-full mx-auto space-y-6">
                    <?php
                    function isJobActive($deadline) {
                        $today = new DateTime();
                        $deadlineDate = new DateTime($deadline);
                        return $today <= $deadlineDate;
                    }
                    ?>
                    <?php if(empty($job_postings)): ?>
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-center">
        <p class="text-gray-600">No job postings found. Create your first job posting!</p>
    </div>
<?php else: ?>
    <?php foreach ($job_postings as $job) : ?>
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($job['job_title']) ?></h3>
                    <p class="text-sm text-gray-600 flex items-center mb-2">
                        <i data-lucide="map-pin" class="w-4 h-4 mr-1"></i>
                        <?= htmlspecialchars($job['location']) ?>
                        <span class="mx-2">•</span>
                        <i data-lucide="clock" class="w-4 h-4 mr-1"></i>
                        <?= htmlspecialchars($job['job_type']) ?>
                    </p>
                </div>
                <?php
                $isActive = isJobActive($job['application_deadline']);
                $statusClass = $isActive ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100';
                $statusText = $isActive ? 'Active' : 'Inactive';
                ?>
                <span class="px-3 py-1 text-xs font-semibold <?= $statusClass ?> rounded-full">
                    <?= $statusText ?>
                </span>
            </div>
            <p class="mt-2 text-sm text-gray-600"><?= htmlspecialchars(substr($job['job_description'], 0, 150)) ?>...</p>
            <div class="mt-4 flex justify-between items-center">
                <span class="text-sm text-gray-500 flex items-center">
                    <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                    Posted on <?= htmlspecialchars(date('Y-m-d', strtotime($job['created_at']))) ?>
                </span>
                <div class="space-x-2">
                    <form action="<?php echo site_url('employer/job_posting/edit'); ?>" method="GET" class="inline">
                        <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                        <button type="submit" class="text-primary hover:text-blue-700 font-medium">
                            <i data-lucide="edit" class="w-5 h-5 inline-block align-text-bottom"></i>
                            Edit
                        </button>
                    </form>
                    <form action="<?php echo site_url('employer/job_posting/archive'); ?>" method="POST" class="inline">
                        <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                        <button type="submit" class="text-yellow-600 hover:text-yellow-800 font-medium <?= $isActive ? '' : 'opacity-50 cursor-not-allowed' ?>" <?= $isActive ? '' : 'disabled' ?>>
                            <i data-lucide="archive" class="w-5 h-5 inline-block align-text-bottom"></i>
                            Archive
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>

