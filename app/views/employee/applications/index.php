<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications - JobConnect</title>
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
                    <h1 class="text-2xl font-bold text-gray-900">My Applications</h1>
                    <button id="sidebar-toggle" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    <!-- Search and Sort Controls -->
                    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="w-full sm:w-1/3 mb-4 sm:mb-0">
                            <input type="text" id="search" placeholder="Search applications..." class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        <div class="flex space-x-4">
                            <select id="sort-by" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                <option value="date">Sort by Date</option>
                                <option value="company">Sort by Company</option>
                                <option value="status">Sort by Status</option>
                            </select>
                            <button id="sort-order" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                <i class="fas fa-sort-amount-down"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Applications List -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul id="applications-list" class="divide-y divide-gray-200">
                            <?php foreach ($applications as $application): ?>
                            <li>
                                <a href="<?php echo site_url('employee/applications/view/' . $application['id']); ?>" class="block hover:bg-gray-50">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-primary truncate">
                                                <?php echo $application['job_title']; ?>
                                            </p>
                                            <div class="ml-2 flex-shrink-0 flex">
                                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-<?php echo $application['status'] === 'pending' ? 'yellow' : ($application['status'] === 'rejected' ? 'red' : 'green'); ?>-100 text-<?php echo $application['status'] === 'pending' ? 'yellow' : ($application['status'] === 'rejected' ? 'red' : 'green'); ?>-800">
                                                    <?php echo ucfirst($application['status']); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-2 sm:flex sm:justify-between">
                                            <div class="sm:flex">
                                                <p class="flex items-center text-sm text-gray-500">
                                                    <i class="fas fa-building flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"></i>
                                                    <?php echo $application['company_name']; ?>
                                                </p>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                                <i class="fas fa-calendar flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"></i>
                                                <p>
                                                    Applied on <time datetime="<?php echo $application['application_date']; ?>"><?php echo date('F j, Y', strtotime($application['application_date'])); ?></time>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
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

        // Search functionality
        document.getElementById('search').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const applications = document.querySelectorAll('#applications-list li');
            
            applications.forEach(app => {
                const text = app.textContent.toLowerCase();
                app.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Sorting functionality
        let sortAscending = true;
        const sortBy = document.getElementById('sort-by');
        const sortOrder = document.getElementById('sort-order');
        const applicationsList = document.getElementById('applications-list');

        function sortApplications() {
            const applications = Array.from(applicationsList.children);
            applications.sort((a, b) => {
                let aValue, bValue;
                switch(sortBy.value) {
                    case 'date':
                        aValue = new Date(a.querySelector('time').getAttribute('datetime'));
                        bValue = new Date(b.querySelector('time').getAttribute('datetime'));
                        break;
                    case 'company':
                        aValue = a.querySelector('.fa-building').nextSibling.textContent.trim();
                        bValue = b.querySelector('.fa-building').nextSibling.textContent.trim();
                        break;
                    case 'status':
                        aValue = a.querySelector('.rounded-full').textContent.trim();
                        bValue = b.querySelector('.rounded-full').textContent.trim();
                        break;
                }
                if (aValue < bValue) return sortAscending ? -1 : 1;
                if (aValue > bValue) return sortAscending ? 1 : -1;
                return 0;
            });
            applications.forEach(app => applicationsList.appendChild(app));
        }

        sortBy.addEventListener('change', sortApplications);
        sortOrder.addEventListener('click', () => {
            sortAscending = !sortAscending;
            sortOrder.innerHTML = sortAscending ? '<i class="fas fa-sort-amount-down"></i>' : '<i class="fas fa-sort-amount-up"></i>';
            sortApplications();
        });
    </script>
</body>
</html>

