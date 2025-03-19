<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <link
      href="https://cdn.jsdelivr.net/npm/daisyui@2.51.5/dist/full.css"
      rel="stylesheet"
      type="text/css"
    />
  </head>
  <body class="p-6 bg-gray-100">
    <!-- MANAGE PRODUCT -->
    <div class="grid grid-cols-1 lg:grid-cols-2">
      <div class="col-span-1">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
          <h2 class="text-2xl font-bold mb-4">Manage Products</h2>
          <form id="productForm" enctype="multipart/form-data">
            <input type="hidden" id="productId" name="id" />
            <input type="hidden" name="action" value="create" />

            <div class="mb-4">
              <label class="block">Name</label>
              <input
                type="text"
                id="name"
                name="name"
                class="input input-bordered w-full"
                required
              />
            </div>

            <div class="mb-4">
              <label class="block">Brand</label>
              <input
                type="text"
                id="brand"
                name="brand"
                class="input input-bordered w-full"
                required
              />
            </div>

            <div class="mb-4">
              <label class="block">Category</label>
              <select
                id="category"
                name="category"
                class="select select-bordered w-full"
                required
              ></select>
            </div>

            <div class="mb-4">
              <label class="block">Price</label>
              <input
                type="number"
                id="price"
                name="price"
                class="input input-bordered w-full"
                required
              />
            </div>

            <div class="mb-4">
              <label class="block">Description</label>
              <textarea
                id="description"
                name="description"
                class="textarea textarea-bordered w-full"
              ></textarea>
            </div>

            <div class="mb-4">
              <label class="block">Detail</label>
              <textarea
                id="detail"
                name="detail"
                class="textarea textarea-bordered w-full"
              ></textarea>
            </div>

            <div class="mb-4">
              <label class="block">Status</label>
              <select
                id="status"
                name="status"
                class="select select-bordered w-full"
              >
                <option value="ACTIVE">ACTIVE</option>
                <option value="INACTIVE">INACTIVE</option>
                <option value="DRAFT">DRAFT</option>
              </select>
            </div>

            <div class="mb-4">
              <label class="block">Images</label>
              <input
                type="file"
                id="images"
                name="images[]"
                class="file-input file-input-bordered w-full"
                multiple
              />
              <div id="fileList"></div>
              <div id="imagesList" class="flex flex-row"></div>
            </div>

            <button type="submit" class="btn btn-primary w-full">
              Save Product
            </button>
          </form>
        </div>

      </div>
        <div class="col-span-1 ">
          <h2 class="text-xl font-bold mt-6">Product List</h2>
          <div id="productList" class="mt-4"></div>
        </div>
    </div>

    <!-- MODAL -->
     <div
    id="productModalOwner"
    class="p-0 overflow-y-auto fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-[99999] transition-all duration-300 ease-out"
>
        <div class="overflow-y-auto p-4 bg-white rounded-lg lg:min-h-[40vh] lg:max-h-[80vh] max-w-[80vw] lg:max-w-[60vw] relative w-full">
            <!-- Close Button -->
            <button id="modalCloseOwner" class="absolute top-2 right-2 text-gray-500 hover:text-black text-3xl">
                &times;
            </button>

            <div class="flex flex-col md:flex-row gap-4 py-2 h-full justify-start md:justify-center">
                <!-- Left: Image Carousel -->
                <div class="w-full md:w-1/3 lg:w-1/2 rounded-lg relative">
                    <div class="overflow-x-auto snap-x snap-mandatory">
                        <div id="modalCarouselOnwer" class="flex flex-nowrap w-full">
                            <!-- Images will be injected here -->
                        </div>
                    </div>
                </div>

                <!-- Right: Product Details -->
                <div class="w-full md:w-1/2 flex flex-col py-2">
                    <!-- Top: Name + Category + Price -->
                    <div class="flex flex-wrap justify-between items-center mb-3 w-full">
                        <div class="flex items-center gap-2">
                            <h2 id="modalProductNameOnwer" class="text-xl font-bold"></h2>
                            <span id="modalProductCategoryOnwer" class="inline-block px-3 py-1 bg-yellow-400 text-black rounded-full text-sm lg:text-md"></span>
                        </div>
                        <p id="modalProductPriceOnwer" class="text-lg font-semibold text-green-700"></p>
                    </div>

                    <!-- Other Info -->
                    <div class="space-y-2 w-full h-full">
                        <div class="w-full">
                            <h4 class="font-semibold text-sm lg:text-md">Brand:</h4>
                            <p id="modalProductBrandOnwer" class="text-sm lg:text-md text-gray-700 break-words"></p>
                        </div>

                        <div class="w-full">
                            <h4 class="font-semibold text-sm lg:text-md">Description:</h4>
                            <p id="modalProductDescriptionOnwer" class="text-sm lg:text-md text-gray-600 break-words w-full"></p>
                        </div>

                        <div class="w-full">
                            <h4 class="font-semibold text-sm lg:text-md">Details:</h4>
                            <p id="modalProductDetailOnwer" class="text-sm lg:text-md text-gray-600 break-words w-full"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <script src="script/create-update-product.js"></script>
  </body>
</html>
