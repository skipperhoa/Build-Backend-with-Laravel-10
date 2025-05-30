 <!-- Elements -->
 <div>
     <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Add More Permissions
      </label>
     <select class="hidden select_permissions" x-cloak id="select_permissions">

     </select>

     <div  class="flex flex-col items-center">
         <input type="hidden" class="arr_permission_edit" value="{{ $user->permissions }}" />
         <input name="permissions"  type="hidden" :value="selectedValues_permission()" />
         <div class="relative z-20 inline-block w-full">
             <div class="relative flex flex-col items-center">
                  <div @click="open_permission" class="w-full">
                     <div
                         class="shadow-theme-xs focus:border-brand-300 focus:shadow-focus-ring dark:focus:border-brand-300 mb-2 flex h-11 rounded-lg border border-gray-300 py-1.5 pr-3 pl-3 outline-hidden transition dark:border-gray-700 dark:bg-gray-900">
                         <div class="flex flex-auto flex-wrap gap-2">
                             <template x-for="(option,index) in selected_permission" :key="index">
                                 <div
                                     class="group flex items-center justify-center rounded-full border-[0.7px] border-transparent bg-success-50 py-1 pr-2 pl-2.5 text-sm text-gray-800 hover:border-gray-200 dark:bg-gray-800 dark:text-white/90 dark:hover:border-gray-800">
                                     <div class="max-w-full flex-initial" x-model="options_permission[option]"
                                         x-text="options_permission[option].text">
                                     </div>
                                     <div class="flex flex-auto flex-row-reverse">
                                         <div @click="remove_permission(index,option)"
                                             class="cursor-pointer pl-2 text-gray-500 group-hover:text-gray-400 dark:text-gray-400">
                                             <svg class="fill-current" role="button" width="14" height="14"
                                                 viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                 <path fill-rule="evenodd" clip-rule="evenodd"
                                                     d="M3.40717 4.46881C3.11428 4.17591 3.11428 3.70104 3.40717 3.40815C3.70006 3.11525 4.17494 3.11525 4.46783 3.40815L6.99943 5.93975L9.53095 3.40822C9.82385 3.11533 10.2987 3.11533 10.5916 3.40822C10.8845 3.70112 10.8845 4.17599 10.5916 4.46888L8.06009 7.00041L10.5916 9.53193C10.8845 9.82482 10.8845 10.2997 10.5916 10.5926C10.2987 10.8855 9.82385 10.8855 9.53095 10.5926L6.99943 8.06107L4.46783 10.5927C4.17494 10.8856 3.70006 10.8856 3.40717 10.5927C3.11428 10.2998 3.11428 9.8249 3.40717 9.53201L5.93877 7.00041L3.40717 4.46881Z"
                                                     fill="" />
                                             </svg>
                                         </div>
                                     </div>
                                 </div>
                             </template>
                             <div x-show="selected_permission.length == 0" class="flex-1">
                                 <input placeholder="Select option"
                                     class="h-full w-full appearance-none border-0 bg-transparent p-1 pr-2 text-sm outline-hidden placeholder:text-gray-800 focus:border-0 focus:ring-0 focus:outline-hidden dark:placeholder:text-white/90"
                                     :value="selectedValues_permission()" />
                             </div>
                         </div>
                         <div class="flex w-7 items-center py-1 pr-1 pl-1">
                             <button type="button" @click="open_permission"
                                 class="h-5 w-5 cursor-pointer text-gray-700 outline-hidden focus:outline-hidden dark:text-gray-400"
                                 :class="isOpen_permission() === true ? 'rotate-180' : ''">
                                 <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                     <path d="M4.79175 7.39551L10.0001 12.6038L15.2084 7.39551" stroke=""
                                         stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                 </svg>
                             </button>
                         </div>
                     </div>
                 </div>
                 <div class="w-full px-4">
                     <div x-show.transition.origin.top="isOpen_permission()"
                         class="max-h-select absolute top-full left-0 z-40 w-full overflow-y-auto rounded-lg bg-white shadow-sm dark:bg-gray-900"
                         @click.outside="close_permission">
                         <div class="flex w-full flex-col">
                             <template x-for="(option,index) in options_permission" :key="index">
                                 <div>
                                     <div class="hover:bg-primary/5 w-full cursor-pointer rounded-t border-b border-gray-200 dark:border-gray-800"
                                         @click="select_permission(index,$event)">
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
 <!-- ====== Form Elements Section End -->
