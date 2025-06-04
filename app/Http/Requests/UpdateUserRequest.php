<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // đặt "true" để test, trong trường hợp khác nên check can permission nhé
        return true;
    }

    /**
     * Chỉnh sửa data trước khỉ request
     */

    public function prepareForValidation()
    {

        $this->merge([
            'status' => $this->status?? $this->user->id
        ]);
    }

    public function messages() : array
    {
        return  [
            'name.required' => 'Vui lọc nhập tên người dùng',
            'email.required' => 'Vui lọc nhập email',
            'avatar.required' => 'Vui lọc chọn avatar',
            'password.required' => 'Vui lọc nhập mật khẩu',
            'password.confirmed' => 'Vui lòng nhập lại mật khẩu để xác nhận',
            'roles.required' => 'Vui lọc chọn vai trò',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

         return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'roles' => 'required|exists:roles,id',
        ];
    }
}
