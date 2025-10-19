<div class="fixed top-0 left-0 w-full z-50 shadow-lg">
    <div class="relative overflow-hidden py-4 md:py-6" style="background: linear-gradient(135deg, #065f46, #047857) !important;">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden z-0">
            <!-- Watermark Logo -->
            <div class="absolute inset-0 opacity-5 flex items-center justify-center">
                <svg viewBox="0 0 200 50" class="h-32 w-auto">
                    <path fill="currentColor" d="M40,10 L160,10 L160,40 L40,40 Z M50,20 L70,20 L70,30 L50,30 Z M80,20 L100,20 L100,30 L80,30 Z M110,20 L130,20 L130,30 L110,30 Z M140,20 L150,20 L150,30 L140,30 Z"/>
                </svg>
            </div>

            <!-- Animated Circles -->
            <div class="absolute w-full h-full opacity-10">
                <div class="absolute top-1/4 left-1/5 w-16 h-16 rounded-full bg-yellow-400 blur-xl animate-float1"></div>
                <div class="absolute top-1/3 right-1/4 w-28 h-28 rounded-full bg-emerald-600 blur-xl animate-float2"></div>
                <div class="absolute bottom-1/4 left-1/3 w-20 h-20 rounded-full bg-red-500 blur-xl animate-float3"></div>
            </div>
        </div>

        <!-- Header Content -->
        <div class="relative z-10 container mx-auto px-6 md:px-8 flex items-center justify-between">
            <!-- Left Logo -->
            <div class="flex-shrink-0 mr-4 ml-4 md:ml-8">
                <div class="bg-white/10 backdrop-blur-sm rounded-full p-2 border border-white/20">
                    <img src="\images\uitmlogo.png" alt="ITS NU Pekalongan Logo" class="h-16 w-auto">
                </div>
            </div>

            <!-- Centered Text & Slot -->
            <div class="flex-1 text-center">
                <h1 class="text-2xl md:text-3xl font-bold text-white animate-fadeIn mb-1">
                    <span class="inline-block transform hover:scale-105 transition-transform duration-300 bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 via-yellow-200 to-yellow-400">
                        Lost & Found
                    </span>
                </h1>
                <p class="text-lg md:text-xl text-emerald-200 font-medium animate-slideUp">
                    ITS NU Pekalongan
                </p>

                <div class="mt-2 text-base text-emerald-100 font-medium max-w-2xl mx-auto animate-slideUp">
                    {{ $slot }}
                </div>

                <!-- Animated Dots -->
                <div class="flex justify-center space-x-2 mt-4">
                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-80 animate-pulse"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-white opacity-80 animate-pulse delay-100"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-red-400 opacity-80 animate-pulse delay-200"></div>
                </div>
            </div>

            <!-- Spacer to balance layout -->
            <div class="w-20 hidden sm:block"></div>
        </div>
    </div>

    <!-- Bottom Wave Divider -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden transform rotate-180">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="fill-current text-white/90">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"></path>
        </svg>
    </div>

    <!-- Animations -->
    <style>
        @keyframes float1 {
            0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
            50% { transform: translateY(-30px) translateX(15px) rotate(5deg); }
        }
        @keyframes float2 {
            0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
            50% { transform: translateY(20px) translateX(-20px) rotate(-3deg); }
        }
        @keyframes float3 {
            0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
            50% { transform: translateY(-25px) translateX(-15px) rotate(2deg); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(25px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.2); opacity: 1; }
        }

        .animate-float1 { animation: float1 9s ease-in-out infinite; }
        .animate-float2 { animation: float2 11s ease-in-out infinite; }
        .animate-float3 { animation: float3 13s ease-in-out infinite; }
        .animate-fadeIn { animation: fadeIn 1s ease-out both; }
        .animate-slideUp { animation: slideUp 1s ease-out 0.2s both; }
        .animate-pulse { animation: pulse 2s ease-in-out infinite; }
        .delay-100 { animation-delay: 0.15s; }
        .delay-200 { animation-delay: 0.3s; }
    </style>
</div>