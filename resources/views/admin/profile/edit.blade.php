@extends('layouts.admin')

@section('title', ' - Chỉnh sửa hồ sơ')
@section('page-title', 'Chỉnh sửa hồ sơ')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Chỉnh sửa hồ sơ</h1>
                <p class="text-gray-600 dark:text-gray-400">Cập nhật thông tin cá nhân và mật khẩu</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.profile') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay lại
                </a>
            </div>
        </div>

        <!-- Profile Edit Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-edit text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Cập nhật thông tin</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Thay đổi thông tin cá nhân và cài đặt bảo mật
                        </p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <h3 class="text-red-800 dark:text-red-200 font-medium">Có lỗi xảy ra:</h3>
                        </div>
                        <ul class="text-red-700 dark:text-red-300 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Avatar Section -->
                    <div class="space-y-6">
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-camera mr-2 text-purple-500"></i>
                            Ảnh đại diện
                        </h3>

                        <div class="flex flex-col sm:flex-row items-start gap-6">
                            <div class="relative">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                        class="w-24 h-24 rounded-full object-cover border-4 border-white dark:border-gray-600 shadow-lg"
                                        id="avatar-preview">
                                @else
                                    <div class="w-24 h-24 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full flex items-center justify-center border-4 border-white dark:border-gray-600 shadow-lg"
                                        id="avatar-preview">
                                        <span class="text-white text-2xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Chọn ảnh mới
                                </label>
                                <input type="file"
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('avatar') !border-red-500 dark:!border-red-500 @enderror"
                                    id="avatar" name="avatar" accept="image/*">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">JPG, PNG, GIF (Tối đa 2MB)</p>
                                @error('avatar')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-user mr-2 text-blue-500"></i>
                            Thông tin cá nhân
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Họ và tên <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('name') !border-red-500 dark:!border-red-500 @enderror"
                                    id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email"
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('email') !border-red-500 dark:!border-red-500 @enderror"
                                    id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Số điện thoại
                                </label>
                                <input type="tel"
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('phone') !border-red-500 dark:!border-red-500 @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Địa chỉ
                                </label>
                                <textarea
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('address') !border-red-500 dark:!border-red-500 @enderror"
                                    id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password Change -->
                    <div class="space-y-6">
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-lock mr-2 text-green-500"></i>
                            Đổi mật khẩu
                        </h3>

                        <div
                            class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-yellow-600 dark:text-yellow-400 mr-2"></i>
                                <p class="text-yellow-800 dark:text-yellow-200 text-sm">Để đảm bảo bảo mật, hãy chỉ thay đổi
                                    mật khẩu khi cần thiết và sử dụng mật khẩu mạnh.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Current Password -->
                            <div>
                                <label for="current_password"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Mật khẩu hiện tại
                                </label>
                                <input type="password"
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('current_password') !border-red-500 dark:!border-red-500 @enderror"
                                    id="current_password" name="current_password">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="password"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Mật khẩu mới
                                </label>
                                <input type="password"
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('password') !border-red-500 dark:!border-red-500 @enderror"
                                    id="password" name="password">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Xác nhận mật khẩu
                                </label>
                                <input type="password"
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                    id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <i class="fas fa-save mr-2"></i>
                            Cập nhật hồ sơ
                        </button>
                        <a href="{{ route('admin.profile') }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <i class="fas fa-times mr-2"></i>
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Avatar preview functionality
        document.getElementById('avatar').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('avatar-preview');
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        // Replace div with img element
                        const newImg = document.createElement('img');
                        newImg.id = 'avatar-preview';
                        newImg.src = e.target.result;
                        newImg.alt = '{{ $user->name }}';
                        newImg.className = 'w-24 h-24 rounded-full object-cover border-4 border-white dark:border-gray-600 shadow-lg';
                        preview.parentNode.replaceChild(newImg, preview);
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function () {
            const password = this.value;
            const length = password.length;
            let strength = 0;

            if (length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            // Remove existing indicator
            const existingIndicator = document.getElementById('password-strength');
            if (existingIndicator) {
                existingIndicator.remove();
            }

            if (password.length > 0) {
                const indicator = document.createElement('div');
                indicator.id = 'password-strength';
                indicator.className = 'mt-1 text-xs';

                let color, text;
                if (strength < 2) {
                    color = 'text-red-600 dark:text-red-400';
                    text = 'Mật khẩu yếu';
                } else if (strength < 4) {
                    color = 'text-yellow-600 dark:text-yellow-400';
                    text = 'Mật khẩu trung bình';
                } else {
                    color = 'text-green-600 dark:text-green-400';
                    text = 'Mật khẩu mạnh';
                }

                indicator.className += ' ' + color;
                indicator.textContent = text;
                this.parentNode.appendChild(indicator);
            }
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password_confirmation').value;

            if (password && password !== passwordConfirm) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp!');
                return false;
            }
        });
    </script>
@endsection