<div class="search-field__main">
    <form role="search" method="get" id="search-form" action="<?php echo home_url('/'); ?>" autocomplete="off">
        <input type="search" name="s" placeholder="🔍 What task do you need help with?" id="siteefy_search" value="<?php siteefy_get_search_value(); ?>">
       <div class="input-controls">
            <span class="btn-text-clear hidden">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M13.0209 1L1.00006 13.0208" stroke="#AFD9FF" stroke-width="1.5" stroke-linecap="round"/><path d="M1 1L13.0208 13.0208" stroke="#AFD9FF" stroke-width="1.5" stroke-linecap="round"/></svg>
            </span>
           <span class="btn-search">
               <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none"><circle cx="13" cy="13" r="8.19238" transform="rotate(-45 13 13)" stroke="#FFCC00" stroke-width="2"/><path d="M23.9 25.3142C24.2905 25.7047 24.9237 25.7047 25.3142 25.3142C25.7048 24.9237 25.7048 24.2905 25.3142 23.9L23.9 25.3142ZM17.8643 19.2785L23.9 25.3142L25.3142 23.9L19.2785 17.8643L17.8643 19.2785Z" fill="#FFCC00"/></svg>
           </span>
       </div>

    </form>
    <div class="search-output__container hidden">
        <div class="search-top">
            <div id="search-output"></div>
            <div class="search-results__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="13" viewBox="0 0 15 13" fill="none">
                    <path d="M8 1L14 6.5L8 12" stroke="#0880EC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13 6.5L1 6.5" stroke="#0980ED" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
        </div>
        <div id="search-results" class="search-bottom">
            <div class="popup-search-results__container placeholder">
                <div id="popup-tasks-group">
                    <div class="popup-search-result__header header">
                        📝 Tasks <span id="popup-tasks-count">(count)</span>
                    </div>
                    <div class="popup-search-results-group">
                        <a href="" class="search-result__item">
                            <span>Code Reviews</span>
                        </a>
                        <a href="" class="search-result__item">
                            <span>Code Reviews</span>
                        </a>
                        <a href="" class="search-result__item">
                            <span>Code Reviews</span>
                        </a>
                    </div>
                </div>
                <div id="popup-tools-group">
                    <div class="popup-search-result__header header">
                        📝 Tools<span id="popup-tools-count">(count)</span>
                    </div>
                    <div class="popup-search-results-group">
                        <a href="" class="search-result__item">
                            <span>Code Reviews</span>
                        </a>
                        <a href="" class="search-result__item">
                            <span>Code Reviews</span>
                        </a>
                        <a href="" class="search-result__item">
                            <span>Code Reviews</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
