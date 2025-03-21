<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-10">
    <!-- Product Form Section -->
    <div class="col-span-1">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-md lg:text-2xl font-bold mb-4">Manage Contact</h2>
            <form id="contactForm" enctype="multipart/form-data" >
                <input type="hidden" id="contactId" name="id" />
                <input type="hidden" name="contact-action" value="create" />

                <div class="mb-4">
                    <label class="block text-sm lg:text-md">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="input py-1 input-sm input-warning input-bordered w-full"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label class="block text-sm lg:text-md">Phone</label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        class="input py-1 input-sm input-warning input-bordered w-full"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label class="block text-sm lg:text-md">Other</label>
                    <input
                        type="text"
                        id="other"
                        name="other"
                        class="input py-1 input-sm input-warning input-bordered w-full"
                        required
                    />
                </div>

                

                <button type="submit" id="submitContact" class="btn btn-primary w-full">
                    Save Contact
                </button>
            </form>
        </div>
    </div>

    <!-- Product List Section -->
    <div class="col-span-1">
        <h2 class="text-xl font-bold mt-6">Contact List</h2>
        <div id="contactList" class="mt-4"></div>
    </div>
</div>
