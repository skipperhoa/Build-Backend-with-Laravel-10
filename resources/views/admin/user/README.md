### Tích hợp User Permission
Đầu tiền chúng ta cần xây dựng table chứa mối quan hệ giữa User và Permission 
```php
Schema::create('user_permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('permission_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->timestamps();
        });
    }
```

Sau đó ta cần thiết lập Model User và Permission, thiết lập mỗi quan hệ giữa chúng
```php 
// User Model
  public function permissions(){
        return $this->belongsToMany(Permission::class,'user_permission', 'user_id', 'permission_id');
    }
// Permission model
 public function users() {
        return $this->belongsToMany(User::class, 'user_permission', 'permission_id', 'user_id');
    }
```
Khi chúng ta thiết lập xong, việc còn lại là viết chức năng chỉnh sửa cho việc thêm permission vào user thôi
```php
// function edit user in controller
       // lấy các role_id của user
        $arr_roles = $user->roles()->pluck('role_id')->toArray(); 
        // lấy các permission_id của user
        $arr_permissions = $user->permissions()->get()->pluck('id')->toArray(); 

        // chuyển đổi mảng role_id thành chuỗi
        $user->roles = implode(',',$arr_roles); 

        // chuyển đổi mảng permission_id thành chuỗi
        $user->permissions = implode(',',$arr_permissions); 
       
         // lấy các role trong user
        $roles_from_user = Role::whereIn('id', $arr_roles)->with('permissions')->get();
       // dd($roles_from_user->pluck('id')->toArray(), $roles_from_user->pluck('permissions')->flatten()->pluck('id')->toArray());

        if ($roles_from_user) {
            // chổ này ta cần lấy danh sách permission_id ra thành 1 mảng
            $arr_id_permission= $roles_from_user->pluck('permissions')->flatten()->pluck('id')->toArray();
            // chổ này ta cần lấy các permission_id , khác với mảng $arr_id_permission
            $permissions = Permission::whereNotIn('id',$arr_id_permission )->get();

            // bây giờ ta sẽ được các permission không thuộc user
        }


```


Tiếp tục hàm chỉnh sửa ,
```php
// function update user trong controller
        if($user){
            $arr_roles= explode(',',$request->roles);
            $roles = Role::whereIn('id',$arr_roles)->pluck('id')->toArray();
            $user->roles()->sync($roles);
            // Xử lý permissions nếu có
            if ($request->has('permissions')) {
                $arr_permissions = explode(',', $request->permissions);
                $permissions = Permission::whereIn('id', $arr_permissions)->pluck('id')->toArray();
                $user->permissions()->sync($permissions);
            } else {
                $user->permissions()->detach(); // Xóa tất cả permissions nếu không có
            }
        }

```
Quan trọng là chổ ta hiện thị dữ liệu ra giao diện, để cho javascript nó lấy value mà tính toán role và permission để nó load select option, chú ý ở chổ này
```html
  <input type="hidden" class="arr_role_edit" value="{{ $user->roles }}" />
  <input name="roles" class="roles" type="hidden" :value="selectedValues()" />
  <input type="hidden" class="arr_permission_edit" value="{{ $user->permissions }}" />
  <input name="permissions"  type="hidden" :value="selectedValues_permission()" />
```
Xử lý ajax load các permission ra giao diện
```javascript
// views/admin/user/edit.blade.php 

 getPermissionsFromRoleId() {
                    const roles = this.options;
                    const selectedRoles = roles.filter(role => role.selected);
                    const selectedRoleValues = selectedRoles.map(role => role.value);
                    let selectedRoleString = selectedRoleValues.join(",");
                    selectedRoleString = selectedRoleString.length > 0 ? selectedRoleString : "-1";

                    $.ajax({
                        url: "/admin/roles/" + selectedRoleString + "/permissions",
                        type: "GET",
                        success: function(data) {
                            console.log("before", data)
                            let permissions = data.permissions;
                            let html = "";
                            for (let i = 0; i < permissions.length; i++) {
                                html +=
                                    '<span class="inline-flex items-center justify-center gap-1 rounded-full bg-gray-500 px-2.5 py-0.5 text-sm font-medium text-white dark:bg-white/5 dark:text-white">' +
                                    permissions[i].name +
                                    "</span>";
                            }
                            $(".permissions").html(html);

                            if (data.permissions_not_in_roles.length > 0) {
                                console.log("check data.permissions_not_in_roles", data
                                    .permissions_not_in_roles)
                                let html_not_in_roles = "";
                                for (let i = 0; i < data.permissions_not_in_roles.length; i++) {
                                    html_not_in_roles +=
                                        '<option value="' + data.permissions_not_in_roles[i].id + '">' +
                                        data.permissions_not_in_roles[i].name +
                                        "</option>";
                                }
                                $(".select_permissions").html(html_not_in_roles);

                            }
                        },
                    });
                },
```
