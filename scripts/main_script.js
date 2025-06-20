(function($) {
    $(document).ready(function() {

        let search = $('#siteefy_search');
        let clearInput = $('.btn-text-clear');
        let searchResults = $('.search-output__container');

        if (typeof variable === 'undefined') {
            searchTermOld = '';
        }
        if (searchTermOld) {
            search.val(searchTermOld);
            clearInput.removeClass('hidden');
        }
        //activate search field on page load.
        search.focus();
        let testOutput = $('#search-output');

        let typingTimer; // Timer identifier
        const typingDelay = 500; // Delay in milliseconds (1.5s)
        search.on('input', function() {
            clearTimeout(typingTimer); // Clear the previous timer on every new input
            typingTimer = setTimeout(function() {
                showSearchResults(); // Call your function after 1.5s delay
            }, typingDelay);
        });


        search.on('click', showSearchResults);
        //hide searh results when clicking outside of container.
        $('body').click(function(event) {
            if (!$(event.target).closest('.search-field__main').length && !$(event.target).is('.search-field__main')) {
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
        $('.btn-search').on('click', function(e) {
            submitSearch(e);
        });
        $('.search-top').on('click', function(e) {
            submitSearch(e);
        });

        function submitSearch(e) {
            e.preventDefault();
            if (search.val() != '') {
                $('#search-form').submit();
            }
        }

        // clearInputField
        clearInput.on('click', clearInputField);

        function clearInputField() {
            search.val('');
            testOutput.html('');
            clearInput.addClass('hidden');
            search.focus();
            showSearchResults();
        }

        function getSearchResults(searchTerm) {
            return new Promise((resolve, reject) => {
                // Skip cache for empty searches
                if (!searchTerm || searchTerm.trim() === '') {
                    resolve({ data: '' });
                    return;
                }

                const searchTermLower = searchTerm.toLowerCase().trim();
                const cacheKey = `siteefy_search_${searchTermLower}`;
                const cacheExpiryKey = `siteefy_search_expiry_${searchTermLower}`;
                const useCache = siteefy_settings_main.useCache;

                // Check cache if enabled
                if (useCache) {
                    const cachedData = localStorage.getItem(cacheKey);
                    const cacheExpiry = localStorage.getItem(cacheExpiryKey);
                    const now = Date.now();

                    // Check if cache exists and is still valid (24 hours)
                    if (cachedData && cacheExpiry && now < parseInt(cacheExpiry)) {
                        try {
                            const parsedData = JSON.parse(cachedData);
                            console.log('✅ CACHE HIT: Using cached search results for:', searchTerm);
                            resolve(parsedData);
                            return;
                        } catch (e) {
                            console.warn('❌ CACHE CORRUPTED: Failed to parse cached data for:', searchTerm);
                            // Clear corrupted cache
                            localStorage.removeItem(cacheKey);
                            localStorage.removeItem(cacheExpiryKey);
                        }
                    } else if (cachedData && cacheExpiry) {
                        // Cache expired, clean it up
                        console.log('⏰ CACHE EXPIRED: Removing expired cache for:', searchTerm);
                        localStorage.removeItem(cacheKey);
                        localStorage.removeItem(cacheExpiryKey);
                    } else {
                        console.log('🔍 CACHE MISS: No cache found for:', searchTerm);
                    }
                }

                // Check for partial matches in cache (fuzzy search)
                if (useCache && searchTermLower.length > 2) {
                    const partialMatches = findPartialMatches(searchTermLower);
                    if (partialMatches.length > 0) {
                        console.log('🔍 PARTIAL CACHE MATCHES: Found', partialMatches.length, 'partial matches for:', searchTerm);
                    }
                }

                console.log('🌐 FETCHING: Making AJAX request for:', searchTerm);

                // Make AJAX request for fresh data
                jQuery.ajax({
                    type: "get",
                    dataType: "json",
                    url: my_ajax_object.ajax_url,
                    data: {
                        action: 'get_search_results_inline',
                        searchQuery: searchTerm
                    },
                    success: function(msg) {
                        console.log('✅ AJAX SUCCESS: Received fresh data for:', searchTerm);

                        // Cache the result if enabled
                        if (useCache && msg && msg.data) {
                            try {
                                const cacheExpiry = Date.now() + (24 * 60 * 60 * 1000); // 24 hours
                                localStorage.setItem(cacheKey, JSON.stringify(msg));
                                localStorage.setItem(cacheExpiryKey, cacheExpiry.toString());

                                // Clean up old cache entries (keep only last 100 searches)
                                cleanupOldCache();

                                console.log('💾 CACHED: Stored search results for:', searchTerm);
                            } catch (e) {
                                console.warn('❌ CACHE STORE FAILED: Failed to cache search results for:', searchTerm, e);
                                // If localStorage is full, clean up and try again
                                if (e.name === 'QuotaExceededError') {
                                    cleanupOldCache();
                                    try {
                                        localStorage.setItem(cacheKey, JSON.stringify(msg));
                                        localStorage.setItem(cacheExpiryKey, cacheExpiry.toString());
                                        console.log('💾 CACHED: Successfully stored after cleanup for:', searchTerm);
                                    } catch (e2) {
                                        console.warn('❌ CACHE STORE FAILED: Still failed to cache after cleanup for:', searchTerm, e2);
                                    }
                                }
                            }
                        }
                        resolve(msg);
                    },
                    error: function(err) {
                        console.error('❌ AJAX ERROR: Search request failed for:', searchTerm, err);
                        reject(err);
                    }
                });
            });
        }

        // Helper function to find partial matches in cache
        function findPartialMatches(searchTerm) {
            const matches = [];
            const keys = Object.keys(localStorage);

            for (let key of keys) {
                if (key.startsWith('siteefy_search_') && key !== `siteefy_search_${searchTerm}`) {
                    const cachedTerm = key.replace('siteefy_search_', '');
                    if (cachedTerm.includes(searchTerm) || searchTerm.includes(cachedTerm)) {
                        try {
                            const cachedData = JSON.parse(localStorage.getItem(key));
                            matches.push({
                                term: cachedTerm,
                                data: cachedData
                            });
                        } catch (e) {
                            // Skip corrupted cache entries
                        }
                    }
                }
            }

            return matches;
        }

        // Helper function to clean up old cache entries
        function cleanupOldCache() {
            const keys = Object.keys(localStorage);
            const searchKeys = keys.filter(key => key.startsWith('siteefy_search_'));

            if (searchKeys.length > 100) {
                // Sort by creation time (approximate) and remove oldest
                const keyTimes = searchKeys.map(key => {
                    const expiryKey = key.replace('siteefy_search_', 'siteefy_search_expiry_');
                    const expiry = localStorage.getItem(expiryKey);
                    return {
                        key: key,
                        expiryKey: expiryKey,
                        time: expiry ? parseInt(expiry) : 0
                    };
                }).sort((a, b) => a.time - b.time);

                // Remove oldest entries (keep only last 80)
                const toRemove = keyTimes.slice(0, searchKeys.length - 80);
                toRemove.forEach(item => {
                    localStorage.removeItem(item.key);
                    localStorage.removeItem(item.expiryKey);
                });

                console.log('Cleaned up', toRemove.length, 'old cache entries');
            }
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
})(jQuery);