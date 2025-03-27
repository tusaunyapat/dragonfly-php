<!-- Manage Contact as a collapsible panel -->
<div class="collapse collapse-arrow bg-base-100 border border-base-300 col-span-1 w-full rounded-xl ">
  <input type="checkbox" /> <!-- checkbox-based toggle -->

  <div class="collapse-title text-lg lg:text-2xl font-bold">
    จัดการรายชื่อ admin
  </div>

  <div class="collapse-content text-sm grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Contact Form -->
    <div>
      <form id="contactForm" enctype="multipart/form-data">
        <input type="hidden" id="contactId" name="id" />
        <input type="hidden" name="contact-action" value="create" />

        <div class="mb-4">
          <label class="block text-sm lg:text-md">ชื่อ</label>
          <input
            type="text"
            id="name"
            name="name"
            class="input py-1  input-warning input-bordered w-full"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">เบอร์โทรศัพท์</label>
          <input
            type="text"
            id="phone"
            name="phone"
            class="input py-1  input-warning input-bordered w-full"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">อื่น ๆ</label>
          <input
            type="text"
            id="other"
            name="other"
            class="input py-1  input-warning input-bordered w-full"
            
          />
        </div>

        <button type="submit" id="submitContact" class="btn btn-primary w-full">
          เพิ่มรายชื่อ
        </button>
      </form>
    </div>

    <!-- Contact List -->
    <div>
      <h2 class="text-lg font-bold pb-2">รายชื่อ admin</h2>
      <div class="lg:max-h-[70vh] rounded-md w-full overflow-auto">
        <table class="table">
          <thead class="sticky top-0 z-[999] bg-white">
            <tr>
              <th class="w-[5%] text-left px-1"></th>
              <th class="w-[30%] text-left px-1">ชื่อ</th>
              <th class="w-[20%] text-left px-1">เบอร์โทรศัพท์</th>
              <th class="w-[45%] text-left px-1">อื่น ๆ</th>
            </tr>
          </thead>
          <tbody id="contactList"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
