<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
            {{ __('Edit Client') }}
        </h2>
        <hr class="mb-4 border-blue-500" />
        <div class="flex justify-between items-center">
            <a type="button" href="{{ route('clients.index') }}"
                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                {{ __('Back') }}
            </a>

            @include('client.partials.show-flash-message')

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="relative overflow-x-auto">
                <form
                    id="createClient"
                    method="post"
                    action="{{ route('clients.update', $client->id) }}"
                    class="max-w mx-auto p-2 mt-4"
                    novalidate
                >
                    @csrf
                    @method('PUT')
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <x-crm-input
                                name="first_name"
                                maxlength="50"
                                id="first_name"
                                :value="$client->first_name"
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
                                maxlength="50"
                                id="last_name"
                                :value="$client->last_name"
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
                                :value="$client->email"
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
                                :value="$client->phone"
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
                            maxlength="255"
                            id="address"
                            placeholder=" "
                            :value="$client->address"
                        />
                        <x-crm-label for="address" :value="__('Address')" />
                        {{-- Error message from the back end --}}
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        {{-- Front end validation --}}
                        <span id="address_error" class="error-message"></span>
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{ __('Update') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                {{ __('Client\'s Cash Loan') }}
            </h3>
            <hr class="mb-4 border-blue-500" />
            <div class="relative overflow-x-auto">
                <form
                    id="loanCash"
                    method="post"
                    action="{{ route('clients.loan.cash', $client->id) }}"
                    class="max-w mx-auto p-2 mt-4"
                    novalidate
                >
                    @csrf

                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <x-crm-input
                                type="number"
                                name="loan_amount"
                                id="loan_amount"
                                :value="$client->cashLoanProduct->loan_amount ?? 0"
                                required
                            />
                            <x-crm-label for="loan_amount" :value="__('Loan cash')" />
                            {{-- Error message from the back end --}}
                            <x-input-error class="mt-2" :messages="$errors->get('loan_amount')" />
                        </div>
                    </div>
                    <button type="submit"
                        class="focus:outline-none text-white bg-amber-500 hover:bg-amber-700 focus:ring-4 focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-amber-900">
                        {{ __('Update Cash Loan') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('client.scripts.client-form-validation')
</x-app-layout>
