<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Job Postings - JobConnect</title>
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
                        <i data-lucide="archive" class="w-8 h-8 mr-2"></i>
                        Archived Job Postings
                    </h1>
                    <a href="<?php echo site_url('employer/job_postings'); ?>" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200 flex items-center">
                        <i data-lucide="list" class="w-5 h-5 mr-2"></i>
                        Active Job Postings
                    </a>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 bg-gray-100">
                <div class="max-w-full mx-auto space-y-6">
                    <?php if(empty($archived_job_postings)): ?>
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-center">
                            <p class="text-gray-600">No archived job postings found.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($archived_job_postings as $job) : ?>
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
                                        <span class="px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">
                                            Archived
                                        </span>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600"><?= htmlspecialchars(substr($job['job_description'], 0, 150)) ?>...</p>
                                    <div class="mt-4 flex justify-between items-center">
                                        <span class="text-sm text-gray-500 flex items-center">
                                            <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                                            Archived on <?= htmlspecialchars(date('Y-m-d', strtotime($job['updated_at']))) ?>
                                        </span>
                                        <div class="space-x-2">
                                            <form action="<?php echo site_url('employer/job_posting/unarchive'); ?>" method="POST" class="inline">
                                                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                                <button type="submit" class="text-primary hover:text-blue-700 font-medium">
                                                    <i data-lucide="refresh-cw" class="w-5 h-5 inline-block align-text-bottom"></i>
                                                    Unarchive
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

