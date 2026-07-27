# Training Institute Rebuild Plan

## Summary

Create a Laravel rebuild for Bangladesh National Youth Technical Institute in clear phases. Today's implementation is limited to a presentation-ready homepage at `/`, using Laravel Blade, Tailwind CSS v4, and dependency-free JavaScript.

## Project Phases

1. **Public Homepage**
   Premium responsive homepage, English/Bangla switching, light/dark mode, mobile navigation, and presentation-ready content.
2. **Public Website**
   Courses, institute details, branches, teachers, gallery, news, notices, reviews, contact, online exam entry, and student result verification.
3. **Authentication and Roles**
   Super Admin, Branch, Editor, Student, and configurable staff permissions.
4. **Academic Management**
   Courses, students, teachers, admit cards, registration cards, ID cards, certificates, testimonials, transcripts, forwarding letters, and results.
5. **Branch Management**
   Branch applications, approval workflow, branch accounts, branch lists, and branch reporting.
6. **Online Examination**
   Exams, question banks, scheduling, participation, scoring, and result publication.
7. **Website CMS**
   Sliders, gallery, about content, news, notices, reviews, contact information, menus, and footer management.
8. **Administration**
   Dashboard statistics, users, reports, media library, general settings, localization settings, audit history, and system configuration.
9. **Quality and Deployment**
   Automated tests, authorization review, responsive validation, accessibility, performance, backups, and production deployment.

## Homepage Implementation

- Replace the Laravel welcome screen with a semantic Blade homepage served by the existing `/` route.
- Build a premium technical-education visual identity using deep navy, emerald green, warm gold accents, layered gradients, subtle grid textures, refined shadows, and purposeful motion.
- Build these sections: sticky header, mobile menu, hero, notice ticker, trust indicators, featured courses, institute introduction, performance statistics, student services, branch presence, testimonials, enrollment CTA, contact details, and footer.
- Use the provided institute logo as a local project asset. Use polished neutral visual fallbacks for unavailable photography until final media is supplied.
- Keep today's data static and presentation-focused while structuring sections so CMS/database content can replace it later without redesigning the markup.
- Make navigation section-based for today. Future pages such as sign-in, results, exams, branches, and applications may appear as clearly labelled preview links without inventing unfinished routes.

## Responsive and Interactive Behavior

- Design mobile-first for widths from 320px upward, then adapt layouts for tablet, laptop, desktop, and wide screens.
- Use a compact mobile header, full-screen navigation drawer, stacked hero actions, swipe-friendly horizontal content where appropriate, touch targets of at least 44px, fluid typography, and responsive image crops.
- Avoid horizontal overflow and preserve readable line lengths, spacing, hierarchy, and content order at every breakpoint.
- Implement manual light/dark mode with Tailwind v4's class-based `dark:` variants. Start from the operating-system preference and remember manual selection in `localStorage`.
- Implement complete English/Bangla homepage switching with a small static translation dictionary. Remember the selected language and update the document language attribute.
- Use vanilla JavaScript for theme, language, menu, and notice behavior; add no new frontend dependency.
- Respect `prefers-reduced-motion`, keyboard navigation, focus visibility, semantic landmarks, meaningful image alternatives, and accessible toggle labels.

## Interfaces

- `/` remains the public homepage route.
- Browser preferences use stable `localStorage` keys for `theme` and `locale`.
- Supported locale values are `en` and `bn`; English is the fallback.
- No database schema, admin API, authentication workflow, or public content API is added during the homepage phase.

## Future Dashboard and Access Plan

- Add a **Super Admin Dashboard** with full system access for managing users, roles, branches, students, courses, certificates, reports, website content, and global settings.
- Add a **Branch Dashboard** for each approved branch so branch staff can manage their own students, admissions, records, reports, and certificate-related requests within their assigned branch only.
- Add an **Editor Dashboard** with access to all student records needed for certificate preparation, verification, and printing.
- Ensure certificate printing access is permission-based, auditable, and separated from unrelated administrative settings.
- Keep role boundaries clear so Super Admin can oversee every branch, Branch users can manage only their branch data, and Editors can access student certificate workflows without full system control.

## Verification

- Add a Pest feature test confirming `/` returns successfully and contains the main homepage landmarks and institute identity.
- Run the focused homepage test and the existing compact test suite.
- Run `npm run build` and confirm Vite compiles Tailwind and JavaScript without errors.
- Validate representative widths at 320px, 375px, 768px, 1024px, 1440px, and a wide desktop size.
- Verify mobile navigation, both languages, both themes, preference persistence, keyboard navigation, reduced motion, image loading, and absence of horizontal scrolling.
- Confirm the page remains understandable when JavaScript is unavailable, with English content and normal navigation visible.

## Assumptions

- The official name is "Bangladesh National Youth Technical Institute".
- Today's deliverable is the complete homepage selected by the user; all admin and deeper website modules remain documented future phases.
- Full English/Bangla behavior is included using the recommended default because no alternate language preference was selected.
- Current public branding assets may be reused for the rebuild; unavailable assets receive temporary premium fallbacks.
- Client-provided final copy, official media, statistics, course details, and route destinations can replace prototype content later.
