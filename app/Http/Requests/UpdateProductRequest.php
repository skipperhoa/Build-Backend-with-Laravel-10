<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateProductRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:products,title,'.$this->product->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'slug' => 'nullable|string|max:255|unique:products,slug,'.$this->product->id,
            'keywords' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages() : array
    {
        return [
           'title.required' => 'Vui lòng nhập tiêu đề sản phẩm.',
            'title.unique'   => 'Tiêu đề này đã tồn tại, hãy chọn tiêu đề khác.',
            'slug.unique' => 'Slug bị trùng',
            'keywords.required' => 'Vui lòng nhập Keywords',
            'description.required' => 'Vui lòng nhập Description',
            'price.required' => 'Vui lòng nhập giá',
            'category_id.required' => 'Vui lòng chọn danh mục',
        ];
    }
}
