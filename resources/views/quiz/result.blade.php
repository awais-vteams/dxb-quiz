<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Result') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <table class="table divide-y divide-gray-300">
                        <tbody>
                            <tr>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Correct Answer</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $result->correct_answers }}</td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Wrong Answer</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $result->wrong_answers }}</td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Skip Answer</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $result->skip_answers }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
