<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-10">
    <!-- Product Form Section -->
    <div class="col-span-1">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-md lg:text-2xl font-bold mb-4">Manage Products</h2>
            <form id="productForm" enctype="multipart/form-data">
                <input type="hidden" id="productId" name="id" />
                <input type="hidden" name="action" value="create" />

                <div class="mb-4">
                    <label class="block text-sm lg:text-md">Name</label>
                    <input
                        type="text"
                        id="product-name"
                        name="name"
                        class="input py-1 input-sm input-warning input-bordered w-full"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label class="block text-sm lg:text-md">Brand</label>
                    <input
                        type="text"
                        id="brand"
                        name="brand"
                        class="input input-bordered py-1 input-sm input-warning w-full"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label class="block text-sm lg:text-md">Category</label>
                    <select
                        id="category"
                        name="category"
                        class="select select-bordered select-sm select-warning w-full"
                        required
                    ></select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm lg:text-md">Price</label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        class="input input-bordered py-1 input-sm input-warning w-full"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label class="block text-sm lg:text-md">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="textarea textarea-bordered w-full textarea-warning"
                    ></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm lg:text-md">Detail</label>
                    <textarea
                        id="detail"
                        name="detail"
                        class="textarea textarea-bordered w-full textarea-warning"
                    ></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm lg:text-md">Status</label>
                    <select
                        id="status"
                        name="status"
                        class="select select-bordered w-full select-sm select-warning"
                    >
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                        <option value="DRAFT">DRAFT</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm lg:text-md">Images</label>
                    <input
                        type="file"
                        id="images"
                        name="images[]"
                        class="file-input file-input-bordered w-full file-input-warning"
                        multiple
                    />
                    <div id="fileList"></div>
                    <div id="imagesList" class="flex flex-row"></div>
                </div>

                <button type="submit" id="submitProduct" class="btn btn-primary w-full">
                    Save Product
                </button>
            </form>
        </div>
    </div>

    <!-- Product List Section -->
    <div class="col-span-1">
        <h2 class="text-xl font-bold mt-6">Product List</h2>
        <div id="productList" class="mt-4"></div>
    </div>
</div>
