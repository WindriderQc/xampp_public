$(document).ready(function() {
    console.log('LHSQC Javascript loaded'); // Check if the event is triggered

    // Mobile Nav
    $('.button-menu li').on('click', function(event) {
        event.stopPropagation(); // Prevent the event from bubbling up
        console.log('Menu button clicked'); // Check if the event is triggered
        const menu = $('.nav-mobile-menu');
        menu.toggleClass('active');
      
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

    // Tabs item active state
    /*document.querySelectorAll('#tabsList .tabsItem').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('#tabsList .tabsItem').forEach(el => el.classList.remove('active'));
            this.classList.add('active');
        });
    });*/





/*! Tab Menu ....   test if required*/ 

    jQuery('.tabsmenu.standard .tabmenu-links a').on('click',function(e){
        var currentAttrValue=jQuery(this).attr('href');
        jQuery('.tabsmenu '+ currentAttrValue).show().siblings().hide();
        jQuery(this).parent('li').addClass('activemenu').siblings().removeClass('activemenu');
        e.preventDefault();
    });
    jQuery('.tabsmenu.animated-fade .tabmenu-links a').on('click',function(e){
        var currentAttrValue=jQuery(this).attr('href');
        jQuery('.tabsmenu '+ currentAttrValue).fadeIn(400).siblings().hide();
        jQuery(this).parent('li').addClass('activemenu').siblings().removeClass('activemenu');e.preventDefault();
    });
    jQuery('.tabsmenu.animated-slide-1 .tabmenu-links a').on('click',function(e){
        var currentAttrValue=jQuery(this).attr('href');jQuery('.tabsmenu '+ currentAttrValue).siblings().slideUp(400);
        jQuery('.tabsmenu '+ currentAttrValue).delay(400).slideDown(400);
        jQuery(this).parent('li').addClass('activemenu').siblings().removeClass('activemenu');e.preventDefault();
    });
    jQuery('.tabsmenu.animated-slide-menu .tabmenu-links a').on('click',function(e){
        var currentAttrValue=jQuery(this).attr('href');
        jQuery('.tabsmenu '+ currentAttrValue).slideDown(400).siblings().slideUp(400);
        jQuery(this).parent('li').addClass('activemenu').siblings().removeClass('activemenu');
        e.preventDefault();
    });

    jQuery('.tabsmain.standard .tabmain-links a').on('click',function(e){
        var currentAttrValue=jQuery(this).attr('href');
        jQuery('.tabsmain '+ currentAttrValue).show().siblings().hide();
        jQuery(this).parent('li').addClass('activemain').siblings().removeClass('activemain');
        e.preventDefault();
    });
    jQuery('.tabsmain.animated-fade .tabmain-links a').on('click',function(e){
        var currentAttrValue=jQuery(this).attr('href');
        jQuery('.tabsmain '+ currentAttrValue).fadeIn(400).siblings().hide();
        jQuery(this).parent('li').addClass('activemain').siblings().removeClass('activemain');
        e.preventDefault();
    });
    jQuery('.tabsmain.animated-slide-1 .tabmain-links a').on('click',function(e){
        var currentAttrValue=jQuery(this).attr('href');
        jQuery('.tabsmain '+ currentAttrValue).siblings().slideUp(400);
        jQuery('.tabsmain '+ currentAttrValue).delay(400).slideDown(400);
        jQuery(this).parent('li').addClass('activemain').siblings().removeClass('activemain');e.preventDefault();
    });
    jQuery('.tabsmain.animated-slide-main .tabmain-links a').on('click',function(e){
        var currentAttrValue=jQuery(this).attr('href');
        jQuery('.tabsmain '+ currentAttrValue).slideDown(400).siblings().slideUp(400);
        jQuery(this).parent('li').addClass('activemain').siblings().removeClass('activemain');
        e.preventDefault();
    });






    
    /*document.querySelectorAll('.tabsMenu .nav-link').forEach(button => {
        button.addEventListener('click', function() {

            // Remove active class from all nav items 
            document.querySelectorAll('.tabsMenu .nav-item').forEach(item => { 
                item.classList.remove('active'); 
                item.style.display = 'none'; // Hide all items 
            }); 
            // Add active class to the clicked button's parent li 
            this.parentElement.classList.add('active'); 
            this.parentElement.style.display = 'block'; // Show the clicked item
            
           
            // Hide the menu
            document.querySelector('.tabsMenu').style.display = 'none';
        });
    });*/


    document.querySelectorAll('.tabsMenu .nav-link').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all nav items
            document.querySelectorAll('.tabsMenu .nav-item').forEach(item => {
                item.classList.remove('active');
                item.style.display = 'none'; // Hide all items
            });
    
            // Add active class to the clicked button's parent li
            this.parentElement.classList.add('active');
            this.parentElement.style.display = 'block'; // Show the clicked item
    
        });
    });
    
    // Show all items on hover
    document.querySelector('.tabsMenu').addEventListener('mouseover', function() {
        document.querySelectorAll('.tabsMenu .nav-item').forEach(item => {
            item.style.display = 'block';
        });
    });
    
    // Hide all non-active items when mouse leaves
    document.querySelector('.tabsMenu').addEventListener('mouseout', function() {
        document.querySelectorAll('.tabsMenu .nav-item').forEach(item => {
            if (!item.classList.contains('active')) {
                item.style.display = 'none';
            }
        });
    });
    


});



