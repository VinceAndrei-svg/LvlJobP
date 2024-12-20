<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - JobConnect Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB',
                        secondary: '#3B82F6',
                        accent: '#60A5FA'
                    }
                }
            }
        }
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 min-h-screen flex items-center justify-center">
        <div class="w-full max-w-6xl flex items-center gap-8">
            <!-- Left side animation -->
            <div class="hidden lg:block w-1/2 relative">
                <div id="lottie-animation" class="w-full h-full"></div>
            </div>

            <!-- Right side registration form -->
            <div class="w-full lg:w-1/2">
                <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8">
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold text-primary mb-2">Join JobConnect</h1>
                        <p class="text-gray-600">Create an account to start your job search journey</p>
                    </div>

                    <?php flash_alert(); ?>

                    <form id="regForm" method="POST" action="<?php echo site_url('auth/register'); ?>" class="space-y-4">
                        <?php csrf_field(); ?>
                        
                        <div class="space-y-2">
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="username" 
                                    id="username" 
                                    required 
                                    class="w-full px-4 py-2 rounded-full border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all pl-10"
                                    placeholder="Enter your full name"
                                />
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <div class="relative">
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    required 
                                    class="w-full px-4 py-2 rounded-full border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all pl-10"
                                    placeholder="your@email.com"
                                />
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    required 
                                    minlength="8"
                                    class="w-full px-4 py-2 rounded-full border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all pl-10"
                                    placeholder="Create a strong password"
                                />
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password_confirmation" 
                                    id="password_confirmation" 
                                    required 
                                    minlength="8"
                                    class="w-full px-4 py-2 rounded-full border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all pl-10"
                                    placeholder="Confirm your password"
                                />
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <div class="relative">
                                <select 
                                    name="role" 
                                    id="role" 
                                    required 
                                    class="w-full px-4 py-2 rounded-full border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all pl-10 appearance-none"
                                >
                                    <option value="">Select your role</option>
                                    <option value="employee">Employee</option>
                                    <option value="employer">Employer</option>
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-2.5 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <button 
                            type="submit" 
                            class="w-full bg-primary text-white rounded-full py-2 hover:bg-primary/90 transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2"
                        >
                            Create Account
                        </button>

                        <p class="text-center text-sm text-gray-600">
                            Already have an account? 
                            <a href="<?php echo site_url('auth/login'); ?>" class="text-primary hover:underline">
                                Log in here
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script>
        $(function() {
            var regForm = $("#regForm")
            if(regForm.length) {
                regForm.validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 8
                        },
                        password_confirmation: {
                            required: true,
                            minlength: 8,
                            equalTo: "#password"
                        },
                        username: {
                            required: true,
                            minlength: 3,
                            maxlength: 50
                        },
                        role: {
                            required: true
                        }
                    },
                    messages: {
                        email: {
                            required: "Please enter your email address.",
                            email: "Please enter a valid email address."
                        },
                        password: {
                            required: "Please create a password",
                            minlength: jQuery.validator.format("Password must be at least {0} characters.")
                        },
                        password_confirmation: {
                            required: "Please confirm your password",
                            minlength: jQuery.validator.format("Password must be at least {0} characters."),
                            equalTo: "Passwords do not match."
                        },
                        username: {
                            required: "Please enter your full name.",
                            minlength: jQuery.validator.format("Name must be at least {0} characters."),
                            maxlength: jQuery.validator.format("Name must not exceed {0} characters.")
                        },
                        role: {
                            required: "Please select your role."
                        }
                    },
                    errorClass: "text-red-500 text-sm mt-1",
                    errorElement: "span",
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.parent());
                    }
                })
            }

            // Initialize Lottie animation
            var animation = lottie.loadAnimation({
                container: document.getElementById('lottie-animation'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: 'https://assets3.lottiefiles.com/packages/lf20_sSF6EG.json' // Job search animation
            });
        })
    </script>
</body>
</html>

