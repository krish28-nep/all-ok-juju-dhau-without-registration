$(document).on('keyup', '.searchInput', function () {
    const searchInput = $(this);
    const searchQuery = searchInput.val().trim(); // Trim whitespace
    const suggestionsList = searchInput.siblings('.suggestions-list');

    if (searchQuery.length > 0) {
        $.ajax({
            url: 'search_suggestions.php',
            method: 'GET',
            data: { search_keyword: searchQuery },
            success: function (response) {
                if (response.trim() !== '') { // Check if the response is not empty
                    suggestionsList.html(response).show();
                } else {
                    suggestionsList.hide();
                }
            },
            error: function () {
                suggestionsList.hide(); // Hide on AJAX error
            }
        });
    } else {
        suggestionsList.hide();
    }

    // Hide other suggestions lists
    $('.suggestions-list').not(suggestionsList).hide();
});

// Hide suggestions when clicking outside
$(document).click(function (e) {
    if (!$(e.target).closest('.search').length) { // Ensure the search container is specified
        $('.suggestions-list').hide();
    }
});

// Populate search input with the clicked suggestion and submit the form
$(document).on('click', '.suggestion-item', function () {
    const suggestionItem = $(this);
    const searchInput = suggestionItem.closest('.search').find('.searchInput');
    searchInput.val(suggestionItem.text());
    suggestionItem.closest('.suggestions-list').hide();

    // Trigger the search form submission
    const searchForm = searchInput.closest('form'); // Find the closest form
    searchForm.submit();
});
