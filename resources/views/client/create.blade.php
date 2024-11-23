<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
            {{ __('Clients') }}
        </h2>
        <hr class="mb-4 border-blue-500" />
        <div class="flex justify-between items-center">
            <a type="button" href="{{ route('dashboard') }}"
                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="relative overflow-x-auto">
                <form
                    id="createClient"
                    method="post"
                    action="{{ route('clients.store') }}"
                    class="max-w mx-auto p-2 mt-4"
                    novalidate
                >
                    @csrf
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <x-crm-input
                                name="first_name"
                                minlength="3"
                                maxlength="50"
                                id="first_name"
                                :value="old('first_name')"
                                required
                            />
                            <x-crm-label for="name" :value="__('First name')" />
                            {{-- Error message from the back end --}}
                            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                            {{-- Front end validation --}}
                            <span id="first_name_error" class="error-message"></span>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <x-crm-input
                                name="last_name"
                                minlength="3"
                                maxlength="50"
                                id="last_name"
                                :value="old('last_name')"
                                required
                            />
                            <x-crm-label for="last_name" :value="__('Last name')" />
                            {{-- Error message from the back end --}}
                            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                            {{-- Front end validation --}}
                            <span id="last_name_error" class="error-message"></span>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <x-crm-input
                                type="email"
                                name="email"
                                id="email"
                                :value="old('email')"
                                required
                            />
                            <x-crm-label for="email" :value="__('Email address')" />
                            {{-- Error message from the back end --}}
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            {{-- Front end validation --}}
                            <span id="email_error" class="error-message"></span>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <x-crm-input
                                type="tel"
                                pattern="^[0-9]{8,12}$"
                                name="phone"
                                id="phone"
                                :value="old('phone')"
                                required
                            />
                            <x-crm-label for="phone" :value="__('Phone number (8-12 digits)')" />
                            {{-- Error message from the back end --}}
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            {{-- Front end validation --}}
                            <span id="phone_error" class="error-message"></span>
                        </div>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <x-crm-input
                            name="address"
                            minlength="5"
                            maxlength="50"
                            id="address"
                            placeholder=" "
                            :value="old('address')"
                        />
                        <x-crm-label for="address" :value="__('Address')" />
                        {{-- Error message from the back end --}}
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        {{-- Front end validation --}}
                        <span id="address_error" class="error-message"></span>
                    </div>
                    <button
                        type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        {{ __('Submit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('client.scripts.client-form-validation')
</x-app-layout>
