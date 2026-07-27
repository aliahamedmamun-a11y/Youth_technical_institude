@include('dashboards.layout', [
    'title' => 'Student Dashboard',
    'eyebrow' => 'Student portal',
    'description' => 'View personal course information, documents, exam entry, result status, and certificate updates.',
    'cards' => [
        ['label' => 'Courses', 'title' => 'My courses', 'body' => 'See enrolled course details, schedules, and academic information.'],
        ['label' => 'Documents', 'title' => 'My documents', 'body' => 'Track admit card, registration card, ID card, transcript, and certificate status.'],
        ['label' => 'Results', 'title' => 'Result updates', 'body' => 'Check published result information and verification status.'],
    ],
])
