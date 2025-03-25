<!-- Manage Category as a collapsible panel -->
<div class="collapse collapse-arrow bg-base-100 border border-base-300 w-full">
  <input type="checkbox" /> <!-- checkbox-based toggle -->

  <div class="collapse-title text-lg lg:text-2xl font-bold">
    Manage Category
  </div>

  <div class="collapse-content grid grid-cols-1 lg:grid-cols-2 gap-6 text-sm">
    <!-- Category Form Section -->
    <div>
      <form id="categoryForm" enctype="multipart/form-data">
        <input type="hidden" id="cateId" name="id" />
        <input type="hidden" name="action" value="create" />

        <div class="mb-4">
          <label class="block text-sm lg:text-md">Name</label>
          <input
            type="text"
            id="cate_name"
            name="cate_name"
            class="input py-1  input-warning input-bordered w-full"
            required
          />
        </div>

        <button type="submit" id="submitCategory" class="btn btn-primary w-full">
          Save Category
        </button>
      </form>
    </div>

    <!-- Category List Section -->
    <div>
      <h2 class="text-lg font-bold pb-2">Category List</h2>
      <div class="lg:max-h-[70vh] rounded-md w-full overflow-auto">
        <table class="table w-full table-fixed">
          <thead class="sticky top-0 z-[999] bg-white">
            <tr>
              <th class="w-[30%] sm:w-[20%] text-left px-2"></th>
              <th class="w-[70%] sm:w-[80%] text-left px-2">Category Name</th>
            </tr>
          </thead>
          <tbody id="categoryList">
            <!-- Data rows will go here -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
