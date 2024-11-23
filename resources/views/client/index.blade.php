<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
            {{ __('Clients') }}
        </h2>
        <hr class="mb-4 border-blue-500" />
        <div class="flex justify-between items-center mx-4">
            <a type="button" href="{{ route('dashboard') }}"
                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                {{ __('Back') }}
            </a>
            @if (session('client-action'))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 4000)"
                    class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                    role="alert"
                >
                    {{ session('client-action') }}
                </div>
            @endif
            <a href="{{ route('clients.create') }}"
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                {{ __('Add A New Client') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-bold text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('First Name') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Last Name') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Email') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Phone') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Cash Loan') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Home Loan') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            @php
                                $bgColor = $loop->odd ? 'bg-gray-50 dark:bg-gray-800' : 'bg-white dark:bg-gray-700';
                            @endphp
                            <tr class="{{ $bgColor }}">
                                <td class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $client->first_name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $client->last_name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $client->email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $client->phone }}
                                </td>
                                <td
                                    class="px-6 py-4 font-bold {{ $client->cashLoanProduct ? 'text-green-700 dark:text-green-500' : 'text-red-700 dark:text-red-500' }}">
                                    {{ $client->cashLoanProduct ? 'Yes' : 'No' }}
                                </td>
                                <td
                                    class="px-6 py-4 font-bold {{ $client->homeLoanProduct ? 'text-green-700 dark:text-green-500' : 'text-red-700 dark:text-red-500' }}">
                                    {{ $client->homeLoanProduct ? 'Yes' : 'No' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($client->advisor_id == auth()->user()->id)
                                        <button type="button"
                                            class="focus:outline-none text-black bg-orange-400 hover:bg-orange-500 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">
                                            {{ __('Edit') }}
                                        </button>
                                        <button type="button"
                                            class="focus:outline-none text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-500 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                            {{ __('Delete') }}
                                        </button>
                                    @else
                                        <span class="text-blue-500 dark:text-gray-400">
                                            {{ __('No permissions for this client') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $clients->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
