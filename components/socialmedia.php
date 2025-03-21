<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-10">
    <!-- Product Form Section -->
    <div class="col-span-1">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-md lg:text-2xl font-bold mb-4">Manage Social media</h2>
            <form id="socialmediaForm" enctype="multipart/form-data" >
                <input type="hidden" id="socialmediaId" name="id" />
                <input type="hidden" name="socialmedia-action" value="create" />

                <div class="mb-4">
                    <label class="block text-sm lg:text-md">Platform</label>
                    <input
                        type="text"
                        id="platform"
                        name="platform"
                        class="input py-1 input-sm input-warning input-bordered w-full"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label class="block text-sm lg:text-md">url</label>
                    <input
                        type="text"
                        id="url"
                        name="url"
                        class="input py-1 input-sm input-warning input-bordered w-full"
                        required
                    />
                </div>

                

                <button type="submit" id="submitSocialmedia" class="btn btn-primary w-full">
                    Save Social media
                </button>
            </form>
        </div>
    </div>

    <!-- Product List Section -->
    <div class="col-span-1">
        <h2 class="text-xl font-bold mt-6">Social media List</h2>
        <div id="socialmediaList" class="mt-4"></div>
    </div>
</div>
