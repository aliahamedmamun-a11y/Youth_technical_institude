@include('dashboards.layout', [
    'title' => 'Branch Dashboard',
    'eyebrow' => 'Branch workspace',
    'description' => 'Manage students, admissions, academic records, reports, and certificate requests for the assigned branch only.',
    'cards' => [
        ['label' => 'Students', 'title' => 'Branch student records', 'body' => 'Maintain admissions, profiles, registration details, and academic documents.'],
        ['label' => 'Requests', 'title' => 'Certificate requests', 'body' => 'Submit and follow certificate-related requests for students in this branch.'],
        ['label' => 'Reports', 'title' => 'Branch reporting', 'body' => 'View branch-specific summaries for students, courses, exams, and results.'],
    ],
])
