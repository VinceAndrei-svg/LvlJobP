<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JobConnect Portal</title>
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
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 h-screen flex items-center justify-center">
        <div class="w-full max-w-6xl flex items-center gap-8">
            <!-- Left side animation -->
            <div class="hidden lg:block w-1/2 relative">
                <div id="lottie-animation" class="w-full h-full"></div>
            </div>

            <!-- Right side login form -->
            <div class="w-full lg:w-1/2">
                <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold text-primary mb-2">Welcome to JobConnect</h1>
                        <p class="text-gray-600">Your gateway to exciting career opportunities</p>
                        <p class="text-gray-600">Login to explore job listings and connect with employers</p>
                    </div>

                    <form method="POST" action="<?php echo site_url('auth/login'); ?>" class="space-y-6">
                        <?php csrf_field(); ?>
                        
                        <div class="space-y-2">
                            <div class="relative">
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    required 
                                    class="w-full px-4 py-3 rounded-full border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all pl-10"
                                    placeholder="Email address"
                                />
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <?php if ($LAVA->session->flashdata('err_message')): ?>
                                <p class="text-red-500 text-sm"><?php echo $LAVA->session->flashdata('err_message'); ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="space-y-2">
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    required 
                                    minlength="8"
                                    class="w-full px-4 py-3 rounded-full border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all pl-10"
                                    placeholder="Password"
                                />
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary" />
                                <span class="text-gray-600">Remember me</span>
                            </label>
                            <a href="<?php echo site_url('auth/password-reset'); ?>" class="text-gray-600 hover:text-primary transition-colors">
                                Forgot password?
                            </a>
                        </div>

                        <button 
                            type="submit" 
                            class="w-full bg-primary text-white rounded-full py-3 hover:bg-primary/90 transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2"
                        >
                            Log In
                        </button>

                    </form>
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">
                            Don't have an account?
                            <a href="/auth/register" class="text-primary hover:underline ml-1">
                                Create Account
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script>
        $(function() {
            var logForm = $("form")
            if(logForm.length) {
                logForm.validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 8
                        }
                    },
                    messages: {
                        email: {
                            required: "Please enter your email address.",
                            email: "Please enter a valid email address."
                        },
                        password: {
                            required: "Please enter your password.",
                            minlength: "Password must be at least 8 characters long."
                        }
                    },
                    errorClass: "text-red-500 text-sm mt-1"
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
