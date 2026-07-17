import './bootstrap';

// Alpine.js for interactive components
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Initialize SortableJS for gallery reordering (loaded via CDN in blade views)
document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle
    const mobileSidebarBtn = document.getElementById('mobileSidebarBtn');
    if (mobileSidebarBtn) {
        mobileSidebarBtn.addEventListener('click', function() {
            const sidebar = document.querySelector('aside');
            if (sidebar) {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('fixed');
                sidebar.classList.toggle('inset-0');
                sidebar.classList.toggle('z-50');
            }
        });
    }

    // Initialize tooltips if any
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(tooltip => {
        tooltip.addEventListener('mouseenter', function() {
            const tip = document.createElement('div');
            tip.className = 'bg-gray-900 text-white text-xs px-2 py-1 rounded absolute z-50';
            tip.textContent = this.dataset.tooltip;
            document.body.appendChild(tip);
            
            const rect = this.getBoundingClientRect();
            tip.style.top = rect.top - 30 + 'px';
            tip.style.left = rect.left + (rect.width / 2) - (tip.offsetWidth / 2) + 'px';
            
            this.addEventListener('mouseleave', function() {
                tip.remove();
            }, { once: true });
        });
    });
});

// Global AJAX setup for CSRF
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Initialize Leaflet map for project detail pages
window.initProjectMap = function(lat, lng, elementId) {
    const map = L.map(elementId).setView([lat, lng], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    
    L.marker([lat, lng]).addTo(map);
    
    return map;
};

// Flash message auto-hide
setTimeout(() => {
    const alerts = document.querySelectorAll('[role="alert"]');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);

// Real-time slug checker (optional - bisa ditambahkan di form create)
window.checkSlugAvailability = function(inputElement, type) {
    const name = inputElement.value;
    if (!name || name.length < 3) return;
    
    const slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    
    fetch(`/api/check-slug?slug=${slug}&type=${type}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        const feedback = inputElement.nextElementSibling;
        if (data.exists) {
            inputElement.classList.add('border-red-300', 'bg-red-50');
            if (feedback && feedback.classList.contains('slug-feedback')) {
                feedback.innerHTML = `<i class="fas fa-exclamation-circle text-red-500 text-xs"></i> 
                    <span class="text-xs text-red-600">Nama sudah digunakan, silakan ganti</span>`;
            }
        } else {
            inputElement.classList.remove('border-red-300', 'bg-red-50');
            inputElement.classList.add('border-green-300', 'bg-green-50');
            if (feedback && feedback.classList.contains('slug-feedback')) {
                feedback.innerHTML = `<i class="fas fa-check-circle text-green-500 text-xs"></i> 
                    <span class="text-xs text-green-600">Nama tersedia</span>`;
            }
        }
    });
};