/*! Tab Menu Next 4 Lines*/ 
jQuery(document).ready(function(){jQuery('.tabsmenu.standard .tabmenu-links a').on('click',function(e){var currentAttrValue=jQuery(this).attr('href');jQuery('.tabsmenu '+ currentAttrValue).show().siblings().hide();jQuery(this).parent('li').addClass('activemenu').siblings().removeClass('activemenu');e.preventDefault();});jQuery('.tabsmenu.animated-fade .tabmenu-links a').on('click',function(e){var currentAttrValue=jQuery(this).attr('href');jQuery('.tabsmenu '+ currentAttrValue).fadeIn(400).siblings().hide();jQuery(this).parent('li').addClass('activemenu').siblings().removeClass('activemenu');e.preventDefault();});jQuery('.tabsmenu.animated-slide-1 .tabmenu-links a').on('click',function(e){var currentAttrValue=jQuery(this).attr('href');jQuery('.tabsmenu '+ currentAttrValue).siblings().slideUp(400);jQuery('.tabsmenu '+ currentAttrValue).delay(400).slideDown(400);jQuery(this).parent('li').addClass('activemenu').siblings().removeClass('activemenu');e.preventDefault();});jQuery('.tabsmenu.animated-slide-menu .tabmenu-links a').on('click',function(e){var currentAttrValue=jQuery(this).attr('href');jQuery('.tabsmenu '+ currentAttrValue).slideDown(400).siblings().slideUp(400);jQuery(this).parent('li').addClass('activemenu').siblings().removeClass('activemenu');e.preventDefault();});});
jQuery(document).ready(function(){jQuery('.tabsmain.standard .tabmain-links a').on('click',function(e){var currentAttrValue=jQuery(this).attr('href');jQuery('.tabsmain '+ currentAttrValue).show().siblings().hide();jQuery(this).parent('li').addClass('activemain').siblings().removeClass('activemain');e.preventDefault();});jQuery('.tabsmain.animated-fade .tabmain-links a').on('click',function(e){var currentAttrValue=jQuery(this).attr('href');jQuery('.tabsmain '+ currentAttrValue).fadeIn(400).siblings().hide();jQuery(this).parent('li').addClass('activemain').siblings().removeClass('activemain');e.preventDefault();});jQuery('.tabsmain.animated-slide-1 .tabmain-links a').on('click',function(e){var currentAttrValue=jQuery(this).attr('href');jQuery('.tabsmain '+ currentAttrValue).siblings().slideUp(400);jQuery('.tabsmain '+ currentAttrValue).delay(400).slideDown(400);jQuery(this).parent('li').addClass('activemain').siblings().removeClass('activemain');e.preventDefault();});jQuery('.tabsmain.animated-slide-main .tabmain-links a').on('click',function(e){var currentAttrValue=jQuery(this).attr('href');jQuery('.tabsmain '+ currentAttrValue).slideDown(400).siblings().slideUp(400);jQuery(this).parent('li').addClass('activemain').siblings().removeClass('activemain');e.preventDefault();});});




// helper function

function inArray(needle, haystack) {
	var ret = false;
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle){ret = true;}
    }
    return ret;
}




//  toggle active class on a target and its source
function toggler(event, target)  {
    
    const divName = target ;   // `${target}${block}`;

    console.log("clicked",divName);
    const targetDiv = document.getElementById(divName);


    const source = event.target;
    source.classList.toggle('active'); // Toggle the active class on the button
    targetDiv.classList.toggle('active'); // Toggle the active class on the target div

}
