<x-app-layout>
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `List Api` }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName"></h2>

            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                            href="index.html">
                            Home
                            <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke=""
                                    stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90" x-text="pageName"></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Breadcrumb End -->



    <div
        class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 mt-2 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
        <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">

                </h3>
            </div>

            <div class="flex items-center gap-3">
                <div>
                    <form action="{{ route('admin.list.all.api') }}" method="GET">
                        <label>Tìm kiếm : </label>
                        <input type="text" name="search" placeholder="Tìm kiếm"class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800  rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"/>
                    </form>
                </div>

            </div>
        </div>

        <div class="w-full overflow-x-auto">
            <table class="min-w-full">
                <!-- table header start -->
                <thead>
                    <tr class="border-gray-100 border-y dark:border-gray-800">
                        <th class="py-3">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    HTTP Method
                                </p>
                            </div>
                        </th>

                        <th class="py-3">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Route
                                </p>
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Name
                                </p>
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="flex items-center col-span-2">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                  Corresponding Action
                                </p>
                            </div>
                        </th>

                    </tr>
                </thead>
                <!-- table header end -->

                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                   @php
                      $color = [
                        "DELETE" => "#FF0000",
                        "GET|HEAD" => "#0a6ff9",
                        "POST" => "#f9c60a",
                        "PUT|PATCH" => "#f9970a",
                        "PATCH" => "#0000FF",
                        "HEAD" => "#4B0082",
                        "OPTIONS" => "#9400D3"
                      ]
                   @endphp
                   @foreach ($paginatedRoutes as $value)
                        @php
                            $getColor = $color[$value['method']]


                        @endphp
                        <tr class="border-gray-100 dark:border-gray-800">
                            <td class="text-sm py-2 " style="color: {{$getColor}}">{{$value['method']}}</td>
                            <td class="text-sm py-2">{{$value['uri']}}</td>
                            <td class="text-sm py-2">{{$value['name'] }}</td>
                            <td class="text-sm py-2">{{$value['action'] }}</td>
                        </tr>
                   @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">

                            {{ $paginatedRoutes->links() }}

                        </td>
                    </tr>
            </table>
        </div>
    </div>
</x-app-layout>
