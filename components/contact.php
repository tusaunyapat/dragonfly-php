<!-- Manage Contact as a collapsible panel -->
<div class="collapse collapse-arrow bg-base-100 border border-base-300 col-span-1 w-full">
  <input type="checkbox" /> <!-- checkbox-based toggle -->

  <div class="collapse-title text-lg lg:text-2xl font-bold">
    Manage Contact
  </div>

  <div class="collapse-content text-sm grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Contact Form -->
    <div>
      <form id="contactForm" enctype="multipart/form-data">
        <input type="hidden" id="contactId" name="id" />
        <input type="hidden" name="contact-action" value="create" />

        <div class="mb-4">
          <label class="block text-sm lg:text-md">Name</label>
          <input
            type="text"
            id="name"
            name="name"
            class="input py-1  input-warning input-bordered w-full"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">Phone</label>
          <input
            type="text"
            id="phone"
            name="phone"
            class="input py-1  input-warning input-bordered w-full"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">Other</label>
          <input
            type="text"
            id="other"
            name="other"
            class="input py-1  input-warning input-bordered w-full"
            required
          />
        </div>

        <button type="submit" id="submitContact" class="btn btn-primary w-full">
          Save Contact
        </button>
      </form>
    </div>

    <!-- Contact List -->
    <div>
      <h2 class="text-lg font-bold pb-2">Contact List</h2>
      <div class="lg:max-h-[70vh] rounded-md w-full overflow-auto">
        <table class="table">
          <thead class="sticky top-0 z-[999] bg-white">
            <tr>
              <th class="w-[5%] text-left px-1"></th>
              <th class="w-[30%] text-left px-1">Name</th>
              <th class="w-[20%] text-left px-1">Phone</th>
              <th class="w-[45%] text-left px-1">Other</th>
            </tr>
          </thead>
          <tbody id="contactList"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
