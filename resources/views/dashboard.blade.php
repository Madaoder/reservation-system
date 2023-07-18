<x-app-layout>
    <x-slot name="header" class="flex justify-between h-16">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Courses
        </h2>
        <div>
            <a type="button" href="{{ url('/teacher/create') }}">create Course</a>
        </div>
    </x-slot>


    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Course name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        start time
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    @foreach($courses as $key=>$course)
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{$course->name}}
                    </th>
                    <td class="px-6 py-4">
                        {{$course->start_time}}
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>

</x-app-layout>