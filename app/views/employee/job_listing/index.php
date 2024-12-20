<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings - JobConnect</title>
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
                    <h1 class="text-2xl font-bold text-gray-900">Job Listings</h1>
                    <button id="sidebar-toggle" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    <!-- Search bar -->
                    <div class="mb-6">
                        <div class="relative">
                            <input type="text" id="job-search" placeholder="Search for jobs..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Job listings -->
                    <div class="space-y-4" id="job-listings">
                        <?php foreach ($job_listings as $job): ?>
                        <div class="bg-white shadow-sm rounded-lg p-6 job-item">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900"><?php echo $job['job_title']; ?></h2>
                                    <p class="text-sm text-gray-600"><?php echo $job['location']; ?></p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <?php echo ucfirst(str_replace('_', ' ', $job['job_type'])); ?>
                                </span>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-money-bill-wave mr-2"></i><?php echo $job['salary_range'] ?? 'Not specified'; ?>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <i class="far fa-calendar mr-2"></i>Deadline: <?php echo date('Y-m-d', strtotime($job['application_deadline'])); ?>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600"><?php echo substr($job['job_description'], 0, 150) . '...'; ?></p>
                            </div>
                            <div class="mt-4">
                                <a href="<?php echo site_url('employee/job_posting/detail/' . $job['id']); ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 flex justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium"><?php echo ($current_page - 1) * $items_per_page + 1; ?></span> to <span class="font-medium"><?php echo min($current_page * $items_per_page, $total_jobs); ?></span> of <span class="font-medium"><?php echo $total_jobs; ?></span> results
                        </div>
                        <div class="flex-1 flex justify-between sm:justify-end">
                            <?php if ($current_page > 1): ?>
                            <a href="?page=<?php echo $current_page - 1; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                            <?php endif; ?>
                            <?php if ($current_page < $total_pages): ?>
                            <a href="?page=<?php echo $current_page + 1; ?>" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                            <?php endif; ?>
                        </div>
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

        // Job search functionality
        document.getElementById('job-search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const jobItems = document.querySelectorAll('.job-item');

            jobItems.forEach(item => {
                const title = item.querySelector('h2').textContent.toLowerCase();
                const location = item.querySelector('p').textContent.toLowerCase();
                const description = item.querySelector('.mt-4 p').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || location.includes(searchTerm) || description.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

