<?php
// Remove the mock data
// $applications = [...];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - JobConnect</title>
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
        <?php include APP_DIR.'views/employee/sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top bar -->
            <header class="bg-white shadow-md">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-primary">Employee Dashboard</h1>
                    <button id="sidebar-toggle" class="md:hidden">
                        <i class="fas fa-bars text-primary text-2xl"></i>
                    </button>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4">
                <div class="max-w-7xl mx-auto">
                    <!-- Employee Profile -->
                    <div class="bg-white shadow rounded-lg p-6 mb-6">
                        <div class="flex items-center">
                            <?php
                            $avatarUrl = !empty($employee['avatar']) 
                                ? $employee['avatar'] 
                                : "https://ui-avatars.com/api/?name=" . urlencode($employee['username']) . "&background=random";
                            ?>
                            <img src="<?php echo $avatarUrl; ?>" alt="<?php echo $employee['username']; ?>'s avatar" class="w-20 h-20 rounded-full mr-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800"><?php echo $employee['username']; ?></h2>
                                <p class="text-gray-600">Email: <?php echo $employee['email']; ?></p>
                                <p class="text-gray-600">Member since: <?php echo date('F j, Y', strtotime($employee['created_at'])); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Job Applications -->
                    <div class="bg-white shadow rounded-lg p-6 mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Recent Job Applications</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($recent_applications as $application): ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $application['job_title']; ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $application['company_name']; ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-<?php echo strtolower($application['status']) === 'rejected' ? 'red' : 'green'; ?>-100 text-<?php echo strtolower($application['status']) === 'rejected' ? 'red' : 'green'; ?>-800">
                                                    <?php echo ucfirst($application['status']); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('Y-m-d', strtotime($application['applied_date'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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
    </script>
</body>
</html>

