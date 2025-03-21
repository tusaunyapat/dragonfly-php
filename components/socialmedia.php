<!-- Manage Social Media as a collapsible panel -->
<div class="collapse collapse-arrow bg-base-100 border border-base-300 w-full">
  <input type="checkbox" /> <!-- checkbox-based toggle -->

  <div class="collapse-title text-lg lg:text-2xl font-bold">
    Manage Social Media
  </div>

  <div class="collapse-content grid grid-cols-1 lg:grid-cols-2 gap-6 text-sm">
    <!-- Social Media Form Section -->
    <div>
      <form id="socialmediaForm" enctype="multipart/form-data">
        <input type="hidden" id="socialmediaId" name="id" />
        <input type="hidden" name="socialmedia-action" value="create" />

        <div class="mb-4">
          <label class="block text-sm lg:text-md">Platform</label>
          <input
            type="text"
            id="platform"
            name="platform"
            class="input py-1  input-warning input-bordered w-full"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm lg:text-md">URL</label>
          <input
            type="text"
            id="url"
            name="url"
            class="input py-1  input-warning input-bordered w-full"
            required
          />
        </div>

        <button type="submit" id="submitSocialmedia" class="btn btn-primary w-full">
          Save Social Media
        </button>
      </form>
    </div>

    <!-- Social Media List Section -->
    <div>
      <h2 class="text-lg font-bold pb-2">Social Media List</h2>
      <div class="lg:max-h-[40vh] rounded-md w-full overflow-auto">
        <table class="table w-full table-fixed">
          <thead class="sticky top-0 z-[999] bg-white">
            <tr>
              <th class="w-[10%] text-left px-2"></th>
              <th class="w-[40%] text-left px-2">Platform</th>
              <th class="w-[50%] text-left px-2">URL</th>
            </tr>
          </thead>
          <tbody id="socialmediaList">
            <!-- Dynamic social media rows go here -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
