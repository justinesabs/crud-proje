<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center h-screen">

    <h1 class="text-4xl font-bold mb-6 text-blue-700">CRUD App</h1>

    <!-- Text Fields for User Input -->
    <input type="text" id="item-name" placeholder="Enter Item Name"
        class="mb-4 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-80 p-2.5">
    
    <input type="text" id="item-description" placeholder="Enter Item Description"
        class="mb-6 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-80 p-2.5">

    <!-- Submit Button -->
    <button onclick="submitItem()"
        class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-300 mb-4">
        Submit
    </button>

    <!-- Fetch Items Button -->
    <button onclick="fetchItems()"
        class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-300">
        Fetch Items
    </button>

    <!-- Notification Area -->
    <div id="notification" class="mt-4 text-center text-gray-700"></div>

    <!-- Item List Container -->
    <div id="item-list" class="mt-6 bg-white p-4 rounded shadow w-80 h-64 overflow-auto"></div>

    <script>
        // Function to fetch items
        function fetchItems() {
            axios.get('/api/items')
                .then(response => {
                    const itemList = document.getElementById('item-list');
                    itemList.innerHTML = '';  // Clear previous results

                    response.data.forEach(item => {
                        const itemDiv = document.createElement('div');
                        itemDiv.className = 'p-2 border-b border-gray-200 text-gray-800';
                        itemDiv.textContent = `${item.id}: ${item.name}: ${item.description}`;
                        itemList.appendChild(itemDiv);
                    });
                    displayNotification('Items loaded successfully! No errors detected.', 'text-green-600');
                })
                .catch(error => {
                    console.error('Error fetching items:', error);
                    displayNotification('Error loading items. Please try again.', 'text-red-500');
                });
        }

        // Function to submit an item
        function submitItem() {
            const name = document.getElementById('item-name').value;
            const description = document.getElementById('item-description').value;

            // Validate inputs
            if (!name || !description) {
                displayNotification('Please enter both name and description.', 'text-yellow-500');
                return;
            }

            const newItem = { name, description };

            axios.post('/api/items', newItem)
                .then(response => {
                    displayNotification('Item submitted successfully! No errors detected.', 'text-green-600');
                    fetchItems();  // Refresh the item list after submission
                })
                .catch(error => {
                    console.error('Error submitting item:', error);
                    displayNotification('Failed to submit item.', 'text-red-500');
                });
        }

        // Function to display notifications
        function displayNotification(message, className) {
            const notificationDiv = document.getElementById('notification');
            notificationDiv.textContent = message;
            notificationDiv.className = className + ' mt-4';
        }
    </script>
</body>
</html>
