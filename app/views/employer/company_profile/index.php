<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile - JobConnect</title>
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
        <?php include APP_DIR.'views/employer/sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top bar -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Company Profile</h1>
                    <button id="sidebar-toggle" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <div class="max-w-4xl mx-auto">
                    <form action="<?php echo site_url('employer/company_profile/update'); ?>" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                                    <input type="text" id="company_name" name="company_name" value="<?php echo $company_profile['company_name'] ?? ''; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                </div>
                                <div>
                                    <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                                    <input type="text" id="industry" name="industry" value="<?php echo $company_profile['industry'] ?? ''; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                </div>
                                <div>
                                    <label for="company_size" class="block text-sm font-medium text-gray-700">Company Size</label>
                                    <select id="company_size" name="company_size" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                        <option value="">Select company size</option>
                                        <option value="1-10" <?php echo ($company_profile['company_size'] ?? '') === '1-10' ? 'selected' : ''; ?>>1-10 employees</option>
                                        <option value="11-50" <?php echo ($company_profile['company_size'] ?? '') === '11-50' ? 'selected' : ''; ?>>11-50 employees</option>
                                        <option value="51-200" <?php echo ($company_profile['company_size'] ?? '') === '51-200' ? 'selected' : ''; ?>>51-200 employees</option>
                                        <option value="201-500" <?php echo ($company_profile['company_size'] ?? '') === '201-500' ? 'selected' : ''; ?>>201-500 employees</option>
                                        <option value="501-1000" <?php echo ($company_profile['company_size'] ?? '') === '501-1000' ? 'selected' : ''; ?>>501-1000 employees</option>
                                        <option value="1001+" <?php echo ($company_profile['company_size'] ?? '') === '1001+' ? 'selected' : ''; ?>>1001+ employees</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="founded_year" class="block text-sm font-medium text-gray-700">Founded Year</label>
                                    <input type="number" id="founded_year" name="founded_year" value="<?php echo $company_profile['founded_year'] ?? ''; ?>" min="1800" max="<?php echo date('Y'); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                </div>
                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                                    <input type="url" id="website" name="website" value="<?php echo $company_profile['website'] ?? ''; ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                </div>
                                <div>
                                    <label for="headquarters" class="block text-sm font-medium text-gray-700">Headquarters</label>
                                    <input type="text" id="headquarters" name="headquarters" value="<?php echo $company_profile['headquarters'] ?? ''; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="about" class="block text-sm font-medium text-gray-700">About the Company</label>
                                <textarea id="about" name="about" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"><?php echo $company_profile['about'] ?? ''; ?></textarea>
                            </div>
                            <div>
                                <label for="mission" class="block text-sm font-medium text-gray-700">Mission</label>
                                <textarea id="mission" name="mission" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"><?php echo $company_profile['mission'] ?? ''; ?></textarea>
                            </div>
                            <div>
                                <label for="vision" class="block text-sm font-medium text-gray-700">Vision</label>
                                <textarea id="vision" name="vision" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"><?php echo $company_profile['vision'] ?? ''; ?></textarea>
                            </div>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="contact_email" class="block text-sm font-medium text-gray-700">Contact Email</label>
                                    <input type="email" id="contact_email" name="contact_email" value="<?php echo $company_profile['contact_email'] ?? ''; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                </div>
                                <div>
                                    <label for="contact_phone" class="block text-sm font-medium text-gray-700">Contact Phone</label>
                                    <input type="tel" id="contact_phone" name="contact_phone" value="<?php echo $company_profile['contact_phone'] ?? ''; ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                Save Profile
                            </button>
                        </div>
                    </form>
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

