<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    course name
                </th>
                <th scope="col" class="px-6 py-3">
                    teacher
                </th>
                <th scope="col" class="px-6 py-3">
                    start time
                </th>
                <th scope="col" class="px-6 py-3">
                    cancel
                </th>
                <th scope="col" class="px-6 py-3">
                    comment
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$course->name}}
                </th>
                <td class="px-6 py-4">
                    {{$course->teacher->name}}
                </td>
                <td class="px-6 py-4">
                    {{$course->start_time}}
                </td>
                <td class="px-6 py-4">
                    <form action="{{ url('/student/cancel/' . $course->id) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <button>click</button>
                    </form>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ url('/student/comment/' . $course->id) }}">click</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>