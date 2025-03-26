<!-- Manage Product as a collapsible panel -->
<div class="collapse collapse-arrow bg-base-100 border border-base-300 w-full">
  <input type="checkbox" checked="checked"/> <!-- checkbox toggle -->

  <div class="collapse-title text-lg lg:text-2xl font-bold">
    Manage Products
  </div>

  <div class="collapse-content grid grid-cols-1 lg:grid-cols-2 gap-6 text-sm">
    <!-- Product Form Section -->
    <div>
      <form id="productForm" enctype="multipart/form-data">
        <input type="hidden" id="productId" name="id" />
        <input type="hidden" name="action" value="create" />

        <div class="mb-4">
          <label class="block text-sm lg:text-md">Name</label>
          <input type="text" id="product-name" name="name" class="input py-1  input-warning input-bordered w-full" required />
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">Brand</label>
          <input type="text" id="brand" name="brand" class="input input-bordered py-1  input-warning w-full" required />
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">Category</label>
          <div id="category" name="category" class="w-full flex flex-row flex-wrap gap-4 py-2"></div>
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">Price</label>
          <input type="number" id="price" name="price" class="input input-bordered py-1  input-warning w-full" required />
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">Description</label>
          <textarea id="description" name="description" class="textarea textarea-bordered w-full textarea-warning"></textarea>
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">Detail</label>
          <textarea id="detail" name="detail" class="textarea textarea-bordered w-full textarea-warning"></textarea>
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">Status</label>
          <select id="status" name="status" class="select select-bordered w-full select-sm select-warning">
            <option value="ACTIVE">ACTIVE</option>
            <option value="INACTIVE">INACTIVE</option>
            <option value="DRAFT">DRAFT</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">Images</label>
          <input type="file" id="images" name="images[]" class="file-input file-input-bordered w-full file-input-warning" multiple />
          <div id="fileList" class="mt-2"></div>
          <div id="imagesList" class="flex flex-wrap gap-2 mt-2"></div>
        </div>

        <button type="submit" id="submitProduct" class="btn btn-primary w-full">
          Save Product
        </button>
      </form>
    </div>

    <!-- Product List Section -->
    <div>
      <h2 class="text-lg font-bold pb-2">Product List</h2>
      <div class="lg:max-h-[40vh] rounded-md w-full overflow-auto">
        <table class="table w-full table-fixed">
          <thead class="sticky top-0 z-[999] bg-white">
            <tr>
              <th class="w-[25%] sm:w-[20%] text-left px-2"></th>
              <th class="w-[25%] text-left px-2">Name</th>
              <th class="w-[25%] text-left px-2">Status</th>
              <th class="w-[15%] text-left px-2">Price</th>
            </tr>
          </thead>
          <tbody id="productList">
            <!-- Data rows will go here -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
