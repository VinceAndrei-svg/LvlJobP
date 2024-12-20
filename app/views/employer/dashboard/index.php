<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard - JobConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js"></script>
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
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-primary">Employer Dashboard</h1>
                    <button class="md:hidden" id="menu-toggle">
                        <i class="fas fa-bars text-primary text-2xl"></i>
                    </button>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 bg-gray-100">
                <div class="max-w-7xl mx-auto space-y-8">
                    <!-- Welcome message -->
                    <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                        <h2 class="text-2xl font-bold text-primary mb-2">Welcome, <?=html_escape(get_username(get_user_id()));?>!</h2>
                        <p class="text-gray-600">What would you like to do today?</p>
                    </div>

                    <!-- Quick access cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Job Postings Card -->
                        <a href="<?= site_url('employer/job_posting') ?>" class="bg-white shadow-lg rounded-lg p-6 transition duration-300 ease-in-out transform hover:scale-105">
                            <div class="flex items-center justify-between mb-4">
                                <i class="fas fa-briefcase text-4xl text-primary"></i>
                                <span class="text-2xl font-bold text-primary"><?= $active_job_postings ?></span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Job Postings</h3>
                            <p class="text-gray-600">Manage your active job listings</p>
                        </a>

                        <!-- Applicants Card -->
                        <a href="<?= site_url('employer/applicants') ?>" class="bg-white shadow-lg rounded-lg p-6 transition duration-300 ease-in-out transform hover:scale-105">
                            <div class="flex items-center justify-between mb-4">
                                <i class="fas fa-users text-4xl text-secondary"></i>
                                <span class="text-2xl font-bold text-secondary"><?= $total_applicants ?></span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Applicants</h3>
                            <p class="text-gray-600">Review and manage applications</p>
                        </a>

                        <!-- Company Profile Card -->
                        <a href="<?= site_url('employer/company_profile') ?>" class="bg-white shadow-lg rounded-lg p-6 transition duration-300 ease-in-out transform hover:scale-105">
                            <div class="flex items-center justify-between mb-4">
                                <i class="fas fa-building text-4xl text-accent"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Company Profile</h3>
                            <p class="text-gray-600">Update your company information</p>
                        </a>
                    </div>

                    <!-- System Information with Lottie Animation -->
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="w-full md:w-1/2 mb-4 md:mb-0">
                                <h3 class="text-xl font-bold mb-4 text-primary">About JobConnect</h3>
                                <p class="text-gray-600 mb-2">JobConnect is your all-in-one platform for efficient recruitment and job searching.</p>
                                <p class="text-gray-600 mb-2">Our system offers:</p>
                                <ul class="list-disc list-inside text-gray-600 mb-4">
                                    <li>Easy job posting and management</li>
                                    <li>Advanced applicant tracking</li>
                                    <li>Powerful search and filtering tools</li>
                                    <li>Seamless communication between employers and candidates</li>
                                </ul>
                                <p class="text-gray-600">We're constantly improving to make your hiring process smoother and more effective.</p>
                            </div>
                            <div class="w-full md:w-1/2 flex justify-center">
                                <div id="lottie-animation" style="width: 300px; height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.querySelector('.bg-blue-800').classList.toggle('-translate-x-full');
        });

        // Load Lottie animation
        lottie.loadAnimation({
            container: document.getElementById('lottie-animation'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://assets2.lottiefiles.com/packages/lf20_0zMnYI.json' // This is a sample animation, replace with your preferred one
        });
    </script>
</body>
</html>

