<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
            {{ __('Products Report') }}
        </h2>
        <hr class="mb-4 border-blue-500" />
        <div class="flex justify-between items-center mx-4">
            <a type="button" href="{{ route('clients.index') }}" title="{{ __('Back to clients page') }}"
                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                {{ __('Back') }}
            </a>

            @include('client.partials.show-flash-message')

            <a href="{{ route('advisor.report.csv') }}"
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                {{ __('Export To CSV File') }}
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
                                {{ __('Product Type') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Product Value') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Creation Date') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            @php
                                $bgColor = $loop->odd ? 'bg-gray-50 dark:bg-gray-800' : 'bg-white dark:bg-gray-700';
                            @endphp
                            <tr class="{{ $bgColor }}">
                                <td class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $product['type'] }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $product['type'] === 'Cash Loan' ? $product['loan_amount'] : "{$product['property_value']} - {$product['down_payment']}" }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $product['updated_at'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $products->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

