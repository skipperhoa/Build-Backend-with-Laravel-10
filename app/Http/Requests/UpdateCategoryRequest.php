<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Chỉnh sửa data trước khỉ request
     */

    public function prepareForValidation()
    {
        $this->merge([
            'category_id' => $this->category_id ?? null,
            'slug' => $this->slug ?? Str::slug($this->title),
            //'image' => $this->image??null
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:categories,title,'.$this->category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'slug' => 'nullable|string|max:255|unique:categories,slug,'.$this->category->id,

        ];
    }

    public function messages() : array
    {
        return [
           'title.required' => 'Vui lòng nhập tiêu đề danh mục.',
            'title.unique'   => 'Tiêu đề này đã tồn tại, hãy chọn tiêu đề khác.',
            'slug.unique' => 'Slug bị trùng',
        ];
    }
}
