<x-app-layout>
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Create Product` }">
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
    <form action="{{ route('admin.products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mt-2">
            <div class="space-x-12">
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-5 py-4 sm:px-6 sm:py-5">
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                            Thông Tin Sản phẩm
                        </h3>
                    </div>
                    <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">
                             <!-- Elements -->
                                <div>
                                    <label  fol="Title" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Title
                                    </label>
                                    <input type="text" placeholder="Title" name="title" value="{{ $product->title }}"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>

                              <!-- Elements -->
                                <div>
                                    <label for="Slug" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Slug
                                    </label>
                                    <input type="text" placeholder="Slug" name="slug"
                                        value="{{ $product->slug }}"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>

                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">
                             <!-- Elements -->
                                <div>
                                    <label  fol="Keyword" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Keyword
                                    </label>
                                    <input type="text" placeholder="Keyword" name="keywords" value="{{ $product->keywords }}"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>

                              <!-- Elements -->
                                <div>
                                    <label for="Description" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Description
                                    </label>
                                    <input type="text" placeholder="Description" name="description"
                                        value="{{ $product->description }}"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>

                        </div>

                          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">
                             <!-- Elements -->
                                <div>
                                    <label for="Category" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Category
                                    </label>
                                    <div>
                                         <select name="category_id" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                            @foreach ($categories as $cate)
                                                <option value="{{ $cate->id }}" {{ $cate->id == $product->category->id ? 'selected' : '' }}>{{ $cate->title }} </option>
                                                @if ($cate->children->isNotEmpty())
                                                    @include('admin.product.child-category', ['category' => $product->category,'child_categories' => $cate->children,'level'=>1])

                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                              <!-- Elements -->
                                <div>
                                    <label for="Price" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Price
                                    </label>
                                    <input type="text" placeholder="Price" name="price"
                                        value="{{ $product->price }}"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>

                        </div>




                        <!-- Elements -->
                        <div class="grid grid-cols-1 gap-4 md:gap-6">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Product Picture
                                </label>

                                     <div class="flex flex-row items-center gap-5">
                                        <div
                                            class="w-20 h-20 mt-2 overflow-hidden border border-gray-200 rounded-xl dark:border-gray-800">
                                            <img src="{{ asset($product->image) }}" alt="user"
                                                id="image" class="h-full w-full object-cover object-center" />
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <input type="file" name="file"
                                        class="w-[200px] focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:text-white/90 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 dark:placeholder:text-gray-400" />
                                            <span class="text-sm text-gray-500">Chỉ hổ trợ : jpg, jpeg, png</span>
                                        </div>
                                    </div>





                            </div>
                        </div>

                        <!-- Elements -->
                         <div class="grid grid-cols-1 gap-4 md:gap-6">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                   Body
                                </label>
                                <textarea name="body" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" id="my-editor" cols="30" rows="10">{{ $product->body }}</textarea>

                            </div>
                        </div>

                        <div class="flex flex-row items-center gap-4 justify-between md:gap-6">
                           <div>
                              <button
                                    class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-black transition rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">
                                   Save as Daft
                            </button>
                           </div>
                            <div class="flex flex-row items-center gap-2">
                                <button
                                    class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-black transition rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">
                                   Reset data
                                </button>
                                <button
                                    class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                                    Submit Data
                                </button>
                            </div>
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
                const img = document.getElementById('image');
                img.setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(file);
        });
        // check avatar file
    </script>
@push('scripts')
<script src="https://cdn.ckeditor.com/4.5.11/full-all/ckeditor.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/adapters/jquery.js"></script>
<script>
  var options = {
    filebrowserImageBrowseUrl: '/auth/laravel-filemanager?type=document',
    filebrowserImageUploadUrl: '/auth/laravel-filemanager/upload?type=document&_token=',
    filebrowserBrowseUrl: '/auth/laravel-filemanager?type=document',
    filebrowserUploadUrl: '/auth/laravel-filemanager/upload?type=document&_token=',
    // Kích hoạt plugin Code Snippet
    versionCheck: false,
    extraPlugins: 'codesnippet',
    codeSnippet_theme: 'default', // Chọn theme cho code snippet
    // toolbar: [
    //   { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
    //   { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'CodeSnippet'] }, // Thêm nút CodeSnippet
    //   { name: 'document', items: ['Source', 'Preview'] }
    // ]
};
  CKEDITOR.replace('my-editor', options);
</script>
@endpush
</x-app-layout>
