<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-10">
    <!-- Product Form Section -->
    <div class="col-span-1">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-md lg:text-2xl font-bold mb-4">Manage Products</h2>
            <form id="categoryForm" enctype="multipart/form-data" >
                <input type="hidden" id="cateId" name="id" />
                <input type="hidden" name="action" value="create" />

                <div class="mb-4">
                    <label class="block text-sm lg:text-md">Name</label>
                    <input
                        type="text"
                        id="cate_name"
                        name="cate_name"
                        class="input py-1 input-sm input-warning input-bordered w-full"
                        required
                    />
                </div>

                

                <button type="submit" id="submitCategory" class="btn btn-primary w-full">
                    Save Category
                </button>
            </form>
        </div>
    </div>

    <!-- Product List Section -->
<div class="col-span-1 bg-white rounded-md shadow-md px-4 py-2">
        <h2 class="text-xl font-bold py-2 ">Category List</h2>
        <div id="categoryList" class="mt-4 lg:max-h-[40vh] overflow-y-auto   rounded-md grid grid-cols-1 lg:grid-cols-2 gap-2"></div>
    </div>
</div>
