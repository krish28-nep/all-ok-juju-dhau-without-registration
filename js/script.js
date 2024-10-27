document.addEventListener("DOMContentLoaded", function() {
    const wrapper = document.querySelector(".sliderWrapper");
    const navBottom = document.querySelector("#navBottom");
    const currentProductImg = document.querySelector(".productImg");
    const currentProductTitle = document.querySelector(".productTitle");
    const currentProductPrice = document.querySelector(".productPrice");
    const currentProductDescription = document.querySelector(".productDisc");
    const currentProductSizes = document.querySelectorAll("input[name='liter']");
    const sizeContainer = document.querySelector(".sizes");
    let currentIndex = 0;

    // Products array with base prices, descriptions, and list titles
    const products = [
        { 
            id: 1, 
            list_title: 'Matka-Dhau',
            title: "Matka-Dhau", 
            basePrice: 300, 
            description: "A traditional clay pot yogurt with a rich and creamy texture.", 
            img: "image/matka-dhau.png",
            bgColor: "green"
        },
        { 
            id: 2, 
            list_title: 'Kalla-Dhau',
            title: "Kalla-Dhau", 
            basePrice: 250, 
            description: "A delicious and thick yogurt made from cow's milk.", 
            img: "image/kalla-dhau.png",
            bgColor: "rebeccapurple"
        },
        { 
            id: 3, 
            list_title: 'Cup-Dhau',
            title: "Cup-Dhau", 
            basePrice: 60, 
            description: "A convenient cup of yogurt, perfect for on-the-go consumption.", 
            img: "image/cup.png",
            bgColor: "teal"
        },
        { 
            id: 4, 
            list_title: 'Plastic-Dhau',
            title: "Plastic-Dhau", 
            basePrice: 200, 
            description: "A modern packaging option for your favorite yogurt.", 
            img: "image/plastic.png",
            bgColor: "cornflowerblue"
        },
        { 
            id: 5, 
            list_title: 'Special Combo',
            title: "Combo Kalla-Dhau + Cup-Dhau", 
            basePrice: 300, 
            description: "Enjoy the best of both worlds with this combo pack.", 
            img: "image/combo.png",
            bgColor: "goldenrod"
        }
    ];

    const sizeMultipliers = {
        "1ltr": 1,
        "3ltr": 3,
        "4ltr": 4
    };

    // Generate and append navBottom menu items using list_title
    products.forEach((product, index) => {
        const menuItem = document.createElement("li");
        menuItem.innerHTML = `<button class="menuItem">${product.list_title}</button>`;
        if (index === 0) menuItem.querySelector("button").classList.add("active");
        menuItem.querySelector("button").addEventListener("click", () => updateSlider(index, true));
        navBottom.appendChild(menuItem);
    });

    // Create and append slider items
    products.forEach((product, index) => {
        const sliderItem = document.createElement("div");
        sliderItem.className = "sliderItem";
        sliderItem.style.setProperty("--bg-color", product.bgColor);
        sliderItem.innerHTML = `
            <img src="${product.img}" alt="" class="sliderImage" />
            <div class="slideBg"></div>
            <h1 class="sliderTitle">${product.title}</h1>
            <h2 class="sliderPrice">RS ${product.basePrice}</h2>
            <a class="buyButton" href="#product">BUY NOW!</a>
        `;
        wrapper.appendChild(sliderItem);
    });

    // Function to update the active menu item and slide
    function updateSlider(index, updateProduct = false) {
        wrapper.style.transform = `translateX(${-100 * index}vw)`; 

        document.querySelectorAll(".menuItem").forEach(item => item.classList.remove('active'));
        document.querySelectorAll(".menuItem")[index].classList.add('active');

        if (updateProduct) {
            const chosenProduct = products[index];
            currentProductTitle.textContent = chosenProduct.title;
            currentProductImg.src = chosenProduct.img;
            currentProductPrice.textContent = `RS ${chosenProduct.basePrice}`;
            currentProductDescription.textContent = chosenProduct.description;

            // Show or hide size options based on product type
            sizeContainer.style.display = chosenProduct.title === "Cup-Dhau" ? "none" : "flex";
        }

        currentIndex = index;
    }

    // Update the price dynamically when the radio button is selected
    currentProductSizes.forEach((sizeInput) => {
        sizeInput.addEventListener("change", () => {
            const selectedSize = sizeInput.value;
            const chosenProduct = products[currentIndex];
            let newPrice;

            // Check if the selected product is the Combo
            if (chosenProduct.title === "Combo Kalla-Dhau + Cup-Dhau") {
                newPrice = (products[1].basePrice * sizeMultipliers[selectedSize]) + 60;
            } else {
                newPrice = chosenProduct.basePrice * sizeMultipliers[selectedSize];
            }

            // Update the displayed price
            currentProductPrice.textContent = `RS ${newPrice}`;
        });
    });

    // Initialize the slider with the first product
    updateSlider(0, true);
});