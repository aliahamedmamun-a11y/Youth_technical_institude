<x-dashboard-shell title="Add About Entry" eyebrow="Website content" description="Create a new About Us story for the homepage rotation.">
    <x-about-form :about="$about" :action="route('super-admin.about.store')" submit-label="Create entry" />
</x-dashboard-shell>
