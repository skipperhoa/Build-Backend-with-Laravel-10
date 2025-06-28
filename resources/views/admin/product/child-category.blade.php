@php
    $category_id_edit = $category->id ?? null;
@endphp
@foreach ($child_categories as $child)
    <option value="{{ $child->id }}" {{ $child->id == $category_id_edit ? 'selected' : '' }} >
        {{ str_repeat('-', $level + 2) }} {{ $child->title }}
    </option>
    @if ($child->children->isNotEmpty())
        @include('admin.product.child-category', [
            'category' => $child,
            'child_categories' => $child->children,
            'level' => $level + 3
        ])
    @endif
@endforeach
