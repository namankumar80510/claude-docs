// Mobile sidebar toggle
document.addEventListener('DOMContentLoaded', () => {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth < 1024 &&
            !sidebar.contains(e.target) &&
            !sidebarToggle.contains(e.target) &&
            !sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.add('-translate-x-full');
        }
    });
});

// Add dark mode toggle if needed
if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark');
}

// Mobile search
document.addEventListener('DOMContentLoaded', () => {
    const mobileSearchButton = document.getElementById('mobile-search-button');
    const searchModal = document.getElementById('search-modal');
    const closeSearchModal = document.getElementById('close-search-modal');
    mobileSearchButton.addEventListener('click', () => {
        searchModal.classList.toggle('hidden');
    });

    closeSearchModal.addEventListener('click', () => {
        searchModal.classList.add('hidden');
    });
});
