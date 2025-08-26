<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - School Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo/Branding -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-2xl flex items-center justify-center text-3xl font-bold mx-auto mb-4 shadow-lg">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">SchoolSys</h1>
                <p class="text-gray-500 mt-1">School Management System</p>
            </div>
            
            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white p-6 text-center">
                    <h2 class="text-xl font-semibold">Admin Portal</h2>
                    <p class="mt-1 text-blue-100 text-sm">Sign in to access the dashboard</p>
                </div>
                
                <!-- Form -->
                <div class="p-8">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 p-3 bg-green-50 text-green-700 text-sm rounded-lg flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="mb-6 p-3 bg-red-50 text-red-700 text-sm rounded-lg">
                            <div class="font-medium mb-1">Whoops! Something went wrong.</div>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email" 
                                       type="email" 
                                       name="email" 
                                       value="{{ old('email', 'kaushalkhadka789@gmail.com') }}" 
                                       required 
                                       autocomplete="email" 
                                       autofocus
                                       placeholder="Enter your email"
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Password
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs font-medium text-blue-600 hover:text-blue-500 transition-colors duration-150">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" 
                                       type="password" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password"
                                       placeholder="Enter your password"
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input id="remember" 
                                   name="remember" 
                                   type="checkbox" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" 
                                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                                <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} SchoolSys. All rights reserved.</p>
                <div class="mt-2 flex justify-center space-x-4">
                    <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-red-500 transition-colors">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
