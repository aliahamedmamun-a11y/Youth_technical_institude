@include('dashboards.layout', [
    'title' => 'Editor Dashboard',
    'eyebrow' => 'Certificate desk',
    'description' => 'Access student records needed for certificate preparation, verification, correction, and printing without full system administration control.',
    'cards' => [
        ['label' => 'Students', 'title' => 'Certificate-ready records', 'body' => 'Find all student details needed to prepare accurate certificates.'],
        ['label' => 'Verification', 'title' => 'Document checks', 'body' => 'Review names, course data, result status, and branch information before printing.'],
        ['label' => 'Printing', 'title' => 'Certificate printing', 'body' => 'Print approved certificates through permission-based and auditable workflows.'],
    ],
])
