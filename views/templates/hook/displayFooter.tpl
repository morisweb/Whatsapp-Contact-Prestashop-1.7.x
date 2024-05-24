<div id="whatsapp-icon">
    <a href="{$whatsapp_link}" target="_blank" title="">
        <img src="{$module_dir}whatsappcontact/logo.png" alt="WhatsApp">
        <span class="whatsapp-tooltip">{$whatsapp_message}</span>
    </a>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var whatsappIcon = document.getElementById('whatsapp-icon');
        var tooltip = document.querySelector('#whatsapp-icon .whatsapp-tooltip');
        
        whatsappIcon.addEventListener('mouseover', function() {
            tooltip.style.opacity = '1';
            tooltip.style.transform = 'scale(1)';
        });
        
        whatsappIcon.addEventListener('mouseout', function() {
            tooltip.style.opacity = '0';
            tooltip.style.transform = 'scale(0)';
        });
    });
</script>

<style>
    #whatsapp-icon {
        position: fixed;
        bottom: 20px;
        left: 20px;
        z-index: 9999;
    }

    .whatsapp-tooltip {
        opacity: 0;
        transform: scale(0);
        transition: all 0.3s ease-in-out;
        display: block;
        position: absolute;
        bottom: -3px; /* Height of the tooltip relative to the icon */
        left: calc(100% + 10px); /* Distance from the right of the icon */
        transform-origin: top left;
        background-color: #fff;
        padding: 8px 12px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
</style>