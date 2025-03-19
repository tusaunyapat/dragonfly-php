<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.5/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Manage Products</h2>
        <form id="productForm" enctype="multipart/form-data">
            <input type="hidden" id="productId" name="id">
            <input type="hidden" name="action" value="create">
            <div class="mb-4">
                <label class="block">Name</label>
                <input type="text" id="name" name="name" class="input input-bordered w-full" required>
            </div>
            <div class="mb-4">
                <label class="block">Brand</label>
                <input type="text" id="brand" name="brand" class="input input-bordered w-full" required>
            </div>
            <div class="mb-4">
                <label class="block">Category</label>
                <select id="category" name="category" class="select select-bordered w-full" required></select>
            </div>
            <div class="mb-4">
                <label class="block">Price</label>
                <input type="number" id="price" name="price" class="input input-bordered w-full" required>
            </div>
            <div class="mb-4">
                <label class="block">Description</label>
                <textarea id="description" name="description" class="textarea textarea-bordered w-full"></textarea>
            </div>
            <div class="mb-4">
                <label class="block">Detail</label>
                <textarea id="detail" name="detail" class="textarea textarea-bordered w-full"></textarea>
            </div>
            <div class="mb-4">
                <label class="block">Status</label>
                <select id="status" name="status" class="select select-bordered w-full">
                    <option value="ACTIVE">ACTIVE</option>
                    <option value="INACTIVE">INACTIVE</option>
                    <option value="DRAFT">DRAFT</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block">Images</label>
                <input type="file" id="images" name="images[]" class="file-input file-input-bordered w-full" multiple>
                <div id="fileList"></div>
                <div id="imagesList" class="flex flex-row"></div>
            </div>
            <button type="submit" class="btn btn-primary w-full">Save Product</button>
        </form>
        <h2 class="text-xl font-bold mt-6">Product List</h2>
        <div id="productList" class="mt-4"></div>
    </div>
    <script src="script/create-update-product.js"></script>
</body>
</html>
