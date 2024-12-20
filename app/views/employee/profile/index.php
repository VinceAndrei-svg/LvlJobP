<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile - JobConnect</title>
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
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        .fade-out {
            animation: fadeOut 0.3s ease-in-out;
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
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
                    <h1 class="text-2xl font-bold text-gray-900">Employee Profile</h1>
                    <button id="sidebar-toggle" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
                    <form action="<?php echo site_url('employee/profile/update'); ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-8">
                        <?php csrf_field(); ?>

                        <!-- Personal Information -->
                        <div class="space-y-6">
                            <h2 class="text-2xl font-semibold text-gray-900">Personal Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                    <input type="text" id="first_name" name="first_name" value="<?php echo $user_data['first_name'] ?? ''; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" value="<?php echo $user_data['last_name'] ?? ''; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" id="email" name="email" value="<?php echo $user_data['email'] ?? ''; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                    <input type="tel" id="phone" name="phone" value="<?php echo $user_data['phone'] ?? ''; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                </div>
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $user_data['date_of_birth'] ?? ''; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                </div>
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <input type="text" id="location" name="location" value="<?php echo $user_data['location'] ?? ''; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                </div>
                            </div>
                        </div>

                        <!-- Professional Summary -->
                        <div class="space-y-6">
                            <h2 class="text-2xl font-semibold text-gray-900">Professional Summary</h2>
                            <div>
                                <label for="summary" class="block text-sm font-medium text-gray-700 mb-1">Summary</label>
                                <textarea id="summary" name="summary" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out"><?php echo $user_data['summary'] ?? ''; ?></textarea>
                            </div>
                        </div>

                        <!-- Work Experience -->
                        <div class="space-y-6">
                            <h2 class="text-2xl font-semibold text-gray-900">Work Experience</h2>
                            <div class="space-y-6" id="work-experience-container">
                                <?php foreach ($work_experiences as $experience): ?>
                                <div class="border border-gray-200 rounded-md p-6 space-y-4 relative fade-in">
                                    <button type="button" class="remove-row absolute top-2 right-2 text-gray-400 hover:text-red-500 transition duration-150 ease-in-out">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="job_title" class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                            <input type="text" name="job_title[]" value="<?php echo $experience['job_title']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                        </div>
                                        <div>
                                            <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                                            <input type="text" name="company[]" value="<?php echo $experience['company']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                        </div>
                                        <div>
                                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                            <input type="date" name="start_date[]" value="<?php echo $experience['start_date']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                        </div>
                                        <div>
                                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                            <input type="date" name="end_date[]" value="<?php echo $experience['end_date']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="job_description" class="block text-sm font-medium text-gray-700 mb-1">Job Description</label>
                                        <textarea name="job_description[]" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out"><?php echo $experience['job_description']; ?></textarea>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-work-experience" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150 ease-in-out">
                                <i class="fas fa-plus-circle mr-2"></i> Add Work Experience
                            </button>
                        </div>

                        <!-- Education -->
                        <div class="space-y-6">
                            <h2 class="text-2xl font-semibold text-gray-900">Education</h2>
                            <div class="space-y-6" id="education-container">
                                <?php foreach ($educations as $education): ?>
                                <div class="border border-gray-200 rounded-md p-6 space-y-4 relative fade-in">
                                    <button type="button" class="remove-row absolute top-2 right-2 text-gray-400 hover:text-red-500 transition duration-150 ease-in-out">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="degree" class="block text-sm font-medium text-gray-700 mb-1">Degree</label>
                                            <input type="text" name="degree[]" value="<?php echo $education['degree']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                        </div>
                                        <div>
                                            <label for="institution" class="block text-sm font-medium text-gray-700 mb-1">Institution</label>
                                            <input type="text" name="institution[]" value="<?php echo $education['institution']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                        </div>
                                        <div>
                                            <label for="graduation_date" class="block text-sm font-medium text-gray-700 mb-1">Graduation Date</label>
                                            <input type="date" name="graduation_date[]" value="<?php echo $education['graduation_date']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-education" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150 ease-in-out">
                                <i class="fas fa-plus-circle mr-2"></i> Add Education
                            </button>
                        </div>

                        <!-- Skills -->
                        <div class="space-y-6">
                            <h2 class="text-2xl font-semibold text-gray-900">Skills</h2>
                            <div>
                                <label for="skills" class="block text-sm font-medium text-gray-700 mb-1">Skills (comma-separated)</label>
                                <input type="text" id="skills" name="skills" value="<?php echo implode(', ', array_column($skills, 'skill')); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                            </div>
                        </div>

                        <!-- Languages -->
                        <div class="space-y-6">
                            <h2 class="text-2xl font-semibold text-gray-900">Languages</h2>
                            <div class="space-y-6" id="languages-container">
                                <?php foreach ($languages as $language): ?>
                                <div class="border border-gray-200 rounded-md p-6 space-y-4 relative fade-in">
                                    <button type="button" class="remove-row absolute top-2 right-2 text-gray-400 hover:text-red-500 transition duration-150 ease-in-out">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="language" class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                                            <input type="text" name="language[]" value="<?php echo $language['language']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                        </div>
                                        <div>
                                            <label for="proficiency" class="block text-sm font-medium text-gray-700 mb-1">Proficiency</label>
                                            <select name="proficiency[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                                <option value="Beginner" <?php echo $language['proficiency'] == 'Beginner' ? 'selected' : ''; ?>>Beginner</option>
                                                <option value="Intermediate" <?php echo $language['proficiency'] == 'Intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                                                <option value="Advanced" <?php echo $language['proficiency'] == 'Advanced' ? 'selected' : ''; ?>>Advanced</option>
                                                <option value="Native" <?php echo $language['proficiency'] == 'Native' ? 'selected' : ''; ?>>Native</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-language" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150 ease-in-out">
                                <i class="fas fa-plus-circle mr-2"></i> Add Language
                            </button>
                        </div>

                        <!-- Certifications -->
                        <div class="space-y-6">
                            <h2 class="text-2xl font-semibold text-gray-900">Certifications</h2>
                            <div class="space-y-6" id="certifications-container">
                                <?php foreach ($certifications as $certification): ?>
                                <div class="border border-gray-200 rounded-md p-6 space-y-4 relative fade-in">
                                    <button type="button" class="remove-row absolute top-2 right-2 text-gray-400 hover:text-red-500 transition duration-150 ease-in-out">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="certification" class="block text-sm font-medium text-gray-700 mb-1">Certification</label>
                                            <input type="text" name="certification[]" value="<?php echo $certification['certification']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                        </div>
                                        <div>
                                            <label for="issuing_organization" class="block text-sm font-medium text-gray-700 mb-1">Issuing Organization</label>
                                            <input type="text" name="issuing_organization[]" value="<?php echo $certification['issuing_organization']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                        </div>
                                        <div>
                                            <label for="issue_date" class="block text-sm font-medium text-gray-700 mb-1">Issue Date</label>
                                            <input type="date" name="issue_date[]" value="<?php echo $certification['issue_date']; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-certification" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150 ease-in-out">
                                <i class="fas fa-plus-circle mr-2"></i> Add Certification
                            </button>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150 ease-in-out">
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

        // Function to add new row
        function addRow(containerId, templateId) {
            const container = document.getElementById(containerId);
            const template = document.getElementById(templateId);
            const newRow = template.content.cloneNode(true);
            newRow.querySelector('.border').classList.add('fade-in');
            container.appendChild(newRow);
            addRemoveRowListener(container.lastElementChild.querySelector('.remove-row'));
        }

        // Function to remove row
        function removeRow(button) {
            const row = button.closest('.border');
            const container = row.parentElement;
            if (container.children.length > 1) {
                row.classList.add('fade-out');
                setTimeout(() => {
                    row.remove();
                }, 300);
            } else {
                alert("You must have at least one entry in this section.");
            }
        }

        // Add event listener for remove buttons
        function addRemoveRowListener(button) {
            button.addEventListener('click', function() {
                removeRow(this);
            });
        }

        // Initialize remove row listeners
        document.querySelectorAll('.remove-row').forEach(addRemoveRowListener);

        // Add Work Experience
        document.getElementById('add-work-experience').addEventListener('click', function() {
            addRow('work-experience-container', 'work-experience-template');
        });

        // Add Education
        document.getElementById('add-education').addEventListener('click', function() {
            addRow('education-container', 'education-template');
        });

        // Add Language
        document.getElementById('add-language').addEventListener('click', function() {
            addRow('languages-container', 'language-template');
        });

        // Add Certification
        document.getElementById('add-certification').addEventListener('click', function() {
            addRow('certifications-container', 'certification-template');
        });
    </script>

    <template id="work-experience-template">
        <div class="border border-gray-200 rounded-md p-6 space-y-4 relative">
            <button type="button" class="remove-row absolute top-2 right-2 text-gray-400 hover:text-red-500 transition duration-150 ease-in-out">
                <i class="fas fa-times"></i>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="job_title" class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                    <input type="text" name="job_title[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                </div>
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                    <input type="text" name="company[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                </div>
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                </div>
            </div>
            <div>
                <label for="job_description" class="block text-sm font-medium text-gray-700 mb-1">Job Description</label>
                <textarea name="job_description[]" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out"></textarea>
            </div>
        </div>
    </template>

    <template id="education-template">
        <div class="border border-gray-200 rounded-md p-6 space-y-4 relative">
            <button type="button" class="remove-row absolute top-2 right-2 text-gray-400 hover:text-red-500 transition duration-150 ease-in-out">
                <i class="fas fa-times"></i>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="degree" class="block text-sm font-medium text-gray-700 mb-1">Degree</label>
                    <input type="text" name="degree[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                </div>
                <div>
                    <label for="institution" class="block text-sm font-medium text-gray-700 mb-1">Institution</label>
                    <input type="text" name="institution[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                </div>
                <div>
                    <label for="graduation_date" class="block text-sm font-medium text-gray-700 mb-1">Graduation Date</label>
                    <input type="date" name="graduation_date[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                </div>
            </div>
        </div>
    </template>

    <template id="language-template">
        <div class="border border-gray-200 rounded-md p-6 space-y-4 relative">
            <button type="button" class="remove-row absolute top-2 right-2 text-gray-400 hover:text-red-500 transition duration-150 ease-in-out">
                <i class="fas fa-times"></i>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="language" class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                    <input type="text" name="language[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                </div>
                <div>
                    <label for="proficiency" class="block text-sm font-medium text-gray-700 mb-1">Proficiency</label>
                    <select name="proficiency[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                        <option value="Native">Native</option>
                    </select>
                </div>
            </div>
        </div>
    </template>

    <template id="certification-template">
        <div class="border border-gray-200 rounded-md p-6 space-y-4 relative">
            <button type="button" class="remove-row absolute top-2 right-2 text-gray-400 hover:text-red-500 transition duration-150 ease-in-out">
                <i class="fas fa-times"></i>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="certification" class="block text-sm font-medium text-gray-700 mb-1">Certification</label>
                    <input type="text" name="certification[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                </div>
                <div>
                    <label for="issuing_organization" class="block text-sm font-medium text-gray-700 mb-1">Issuing Organization</label>
                    <input type="text" name="issuing_organization[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                </div>
                <div>
                    <label for="issue_date" class="block text-sm font-medium text-gray-700 mb-1">Issue Date</label>
                    <input type="date" name="issue_date[]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                </div>
            </div>
        </div>
    </template>
</body>
</html>

