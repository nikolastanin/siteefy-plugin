<header id="main-header">
    <div class="nav container">
        <a href="<?php echo get_siteefy_home_url();  ?>">
            <img src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/siteefy-logo-black.png" width="141px" height="59px" alt="siteefy logo">
        </a>
        <div class="main-menu">
            <?php wp_nav_menu(); ?>
        </div>
        <div id="hamburger" style="display:none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
                <path d="M0 2H23" stroke="#3F3F3F" stroke-width="3"/>
                <path d="M0 11.0357H23" stroke="#3F3F3F" stroke-width="3"/>
                <path d="M0 20.8929H23" stroke="#3F3F3F" stroke-width="3"/>
            </svg>
        </div>
    </div>
</header>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const header = document.getElementById("main-header");
        const headerImg = document.querySelector("header img");
        window.addEventListener("scroll", function () {
            if (window.scrollY > 50) {
                header.style.background = "linear-gradient(158deg, #CFDCFF 18.38%, #EDF2FF 57.07%, #99B5FF 88.75%)";
                header.style.padding = "16px 0";
                header.style.boxShadow = "0px 0px 10px 0px rgba(0, 0, 0, 0.1)";
                header.style.transition = "all 0.2s linear";
                header.style.position = "fixed";
                header.style.top = "0";
                header.style.left = "0";
                header.style.width = "100%";
                header.style.zIndex = "1000";  // Ensures it stays on top of other content
                // headerImg.style.transform = "scale(0.7)"; // Ensures it stays on top of other content
            } else {
                header.style.background = "transparent";
                header.style.padding = "32px 0";
                header.style.position = "";
                header.style.top = "";
                header.style.left = "";
                header.style.width = "";
                header.style.zIndex = "";
                header.style.boxShadow = "none";
                // headerImg.style.transform = "scale(1.0)"; // Ensures it stays on top of other content
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        const hamburger = document.getElementById("hamburger");
        const mainMenu = document.querySelector(".main-menu");

        hamburger.addEventListener("click", function () {
            if (mainMenu.style.display === "none" || mainMenu.style.display === "") {
                mainMenu.style.display = "flex";
            } else {
                mainMenu.style.display = "none";
            }
        });
    });
</script>