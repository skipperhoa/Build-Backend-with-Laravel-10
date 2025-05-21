<x-app-layout>
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Create User` }">
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

    {{-- error message --}}

    @if ($errors->any())
        <div
            class="rounded-xl border border-warning-500 bg-warning-50 p-4 dark:border-warning-500/30 dark:bg-warning-500/15">
            <div class="flex items-start gap-3">
                <div class="-mt-0.5 text-warning-500 dark:text-orange-400">
                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3.6501 12.0001C3.6501 7.38852 7.38852 3.6501 12.0001 3.6501C16.6117 3.6501 20.3501 7.38852 20.3501 12.0001C20.3501 16.6117 16.6117 20.3501 12.0001 20.3501C7.38852 20.3501 3.6501 16.6117 3.6501 12.0001ZM12.0001 1.8501C6.39441 1.8501 1.8501 6.39441 1.8501 12.0001C1.8501 17.6058 6.39441 22.1501 12.0001 22.1501C17.6058 22.1501 22.1501 17.6058 22.1501 12.0001C22.1501 6.39441 17.6058 1.8501 12.0001 1.8501ZM10.9992 7.52517C10.9992 8.07746 11.4469 8.52517 11.9992 8.52517H12.0002C12.5525 8.52517 13.0002 8.07746 13.0002 7.52517C13.0002 6.97289 12.5525 6.52517 12.0002 6.52517H11.9992C11.4469 6.52517 10.9992 6.97289 10.9992 7.52517ZM12.0002 17.3715C11.586 17.3715 11.2502 17.0357 11.2502 16.6215V10.945C11.2502 10.5308 11.586 10.195 12.0002 10.195C12.4144 10.195 12.7502 10.5308 12.7502 10.945V16.6215C12.7502 17.0357 12.4144 17.3715 12.0002 17.3715Z"
                            fill=""></path>
                    </svg>
                </div>

                <div>
                    <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                        Warning Message
                    </h4>

                    <ul class="text-sm text-gray-500 dark:text-gray-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    @endif

    <!-- ====== Form Elements Section Start -->
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mt-2">
            <div class="space-x-12">
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-5 py-4 sm:px-6 sm:py-5">
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                            Thông tin cá nhân
                        </h3>
                    </div>
                    <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">

                        <!-- Elements -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Name
                            </label>
                            <input type="text" placeholder="Hoa Nguyen Coder" name="name"
                                value="{{ $user?->name }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                        </div>

                        <!-- Elements -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Email
                            </label>
                            <input type="text" placeholder="nguyen.thanh.hoa.ctec@gmail.com" name="email"
                                value="{{ $user?->email }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                        </div>

                        <!-- Elements -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Password
                            </label>
                            <input type="password" placeholder="Password" name="password" value="{{ $user?->password }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />

                        </div>

                        <!-- Elements -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Confirm Password
                            </label>
                            <input type="password" placeholder="Confirm Password" name="password_confirmation"
                                value="{{ $user?->password }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                        </div>



                        <!-- Elements -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Phone
                            </label>
                            <input type="text" placeholder="123456789" name="phone" value="{{ $user?->phone }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                        </div>

                        <!-- Elements -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Multiple Select Role
                            </label>
                            <div>
                                <select class="hidden" x-cloak id="select">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>

                                <div x-data="dropdown()" x-init="loadOptions()" class="flex flex-col items-center">
                                    <input type="hidden" class="arr_role_edit" value="{{ $user->roles }}" />
                                    <input name="roles" class="roles" type="hidden" :value="selectedValues()" />
                                    <div class="relative z-20 inline-block w-full">
                                        <div class="relative flex flex-col items-center">
                                            <div @click="open" class="w-full">
                                                <div
                                                    class="shadow-theme-xs focus:border-brand-300 focus:shadow-focus-ring dark:focus:border-brand-300 mb-2 flex h-11 rounded-lg border border-gray-300 py-1.5 pr-3 pl-3 outline-hidden transition dark:border-gray-700 dark:bg-gray-900">
                                                    <div class="flex flex-auto flex-wrap gap-2">
                                                        <template x-for="(option,index) in selected"
                                                            :key="index">
                                                            <div
                                                                class="group flex items-center justify-center rounded-full border-[0.7px] border-transparent bg-gray-100 py-1 pr-2 pl-2.5 text-sm text-gray-800 hover:border-gray-200 dark:bg-gray-800 dark:text-white/90 dark:hover:border-gray-800">
                                                                <div class="max-w-full flex-initial"
                                                                    x-model="options[option]"
                                                                    x-text="options[option].text">
                                                                </div>
                                                                <div class="flex flex-auto flex-row-reverse">
                                                                    <div @click="remove(index,option)"
                                                                        class="cursor-pointer pl-2 text-gray-500 group-hover:text-gray-400 dark:text-gray-400">
                                                                        <svg class="fill-current" role="button"
                                                                            width="14" height="14"
                                                                            viewBox="0 0 14 14" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd"
                                                                                clip-rule="evenodd"
                                                                                d="M3.40717 4.46881C3.11428 4.17591 3.11428 3.70104 3.40717 3.40815C3.70006 3.11525 4.17494 3.11525 4.46783 3.40815L6.99943 5.93975L9.53095 3.40822C9.82385 3.11533 10.2987 3.11533 10.5916 3.40822C10.8845 3.70112 10.8845 4.17599 10.5916 4.46888L8.06009 7.00041L10.5916 9.53193C10.8845 9.82482 10.8845 10.2997 10.5916 10.5926C10.2987 10.8855 9.82385 10.8855 9.53095 10.5926L6.99943 8.06107L4.46783 10.5927C4.17494 10.8856 3.70006 10.8856 3.40717 10.5927C3.11428 10.2998 3.11428 9.8249 3.40717 9.53201L5.93877 7.00041L3.40717 4.46881Z"
                                                                                fill="" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>
                                                        <div x-show="selected.length == 0" class="flex-1">
                                                            <input placeholder="Select option"
                                                                class="h-full w-full appearance-none border-0 bg-transparent p-1 pr-2 text-sm outline-hidden placeholder:text-gray-800 focus:border-0 focus:ring-0 focus:outline-hidden dark:placeholder:text-white/90"
                                                                :value="selectedValues()" />
                                                        </div>
                                                    </div>
                                                    <div class="flex w-7 items-center py-1 pr-1 pl-1">
                                                        <button type="button" @click="open"
                                                            class="h-5 w-5 cursor-pointer text-gray-700 outline-hidden focus:outline-hidden dark:text-gray-400"
                                                            :class="isOpen() === true ? 'rotate-180' : ''">
                                                            <svg class="stroke-current" width="20" height="20"
                                                                viewBox="0 0 20 20" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M4.79175 7.39551L10.0001 12.6038L15.2084 7.39551"
                                                                    stroke="" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-full px-4">
                                                <div x-show.transition.origin.top="isOpen()"
                                                    class="max-h-select absolute top-full left-0 z-40 w-full overflow-y-auto rounded-lg bg-white shadow-sm dark:bg-gray-900"
                                                    @click.outside="close">
                                                    <div class="flex w-full flex-col">
                                                        <template x-for="(option,index) in options"
                                                            :key="index">
                                                            <div>
                                                                <div class="hover:bg-primary/5 w-full cursor-pointer rounded-t border-b border-gray-200 dark:border-gray-800"
                                                                    @click="select(index,$event)">
                                                                    <div :class="option.selected ? 'border-primary' : ''"
                                                                        class="relative flex w-full items-center border-l-2 border-transparent p-2 pl-2">
                                                                        <div class="flex w-full items-center">
                                                                            <div class="mx-2 leading-6 text-gray-800 dark:text-white/90"
                                                                                x-model="option" x-text="option.text">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    List Permissions from Role
                                </span>
                                <div class="permissions mt-2 flex flex-wrap gap-2">

                                </div>
                            </div>
                        </div>



                        <!-- Elements -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Upload Avatar file
                            </label>

                                <input type="file" name="avatar"
                                    class="focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:text-white/90 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 dark:placeholder:text-gray-400" />

                            <div
                                class="w-20 h-20 mt-2 overflow-hidden border border-gray-200 rounded-full dark:border-gray-800">
                                <img src="{{ $user?->avatar }}" alt="user" id="avatar"
                                    class="h-full w-full object-cover object-center" />
                            </div>
                        </div>

                        <!-- Elements -->
                        <div class="">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Status
                            </label>

                            <div x-data="{ switcherToggle: {{ $user->status>0 ? 'true' : 'false' }} }">

                                <label for="toggle1"
                                    class="flex cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                    <div class="relative">
                                        <input type="hidden" name="status" :value="switcherToggle ? 1 : 0" />
                                        <input type="checkbox" id="toggle1" class="sr-only"
                                            @change="switcherToggle = !switcherToggle">
                                        <div class="block h-6 w-11 rounded-full  dark:bg-white/10"
                                            :class="switcherToggle ? 'bg-brand-500 dark:bg-brand-500' :
                                                'bg-gray-200 dark:bg-white/10'">
                                        </div>
                                        <div :class="switcherToggle ? 'translate-x-full' : 'translate-x-0'"
                                            class="shadow-theme-sm absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300 ease-linear translate-x-0">
                                        </div>
                                    </div>


                                </label>
                            </div>



                        </div>

                        <div>
                            <button
                                class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                                Update User
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
    <!-- ====== Form Elements Section End -->
    <script>
        // check avatar file
        const input = document.querySelector('input[type="file"]');
        input.addEventListener('change', function() {
            const file = this.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('avatar');
                img.setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(file);
        });
        // check avatar file

        function dropdown() {
            return {
                options: [],
                selected: [],
                show: false,
                open() {

                    this.show = true;
                },
                close() {
                    this.show = false;
                },
                isOpen() {
                    return this.show === true;
                },
                select(index, event) {
                    //console.log(this.selected);
                    if (!this.options[index].selected) {
                        this.options[index].selected = true;
                        this.options[index].element = event.target;
                        console.log("hoa", index);
                        this.selected.push(index);
                    } else {
                        this.selected.splice(this.selected.lastIndexOf(index), 1);
                        this.options[index].selected = false;
                    }
                    console.log(this.options[index].value);

                    this.getPermissionsFromRoleId();
                },
                remove(index, option) {

                    this.options[option].selected = false;
                    this.selected.splice(index, 1);
                    if (this.selected.length > 0) {
                        this.getPermissionsFromRoleId();
                    } else {
                        $(".permissions").html("");
                    }
                },
                loadOptions() {


                    const options = document.getElementById("select").options;
                    for (let i = 0; i < options.length; i++) {
                        this.options.push({
                            value: options[i].value,
                            text: options[i].innerText,
                            selected: options[i].getAttribute("selected") != null ?
                                options[i].getAttribute("selected") :
                                false,
                        });
                    }
                    this.setItemDefault();
                    this.getPermissionsFromRoleId();
                },
                getPermissionsFromRoleId() {
                    let str_role = this.selected.toString();
                    $.ajax({
                        url: "/admin/roles/" + str_role + "/permissions",
                        type: "GET",
                        success: function(data) {
                            console.log(data);
                            let permissions = data.permissions;
                            let html = "";
                            for (let i = 0; i < permissions.length; i++) {
                                html +=
                                    '<span class="inline-flex items-center justify-center gap-1 rounded-full bg-gray-500 px-2.5 py-0.5 text-sm font-medium text-white dark:bg-white/5 dark:text-white">' +
                                    permissions[i].name +
                                    "</span>";
                            }
                            $(".permissions").html(html);
                        },
                    });
                },
                setItemDefault() {
                    const collection = document.getElementsByClassName("arr_role_edit");
                    const value = collection[0].value;
                    const options = document.getElementById("select").options;
                    for (let i = 0; i < options.length; i++) {
                        if (options[i].value == value) {

                            this.options[i].selected = true;
                            this.options[i].element = value;
                            this.selected.push(i);
                        }


                    }
                    collection[0].remove();

                },

                selectedValues() {

                    return this.selected.map((option) => {
                        return this.options[option].value;
                    });
                },
            };
        }
    </script>

</x-app-layout>
