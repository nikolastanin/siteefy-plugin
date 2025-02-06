(function($) {
    $(document).ready(function() {

        let search = $('#siteefy_search');
        let clearInput =  $('.btn-text-clear');
        let searchResults = $('.search-output__container');

       if(typeof variable === 'undefined'){
           searchTermOld = '';
       }
        if(searchTermOld){
            search.val(searchTermOld);
            clearInput.removeClass('hidden');
        }
        //activate search field on page load.
        search.focus();
        let testOutput = $('#search-output');

        let typingTimer;  // Timer identifier
        const typingDelay = 500;  // Delay in milliseconds (1.5s)
        search.on('input', function(){
            clearTimeout(typingTimer);  // Clear the previous timer on every new input
            typingTimer = setTimeout(function() {
                showSearchResults();  // Call your function after 1.5s delay
            }, typingDelay);
        });


        search.on('click',showSearchResults);
        //hide searh results when clicking outside of container.
        $('body').click(function (event){
            if(!$(event.target).closest('.search-field__main').length && !$(event.target).is('.search-field__main')) {
                clearInput.addClass('hidden');
                searchResults.addClass('hidden');
            }
        });
        //show search results.
       async function showSearchResults() {
            let searchTerm = search.val();
           // You can further handle the results, like updating the DOM or displaying them
            if (searchTerm !== '') {
                clearInput.removeClass('hidden');
                searchResults.removeClass('hidden');
                testOutput.html(`Searching for <span class="search-term">${searchTerm}</span> in our library.`);
            } else {
                clearInput.addClass('hidden');
                searchResults.addClass('hidden');
                testOutput.html('');
            }
           let ajaxResults = await getSearchResults(searchTerm); // Wait for the search results
           console.log(ajaxResults.data)
           $('#search-results').html(ajaxResults.data);
       }
        // submit search on enter key press.
        $('#siteefy_search').on('keypress', function(e) {
            if (e.which === 13) {
                submitSearch(e);
            }
        });
        $('.btn-search').on('click', function(e){
            submitSearch(e);
        });
        $('.search-top').on('click', function(e){
            submitSearch(e);
        });

        function submitSearch(e){
            e.preventDefault();
            if(search.val()!=''){
                $('#search-form').submit();
            }
        }

        // clearInputField
        clearInput.on('click',clearInputField);
        function clearInputField(){
            search.val('');
            testOutput.html('');
            clearInput.addClass('hidden');
            search.focus();
            showSearchResults();
        }

        function getSearchResults(searchTerm) {
            return new Promise((resolve, reject) => {
                // Check if the searchTerm is in localStorage
                let cachedResults;
                let useCache = siteefy_settings_main.useCache;
                if (useCache) {
                    cachedResults = localStorage.getItem(`searchCache${searchTerm}`);
                } else {
                    cachedResults = false;
                }
                console.log(searchTerm)
                let searchCache = cachedResults ? JSON.parse(cachedResults) : {};

                // If cached, return the cached result
                if (searchCache[searchTerm]) {
                    resolve(searchCache[searchTerm]);
                    return;
                }

                // If not cached, make the AJAX request
                jQuery.ajax({
                    type: "get",
                    dataType: "json",
                    url: my_ajax_object.ajax_url,
                    data: {
                        action: 'get_search_results_inline',
                        searchQuery: searchTerm
                    },
                    success: function(msg) {
                        // Cache the result in localStorage
                        searchCache[searchTerm] = msg;
                        if(useCache){
                            localStorage.setItem(`searchCache${searchTerm}`, JSON.stringify(searchCache));
                        }
                        resolve(msg);  // Return the result on success
                    },
                    error: function(err) {
                        reject(err);  // Handle the error
                    }
                });
            });
        }




        $('.tool-item').on('click', function() {
            // Get the value of the data-link attribute
            var link = $(this).data('link');

            // Navigate to the link
            if (link) {
                window.location.href = link;
            }
        });



        // Detect scroll event
        $(window).on('scroll', function() {
            var scrollPosition = $(window).scrollTop();

            // Check if the scroll position exceeds a certain threshold (e.g., 50px)
            if (scrollPosition > 50) {
                $('header.new').css('background', '-webkit-linear-gradient(-30deg,#0811DE 0%,#08C8F6 79%)');
            } else {
                // Revert back to the original color when scrolling back to the top
                $('header.new').css('background', 'transparent');
            }
        });


    });
})( jQuery );