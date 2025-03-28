<!-- Manage Product as a collapsible panel -->
<div class="collapse collapse-arrow bg-base-100 border border-base-300 w-full rounded-xl">
  <input type="checkbox" checked="checked"/> <!-- checkbox toggle -->

  <div class="collapse-title text-lg lg:text-2xl font-bold">
    จัดการสินค้า
  </div>

  <div class="collapse-content grid grid-cols-1 lg:grid-cols-2 gap-6 text-sm">
    <!-- Product Form Section -->
    <div>
      <form id="productForm" enctype="multipart/form-data">
        <input type="hidden" id="productId" name="id" />
        <input type="hidden" name="action" value="create" />

        <div class="mb-4">
          <label class="block text-sm lg:text-md">ชื่อสินค้า</label>
          <input type="text" id="product-name" name="name" class="input py-1  input-warning input-bordered w-full" required />
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">ยี่ห้อสินค้า</label>
          <input type="text" id="brand" name="brand" class="input input-bordered py-1  input-warning w-full" required />
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">หมวดหมู่สินค้า</label>
          <div id="category" name="category" class="w-full flex flex-row flex-wrap gap-4 py-2"></div>
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">ราคา</label>
          <input type="number" id="price" name="price" class="input input-bordered py-1  input-warning w-full" required />
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">คำอธิบายสินค้าอย่างย่อ</label>
          <textarea id="description" name="description" class="textarea textarea-bordered w-full textarea-warning"></textarea>
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">รายละเอียดสินค้า</label>
          <textarea id="detail" name="detail" class="textarea textarea-bordered w-full textarea-warning"></textarea>
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">สถานะสินค้า</label>
          <select id="status" name="status" class="select select-bordered w-full select-sm select-warning">
            <option value="ACTIVE">แสดงสินค้า</option>
            <option value="INACTIVE">ไม่แสดงสินค้า</option>
            <option value="DRAFT">ร่างสินค้า</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">รูปภาพ</label>
          <input type="file" id="images" name="images[]" class="file-input file-input-bordered w-full file-input-warning" multiple />
          <div id="fileList" class="mt-2"></div>
          <div id="imagesList" class="flex flex-wrap gap-2 mt-2"></div>
        </div>

        <button type="submit" id="submitProduct" class="btn btn-primary w-full">
          เพิ่มสินค้า
        </button>
      </form>
    </div>

    <!-- Product List Section -->
    <div>
      <h2 class="text-lg font-bold pb-2">รายการสินค้า</h2>
      <div class="lg:max-h-[40vh] rounded-md w-full overflow-auto">
        <table class="table w-full table-fixed">
          <thead class="sticky top-0 z-[999] bg-white">
            <tr>
              <th class="w-[25%] sm:w-[20%] text-left px-2"></th>
              <th class="w-[25%] text-left px-2">ชื่อสินค้า</th>
              <th class="w-[25%] text-left px-2">สถานะ</th>
              <th class="w-[15%] text-left px-2">ราคา</th>
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
