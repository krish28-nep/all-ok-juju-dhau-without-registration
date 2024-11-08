document.addEventListener('DOMContentLoaded', function () {
    // Check if any of the required elements exist in the DOM
    if (document.querySelector('.menuItem') || document.querySelector('.sliderItem') || document.querySelector('.product-item')) {
        const menuItems = document.querySelectorAll('.menuItem');
        const sliderItems = document.querySelectorAll('.sliderItem');
        const product_items = document.querySelectorAll('.product-item');

        // Check if there are menu items
        if (menuItems.length === 0 || sliderItems.length === 0 || product_items.length === 0) {
            console.error('Menu items or slider items are not found in the DOM.');
            return; // Exit the function if elements are not found
        }

        menuItems.forEach(item => {
            item.addEventListener('click', function () {
                const index = this.getAttribute('data-index');

                // Hide all slider items
                sliderItems.forEach(sliderItem => {
                    sliderItem.style.display = 'none'; // Hide all items
                });

                product_items.forEach(product_item => {
                    product_item.style.display = 'none'; // Hide all items
                });

                // Show the selected slider item and product item
                if (sliderItems[index]) {
                    sliderItems[index].style.display = 'flex'; // Show the selected item
                }
                if (product_items[index]) {
                    product_items[index].style.display = 'block'; // Show the selected item
                }

                // Remove 'active' class from all menu items
                menuItems.forEach(menu => {
                    menu.classList.remove('active');
                });

                // Add 'active' class to the clicked menu item
                this.classList.add('active');
            });
        });

        // Optional: Show the first slider item and product item initially
        sliderItems.forEach((sliderItem, index) => {
            sliderItem.style.display = index === 0 ? 'flex' : 'none';
        });
        product_items.forEach((product_item, index) => {
            product_item.style.display = index === 0 ? 'block' : 'none';
        });

        // Set the first menu item as active initially
        if (menuItems.length > 0) {
            menuItems[0].classList.add('active');
        }
    } else {
        console.error('No menu items, slider items, or product items found in the DOM.');
    }
});
