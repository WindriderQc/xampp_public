$(document).ready(function() {
    console.log('LHSQC Javascript loaded'); // Check if the event is triggered

    // Mobile Nav
    $('ul.button-menu').on('click', function() {
        console.log('Menu button clicked'); // Check if the event is triggered
        $('.nav-mobile-menu').toggleClass('active');
    });

    // Toggle submenus within the mobile menu
    $('.nav-mobile-menu > li > div').on('click', function() {
        console.log('SubMenu button clicked'); // Check if the event is triggered
        $(this).siblings('ul').slideToggle(); // Smooth toggle
        $(this).parent().siblings('li').find('ul').slideUp(); // Close other submenus
    });

    $('.nav-mobile-menu > li > ul').on('click', function(event) {
        event.stopPropagation(); // Prevent event bubbling up to parent menus
        console.log('SubSub Menu button clicked'); // Check if the event is triggered
        $(this).children('div').slideToggle(); // Slide toggle the submenu
        $(this).parent().siblings().find('ul').slideUp(); // Hide other open submenus
    });

    // Scroll link
    document.querySelectorAll('.scroll-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();  // Prevent default anchor behavior
            const targetId = this.getAttribute('href').substring(1);  // Get the ID without the '#'
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                const offset = 80;  // Set your offset value here
                const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = elementPosition - offset;
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });



    // Sticky Nav
    function isMobile() {
        return ('ontouchstart' in document.documentElement ? true : false);
    }

    function StickyNav() {
        if (isMobile()) return;
        var nav = $('nav');
        var sticky = nav.clone().prop('id', 'stickynav');
        sticky.html('<div class="shell">' + sticky.html() + '</div>');
        $('body').prepend(sticky);
        $(window).on('scroll', function() {
            var scrollTop = $(this).scrollTop();
            if (scrollTop > 60) {
                $('#stickynav').addClass('animate').css("visibility", "visible");
                $('header nav').css("visibility", "hidden");
            } else {
                $('#stickynav').removeClass('animate').css("visibility", "hidden");
                $('header nav').css("visibility", "visible");
            }
        });
    }

    StickyNav();

    // Alerts close button
    $('.close').on('click', function() {
        $(this).parent().fadeOut();
    });

    // List group item active state
    $('.list-group li').click(function(e) {
        e.preventDefault();
        $that = $(this);
        $('.list-group').find('li').removeClass('active');
        $that.addClass('active');
    });

    // Tabs item active state
    document.querySelectorAll('#tabsList .tabsItem').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('#tabsList .tabsItem').forEach(el => el.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
