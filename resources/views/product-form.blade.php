<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Image preview -->
                    <div class="mt-2">
                        <img id="productImagePreview" 
                        src="{{ isset($product) && $product->product_image ? asset('storage/Uploads/Product Images/'.$product->product_image) : '' }}"
                        alt="Image Preview" style="max-width: 64px; display: none;" />
                    </div>
                    
                    <form method="POST" action="{{ isset($product) ? route('product.update', $product->product_id) : route('product.store') }}" enctype="multipart/form-data" class="p-4">

                        @csrf
                        @isset ($product)
                            @method('PUT')
                        @endisset

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <!-- Image -->
                            <div>
                                <label for="product_image" class="block text-sm font-medium text-gray-700">Product Image</label>
                                <input type="file" id="product_image" name="product_image"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <!-- Product Name -->
                            <div>
                                <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                <input type="text" id="product_name" name="product_name" value="{{isset($product)  ? $product->product_name : old('product_name') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select id="category" name="category"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="" disabled selected>Select a category</option>
                                    @foreach ($categories as $index => $category)
                                        <option value="{{$category->category_id}}" {{isset($product)  && $product->category_id == $category->category_id ? 'selected' : ''}}>
                                            {{$index + 1}}.{{$category->category_name}}
                                        </option>
                                    <!-- Add category options here -->
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" id="price" name="price" value="{{isset($product)  ? $product->price : old('price') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <!-- Stock -->
                            <div>
                                <label for="stocks" class="block text-sm font-medium text-gray-700">Stock</label>
                                <input type="number" id="stocks" name="stocks" value="{{isset($product)  ? $product->stocks : old('stocks') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        
                        <div class="mt-4 flex justify-end">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{isset($product) ? 'SAVE' : 'ADD'}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('product_image').addEventListener('change', function(event) {
            const input = event.target;
            const preview = document.getElementById('productImagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
</x-app-layout>

